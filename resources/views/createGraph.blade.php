<script>
    
function produceFilterStr(filter, filterType){
       
       var sqlFilter = "";
       
          $.each(filter, function(key, value){           
                                  
            if(filterType[key]==='number'){                                  
                                  
                    sqlFilter = sqlFilter + key + "=" + value +" AND ";
               
               }
               
            if(filterType[key]==='text'){                                  
                                  
                    sqlFilter = sqlFilter + key + "='" + value +"' AND ";
               
               }


           
           });
                       
       
        sqlFilter = sqlFilter.slice(0,-4);  //Triming final 'AND' 
       
       return sqlFilter;
   }    
   
function clearGraph(chart){

           
    var initialData = [
        { date: 'Sty', value: 0 },
        { date: 'Lut', value: 0 },
        { date: 'Mar', value: 0 },
        { date: 'Kwi', value: 0 },
        { date: 'Maj', value: 0 },
        { date: 'Cze', value: 0 },
        { date: 'Lip', value: 0 },
        { date: 'Sie', value: 0 },
        { date: 'Wrz', value: 0 },
        { date: 'Paz', value: 0 },
        { date: 'Lis', value: 0 },
        { date: 'Gru', value: 0 }                
    ];   
       
    
        
    chart.setData(initialData);
    
}
   
   
function refreshGraph(filter, filterType, chart){
    
    
            
            var flt = produceFilterStr(filter, filterType);                          
    
            $.ajax({
              type: "GET",
              dataType: 'json',
              url: "/ds/examsGraph?year="+$("#yearValue").val()+"&filter="+flt
            })
            .done(function( data ) {

              chart.setData(data);

            })
            .fail(function() {

                console.log('ERROR: Cannot get data for the graph');

            });

    
    
}

    
$(document).ready(function(){
    
           
    /*
     *  Graph initialization 
     */        
       
    var initialData = [
        { date: 'Sty', value: 0 },
        { date: 'Lut', value: 0 },
        { date: 'Mar', value: 0 },
        { date: 'Kwi', value: 0 },
        { date: 'Maj', value: 0 },
        { date: 'Cze', value: 0 },
        { date: 'Lip', value: 0 },
        { date: 'Sie', value: 0 },
        { date: 'Wrz', value: 0 },
        { date: 'Paz', value: 0 },
        { date: 'Lis', value: 0 },
        { date: 'Gru', value: 0 }                
    ];   
       
    var chart = Morris.Bar({
            element: 'chart',
               data: initialData,
               xkey: 'date',
              ykeys: ['value'],
             labels: ['Wyników'],
             xLabelMargin: 10,
             barColors:['337AB7']
         
        });
    
    /*
     *  Year dropdown Initialization     
     */
    
    
       var filter     = {};   /* Associative array for storing fields with filters */
       var filterType = {};   /* Corresponding for with filter types               */
    
    $('#year').ddslick({
        
            width: 300,
            
            imagePosition: "left",
            selectText: "Wybierz rok",
             onSelected: function (data) {
                 $('#yearValue').val(data.selectedData.text);
                /* Invoked on initial load too */
                                 
                    if($("ul#members li").length>0){

                        refreshGraph(filter, filterType, chart);
                   
                    }else{
                        
                        clearGraph(chart);
                        
                    }
                
                //refreshGraph(filter, filterType, chart);
            }
     });
    
    /*
     *  Connected sortable initialization and event handling      
     */
      
    
         $( "#members, #non-members" ).sortable({
            connectWith: ".connectedSortable"
            });
   
         $( "#members" ).sortable({
                receive: function( event, ui ) {
                                 
                        /* Add KyeUp handler to input field that was move to active list */
                       ui.item.children().children("input").keyup(
                            function(){        
                                
                                if(ui.item.children().children("input").val().length>0){    
                                    /* When there are some inputs we add filter with type to array*/
                                   filter[ui.item.attr('columnName')]=ui.item.children().children("input").val();                                                   
                                   filterType[ui.item.attr('columnName')]=ui.item.attr('filterType');  
                               
                                } else {
                                    /* When the filter box is empty */
                                   delete filter[ui.item.attr('columnName')];
                                   delete filterType[ui.item.attr('columnName')]; 
                                }             
                    
                            refreshGraph(filter, filterType, chart);
                                        
                       });
                                 
                                 
                                 
                         /* Adding up single filter field */        
                                 
                        if(ui.item.children().children("input").val().length>0){    
                            /* When there are some inputs we add filter with type to array*/
                               filter[ui.item.attr('columnName')]=ui.item.children().children("input").val();                                                   
                               filterType[ui.item.attr('columnName')]=ui.item.attr('filterType');  
                               
                        } else {
                            /* When the filter box is empty */
                               delete filter[ui.item.attr('columnName')];
                               delete filterType[ui.item.attr('columnName')]; 
                        }             
                    
                      refreshGraph(filter, filterType, chart);
                                 
                                 
                },
                
                remove: function( event, ui){
                                  
                    /* Removing KeyUp event from input fields that were took down */
                    ui.item.children().children("input").off('keyup');
                                        

                    delete filter[ui.item.attr('columnName')];
                    delete filterType[ui.item.attr('columnName')]; 
                
                
                    if($("ul#members li").length>0){

                        refreshGraph(filter, filterType, chart);
                   
                    }else{
                        
                        clearGraph(chart);
                        
                    }
                    
                }
                
                
                
            });
            
    
});


</script>


<div class='content-header'>  
    <img src="images/graph.png" style="float: left;"/><div class="titleBar">Stwórz wykres</div><div class="closeButton btn btn-default" >zamknij</div>
</div>
<div class='content-body'>
    <div style="float: left;">
    <ul class="connectedSortable" id="non-members">
        <li columnTitle="Kartoteka" columnName="set.name" columnAlias="set.name as setname" filterType="text">
            <div class="reportFieldName">Kartoteka</div>
            <div class="reportFieldValue"><input id="setname" type="text" class="form-control" placeholder="Wszystkie" ></div>
                    
       </li>
       
       <li columnName="examination.exam_date" columnAlias="examination.exam_date as examdate" filterType="dateRange">
            <div class="reportFieldName">Data badania</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Dowolna" name="exam_date"></div>
                    
       </li>
       
        <li columnName="patient.person" columnAlias="patient.person as patper" filterType="text">
            <div class="reportFieldName">Pacjent</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Wszyscy"></div>
                    
       </li>
       
        <li columnName="patient.pesel" columnAlias="patient.pesel as patpesel" filterType="text">
            <div class="reportFieldName">Pesel</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Dowolny"></div>                    
            
       </li>
       
       <li columnName="patient.age" columnAlias="patient.age as patage" filterType="number">
            <div class="reportFieldName">Wiek</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Dowolny"></div>
                    
       </li>
       
       
       <li columnName="examination.result" columnAlias="examination.result as result" filterType="text">
            <div class="reportFieldName">Wynik</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Dowolny"></div>
                    
       </li>
       
       <li columnName="contractor.name" columnAlias="contractor.name as contname" filterType="text">
            <div class="reportFieldName">Odbiorca</div>
            <div class="reportFieldValue"><input type="text" class="form-control" placeholder="Wszyscy"></div>
                    
       </li>
       
       
       
       
       
    </ul>
    
    <ul class="connectedSortable" id="members">
    
    </ul>
    </div>
     <div style="float: left;">
         <div style="padding-right: 10px; padding-left: 20px;">
             <select id="year" class="form-control">                 
                
                 <option>2016</option>
                 <option>2017</option>
                 <option>2018</option>
                 <option>2019</option>
                 <option>2020</option>
             </select>
         </div>
         <div id="chart" style="width: 750px; height: 550px;"></div>
    </div>
    
</div>

<input id="yearValue" type="hidden" ></input>
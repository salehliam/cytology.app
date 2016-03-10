@include('js.datatables-logic')
@include('js.report-columns')

<style>
    
    #table_wrapper{
    
    font-size: 14px;
   
    width: 780px;
    
    font-family: Tahoma;
    table-layout: fixed;
    float: left;
}

#table tbody tr td{
    
    height: 33px;
    
}
    
</style>

<script>

   /***********************************************************************************************************************
   *  Helper function removing element from array by its value 
   *  
   */
  
    Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
   };
    
   /**********************************************************************************************************************
    *  Helper function turning filter array into string that can be send via HTTP
    *  
    *  Filter array is an associative array in the form of filter[column_name]=filter_value 
    *  eg. 
    *       filter['set.name']='abc'
    *       filter['contractor.name']='xyz'
    *       
    *  Column name is given by columnName attribute associated with each element of the sortable list. 
    *  
    *  The product of the function will be in above case "set.name LIKE 'abc' AND contractor.name LIKE 'xyz' AND"
    *  The final AND is trimmed.
    *  
    *  The array filterType was added to distinct date range from others, text search filters.
    *  
    */
   
   function produceFilterStr(filter,filterType){
       
       var sqlFilter = "";
       
       $.each(filter, function(key, value){
           
           if(filterType[key]==='text'){
           
           sqlFilter = sqlFilter + key + " LIKE '" + value +"' AND ";
           
           }
           
           if(filterType[key]==='number'){
           
           sqlFilter = sqlFilter + key + "=" + value +" AND ";
           
           }
           
           if(filterType[key]==='dateRange'){
           
            /* need to break value of the field into two dates */
           
            var dates = value.split('/');
           
            sqlFilter = sqlFilter + key + " >= '" + dates[0] +"' AND "+ key + " <= '" + dates[1] +"' AND ";
           
           }
           
       });
       
        sqlFilter = sqlFilter.slice(0,-4);  //Triming final 'AND' 
       
       return sqlFilter;
   }
   
    /**********************************************************************************************************************
    *  Helper function turning fields array into string that can be send via HTTP
    *  Fields array is an ordinary array consisting column names that will be passed to SQL query 
    *  on the server side
    */    
   
    function produceFieldsStr(fields){
       
       var sqlFields = "",f;
       
       for (f of fields) {                                       
         sqlFields = sqlFields + f + ",";
        }
      
        sqlFields = sqlFields.slice(0,-1); //Triming final comma                   
        return sqlFields;
       
   }
   
   /**********************************************************************************************************************
   * Helper function refreshing content of the table
   * 
   *  columns - ordinary array with fileds name 
   *  filters - associative array consisting column names and filter values for every one of them 
   *  
   *  See TWO VERY IMPORTANT ARRAYS to get grasp of the whole logic 
   *  
   */
      
   function refreshTable(columns, filters, types){
       
    // console.log("URL: "+'ds/examsReport/?fields='+produceFieldsStr(columns)+'&where='+produceFilterStr(filters, types))         ;
     table.ajax.url('ds/examsReport/?fields='+produceFieldsStr(columns)+'&where='+produceFilterStr(filters, types)).load();
       
   }
  
    
   /**********************************************************************************************************************
    *  Page logic
    */
    
 $(document).ready(function(){
            
            $('input[name="exam_date"]').daterangepicker({
                locale: {
                   format: 'YYYY-MM-DD',
                   applyLabel: 'zastosuj',
                   cancelLabel: 'wyczyść',
                   separator: '/'                   
                },
              //   autoUpdateInput: false
                                                                                
            });
            
            /* Every input field tigger change event appart daterangepicker so I need to it this way */
            $('input[name="exam_date"]').on('apply.daterangepicker', function(ev, picker) {
                  
                $(this).keyup();
                
            });
            
            $('input[name="exam_date"]').on('cancel.daterangepicker', function(ev, picker) {
                 $(this).val('');
                 $(this).keyup();
            });
            
            
            /* THREE VERY IMPORTANT ARRAYS */            
            var fields = [];
            var filter = {};
            var filterType = {};

            $( "#members, #non-members" ).sortable({
            connectWith: ".connectedSortable"
            });
            
            initTableReport('ds/examsReport/', getColumns(),$('#sql').val());
             
             $( "#members" ).sortable({
                receive: function( event, ui ) {
                    
                    /*
                     * Change box header colour                                         
                     */
                  ///  $(this).find('div').css('background-color','#337AB7;');
                    
                    var column = table.columns(ui.item.attr('columnName')+':name');
                    
                    /* When filter box is moved here the keyup event is bound to it */
                    /* --------------------------------------------------------------------------------------- */
                    ui.item.children().children("input").keyup(
                    function(){        
                
                     if(ui.item.children().children("input").val().length>0){
                         /* When there are some characters typed in the input add/update filter array */            
                               filter[ui.item.attr('columnName')]=ui.item.children().children("input").val();                       
                               filterType[ui.item.attr('columnName')]=ui.item.attr('filterType');                       
                                                    
                        }else{
                            
                            /* Delete given filter item when user remove everything from the input */
                              delete filter[ui.item.attr('columnName')]; 
                              delete filterType[ui.item.attr('columnName')];
                        }
                        
                       refreshTable(fields, filter, filterType);
                    
                    });
                        
                    /* Here what is done after moving filter box itself */
                    /* -------------------------------------------------------------------------------------*/
                    column.visible(true);
                    
                        if(ui.item.children().children("input").val().length>0){    
                            /* When there are some inputs */
                               filter[ui.item.attr('columnName')]=ui.item.children().children("input").val();                                                   
                               filterType[ui.item.attr('columnName')]=ui.item.attr('filterType');                       
                        } else {
                            /* When the filter box is empty */
                               delete filter[ui.item.attr('columnName')];
                               delete filterType[ui.item.attr('columnName')];                                                        
                        }             
                    
                    
                    fields.push(ui.item.attr('columnAlias'));
                    
                    
                   refreshTable(fields, filter, filterType);
                    
                    
                },
                
                remove: function( event, ui){
                    
                 
                    
                     var column = table.columns(ui.item.attr('columnName')+':name');
                    column.visible(false);
                    
                    
                    ui.item.children().children("input").off('keyup');
                    
                    

                    /* Remove column and filter items */
                    delete filter[ui.item.attr('columnName')];
                    delete filterType[ui.item.attr('columnName')];
                    fields.remove(ui.item.attr('columnAlias'));

                    refreshTable(fields, filter, filterType);
                    
                 
                }
                
                
            });
            
      
    });



</script>

<div class='content-header'>  
    <img src="images/report.png" style="float: left;"/><div class="titleBar">Stwórz zestawienie</div><div class="closeButton btn btn-default" >zamknij</div>
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
    <table id="table" class="table table-striped table-bordered"></table>
    </div>
    
    <input type="hidden" name="where" id="where" value=""/>    
</div>
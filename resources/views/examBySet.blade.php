@include('js.datatables-logic')
@include('js.exam-columns')

<script>  

    

  $(document).ready(function(){                        

                  
        
 /*
  * Eaminations Table Initialization   
  */                      

    
         initTable('/ds/examsBySet/{{$set_id}}', getColumns());
         setTitleBar('/setname/{{$set_id}}');
         customFilterInit();

      
 
/* 
 *  Add Examination Button Event Handler
 */
     
     $('#addExamination').click(function(){
      
     
             dlg = new BootstrapDialog.show({
                                 title: 'Wprowadź Wynik Badania',
                                 message: $('<div></div>').load('/examination/new/'+$('#set_id').val()),
                                 draggable: true, 
                                 closeByBackdrop: false,
                                 type:  BootstrapDialog.TYPE_PRIMARY,
                                 buttons: [
                                        {
                                         label: '<span class="glyphicon glyphicon-edit"></span>&nbspzapisz',
                                         cssClass: 'btn-danger',
                                         id: 'btn-submit',
                                         action: function(dialog){
                                             $(function(){
                                              
                                                  $('#examForm').submit();
                                                
                                                table.ajax.reload(null, false);
                                                //Refresh datatables here
                                                
                                           });
                                          
                                          }
                                         
                                        },
                                        {
                                         label: 'zamknij',
                                         cssClass: 'btn-primary',
                                         action: function(dialog){                                            
                                         dialog.close();                                 
                                         }        
                                 }]
                                 
                        });  
      
  });
     

   
    
/*
 *  Close Button
 */
  $('.closeButton').click(function(){  
     $('.content').fadeOut();
    });
 
 


 
 });
  
  
  </script>
  
      
  <div class='content-header'>  
    <img src="images/set.png" style="float: left;"/><div class="titleBar"></div><div class="closeButton btn btn-default" >zamknij</div>
  </div>
  <div class='content-body'>
    <table id="table" class="table table-striped table-bordered"></table>
    <button class="btn btn-danger" id="addExamination">Rejestruj wynik</button>
    <button class="btn btn-default" id="addFilter">Wyznacz okres</button>
    <div class="searchFilter">
    
     <p>
            <div class="input-group date" style='width: 244px'>
                <input type="text" class="form-control" placeholder="Data Badania od" id="exam_date_from"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
     </p>
     <p>
            <div class="input-group date" style='width: 244px'>
                <input type="text" class="form-control" placeholder="Data Badania do" id="exam_date_to" />
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </p>                       
        <p>
            <button class="btn btn-primary" id="applyFilter">Filtruj</button>
        </p>
    </div>
  </div>


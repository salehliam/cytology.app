@include('js.datatables-logic')
@include('js.patient-columns')
<script>  


  function openEditPatient(id){
            
            
                  dlg = new BootstrapDialog.show({
                                 title: 'Edytuj pacjenta',
                                 message: $('<div></div>').load('/patient/edt/'+id),
                                 draggable: true, 
                                 closeByBackdrop: false,
                                 type:  BootstrapDialog.TYPE_PRIMARY,
                                 buttons: [
                                        {
                                         label: '<span class="glyphicon glyphicon-edit"></span>&nbspzapisz',
                                         cssClass: 'btn-danger',
                                         id: 'btn-submit',
                                         action: function(dialog){
                                             
                                             $('#patientForm').submit();
                                             
                                             
                                                                                                
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
                            
            
        }
        


  
  $(document).ready(function(){                        
                      

    initTable('/ds/patients/',getColumns());
    
    
     
    /*
    *  Close Button
    */
    $('.closeButton').click(function(){  
         $('.content').fadeOut();
    });
 
   
    });
    
   
  
  
  </script>
  
      
  <div class='content-header'>  
 <img src="images/patients.png" style="float: left;"/><div class="titleBar">Wykaz pacjentów</div><div class="closeButton btn btn-default">zamknij</div>
  </div>
  <div class='content-body'>  
<table id="table" class="table table-striped table-bordered"></table>

</div>



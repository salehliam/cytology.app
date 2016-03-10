<script>
    
  
  
  /*
   * Set title bar 
   *******************************************************************************************/
    
  function setTitleBar(varDS){
      
      
      $.ajax({
                type: "GET",
                url:  varDS,
                async: false,               
                dataType: 'json',
                
              success: function (data) {
                        
                $('.titleBar').text(data.result);                                 
                
              }});
      
  }
  
  
  /*
   * Table Init
   * Assume that all tables has the same columns but different datasource:
   * Exams by set, contractor and patient 
   *******************************************************************************************/
  
  function initTable(varDS,varColumns){
  
    
       table = $('#table').DataTable({
                                         
                   processing: true,
                   serverSide: false, /* When switching to server side, filtering stops working */
                    searching: true,
                   pageLength: 10,
                 lengthChange: false,
                    autoWidth: false, /* Necessary to keep table the same size while columns visibility is changed */
                      
                     
                          dom: 'Bfrtip',
                       buttons: [
                                   { extend: 'print',
                                       text: '<i class=\'glyphicon glyphicon-print\'></i></span>&nbsp&nbspDrukuj',
                                            exportOptions: {
                                                   columns: ':visible'  /* Necessary to keep column visibilty setting on the print-out too */
                                            }
                                   },
                                   { extend: 'pdf',
                                       text: '<i class=\'glyphicon glyphicon-file\'></i>&nbsp&nbspPdf',
                                            exportOptions: {
                                                   columns: ':visible'
                                            }
                                   },
                                   { extend: 'excel',
                                       text: '<i class=\'glyphicon glyphicon-file\'></i>&nbsp&nbspExcel',
                                             exportOptions: {
                                                   columns: ':visible'
                                            }
                                   },
                                   { extend: 'colvis',
                                     text: 'Ukryj kolumny'
                                   },
                                   { text: 'Edytuj',
                                            action: initEditable
                                   }
                               
                               ],
                         
                          
                
                                                                        
                language: {                           
                        processing: "wczytuje dane",                        
                        loadingRecords: ""
                      }, 
                      
            
                   ajax: {
                       url: varDS,
                       async: false,
                       dataSrc: 'data'
                       
                   },
                   
                 columns: varColumns
                                                                               
      });
                              
      
  }
  
  function initTableReport(varDS,varColumns){
  
        $.fn.dataTable.ext.errMode = 'none';
  
          table = $('#table').DataTable({
                                         
                   processing: true,
                   serverSide: false, /* When switching to server side, filtering stops working */
                    searching: false,
                       paging: false,
                 lengthChange: false,
                    autoWidth: false, /* Necessary to keep table the same size while columns visibility is changed */
                     scrollY: 500,    /* Making vertical viewport for datatable */
                     scrollX: true,
                     
                        dom: 'Bfrtip',
                       buttons: [
                                   { extend: 'print',
                                       text: '<i class=\'glyphicon glyphicon-print\'></i></span>&nbsp&nbspDrukuj',
                                            exportOptions: {
                                                   columns: ':visible'  /* Necessary to keep column visibilty setting on the print-out too */
                                            }
                                   },
                                   { extend: 'pdf',
                                       text: '<i class=\'glyphicon glyphicon-file\'></i>&nbsp&nbspPdf',
                                            exportOptions: {
                                                   columns: ':visible'
                                            }
                                   },
                                   { extend: 'excel',
                                       text: '<i class=\'glyphicon glyphicon-file\'></i>&nbsp&nbspExcel',
                                             exportOptions: {
                                                   columns: ':visible'
                                            }
                                   }                               
                               
                               ],
                                                                        
                language: {                           
                        processing: "wczytuje dane",                        
                        loadingRecords: ""
                      }, 
                      
            
                   ajax: {
                       url: varDS,
                       async: false,
                       dataSrc: 'data'
                       
                       
                   },
                   
                 columns: varColumns
                                                                               
      });
  
  
  
    }
  
  
  /*
   * Init Editable Feature 
   *******************************************************************************************/
   
  function initEditable(){
      
       $('.contractor').css('color','#0088CC');
       $('.doctor').css('color','#0088CC');
       $('.result').css('color','#0088CC');
       //$('.set').css('color','#0088CC');
       $('.exam_date').css('color','#0088CC');
      
       $.fn.editable.defaults.ajaxOptions = {type: "GET"};
      
       $('.doctor').editable({
           type: 'text',
           url: '/examination/chg/doctor',
           validate: function(value) {
                if (value === null || value === '') {
                    return 'Nie może być puste!';
                }
            }
         });
                                            
       $('.contractor').editable({
           type: 'select',
           url: '/examination/chg/contractor_id',
           source: dsContractorsInline         
           
       });
      
       /* You cannot let user move results between sets because they have their own counters
        * You would have to change them 
          
       $('.set').editable({
           type: 'select',
           url: '/examination/chg/set_id',
           source: dsSetsInline,
           success: refreshTable
           
       });
       */
       
         $('.result').editable({
           type: 'select',
           url: '/examination/chg/result',
           source: [{value: 'NORMA', text: 'NORMA'},
                    {value: 'ASCUS', text: 'ASCUS'},
                    {value: 'LSIL',  text: 'HSIL'},
                    {value: 'CA',    text: 'CA'}]
                
           
       });
      
       
       $('.exam_date').editable({
           type: 'date',      
           format: 'yyyy-mm-dd',
           viewformat: 'yyyy-mm-dd',
           url: '/examination/chg/exam_date',
           datepicker:{
                   language: "pl",
                   weekStart: 1                   
                     }
           
           
           
       });
       
     
  }
  
  /*
  *  Refresh Table
  *******************************************************************************************/
  
   function refreshTable(){
      
         table.ajax.reload(null, false);
         
      
  }
  
  /*
   *  Contractotrs list for Inline Editing
   *******************************************************************************************/
  
  function dsContractorsInline(){
      
      
      var data = $.ajax({
                type: "GET",
                url:  "/ds/contractors/inline",
                async: false,               
                dataType: 'json'
                                                                        
             }).responseJSON;                     
      
      return data;              
       }

/*
 *  Sets list for Inline Editing 
 *******************************************************************************************/
  


  function dsSetsInline(){
      
      
      var data = $.ajax({
                type: "GET",
                url:  "/ds/sets/inline",
                async: false,               
                dataType: 'json'
                                                                        
             }).responseJSON;                     
      
      return data;              
       }

  
/*
 *  Custom Filter init
 *******************************************************************************************/

 function customFilterInit(){
 
     $('#addFilter').click(function(){  
            $('.searchFilter').toggle('slide','left',500);
     });
 
 
     $('#applyFilter').click(function(){  
     

$.fn.dataTableExt.afnFiltering.push(
 
     function( oSettings, aData, iDataIndex ) {
    
        dateMin = $('#exam_date_from').val();
        dateMax = $('#exam_date_to').val();
        
        var date = aData[7];
        
        if ( dateMin == "" && date <= dateMax){
            return true;
        }
        else if ( dateMin =="" && date <= dateMax ){
            return true;
        }
        else if ( dateMin <= date && "" == dateMax ){
            return true;
        }
        else if ( dateMin <= date && date <= dateMax ){
            return true;
        }
        // all failed
        return false;
    }
);

 
        table.draw();

     
    });
     
 
 
    $('.input-group.date').datepicker({
                
                    language: "pl",
                    todayBtn: false,
                    autoclose: true,
                    format: "yyyy-mm-dd"
                    
                    
                 });
 
 
    
}

    
    
</script>
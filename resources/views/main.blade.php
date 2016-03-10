<html>
    <head>              

             @include('main-inc')
        
        
        
        <script>
            
         function openPatients(){

            $.when($('.content').fadeOut()).done(function(){            
                   $.when($('.content').load('/patients/')).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });   

             
             
         }
         
         
        function openPatient(id){
            
            $.when($('.content').fadeOut()).done(function(){            
                   $.when($('.content').load('/examsByPatient/'+id)).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });   
            
        }
        
        function openContractor(id){
            
              $.when($('.content').fadeOut()).done(function(){                                                         
                    $.when($('.content').load('/examsByContractor/'+id)).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });   
            
        }
            
            
        function openSet(id){
            
            $.when($('.content').fadeOut()).done(function(){            
                $('#set_id').val(id);                                
                    $.when($('.content').load('/examsBySet/'+id)).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });                                           
        }    
            

        function createReport(){
            
            $.when($('.content').fadeOut()).done(function(){            
                     $.when($('.content').load('/report/create')).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });                                           
            
            
        }
            
       
        function createGraph(){
            
             $.when($('.content').fadeOut()).done(function(){            
                     $.when($('.content').load('/graph/create')).done(function(){                    
                        $('.content').fadeIn();                            
                    });            
                });                                           
            
        }
            
            
        function refreshSetMenuList(){
                       
            $('li[id^="setId"]').remove();
            
            $.ajax({
                type: "GET",
                url:  "/ds/sets",
                dataType: 'json',
                async: false,
                
              success: function (data) {
            
                   $(data.sets).each(function(index, value){
                                
                     $("#sets_menu").append("<li id='setId"+value.id+"'><a href='#' onClick='openSet("+value.id+")'>"+value.name+"</a></li>");                                       
                   
                });
                
              }});
          
                 
            
        }
        
        function refreshContractorMenuList(){
            
            $('li[id^="contractorId"]').remove();
            
            $.ajax({
                type: "GET",
                url:  "/ds/contractors",
                dataType: 'json',
                async: false,
                
              success: function (data) {
                      
                      
                   $(data.contractors).each(function(index, value){
                                                                                                                                   
                     $("#contractors_menu").append("<li id='contractorId"+value.id+"'><a href='#' onClick='openContractor("+value.id+")'>"+value.name+"</a></li>");

                   
                });
              }});
            
            
        }
        
        
      
    
        /*
         * Prevent every form from being sent on Enter Key
         */
        $(document).on("keypress", "form", function(event) { 
                        return event.keyCode != 13;
        });              
        
                    
        
        
        
        $(document).ready(function(){
                
        refreshSetMenuList();
        
        refreshContractorMenuList();
        
        
                   
           $('#addSet').click(function(){
           
                  dlg = new BootstrapDialog.show({
                                 title: 'Dodaj kartotekę',
                                 message: $('<div></div>').load('/set/new'),
                                 draggable: true, 
                                 closeByBackdrop: false,
                                 type:  BootstrapDialog.TYPE_PRIMARY,
                                 buttons: [
                                        {
                                         label: '<span class="glyphicon glyphicon-edit"></span>&nbspdodaj',
                                         cssClass: 'btn-danger',
                                         id: 'btn-submit',
                                         action: function(dialog){
                                             
                                             $('#setForm').submit();                                             
                                             refreshSetMenuList();
                                               
                                                
                                                                                                
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
           
         
  
  $("#searchPatientInput").keyup(function(event){
    if(event.keyCode == 13){
        $("#searchPatientButton").click();
    }
});
  
  
  $('#searchPatientButton').click(function(e){
           
                
                e.stopPropagation();
                
                $('li[id^="patientId"]').remove();
                
                $.ajax({
                type: "GET",
                async: false,
                url:  "/patient/search/"+$('#searchPatientInput').val(),
                dataType: 'json',
                
                
              success: function (data) {                                    
                
                
                   $(data.sets).each(function(index, value){
                                                
                     $("#patients_menu").append("<li id='patientId"+value.id+"'><a href='#' onClick='openPatient("+value.id+")' >"+value.person+"<span class='menuitem_details'> "+value.peselorage+"</span></a></li>");
                   

                   
                });
              }});
                
               
           });
  
  });
           
           
        
        
        </script>        
        
        
    </head>
    
    <body>        
     
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                 <div class="navbar-header">
                    <a class="navbar-brand" href="#">
                        
                    </a>
                </div>
                
                
                <ul class="nav navbar-nav">        
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Kartoteka <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="sets_menu">
                                <li><a href="#" id="addSet">Nowa kartoteka</a></li>
                                <li role="separator" class="divider"></li>                                
                            </ul>
                        </li>
                        
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Pacjenci <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="patients_menu" style="width: 260px;">
                                <li style="padding-left: 4px; padding-right: 4px;">
                                    <input type="text" style="width: 213px; float: left; margin-bottom: 10px;" class="form-control" placeholder="Wyszukaj..." id="searchPatientInput"/>
                                    <div class="icomenu search" style="margin-left:7px;" id="searchPatientButton"></div>
                                </li>
                                <li><a href="#" id="showPatients" onClick="openPatients()" >Otwórz Wykaz</a></li>                                
                                <li role="separator" class="divider"></li>                                
                            </ul>
                     </li>
                  
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Odbiorcy <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="contractors_menu">
                                <li></li>
                        
                            </ul>
                     </li>
                  
                     <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Raporty <span class="caret"></span></a>
                            <ul class="dropdown-menu" id="contractors_menu">
                                <li><a href="#" id="createReport" onClick="createReport()">Zestawienie</a></li>                                
                                <li><a href="#" id="createGraph" onClick="createGraph()">Wykres</a></li>                                
                            </ul>
                     </li>
                     
                 </ul>
                
                
            </div>
       </nav>
        
        
       
        <div class="row row-centered">
                    <div class="col-xl-2 col-centered">
                       <div class="content">                                                 
                                @yield('content')                        
                       </div>
                    </div>            
        </div>        
                      
                        
       
        
        <input type="hidden" id="set_id">
        
        
        
            </body>
    
</html>
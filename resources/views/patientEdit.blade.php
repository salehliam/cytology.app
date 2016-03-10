<html>
    <head>
        <script>
                             
            $(document).ready(function(){

           
            $("#patientForm").validationEngine('attach',
                    { 
                     promptPosition: "centerRight", 
                     scroll: false,
                     ajaxFormValidation: true,        /* Form's Action URL will be called via AJAX */                                                 
           
                    onAjaxFormComplete: function(status){
                        $('#btn-submit').button('loading');
                        table.ajax.reload(null, false);
                        dlg.close();
                      
                     }
 

                   }
            );
    
        });
        
         </script>
        
            
  
            
   
        
        </script>        
    </head>
<body>
    <form action="/patient/upd/{{$patient->id}}" method="get" id="patientForm">
          
        
        
            
        <p><!-- person -------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Nazwisko i Imię" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="person" value="{{$patient->person}}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            </div>            
        </p>
        <p><!-- age ----------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Wiek" data-validation-engine="validate[groupRequired[perid],custom[age]]" data-prompt-position="right:-22,32" name="age" value="{{$patient->age}}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
            </div>
        </p>
        <p><!-- pesel --------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Pesel" data-validation-engine="validate[groupRequired[perid],custom[pesel],ajax[ajaxPeselExceptMeCheck]]" data-prompt-position="right:-22,32" name="pesel" value="{{$patient->pesel}}"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
            </div>
        </p>        
        
        <input type="hidden" name="currentId" id="currentId" value="{{$patient->id}}">
    

</form>
</body>
</html>
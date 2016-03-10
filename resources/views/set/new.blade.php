<html>
    <head>
        <script>
            
       $(document).ready(function(){
            
          $("#setForm").validationEngine('attach',
                    { 
                     promptPosition: "centerRight", 
                     scroll: false,
                     ajaxFormValidation: true,        /* Form's Action URL will be called via AJAX */                                                 
                                            
                    onAjaxFormComplete: function(status){
                        $('#btn-submit').button('loading');
                        dlg.close();
                      
                     }
                                            
                   }
            );            
        });
        
            
            
        </script>        
    </head>
<body>
    <form id="setForm" action="/set/ins">
    <p>
        <div class="input-group">
        <input type="text" name="name" class="form-control" placeholder="nazwa kartoteki" data-validation-engine="validate[required,maxSize[20],ajax[ajaxSetNameCheck]]"></input>
        <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
        </div>    
    </p>
    </form>

</form>
</body>
</html>
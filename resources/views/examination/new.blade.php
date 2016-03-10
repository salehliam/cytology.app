<html>
    <head>
        <script>
            
            
      /*
       * Helper Functions 
       */      
            
      function refreshContractorList(){
          
          
              $.ajax({
                type: "GET",
                url:  "/ds/contractors",
                async: false,               
                dataType: 'json',
                
              success: function (data) {
                        
                   $(data.contractors).each(function(index, value){
                                                
                     $("#contractors").append("<option value='"+value.id+"'>"+value.name+"</option>");
                     
                   
                });
                
              
                
              }});
          
      }            
        
      function refreshPersonList(){
            
            /*
             * WARNING: async: false is necessary to make chosen plugin wait 
             * until the whole option list is built. Otherwise $('#patients').chosen() 
             * will run first on the empty list eventhough it is evoked after refreshPersonList
            */
           
              $.ajax({
                type: "GET",
                url:  "/ds/patientsDropdown",
                async: false,               
                dataType: 'json',
                
              success: function (data) {
                        
                   $(data.patients).each(function(index, value){
                                                
                     $("#patients").append("<option data-subtext='"+value.peselorage+"' value='"+value.id+"'>"+value.person+"</option>");
                     
                   
                });
                
              
                
              }});
            
        
        }
        
                             
            $(document).ready(function(){

            
            $("#examForm").validationEngine('attach',
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
    
        
            /*
             * Patients list Initialization
             */
        
           refreshPersonList();
           
           $('#patients').selectpicker({
               
               showSubtext: true
                              
                
            });
                     
           /*
            * Contractor list Initialization 
            */
       
           refreshContractorList();
           
           $('#contractors').selectpicker({
               
               showSubtext: true
                              
                
            });
       
       
           /*
            * Toggle New Patient vs Chosen Patient 
            */

           $('#patients').on('changed.bs.select', function(){
              
              var selected = $('#patients').selectpicker('val');
              
              if(selected==0){
                  
                  $(".new_patient").slideDown();
                  $("#new_patient").val('true');
                  
              }else{
                  
                  $(".new_patient").slideUp();
                  $("#new_patient").val('false');
              }
              
           });
  
  
           /*
            * DatePicker Initialization 
            */
                $('.input-group.date').datepicker({
                
                    language: "pl",
                    todayBtn: false,
                    autoclose: true,
                    format: "yyyy-mm-dd"
                    
                    
                 });
            
           /*
            * Labelauty Radio Buttons Initialization
            */ 
  
              $(":radio").labelauty();
                  
            /*
             * HACK: Making Bootstrap Select work with JQuery Validation Engine 
             */
            var prefix = "selectBox_";
        
                $('#contractors').each(function() {
                $(this).next('div.bootstrap-select').attr("id", prefix + this.id).removeClass("validate[required,min[1]]");
        
                $(this).next('div.bootstrap-select').attr("id", prefix + this.id).removeClass("Pole wymagane");
        
           });
              
  
        });
        
  
            
   
        
        </script>        
    </head>
<body>
    <form action="/examination/ins" method="post" id="examForm">
          
        <fieldset>
            <legend>Pacjent</legend>
    <p>
        <select id="patients" data-live-search="true" data-width="568px" name="patient_id"  >
            <option value="0">Nowy pacjent...</option>
        </select>            
    </p>
    <div class="new_patient">
        
            
        <p><!-- person -------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Nazwisko i Imię" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="person"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            </div>            
        </p>
        <p><!-- age ----------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Wiek" data-validation-engine="validate[groupRequired[perid],custom[age]]" data-prompt-position="right:-22,32" name="age"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-signal"></i></span>
            </div>
        </p>
        <p><!-- pesel --------------------------------------------------->
            <div class="input-group">
            <input type="text" class="form-control" placeholder="Pesel" data-validation-engine="validate[groupRequired[perid],custom[pesel],ajax[ajaxPeselCheck]]" data-prompt-position="right:-22,32" name="pesel"/>
            <span class="input-group-addon"><i class="glyphicon glyphicon-credit-card"></i></span>
            </div>
        </p>        
        
    </div>
    
    </fieldset>
          
    <fieldset>
    <legend>Badanie</legend>
    <div class="examination_details">
        
        <p>
        <select id="contractors" data-live-search="true" data-width="568px" data-validation-engine="validate[required,min[1]]" data-errormessage="Pole wymagane" data-prompt-position="right:197,32" name="contractor_id">
            <option value="0">Wybierz odbiorcę...</option>
        </select>            
        </p>
        
        
        <p>
            <div class="input-group">
            <input type="text" class="form-control " placeholder="Numer Badania" data-validation-engine="validate[required,ajax[ajaxContractorExamNumberCheck]]" data-prompt-position="right:-22,32"  name="contractor_exam_number"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
            </div>
        </p>
        
        <p>
             <div class="input-group">
            <input type="text" class="form-control" placeholder="Lekarz Kierujący" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="doctor" />
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
             </div>
        </p>
        
        <p>
            <div class="input-group date">
                <input type="text" class="form-control" placeholder="Data Otrzymania Badania" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="income_date"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </p>                           

        <p>
            <div class="input-group date">
                <input type="text" class="form-control" placeholder="Data Pobrania Materiału" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="sample_date"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </p>                           
        
        <p>
            <div class="input-group date">
                <input type="text" class="form-control" placeholder="Data Wyniku" data-validation-engine="validate[required]" data-prompt-position="right:-22,32" name="exam_date"/>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </p>                           
                                
        
    </div>
     </fieldset>
        
     <fieldset> 
         <legend>Wynik</legend>
         <div class = 'form-horizontal well' style="background: white;">
         <ul class="result_choice">
            
         <li><input type="radio" name="result" value="NORMA" data-labelauty="NORMA" checked></li>
         <li><input type="radio" name="result" value="ASCUS" data-labelauty="ASCUS"> </li>
         <li><input type="radio" name="result" value="LSIL" data-labelauty="LSIL"> </li>
         <li><input type="radio" name="result" value="HSIL" data-labelauty="HSIL"> </li>
         <li><input type="radio" name="result" value="CA" data-labelauty="CA"> </li>
         
         </ul>
         </div>
    </fieldset>
        
        <input type="hidden" name="new_patient" id="new_patient" value="true"/>
        <input type="hidden" name="set_id" id="set_id" value="{!! $set_id !!}" />
    
    </form>

</form>
</body>
</html>
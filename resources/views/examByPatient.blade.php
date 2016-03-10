@include('js.datatables-logic')
@include('js.exam-columns')
<script>  

  
  $(document).ready(function(){                        
                      
       initTable('/ds/examsByPatient/{{$patient_id}}',getColumns());
       setTitleBar('/patname/{{$patient_id}}');
       customFilterInit();
 
       /*
        *  Close Button
        */
  
         $('.closeButton').click(function(){  
         $('.content').fadeOut();
    });
 
 
 });
    
   
  
  
  </script>
  
      
 <div class='content-header'>   
 <img src="images/patient.png" style="float: left;"/><div class="titleBar"></div><div class="closeButton btn btn-default">zamknij</div>
 </div>
  <div class='content-body'>
 <table id="table" class="table table-striped table-bordered"></table>
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



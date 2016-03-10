<?php

namespace App\Http\Controllers;


use App\Set;
use App\Patient;
use App\Contractor;
use App\Examination;
use Illuminate\Support\Facades\Input;
use Response;
use Redirect;
use Datatables;
use DB;


class MainController extends Controller
{
    
    
    /*
     *  Set     
     *******************************************************************************************************/
      
     public function newSet()
    {                     
        return view('set.new');        
    }
    
      
    public function insSet(){
        
        $set = new Set;
        $set->name = Input::get('name');
        $set->save();
        
        return Response::json(['status' => 'ok']);
    }
    
    
    public function getSetName($id){
        
        
        $set = Set::find($id);
                
        
        return Response::json(['result' => $set->name]);
        
    }
    
    /*
     * Examination
     ********************************************************************************************************/
    
    
    public function examsBySet($set_id){
        
        return view('examBySet')->with('set_id',$set_id);
    }
    
    public function examsByPatient($patient_id){
        
        return view('examByPatient')->with('patient_id',$patient_id);
    }
    
    public function examsByContractor($contractor_id){
        
        return view('examByContractor')->with('contractor_id',$contractor_id);
    }
    
    
    public function newExamination($set_id)
    {                     
        return view('examination.new')->with('set_id',$set_id);        
    }
    
    public function chgExamination($field){
     
        /*
         * Update given field with a value and id of examination provided by X-editable
         */
        
         DB::update("update examination set $field = ? where id = ?",array(Input::get('value'),Input::get('pk')));
        
    }
    
     public function insExamination()
    {                     
         
            $set = Set::find(Input::get('set_id'));
         
            //Next counter for the new examination in the given set
                $nextExamNum = $set->counter+1;
                $set->counter = $nextExamNum;
                $newExam = new Examination;
                $newExam->counter = $nextExamNum;
                $newExam->contractor_id = Input::get('contractor_id');
                $newExam->cen = Input::get('contractor_exam_number');
                $newExam->doctor = Input::get('doctor');
                $newExam->income_date = Input::get('income_date');
                $newExam->sample_date = Input::get('sample_date');
                $newExam->exam_date = Input::get('exam_date');
                $newExam->input_date = date('Y-m-d H:i:s');   
                $newExam->result = Input::get('result');
                $newExam->set_id = Input::get('set_id');
                
                
            //Case a new patient is fed in
            if(Input::get('new_patient')=='true'){
              
                $patient = new Patient;
                
                $patient->person = Input::get('person');
                if(Input::get('age')!=null){
                    $patient->age = Input::get('age');
                }
                if(Input::get('pesel')!=null){
                $patient->pesel = Input::get('pesel');
                }
                $patient->save();
                
                $newExam->patient_id = $patient->id;
                $newExam->save();
                $set->save();
              
                
            //Case an existing patient was picked for the new examination
            }else{
              
          
                $newExam->patient_id = Input::get('patient_id');
                $newExam->save();
                $set->save();
              
           }
        
           return Response::json(['status' => 'ok']);
           
           
            
           
    }  
    
    /*
     * Patient
     ********************************************************************************************************/
    
      public function patientsList(){
        
        return view('patientsList');
    }
    
    
    public function edtPatient($id){
        
        $p = Patient::find($id);
        return view('patientEdit')->with('patient',$p);
        
    }
    
    
    public function updPatient($id){
        
        
        $p = Patient::find($id);
        
        $p -> person = Input::get('person');        
        
        if(Input::get('age')!=''){
            $p -> age = Input::get('age');
        }
        if(Input::get('pesel')!=''){
            $p -> pesel = Input::get('pesel');
        }
        $p -> save();
        
            return Response::json(['status' => 'ok']);
        
    }
    
    public function searchPatient($value){

       return Response::json(['sets' => Patient::
                             where('patient.person','LIKE',"%$value%")
                            ->orWhere('patient.pesel','LIKE',"%$value%")
                            ->get()]);
           
           
                       
    }
    
    public function getPatientName($id){
        
        
        $pat = Patient::find($id);
                
        
        return Response::json(['result' => $pat->person]);
        
    }
    
    /*
     * Contractor
     ********************************************************************************************************/
    
    public function getContractorName($id){
        
        
        $con = Contractor::find($id);
                
        
        return Response::json(['result' => $con->name]);
        
    }
    
    /*
     * Report
     ********************************************************************************************************/
    
    public function createReport(){
        
        return view('createReport');
        
    }
    
    
    /*
     * Graph
     ********************************************************************************************************/
    
    public function createGraph(){
        
        return view('createGraph');
        
    }
    
    
    
    
    
    
    /*
     * Exisitng checks for validator (JQuery Validation Engine)
     **********************************************************************************************************/
    
    
    public function chkSet(){
        
         if(Set::where('name',Input::get('fieldValue'))->exists()){
             
                return Response::json(array(Input::get('fieldId'),false,'Podana kartoteka już istnieje'));            
             
         }else{
             
                return Response::json(array(Input::get('fieldId'),true,''));            
             
         }
                                                 
        
    }
        
    
     public function chkContractorExamNumber(){
        
         if(Examination::where('cen',Input::get('fieldValue'))->where('deleted',false)->exists()){
             
                return Response::json(array(Input::get('fieldId'),false,'Badanie już istnieje'));            
             
         }else{
             
                return Response::json(array(Input::get('fieldId'),true,''));            
             
         }
                                                 
        
    }
    
    /*
     * Warning the following two methods can be replaced by one, checking if Input::get('currentId') is NULL or NOT
     */
    public function chkPesel(){

        
        
         if(Patient::where('pesel',Input::get('fieldValue'))->exists()){
             
                return Response::json(array(Input::get('fieldId'),false,'Podany PESEL już istnieje'));            
             
         }else{
             
                return Response::json(array(Input::get('fieldId'),true,''));            
             
         }
                            
    }
    
    public function chkPeselExceptMe(){
        
        $id = Input::get('currentId');
        
         if(Patient::where('pesel',Input::get('fieldValue'))->where('id','<>',$id)->exists()){
             
                return Response::json(array(Input::get('fieldId'),false,'Podany PESEL już istnieje'));            
             
         }else{
             
                return Response::json(array(Input::get('fieldId'),true,''));            
             
         }
                            
    }
    
    
    
    
    /* 
     * Ajax Data Sources 
     *********************************************************************************************************/
    
    public function dsExamsGraph(){
        
             if(Input::has('filter')){
             /* When ther is filter defined create json data for the graph using filter criteria */        

                $filter = Input::get('filter');
                $year   = Input::get('year'); 

                /* Using DB::raw you can iclude any SQL inside QueryBuilder */   
                $res = DB::table( DB::raw("UNNEST(ARRAY[1,2,3,4,5,6,7,8,9,10,11,12]) month(id)") )
                       ->leftJoin(DB::raw("(SELECT examination.id, examination.exam_date "
                                         . "FROM examination "
                                         . "JOIN patient    ON    patient.id = examination.patient_id "
                                         . "JOIN set        ON        set.id = examination.set_id "
                                         . "JOIN contractor ON contractor.id = examination.contractor_id "
                                         . "WHERE $filter AND EXTRACT(YEAR FROM examination.exam_date)=$year) as e"), 
                                   DB::raw('EXTRACT(MONTH FROM e.exam_date)'),'=',DB::raw('month.id')) 
                       ->groupBy("month_id")
                       ->orderBy("month_id")
                       ->get([              
                            DB::raw("month.id AS month_id"),
                            DB::raw("fmonth(month.id) AS date"),
                            DB::raw("COUNT(e.id) as value")
                         ]);        



                return Response::json($res);   
              
             }else{
             
                 
             /* When there is no filter defined reset the graph */    
             /*
                $res = Array(
                       ['date' => 'Sty', 'value' => 0],
                       ['date' => 'Lut', 'value' => 0],
                       ['date' => 'Mar', 'value' => 0],
                       ['date' => 'Kwi', 'value' => 0],
                       ['date' => 'Maj', 'value' => 0],
                       ['date' => 'Cze', 'value' => 0],
                       ['date' => 'Lip', 'value' => 0],
                       ['date' => 'Sie', 'value' => 0],
                       ['date' => 'Wrz', 'value' => 0],
                       ['date' => 'Paz', 'value' => 0],
                       ['date' => 'Lis', 'value' => 0],
                       ['date' => 'Gru', 'value' => 0],
                   );
               */

                $year   = Input::get('year'); 

                /* Using DB::raw you can iclude any SQL inside QueryBuilder */   
                $res = DB::table( DB::raw("UNNEST(ARRAY[1,2,3,4,5,6,7,8,9,10,11,12]) month(id)") )
                       ->leftJoin(DB::raw("(SELECT examination.id, examination.exam_date "
                                         . "FROM examination "
                                         . "JOIN patient    ON    patient.id = examination.patient_id "
                                         . "JOIN set        ON        set.id = examination.set_id "
                                         . "JOIN contractor ON contractor.id = examination.contractor_id "
                                         . "WHERE EXTRACT(YEAR FROM examination.exam_date)=$year) as e"), 
                                   DB::raw('EXTRACT(MONTH FROM e.exam_date)'),'=',DB::raw('month.id')) 
                       ->groupBy("month_id")
                       ->orderBy("month_id")
                       ->get([              
                            DB::raw("month.id AS month_id"),
                            DB::raw("fmonth(month.id) AS date"),
                            DB::raw("COUNT(e.id) as value")
                         ]);        

                 
                return Response::json($res);   
                 
             }
             
        
        
    }
    
    
    public function dsExamsReport(){
        
        if(!Input::has('fields')){
         
          $examinations = new \Illuminate\Database\Eloquent\Collection;
          //$examinations = \App\Examination::findOrFail(0);
         
         return Datatables::of($examinations)->make(true);
            
        }else{
            
            
            $fieldsArr = explode(',',Input::get('fields'));

            if(Input::has('where')){
            
              $examinations = \App\Examination::join('set','examination.set_id','=','set.id')
                ->join('patient','examination.patient_id','=','patient.id')
                ->join('contractor','examination.contractor_id','=','contractor.id')
                ->select($fieldsArr)
                ->whereRaw(Input::get('where'));      
              
            }else{
                
                $examinations = \App\Examination::join('set','examination.set_id','=','set.id')
                ->join('patient','examination.patient_id','=','patient.id')
                ->join('contractor','examination.contractor_id','=','contractor.id')
                ->select($fieldsArr);
                
                
                
            }
              
         return Datatables::of($examinations)->make(true);
            
            
        }
        
       
        
    }
    
    public function dsSets(){

       return Response::json(['sets' => Set::all()]);
                       
    }
    
    public function dsExamsBySet($set_id)
    {

                
        $examinations = \App\Examination::join('set','examination.set_id','=','set.id')
                ->join('patient','examination.patient_id','=','patient.id')
                ->join('contractor','examination.contractor_id','=','contractor.id')
                ->select([
                    'examination.id',
                    'examination.counter',
                    'set.name as setname', 
                    'examination.doctor',
                    'examination.result',
                    'examination.cen',
                    'examination.exam_date',
                    'patient.person',
                    'patient.age',
                    'patient.pesel',
                    'contractor.name'
                    ])
                ->where("set_id",$set_id);                    
         return Datatables::of($examinations)->make(true);
                  
    }

    
     public function dsExamsByPatient($patient_id)
    {

                
        $examinations = \App\Examination::join('set','examination.set_id','=','set.id')
                ->join('patient','examination.patient_id','=','patient.id')
                ->join('contractor','examination.contractor_id','=','contractor.id')
                ->select([
                    'examination.id',
                    'examination.counter',
                    'set.name as setname', 
                    'examination.doctor',
                    'examination.result',
                    'examination.cen',
                    'examination.exam_date',
                    'patient.person',
                    'patient.age',
                    'patient.pesel',
                    'contractor.name'
                    ])
                ->where("patient_id",$patient_id);                    
         return Datatables::of($examinations)->make(true);
                  
    }
    
    
    public function dsExamsByContractor($contractor_id)
    {

                
        $examinations = \App\Examination::join('set','examination.set_id','=','set.id')
                ->join('patient','examination.patient_id','=','patient.id')
                ->join('contractor','examination.contractor_id','=','contractor.id')
                ->select([
                    'examination.id',
                    'examination.counter',
                    'set.name as setname', 
                    'examination.doctor',
                    'examination.result',
                    'examination.cen',
                    'examination.exam_date',
                    'patient.person',
                    'patient.age',
                    'patient.pesel',
                    'contractor.name'
                    ])
                ->where("contractor_id",$contractor_id);       
        
        
        
         return Datatables::of($examinations)->make(true);
                  
    }

    
    public function dsExams()
    {
                
        $examinations = \App\Examination::join('set','examination.set_id','=','set.id')->select(['counter','set.name', 'doctor','result']);
        return Datatables::of($examinations)->make(true);
                  
    }

    
    public function dsPatientsDropdown(){
       
         return Response::json(['patients' => Patient::all()]);
        
    }
    
    public function dsPatients(){
        
       
        
        $patients = Patient::all();
        return Datatables::of($patients)->make(true);
        
    }

    public function dsContractors(){
        
        return Response::json(['contractors' => Contractor::all()]);
        
    }
    
    /* 
     * Ajax Data Sources for X-editable
     *********************************************************************************************************/
    

    public function dsContractorsInline(){
        /*
         * Building Contractors JSON accepted by X-editable [value,text]
         */
        
        $result = new \Illuminate\Database\Eloquent\Collection;
        $item = array();
        $contractors = Contractor::all();
        foreach($contractors as $contractor){
            
            $item['value'] =  $contractor->id;
            $item['text']  =  $contractor->name;
            $result->push($item);
        }
           
        return Response::json($result);
        
    }        
    
    
    public function dsSetsInline(){
        /*
         * Building Sets JSON accepted by X-editable [value,text]
         */
        
        $result = new \Illuminate\Database\Eloquent\Collection;
        $item = array();
        $sets = Set::all();
        foreach($sets as $set){
            
            $item['value'] =  $set->id;
            $item['text']  =  $set->name;
            $result->push($item);
        }
           
        return Response::json($result);
        
    }        
    
    
    

    
}
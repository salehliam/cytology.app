<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model {
    
    
      protected     $table      = 'patient';
      public        $timestamps = false;
      protected     $appends    = array('peselorage','lastResult','lastExam','examsNum');
      
               
      public function getPeselorageAttribute(){
             
             if($this->pesel!=null && $this->age==null){
                 
                return "Pesel $this->pesel";
                 
             }
             
             if($this->pesel==null && $this->age!=null){
                 
                return "Wiek $this->age";
                 
             }
                 
             if($this->pesel!=null && $this->age!=null){
                 
                return "Pesel $this->pesel Wiek $this->age";
                 
             }
          
             
             
         }

         public function getLastResultAttribute(){
             
             $e =  Examination::where('patient_id',$this->id)->orderBy('exam_date','DESC')->first();
             return $e->result;
             
         }
         
         public function getLastExamAttribute(){
             
             $e =  Examination::where('patient_id',$this->id)->orderBy('exam_date','DESC')->first();
             return $e->exam_date;
             
         }
         
         public function getExamsNumAttribute(){
             
             $count =  Examination::where('patient_id',$this->id)->count();
             return $count;
             
         }
         
         
         
         
         
         
}
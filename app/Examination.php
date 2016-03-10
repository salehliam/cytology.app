<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Examination extends Model {
    
    
      protected $table      = 'examination';
         public $timestamps = false;
      protected $appends    = array('patient','contractor','set');
    
        public function getPatientAttribute(){
         
             return $this->hasOne('App\Patient','id','patient_id')->get();
                                          
         }
         
         public function getContractorAttribute(){
         
             return $this->hasOne('App\Contractor','id','contractor_id')->get();
                                          
         }
         
         public function getSetAttribute(){
         
             return $this->hasOne('App\Set','id','set_id')->get();
                                          
         }
      
         
         
}
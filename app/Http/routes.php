<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/* SQL Debug */

Event::listen('illuminate.query', function($query, $bindings){
                     
        foreach($bindings as $b){
            $query = preg_replace('/\?/',$b,$query);
           
        }
                           
        $content = date('Y-m-d H:i:s')."> ".$query."\r\n";  
        
        
        File::append(storage_path().'/logs/sql.log',$content);
                               
});

/*****************************************************************/


Route::get('/', function () {
    return view('main');
});

Route::get('set/new',                                   'MainController@newSet');
Route::get('set/ins',                                   'MainController@insSet');
Route::get('setname/{set_id}',                          'MainController@getSetName');
Route::get('patname/{patient_id}',                      'MainController@getPatientName');
Route::get('conname/{contractor_id}',                   'MainController@getContractorName');

Route::get('examsBySet/{set_id}',                       'MainController@examsBySet');
Route::get('examsByPatient/{patient_id}',               'MainController@examsByPatient');
Route::get('examsByContractor/{contractor_id}',         'MainController@examsByContractor');
Route::get('examination/new/{set_id}',                  'MainController@newExamination');
Route::get('examination/ins',                           'MainController@insExamination');
Route::get('examination/chg/{field}',                   'MainController@chgExamination');


Route::get('patient/search/{value}',                    'MainController@searchPatient');
Route::get('patient/edt/{patient_id}',                  'MainController@edtPatient');
Route::get('patient/upd/{patient_id}',                  'MainController@updPatient');
Route::get('patients',                                  'MainController@patientsList');

Route::get('report/create',                             'MainController@createReport');
Route::get('graph/create',                              'MainController@createGraph');



Route::get('set/chk',                                   'MainController@chkSet');
Route::get('contractorexamnumber/chk',                  'MainController@chkContractorExamNumber');
Route::get('pesel/chk',                                 'MainController@chkPesel');
Route::get('pesel/chkExceptMe',                         'MainController@chkPeselExceptMe');


Route::get('ds/sets',                                   'MainController@dsSets');
Route::get('ds/examsReport/',                           'MainController@dsExamsReport');
Route::get('ds/examsGraph/',                            'MainController@dsExamsGraph');
Route::get('ds/examsBySet/{set_id}',                    'MainController@dsExamsBySet');
Route::get('ds/examsByPatient/{patient_id}',            'MainController@dsExamsByPatient');
Route::get('ds/examsByContractor/{contractor_id}',      'MainController@dsExamsByContractor');
Route::get('ds/exams',                                  'MainController@dsExams');
Route::get('ds/patients',                               'MainController@dsPatients');
Route::get('ds/patientsDropdown',                       'MainController@dsPatientsDropdown');
Route::get('ds/contractors',                            'MainController@dsContractors');
Route::get('ds/contractors/inline',                     'MainController@dsContractorsInline');
Route::get('ds/sets/inline',                            'MainController@dsSetsInline');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

<script>
    
    function getColumns(){
    
    return [
                       
                       {name: 'set.name',                     width:100,              data: 'setname',                    title: 'kartoteka',         visible: false},
                       {name: 'patient.person',               width:150,              data: 'patper',                     title: 'pacjent',           visible: false},
                       {name: 'patient.pesel',                width:100,              data: 'patpesel',                   title: 'pesel',             visible: false},           
                       {name: 'patient.age',                  width:100,              data: 'patage',                     title: 'wiek',              visible: false},           
                       {name: 'examination.result',           width:100,              data: 'result',                     title: 'wynik',             visible: false},
                       {name: 'contractor.name',              width:200,              data: 'contname',                   title: 'odbiorca',          visible: false},
                       {name: 'examination.exam_date',        width:100,              data: 'examdate',                   title: 'db',                visible: false}
                ];
       }
    
 </script>
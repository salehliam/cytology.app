<script>
    
    function getColumns(){
    
    return [
                       {name: 'id',                     width:10,                       data: 'id',                     title: 'id'                 },
                       {name: 'person',                 width:150,                      data: 'person',                 title: 'person'             },
                       {name: 'peselorage',             width:150,                      data: 'peselorage',             title: 'pesel/wiek'         },
                       {name: 'examsNum',               width:10,                       data: 'examsNum',               title: 'lb'                 },
                       {name: 'lastExam',                                               data: 'lastExam',               title: 'ostatnie badanie'   },
                       {name: 'lastResult',                                             data: 'lastResult',             title: 'ostatni wynik'      },
                       {name: 'action',                 width:120,                       data: null,                     title: 'akcje',
                        render: function(data){
                            return "<button class='btn btn-default' onClick='openEditPatient("+data.id+")'>Edytuj</button>" + 
                                   "&nbsp;<button class='btn btn-primary' onClick='openPatient("+data.id+")'>Badania</div>";
                        }}
           ]
                   }    
 </script>
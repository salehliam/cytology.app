<script>
    
    function getColumns(){
    
    return [
                       {name: 'examination.counter',    width:10,             data: 'counter',                title: 'nr'         },
                       {name: 'set.name',               width:50,             data: null,                     title: 'kartoteka',
                            render: function(data){ 
                                    return "<a href='#' style='color: #333' class='set' data-pk='"+data.id+"'>"+data.setname+"</a>";
                                   }
                       },        
                       {name: 'patient.person',         width:150,            data: 'person',                 title: 'pacjent'    },        
                       {name: 'patient.pesel',          width:50,             data: 'pesel',                  title: 'pesel'      },
                       {name: 'patient.age',            width:5,              data: 'age',                    title: 'w.'         },
                       {name: 'examination.cen',        width:30,             data: 'cen',                    title: 'bad.'       },
                       {name: 'examination.doctor',     width:100,            data: null,                     title: 'lekarz',     
                            render: function(data){ 
                                    return "<a href='#' style='color: #333' class='doctor' data-pk='"+data.id+"'>"+data.doctor+"</a>";
                                   }
                       },
                       {name: 'examination.exam_date',  width:35,             data: null,              title: 'db.',
                            render: function(data){ 
                                    return "<a href='#' style='color: #333' class='exam_date' data-pk='"+data.id+"'>"+data.exam_date+"</a>";
                                   }
               
                       
                       },
                       {name: 'examination.result',     width:15,             data: null,                     title: 'wynik',      
                            render: function(data){ 
                                    return "<a href='#' style='color: #333' class='result' data-pk='"+data.id+"'>"+data.result+"</a>";
                                   }
                       
                       },
                       {name: 'contractor.name',        width:150,            data: null,                     title: 'odbiorca',
                            render: function(data){ 
                                    return "<a href='#' style='color: #333' class='contractor' data-pk='"+data.id+"'>"+data.name+"</div>";
                                   }
                       }
                ];
       }
    
 </script>
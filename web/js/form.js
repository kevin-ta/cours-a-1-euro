$( ".btn1" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
         });
    $( ".home2" ).show( "fast");
    $( ".prof" ).show();
});
$( ".btn2" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
            });
    $( ".home2" ).show( "fast");
    $( ".eleve" ).show();
});
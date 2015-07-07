$( ".btn1" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
         });
    $( ".home2" ).show( "fast");
});
$( ".btn2" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
            });
    $( ".home2b" ).show( "fast");
});
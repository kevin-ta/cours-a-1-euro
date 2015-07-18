$( ".btn1" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
         });
    $( ".alert1" ).show( "fast");
});

$( ".btnalert1" ).click(function() {
    $( ".alert1" ).slideUp(700,function() {$( ".alert1" ).remove();
         });
    $( ".alert2" ).remove();
    $( ".home2" ).show( "fast");
    $( ".prof" ).show();
    $( ".eleve" ).remove();
});

$( ".btn2" ).click(function() {
    $( ".home1" ).slideUp(700,function() {$( ".home1" ).remove();
            });
    $( ".alert2" ).show( "fast");
});

$( ".btnalert2" ).click(function() {
    $( ".alert2" ).slideUp(700,function() {$( ".alert2" ).remove();
         });
    $( ".alert1" ).remove();
    $( ".home2" ).show( "fast");
    $( ".eleve" ).show();
    $( ".prof" ).remove();
});
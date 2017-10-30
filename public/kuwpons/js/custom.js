

$(document).ready(function(){

  $('ul li').click(function(){

    $('li').removeClass("active");

    $(this).addClass("active");

});



    $('.header-right-toggle').click(function(){

        $('.header-right-tog-content').slideToggle(150);

    });



});



$(window).resize(function(){

    var totalwidth = $(this).width();

    if( totalwidth > 767){

        $('.header-right-tog-content').removeAttr('style');

    }

})







  $(document).ready(function(){

        $('.search-icon').click(function(){

            $('.search-sec input[type=text]').animate({width: "200px", height:"30px" }, 100).css('background','#fff');

        });

        

        $('.fancybox').fancybox();

		

		     $('#plus').click(function(){

              

            var numric = $('#num').val();

            

            if((parseInt(numric) == 20)){

                return false;

            } else{

               var result = parseInt(numric)+1;

               $('#num').val(result);

            }

            

        })

        

        $('#minus').click(function(){

            var numric = $('#num').val();

            

            if((parseInt(numric) == 0)){

                return false;

            } else{

                var result = parseInt(numric)-1;

                 $('#num').val(result);

            }

            

        });

    })

$(document).ready(function() {
 
    $('a[href^="#"]').click(function (){
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        jQuery("html:not(:animated), body:not(:animated)").animate({scrollTop: destination}, 800);
        return false;
    })
     
    $('.reviews-4').slick({
      dots: false,
      infinite: true,
      speed: 200,
      slidesToShow: 3,
      slidesToScroll: 1,
      adaptiveHeight: true,
      responsive: [
        {
          breakpoint: 976,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 659,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });    

    $("img.panorama").panorama();
    
});


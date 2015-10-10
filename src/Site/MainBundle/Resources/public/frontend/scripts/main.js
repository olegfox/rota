//var numberVideo = 1;

//jQuery('body').vide({
//  mp4: './video/video' + numberVideo + '.mp4'
//}, {
//  volume: 1,
//  playbackRate: 1,
//  muted: true,
//  loop: true,
//  autoplay: true,
//  position: '50% 50%', // Similar to the CSS `background-position` property.
//  posterType: 'detect', // Poster image type. "detect" — auto-detection; "none" — no poster; "jpg", "png", "gif",... - extensions.
//  resizing: true // Auto-resizing, read: https://github.com/VodkaBears/Vide#resizing...
//});


//jQuery("body").keydown(function(e) {
//  if(e.keyCode == 37) { // left
//    numberVideo--;
//
//    if(numberVideo < 1){
//      numberVideo = 3;
//    }
//
//    jQuery('body').vide({
//      mp4: './video/video' + numberVideo + '.mp4'
//    }, {
//      volume: 1,
//      playbackRate: 1,
//      muted: true,
//      loop: true,
//      autoplay: true,
//      position: '50% 50%', // Similar to the CSS `background-position` property.
//      posterType: 'detect', // Poster image type. "detect" — auto-detection; "none" — no poster; "jpg", "png", "gif",... - extensions.
//      resizing: true // Auto-resizing, read: https://github.com/VodkaBears/Vide#resizing...
//    });
//  }
//  else if(e.keyCode == 39) { // right
//    numberVideo++;
//
//    if(numberVideo > 3){
//      numberVideo = 1;
//    }
//
//    jQuery('body').vide({
//      mp4: './video/video' + numberVideo + '.mp4'
//    }, {
//      volume: 1,
//      playbackRate: 1,
//      muted: true,
//      loop: true,
//      autoplay: true,
//      position: '50% 50%', // Similar to the CSS `background-position` property.
//      posterType: 'detect', // Poster image type. "detect" — auto-detection; "none" — no poster; "jpg", "png", "gif",... - extensions.
//      resizing: true // Auto-resizing, read: https://github.com/VodkaBears/Vide#resizing...
//    });
//  }
//});
jQuery(function () {
  //  Инициализация слайдера на главной
  jQuery('.slider').slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    autoplay: false,
    autoplaySpeed: 3000
  });

  jQuery('.slider').on('init setPosition', function (slick) {
    jQuery('.slider .slick-slide div').css({
      'height': jQuery('body').height(),
      'width': jQuery('body').width()
    });
  });

  jQuery('.slider').on('afterChange', function (slick, currentSlide) {
    var slide = jQuery('.slider .slick-slide[data-slick-index="'+currentSlide.currentSlide+'"]');
    if(slide.hasClass('video')){
      var videoObject = slide.data('vide').getVideoObject();
      videoObject.play();
    }
  });

  jQuery('.slider').on('beforeChange', function (slick, currentSlide, nextSlide) {
    var slide = jQuery('.slider .slick-slide[data-slick-index="'+nextSlide.currentSlide+'"]');
    if(slide.hasClass('video')){
      var videoObject = slide.data('vide').getVideoObject();
      videoObject.stop();
    }
  });

  jQuery('.slider .video').each(function (i, e) {
    jQuery(e).vide({
      mp4: jQuery(e).data('video')
    }, {
      volume: 1,
      playbackRate: 1,
      muted: true,
      autoplay: false,
      loop: true,
      position: '50% 50%', // Similar to the CSS `background-position` property.
      posterType: 'detect', // Poster image type. "detect" — auto-detection; "none" — no poster; "jpg", "png", "gif",... - extensions.
      resizing: true // Auto-resizing, read: https://github.com/VodkaBears/Vide#resizing...
    });
  });

  /* Кнопка вниз на главной */
  jQuery("a.icon-arrow").each(function (i, e) {
    jQuery(e).click(function (element) {
      element.preventDefault();
      jQuery("body,html").animate({
        scrollTop: jQuery(jQuery(e).attr('href')).offset().top
      }, 1000);
    });
  });

  /* Стрелка для переключения слайдера */
  if(!Modernizr.touch){
    jQuery(".CursorAnimateRotate").on("mousemove", function (e) {
      jQuery('.cursor').addClass('isVisible');
      if (e.pageX > jQuery(window).width() / 2) {
        jQuery(".CursorAnimateRotate").addClass('right');
      } else {
        jQuery(".CursorAnimateRotate").removeClass('right');
      }
      jQuery('.cursor').css({'left': e.pageX - 35, 'top': e.pageY - 75 - jQuery(window).scrollTop()});
    });

    jQuery(".CursorAnimateRotate").on("mouseout", function (e) {
      jQuery('.cursor').removeClass('isVisible');
    });

    jQuery(".icon-arrow").on("mousemove", function (e) {
      jQuery('.cursor').removeClass('isVisible');
    });

    jQuery('.slider').click(function () {
      if (jQuery(".CursorAnimateRotate").hasClass('right')) {
        jQuery('.slider').slick('slickNext');
      } else {
        jQuery('.slider').slick('slickPrev');
      }
    });
  }

});

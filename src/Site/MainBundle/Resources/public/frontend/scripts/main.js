function sectionScroll(e){
    var anchor = jQuery(this);
    enable_scroll();
    jQuery('.nav-pills li').removeClass('current');
    anchor.parent().addClass('current');
    jQuery('html, body').stop().animate({
        scrollTop: jQuery(anchor.attr('href')).offset().top
    }, 1000, function () {
        if (anchor.attr('href') == "#mieniu") {
            jQuery(".slider-menu .slick-next, .slider-menu .slick-prev").css({
                "opacity": 1
            });
        } else {
            jQuery(".slider-menu .slick-next, .slider-menu .slick-prev").css({
                "opacity": 0
            });
        }
        //if(jQuery(anchor.attr('href')).get(0).scrollHeight <= jQuery(anchor.attr('href')).height() + 115){
        console.log('enable scroll');
        disable_scroll(jQuery(window).scrollTop());
        //}
    });
    if (window.history.pushState) {
        if (anchor.attr('href').replace('#', '') != 'photo_restaurant') {
            window.history.pushState(null, null, '/' + anchor.attr('href').replace('#', ''));
        }
    }
    e.preventDefault();
}

function sectionScroll2(e){
    var anchor = jQuery(this);
    enable_scroll();
    jQuery('.nav-pills li').removeClass('current');
    anchor.parent().addClass('current');
    jQuery('html, body').stop().animate({
        scrollTop: jQuery(anchor.attr('href')).offset().top
    }, 1000, function () {
        if (anchor.attr('href') == "#mieniu") {
            jQuery(".slider-menu .slick-next, .slider-menu .slick-prev").css({
                "opacity": 1
            });
        } else {
            jQuery(".slider-menu .slick-next, .slider-menu .slick-prev").css({
                "opacity": 0
            });
        }
        //if(jQuery(anchor.attr('href')).get(0).scrollHeight <= jQuery(anchor.attr('href')).height() + 115){
        console.log('enable scroll');
        disable_scroll(jQuery(window).scrollTop());
        //}
    });
    if (window.history.pushState) {
        if (anchor.attr('href').replace('#', '') != 'photo_restaurant') {
            window.history.pushState(null, null, '/' + anchor.attr('href').replace('#', ''));
        }
    }
    e.preventDefault();
}

function disable_scroll(top) {
    if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {

        window.onscroll = function () {
            console.log('disable scroll');
            window.scrollTo(0, top);
        };
    }
}

function enable_scroll() {
    if(!/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        window.onscroll = function () {
            console.log('enable scroll');
        };
    }
}

jQuery(function () {
    disable_scroll(0);

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
  jQuery("a.icon-arrow").click(function (e) {
      e.preventDefault();
      jQuery('.nav-pills li a[href="' + jQuery(this).attr('href') + '"]').click();
  });

    /* ---------------------------------------------- /*
     * Scroll Animation
     /* ---------------------------------------------- */

    jQuery('.section-scroll').bind('click', sectionScroll);

});

function sectionScroll(e){
    var anchor = jQuery(this);
    enable_scroll();
    jQuery('.nav-pills li').removeClass('current');
    anchor.parent().addClass('current');
    jQuery('.wrap-st-content').stop().animate({
        scrollTop: jQuery(anchor.attr('href')).index() * jQuery('.wrap-st-content').height()
    }, 1000, function () {
        console.log('enable scroll');
        setTimeout(function(){
            jQuery(anchor.attr('href')).focus();
        }, 1000);

        disable_scroll(jQuery('.wrap-st-content').scrollTop());
    });
    if (window.history.pushState) {
        window.history.pushState(null, null, '/' + anchor.attr('href').replace('#', ''));
    }
    e.preventDefault();
}

function sectionScroll2(e){
    var anchor = jQuery(this);
    enable_scroll();
    jQuery('.nav-pills li').removeClass('current');
    anchor.parent().addClass('current');
    jQuery('.main').show();
    if(jQuery('.slide').length > 0){
        jQuery('.slide').show();
    }
    jQuery('.posts-block').switchClass('bg-none-posts-block', 'bg-posts-block', 0);
    jQuery('.news-block').show();
    jQuery('section.text').show();
    jQuery('body').css({
        'overflow': 'auto'
    });
    jQuery('body,html').scrollTop(jQuery('.posts-block').offset().top + 20);
    jQuery('section.page .text').show();
    jQuery('footer').show();
    jQuery('.hexagons').switchClass('bg-none', 'bg-yes', 0);
    jQuery('.hexagons').find('.pattern').remove();
    jQuery('.hexagon').attr('style', '');
    jQuery('.hexagon').parent().find('.info').show();
    jQuery('.hexagon').parent().find('.mediaOverlayIcon').show();

    jQuery('.wrap-svg-show').parent().parent().find('.card__container').switchClass('card__container_no_radius', 'card__container_radius', 0);

    jQuery('.wrap-svg-show').parent().parent().parent().parent().css({
        'position': 'static',
        'z-index': '0'
    });
    jQuery('.wrap-svg-show').parent().parent().find('.card__container').find('.card__caption').css({
        'visibility': 'hidden'
    });
    jQuery('.wrap-svg-show').parent().parent().find('.card__container').addClass('card__container--closed');
    jQuery('.wrap-svg-show').find('.nav-main').prependTo(jQuery('.st-pusher'));

    jQuery('.nav-main').css({
        'position': 'fixed'
    });
    jQuery('.wrap-svg-show').parent().parent().find('.myScrollCompany').perfectScrollbar('destroy');
    jQuery('.wrap-svg-show').removeClass('wrap-svg-show');
    jQuery('body').css({
        'overflow': 'hidden'
    });
    jQuery('.section-scroll').unbind('click').bind('click', sectionScroll);
    jQuery('.wrap-st-content').stop().animate({
        scrollTop: jQuery(anchor.attr('href')).index() * jQuery('.wrap-st-content').height()
    }, 1000, function () {
        console.log('enable scroll');
        setTimeout(function(){
            jQuery(anchor.attr('href')).focus();
        }, 1000);

        disable_scroll(jQuery('.wrap-st-content').scrollTop());
    });
    if (window.history.pushState) {
        window.history.pushState(null, null, '/' + anchor.attr('href').replace('#', ''));
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
      fade: true,
      cssEase: 'linear'
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
      autoplay: true,
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
      jQuery('.nav-pills li').removeClass('current');
      jQuery('.nav-pills li a[href="' + jQuery(this).attr('href') + '"]').parent().addClass('current');
  });

    /* ---------------------------------------------- /*
     * Scroll Animation
     /* ---------------------------------------------- */

    jQuery('.section-scroll').bind('click', sectionScroll);

    //  Валидация формы обратной связи
    var $feedbackForm = jQuery('.form-block form');

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    if ($feedbackForm.length > 0) {
        $feedbackForm.submit(function () {
            // Флаг проверки
            var $fl = 0;

            if (jQuery(this).find('#name').val().length < 3) {
                $fl = 1;
                jQuery(this).find('#name').css('border-bottom', '1px solid red');
            } else {
                jQuery(this).find('#name').css('border-bottom', '1px solid #bdbdbd');
            }
            if (jQuery(this).find('#phone').val().length < 3) {
                $fl = 1;
                jQuery(this).find('#phone').css('border-bottom', '1px solid red');
            } else {
                jQuery(this).find('#phone').css('border-bottom', '1px solid #bdbdbd');
            }
            if (!isEmail($(this).find('#email').val())) {
                $fl = 1;
                jQuery(this).find('#email').css('border-bottom', '1px solid red');
            } else {
                jQuery(this).find('#email').css('border-bottom', '1px solid #bdbdbd');
            }

            if ($fl == 0) {
                var $params = jQuery(this).serialize();

                alert("Сообщение успешно отправлено!");

                $feedbackForm.find('#name').val('');
                $feedbackForm.find('#company').val('');
                $feedbackForm.find('#phone').val('');
                $feedbackForm.find('#email').val('');
                $feedbackForm.find('#message').val('');

                jQuery.post($(this).attr('action'), $params).fail(function () {
                    alert("Ошибка отправки формы!");
                });
            }

            return false;
        });
    }

    setTimeout(function(){
        jQuery('.myScroll').perfectScrollbar({
            wheelSpeed: 2,
            wheelPropagation: true,
            minScrollbarLength: 20,
            suppressScrollX: true
        });
    }, 500);

});

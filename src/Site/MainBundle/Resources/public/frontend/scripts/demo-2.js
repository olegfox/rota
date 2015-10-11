'use strict';

/**
 * Demo.
 */
var demo = (function(window, jQuery, undefined) {

  /**
   * Enum of CSS selectors.
   */
  var SELECTORS = {
    pattern: '.pattern',
    card: '.card',
    cardImage: '.card__image',
    cardClose: '.card__btn-close'
  };

  /**
   * Enum of CSS classes.
   */
  var CLASSES = {
    patternHidden: 'pattern--hidden',
    polygon: 'polygon',
    polygonHidden: 'polygon--hidden'
  };

  /**
   * Map of svg paths and points.
   */
  var polygonMap = {
    paths: null,
    points: null
  };

  /**
   * Container of Card instances.
   */
  var layout = {};

  /**
   * Initialise demo.
   */
  function init() {

    // For options see: https://github.com/qrohlf/Trianglify
    var pattern = Trianglify({
      width: window.innerWidth,
      height: window.innerHeight,
      cell_size: 120,
      variance: 1,
      stroke_width: 0.5,
      color_function : function(x, y) {
        return '#7cc576';
      }
    }).svg(); // Render as SVG.

    _mapPolygons(pattern);

    _bindCards();
  };

  /**
   * Store path elements, map coordinates and sizes.
   * @param {Element} pattern The SVG Element generated with Trianglify.
   * @private
   */
  function _mapPolygons(pattern) {

    // Append SVG to pattern container.
    $(SELECTORS.pattern).append(pattern);

    // Convert nodelist to array,
    // Used `.childNodes` because IE doesn't support `.children` on SVG.
    polygonMap.paths = [].slice.call(pattern.childNodes);

    polygonMap.points = [];

    polygonMap.paths.forEach(function(polygon) {

      // Hide polygons by adding CSS classes to each svg path (used attrs because of IE).
      $(polygon).attr('class', CLASSES.polygon + ' ' + CLASSES.polygonHidden);

      var rect = polygon.getBoundingClientRect();

      var point = {
        x: rect.left + rect.width / 2,
        y: rect.top + rect.height / 2
      };

      polygonMap.points.push(point);
    });

    // All polygons are hidden now, display the pattern container.
    $(SELECTORS.pattern).removeClass(CLASSES.patternHidden);
  };

  /**
   * Bind Card elements.
   * @private
   */
  function _bindCards() {

    var elements = $(SELECTORS.card);

    $.each(elements, function(card, i) {

      var instance = new Card(i, card);

      layout[i] = {
        card: instance
      };

      var cardImage = $(card).find(SELECTORS.cardImage);
      var cardClose = $(card).find(SELECTORS.cardClose);

      $(cardImage).on('click', _playSequence.bind(this, true, i));
      $(cardClose).on('click', _playSequence.bind(this, false, i));
    });
  };

  /**
   * Create a sequence for the open or close animation and play.
   * @param {boolean} isOpenClick Flag to detect when it's a click to open.
   * @param {number} id The id of the clicked card.
   * @param {Event} e The event object.
   * @private
   *
   */
  function _playSequence(isOpenClick, id, e) {

    var card = layout[id].card;

    // Prevent when card already open and user click on image.
    if (card.isOpen && isOpenClick) return;

    // Create timeline for the whole sequence.
    var sequence = new TimelineLite({paused: true});

    var tweenOtherCards = _showHideOtherCards(id);

    if (!card.isOpen) {
      // Hide all
      //jQuery('.nav').fadeOut(1000);
      jQuery('.main').fadeOut(1000);
      if(jQuery('.slide').length > 0){
        jQuery('.slide').fadeOut(1000);
      }
      jQuery('.posts-block').switchClass('bg-posts-block', 'bg-none-posts-block', 1000);
      jQuery('.news-block').fadeOut(1000);
      jQuery('section.text').fadeOut(1000);
      jQuery('body').css({
        'overflow': 'hidden'
      });
      jQuery('footer').fadeOut(1000);
      jQuery('.hexagons').switchClass('bg-yes', 'bg-none', 1000);
      jQuery('.hexagon').parent().find('.info').fadeOut(1000);
      jQuery('.hexagon').parent().find('.mediaOverlayIcon').fadeOut(1000);
      jQuery('.card__container').eq(id).switchClass('card__container_radius', 'card__container_no_radius', 3000);
      jQuery('.card__container').eq(id).find('.card__image').css({
        'display': 'inline-block'
      });
      jQuery('.hexagon').eq(id).parent().parent().css({
        'position': 'relative',
        'z-index': '1'
      });
      setTimeout(function(){
        jQuery('.card__container').eq(id).find('.card__caption').css({
          'visibility': 'visible'
        });
        jQuery('body,html').scrollTop(0);
        jQuery('.nav-main').prependTo(jQuery('.card__container .wrap-svg').eq(id));
        jQuery('.nav-main').removeClass('revealOnScroll animated');
        jQuery('.nav-main').css({
          'position': 'absolute'
        });
        jQuery('.card__container').eq(id).find('.wrap-svg').addClass('wrap-svg-show');
      }, 3000);

      var hexagonOpen = jQuery('.hexagon').eq(id),
          hexagonCurrent = jQuery('.hexagon').eq(id),
          hexagonCurrentSvg = hexagonCurrent.find('.wrap-svg').html(),
          hexagonCurrentCardContent = hexagonCurrent.find('.card__content').html();
      /**
       *  Обработка нажатия стрелок для переключения между направлениями компании
       */
      var nvClickLeft = function(){
        var hexagonPrev = hexagonCurrent.parent().parent().prev().find('.hexagon');

        if(hexagonPrev.html() == undefined){
          hexagonPrev = jQuery('.hexagon').eq(jQuery('.hexagon').length - 1);
        }
        if(hexagonPrev.parent().parent().index() == hexagonOpen.parent().parent().index()){
          var navMain = hexagonOpen.find('.wrap-svg .nav-main').clone();
          hexagonOpen.find('.wrap-svg').html(hexagonCurrentSvg);
          navMain.prependTo(hexagonOpen.find('.wrap-svg'));
          hexagonOpen.find('.card__content').html(hexagonCurrentCardContent);
        }else{
          var navMain = hexagonOpen.find('.wrap-svg .nav-main').clone();
          hexagonOpen.find('.wrap-svg').html(hexagonPrev.find('.wrap-svg').html());
          hexagonOpen.find('.card__content').html(hexagonPrev.find('.card__content').html());
          navMain.prependTo(hexagonOpen.find('.wrap-svg'));
        }

        hexagonOpen.find('.nv-left').unbind('click').click(nvClickLeft);
        hexagonOpen.find('.nv-right').unbind('click').click(nvClickRight);
        hexagonCurrent = hexagonPrev;
      };
      var nvClickRight = function(){
        var hexagonNext = hexagonCurrent.parent().parent().next().find('.hexagon');

        if(hexagonNext.html() == undefined){
          hexagonNext = jQuery('.hexagon').eq(0);
        }
        if(hexagonNext.parent().parent().index() == hexagonOpen.parent().parent().index()){
          var navMain = hexagonOpen.find('.wrap-svg .nav-main').clone();
          hexagonOpen.find('.wrap-svg').html(hexagonCurrentSvg);
          hexagonOpen.find('.card__content').html(hexagonCurrentCardContent);
          navMain.prependTo(hexagonOpen.find('.wrap-svg'));
        } else{
          var navMain = hexagonOpen.find('.wrap-svg .nav-main').clone();
          hexagonOpen.find('.wrap-svg').html(hexagonNext.find('.wrap-svg').html());
          hexagonOpen.find('.card__content').html(hexagonNext.find('.card__content').html());
          navMain.prependTo(hexagonOpen.find('.wrap-svg'));
        }

        hexagonOpen.find('.nv-left').unbind('click').click(nvClickLeft);
        hexagonOpen.find('.nv-right').unbind('click').click(nvClickRight);
        hexagonCurrent = hexagonNext;
      };
      jQuery('.hexagon').eq(id).find('.nv-left').click(nvClickLeft);
      jQuery('.hexagon').eq(id).find('.nv-right').click(nvClickRight);

      // end Hide all

      // Open sequence.

      sequence.add(tweenOtherCards);
      sequence.add(card.openCard(_onCardMove), 0);

    } else {
      // Close sequence.
      var closeCard = card.closeCard();
      var position = closeCard.duration() * 0.8; // 80% of close card tween.

      sequence.add(closeCard);
      sequence.add(tweenOtherCards, position);

      // Show all
      setTimeout(function(){
        //jQuery('.nav').fadeIn(1000);
        jQuery('.main').fadeIn(1000);
        if(jQuery('.slide').length > 0){
          jQuery('.slide').fadeIn(1000);
        }
        jQuery('.posts-block').switchClass('bg-none-posts-block', 'bg-posts-block', 1000);
        jQuery('.news-block').fadeIn(1000);
        jQuery('section.text').fadeIn(1000);
        jQuery('body').css({
          'overflow': 'auto'
        });
        jQuery('body,html').scrollTop(jQuery('.posts-block').offset().top + 20);
        jQuery('footer').fadeIn(1000);
        jQuery('.hexagons').switchClass('bg-none', 'bg-yes', 1000);
        jQuery('.hexagon').parent().find('.info').fadeIn(1000);
        jQuery('.hexagon').parent().find('.mediaOverlayIcon').fadeIn(1000);
        jQuery('.card__container').eq(id).switchClass('card__container_no_radius', 'card__container_radius', 3000);
      }, 3000);
      jQuery('.hexagon').eq(id).parent().parent().css({
        'position': 'static',
        'z-index': '0'
      });
      jQuery('.card__container').eq(id).find('.card__caption').css({
        'visibility': 'hidden'
      });
      jQuery('.card__container .wrap-svg').eq(id).find('.nav-main').prependTo(jQuery('body'));
      jQuery('.nav-main').css({
        'position': 'relative'
      });
      jQuery('.card__container').eq(id).find('.wrap-svg').removeClass('wrap-svg-show');

      // end Show all
    }

    sequence.play();
  };

  /**
   * Show/Hide all other cards.
   * @param {number} id The id of the clcked card to be avoided.
   * @private
   */
  function _showHideOtherCards(id) {

    var TL = new TimelineLite;

    var selectedCard = layout[id].card;

    for (var i in layout) {

      var card = layout[i].card;

      // When called with `openCard`.
      if (card.id !== id && !selectedCard.isOpen) {
        TL.add(card.hideCard(), 0);
      }

      // When called with `closeCard`.
      if (card.id !== id && selectedCard.isOpen) {
        TL.add(card.showCard(), 0);
      }
    }

    return TL;
  };

  /**
   * Callback to be executed on Tween update, whatever a polygon
   * falls into a circular area defined by the card width the path's
   * CSS class will change accordingly.
   * @param {Object} track The card sizes and position during the floating.
   * @private
   */
  function _onCardMove(track) {

    var radius = track.width / 2;

    var center = {
      x: track.x,
      y: track.y
    };

    polygonMap.points.forEach(function(point, i) {

      if (_detectPointInCircle(point, radius, center)) {
        $(polygonMap.paths[i]).attr('class', CLASSES.polygon);
      } else {
        $(polygonMap.paths[i]).attr('class', CLASSES.polygon + ' ' + CLASSES.polygonHidden);
      }
    });
  }

  /**
   * Detect if a point is inside a circle area.
   * @private
   */
  function _detectPointInCircle(point, radius, center) {

    var xp = point.x;
    var yp = point.y;

    var xc = center.x;
    var yc = center.y;

    var d = radius * radius;

    var isInside = Math.pow(xp - xc, 2) + Math.pow(yp - yc, 2) <= d;

    return isInside;
  };

  // Expose methods.
  return {
    init: init
  };

})(window, jQuery);

// Kickstart Demo.
window.onload = demo.init;

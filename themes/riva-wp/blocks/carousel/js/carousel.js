import slick from '@accessible360/accessible-slick';
import $ from 'jQuery';

export default function () {


  $(function() {
    initialize_carousels();
  });


  const slickDefaults = {
    fade: false,
    dots: true,
    arrows: true,
    adaptiveHeight: true,
    arrowsPlacement: `afterSlides`,
  };


  class Slider {
    /**
     * Slider Constructor
     * @param {HTML Element} element Element to transform into a slick slider.
     * @param {object} options Optional settings to overwrite the defaults.
     */
    constructor(element, options) {
      // Grabs reference to the passed in element.
      this.element = element;

      // We can pass in alternate options to overwrite the defaults.
      this.settings = { ...slickDefaults, ...options };

      // Sets a slider variable from the returned slick slider instance built.
      this.slider = this.build();

      // Calls a utility ready function when everything is done.
      this.ready();
    }

    /**
     * Builds out a slick slider from the element and the settings.
     * @returns jQuery Element
     */
    build() {
      return $(this.element).slick(this.settings);
    }

    /**
     * Utility function to add a ready class to the element.
     */
    ready() {
      this.element.classList.add('ready');
    }
  }


  function initialize_carousels() {
    const $carousels = $('.carousel');

    if ($carousels.length) {

      $('.carousel__items', $carousels).each(function() {
        const $thisSlider = $(this);
        let el = $thisSlider[0];
        const $sliderContainer = $thisSlider.closest('.carousel');

        // const $pagerContainer = $sliderContainer.find('.carousel-controls__pagination');
        const $prevButton = $sliderContainer.find('.carousel-arrow--prev');
        const $nextButton = $sliderContainer.find('.carousel-arrow--next');

        const slickSettings = {
          fade: false,
          dots: true,
          arrows: true,
          adaptiveHeight: true,
          arrowsPlacement: 'afterSlides',
          prevArrow: $prevButton,
          nextArrow: $nextButton,
          adaptiveHeight: true,
          // appendDots: $pagerContainer,
          // dotsClass: 'carousel-pagination', // Slick generates a <ul.carousel-pagination> within the appendDots container
          // customPaging: function (slider, i) {
          //   const slideNumber = (i + 1);
          //   const totalSlides = slider.slideCount;
          //   return '<button class="pagination-control"><span class="visually-hidden">View slide ' + slideNumber + ' of ' + totalSlides + '</span></button>';
          // },
          instructionsText: 'Changing the slide on the carousel will navigate to the next item.',
          infinite: true,
          speed: 250,
          /*autoplay: true,
          autoplaySpeed: 2000,*/
          slidesToScroll: 1,
          slidesToShow: 1,
          centerMode: true,
          centerPadding: '10%',
          adaptiveHeight: false,
          // // -- RESPONSIVE OPTIONS --
          responsive: [
            {
              breakpoint: 1100,
              settings: {
                slidesToShow: 1,
                centerMode: false,
                 centerPadding: '0px',
              }
            }
           ]
        };


        if (!el.Slider) {
          el.Slider = new Slider(el, slickSettings);
        }
      });
    }
  }
}

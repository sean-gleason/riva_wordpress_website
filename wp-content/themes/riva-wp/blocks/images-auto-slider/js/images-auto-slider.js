import slick from '@accessible360/accessible-slick';
import $ from 'jQuery';

export default function () {


  $(function() {
    initialize_auto_sliders();
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


  function initialize_auto_sliders() {
    const $carousels = $('.image-auto-slider');

    if ($carousels.length) {

      $('.image-auto-slider__items', $carousels).each(function() {
        const $thisSlider = $(this);
        let el = $thisSlider[0];
        const $sliderContainer = $thisSlider.closest('.image-auto-slider__items');

        const slickSettings = {
          fade: false,
          dots: false,
          arrows: false,
          adaptiveHeight: true,
          infinite: true,
          speed: 250,
          autoplay: true,
          autoplaySpeed: 2000,
          slidesToScroll: 1,
          slidesToShow: 6,
          centerMode: true,
          centerPadding: '20%',
          // // -- RESPONSIVE OPTIONS --
          // slidesToShow: 3, // show three items at a time at larger viewports.
          responsive: [
             {
               breakpoint: 1100,
               settings: {
                 slidesToShow: 5
               }
             },
             {
               breakpoint: 800,
               settings: {
                 slidesToShow: 3,
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

import $ from 'jQuery';

export default () => {
	$(document).ready(function() {
		alerts();
		closeAlert();

		$('#alert-bar').addClass('loaded');
	});

	function alerts() {
		var $slider = $('.alert-bar__cta--slider');

		$slider.on('init', function(event, slick){
			$('.alert-bar__cta .slick-count .total').html( $('.alert-bar__cta--slider .alert-bar--item').length );
		});

		// after slide change happens...
		$slider.on('afterChange', function(event, slick, currentSlide){
			var current = currentSlide + 1;

			$('.alert-bar__cta .slick-count .current').html( current );
		});

		$slider.slick({
			slidesToShow: 1,
			infinite: false,
			adaptiveHeight: true,
			prevArrow: $('.alert-bar__cta .slick-prev'),
			nextArrow: $('.alert-bar__cta .slick-next'),
		});
	}

	function closeAlert() {
		let AlertBanner = document.getElementById('alert-bar');

		if( AlertBanner ) { announcementBar(); }

		function announcementBar() {
			let closeBanner = document.getElementById('alert-bar__close-btn');
			let bannerText = document.getElementById('alertBarHelper').textContent;

			if (localStorage.getItem('repeat-banner-data') != bannerText) {
				// If different, reset hide bar value for local storage.
				localStorage.setItem('repeat-banner', 'false');
			}

			if(localStorage.getItem('repeat-banner') == 'true') {
				// If false, remove the bar container.
				AlertBanner.remove();
			} else {
				// If true, remove hide class.
				AlertBanner.classList.remove('d-none');
			}

			closeBanner.addEventListener('click', function() {
				AlertBanner.remove();
				localStorage.setItem('repeat-banner-data', bannerText);
				localStorage.setItem('repeat-banner', 'true');
			});
		}
	}
}

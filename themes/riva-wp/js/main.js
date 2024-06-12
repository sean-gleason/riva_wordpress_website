/* IMPORTS
	You can import directly from node_modules here.
*/
import $ from 'jQuery';
import 'what-input';

/*
	BOOTSTRAP IMPORTS
	JavaScript functions for boostrap Components.

	See https://getbootstrap.com/docs/5.2/getting-started/webpack/#setup
	Options: Alert, Button, Carousel, Collapse, Dropdown, Modal, Offcanvas, Popover,
	         ScrollSpy, Tab, Toast, Tooltip
*/
import { Alert, Button, Collapse, Dropdown, Popover } from 'bootstrap'

/*
	LIBRARY IMPORTS
	Utilities, plugins, and behaviors that aren't tied to a specific component.
*/
import alerts from './libraries/alerts';
import anchorLinks from './libraries/anchor-links';
import linkContainer from './libraries/link-container';
import './libraries/hoverintent.min.js';

/*
	COMPONENT IMPORTS
	For specific components.
*/
import accordion from '../blocks/accordion-block/js/accordion-block';
import carousel from '../blocks/carousel/js/carousel';
import imagesAutoSlider from '../blocks/images-auto-slider/js/images-auto-slider.js';
import twoTabs from '../blocks/two-tabs-text-image/js/two-tabs-text-image.js';
import './libraries/filters';
// import '../modules/some-module/js/some-module';

// Easy console access to jQuery through '$'
window.$ = $;

// FOUC on-fully-loaded make the page visible:
addEventListener('load', (e) => {
	document.documentElement.style.visibility = 'visible';
});

/* INITIALIZATION */
$(() => {
  $('body').addClass('document-ready');

  /* Higher priority first, lower priority later */
	alerts();
	linkContainer();
	anchorLinks();

	accordion();
	carousel();
	imagesAutoSlider();
	twoTabs();

	// Bootstrap Things: Currently Non-Functional
	new Alert();
	// new Dropdown();
	// new Popover();
	// new Util();
});


(function ($) {
	var navbar_height = 0; // Setting it to 0 since it might not have the actual size while the page is still rendering
    $('.navbar-nav').on('shown.bs.dropdown', function () {
		if (navbar_height == 0) { // Set the navbar height the first time the user clicks
			navbar_height = jQuery('.navbar-nav').height();
		}

        if (jQuery('.dropdown-menu.show').length > 0) {
			setTimeout(function() { // Try to execute the function again in case the user is clicking another link after the menu is opened
				modifySubMenuHeight();
				jQuery('.dropdown-menu.show').animate({opacity: 1, top: 'auto'}, 500);
			}, 10);
        } else {
            jQuery('.navbar-nav').css('height', 'auto');
        }
    });

    $('.navbar-nav').on('hidden.bs.dropdown', function () {
        if (jQuery('.dropdown-menu.show').length == 0) {
			
			jQuery('.navbar-nav').animate({height: navbar_height}, 500, function() {
				jQuery('.navbar-nav').css('border-radius', '35px'); // Hack to avoid border radius from being modified during transition on growth
			}); // Animate the closing of the navbar too
		}
		
	});

	// Modify submenu opacity and position before it gets shown
	$('.navbar-nav').on('show.bs.dropdown', function() {
		jQuery('.dropdown-menu.show').css('top', '60px'); // Move the submenu a bit to the bottom to animate a slide In
	});

	// Modify submenu opacity and position when it gets hidden
	$('.navbar-nav').on('hide.bs.dropdown', function() {
		jQuery('.dropdown-menu.show').animate({opacity: 0}, 500);
	});



	
	
	// Share button
	// var closeShareTimeStamp = 0;
	// $('.btn.share').on('click', function(e) {
	// 	console.log(e.target);
	// 	if (!$(this).hasClass('active') && e.timeStamp != closeShareTimeStamp) { // We need to check that the closing of the div didn't triggered this click
	// 		$(this).addClass('active');
	// 	}
	// });
	// $('.close-share').on('click', function(e) {
	// 	closeShareTimeStamp = e.timeStamp;
	// 	$(this).closest('.btn').removeClass('active');
	// });

	// Download button
	$('.btn.download').on('click', function(e) {
		if (!$(this).hasClass('active'))
			$(this).addClass('active');
		else if ($(this).hasClass('active') && e.target.innerHTML != '')
			$(this).closest('.btn').removeClass('active');
	});

	// Aria hidden attribute for offcanvasnav
	jQuery('.navbar-toggler').on('click', function() {
		$("#offcanvasNavbar").removeAttr("aria-hidden");
		$("#main_nav").attr("aria-hidden", "true");
	});

	jQuery('.offcanvas-header .btn-close').on('click', function() {
		$("#offcanvasNavbar").attr("aria-hidden", "true");
		$("#main_nav").removeAttr("aria-hidden");
	});

	// Play / Pause buttons
	$('.hero__bottom__controls').on('click', function() {
		$('body').toggleClass('motions-paused');
		if ($('body').hasClass('motions-paused')) {
			pauseAllMotions();
		} else {
			resumeAllMotions();
		}
	});
	
})(jQuery);

function modifySubMenuHeight() {
	// Nav bar dropdown
    var original_navbar_height = 70;
	var bottom_offset = 20; // Using 20px as bottom offset
	
	var navbar_height = (original_navbar_height + jQuery('.dropdown-menu.show').height() + bottom_offset);

	jQuery('.navbar-nav').css('border-radius', '27px'); // Hack to avoid border radius from being modified during transition on growth
	jQuery('.navbar-nav').animate({height: navbar_height}, 500);
}

function pauseAllMotions() {
	// Modify play/pause icon & Text.
	$('.hero__bottom__controls .pause').css('display', 'none');
	$('.hero__bottom__controls .play').css('display', 'block');
	$('.hero__bottom__controls .text').html('Play <br />All Motion');

	// Stop Hero down arrow and pause 'page-flip'.
	$('.hero__bottom__page-flip .animated-arrows').css('animation', 'none');

	// Stop auto slider.
	$('.image-auto-slider__items').slick('slickPause');
	$('.image-auto-slider__items .slick-pause-icon').css('display', 'none');
	$('.image-auto-slider__items .slick-play-icon').css('display', 'inline');

	// Stop alpaca motion on footer.
	$('.alpaca-bounce').attr('src', '/wp-content/themes/riva-wp/images/AlpacaBounce2.png');
}

function resumeAllMotions() {
	// Modify play/pause icon & Text
	$('.hero__bottom__controls .pause').css('display', 'block');
	$('.hero__bottom__controls .play').css('display', 'none');
	$('.hero__bottom__controls .text').html('Pause <br />All Motion');

	// Resume Hero down arrow and allow 'page-flip'.
	$('.hero__bottom__page-flip .animated-arrows').css('animation', 'expand-all 900ms infinite normal ease-out');

	// Resume auto slider
	$('.image-auto-slider__items').slick('slickPlay');
	$('.image-auto-slider__items .slick-pause-icon').css('display', 'inline');
	$('.image-auto-slider__items .slick-play-icon').css('display', 'none');

	// Resume alpaca motion on footer
	$('.alpaca-bounce').attr('src', '/wp-content/themes/riva-wp/images/AlpacaBounce.gif');
}
import $ from 'jQuery';

export default function() {

	/*
		This implementation is based on the WAI-ARIA Authoring Practices 1.1 example:
		https://www.w3.org/TR/wai-aria-practices/examples/accordion/accordion.html

		Home/End, Up/Down keyboard binds are not handled here, and are non-essential,
		but if your project reliably renders accordion items in one column, stacked order,
		it is nice to add that functionality.

		However, as accordions are often rendered in columns, the current best-practice
		pattern for allowing two columns of accordions to function in a masonry-style layout
		(where opening an accordion in Column-A does not also push down the entire row in
		Column-B) confuses the natural DOM order of items that Home/End/Up/Down reliably
		would need to bind to. In short, assuming Home/End/Up/Down binds for all projects
		can reasonably cause more headaches that its worth, and the natural tab order and
		selection capabilities of AT are sufficient/better at navigating a broader set of
		layout options.

		- JE
	*/

	const $accordionItems = $('.accordion-item');
	const $accordionItemToggles = $('.accordion-item__toggle', $accordionItems);

	if ($accordionItemToggles.length) {

		// Bind mouse click / keyboard space/enter button activation.
		// ---
		$accordionItemToggles.off('click').on('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			const $thisToggle = $(this);

			if ($thisToggle.attr('aria-expanded') === 'true') {
				closeAccordionItem($thisToggle);
			}
			else {
				openAccordionItem($thisToggle);
			}
		});
	}


	// Work functions invoked by event binds.
	// ---


	function closeAccordionItem($accordionItemToggle) {
		const $parentItem = $accordionItemToggle.closest('.accordion-item');
		const $itemPanel = $parentItem.find('.accordion-item__panel').first();

		$parentItem.removeClass('accordion-item--open');
		$accordionItemToggle.attr('aria-expanded', 'false');

		/*
			Use jquery slide collapse to hide, this is still the most
			reliable slide/expand option we have readily available.
			Also, it handles inline display: none/block at the end of its
			animation. - JE
		*/
		$itemPanel.slideUp(250); // inline display: none; after 250ms.

		// Add setTimeout because otherwise animation doesn't work
		setTimeout(function() {
			$itemPanel.prop('hidden', true);
		}, 400);
	}


	function openAccordionItem($accordionItemToggle) {
		const $parentItem = $accordionItemToggle.closest('.accordion-item');
		const $itemPanel = $parentItem.find('.accordion-item__panel').first();

		// close any other element opened before opening a new one
		$accordionItems.filter('.accordion-item--open').each(function() {
			closeAccordionItem($(this).find('.accordion-item__toggle'));
		});

		$parentItem.addClass('accordion-item--open');
		$accordionItemToggle.attr('aria-expanded', 'true');

		$itemPanel.prop('hidden', false);
		$itemPanel.slideDown(250); // inline display: block; after 250ms.
	}

}

import $ from 'jQuery';

/*
  Add JS functionality for full card hover/focus, so that we
  don't have to put gobs of text inside anchors which is not
  very screen reader friendly.

  To use: add --link-container class to card wrapper,
  and add --link-container-link to the <a> with the href inside
  of the card.
*/

export default () => {
  const $linkContainers = $('.--link-container');

  if ($linkContainers.length) {
    // Bind click/enter handler
    $('html').on('click', '.--link-container', (e) => {
      if ($(e.target).prop('tagName') === 'A') {
        return;
      }

      const $resultLink = $(e.currentTarget).find('.--link-container-link');

      if ($resultLink.length) {
        $resultLink.get(0).click();
      }
    });
  }
};

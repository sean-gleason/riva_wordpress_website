import $ from 'jQuery';

export default () => {
  // anchor links smooth scrolling.

  // if the header is sticky, take it in count for where the page lands
  // after scrolling
  const headerHeight = $('.l-header').height();

  if (window.location.hash) {
    const hash = window.location.hash;

    if ($(hash).length) {
      setTimeout(function () {
        const offset = $(hash).offset().top;
        $('body, html').animate({ scrollTop: `${offset - 10}px` }, 800);
      }, 300);
    }
  }

  $('a.anchor-link').on('click', function (e) {
    e.preventDefault();
    const $target = $($(this).attr('href'));

    if ($target.length) {
      const scrollTo = $target.offset().top;

      // if the header is sticky, use this instead
      // $('body, html').animate({scrollTop: scrollTo - headerHeight + 'px'}, 800);
      $('body, html').animate({ scrollTop: `${scrollTo}px` }, 800);

      setTimeout(function () {
        $target.focus();
      }, 250);
    }
  });
};

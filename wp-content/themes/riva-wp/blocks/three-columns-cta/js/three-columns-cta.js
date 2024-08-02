import $ from 'jQuery';


export default function() {

  $(function () {
    $('.two-tabs-block__switch span').on('click', function() {
      $('.two-tabs-block__switch span').removeClass('selected');
      $(this).addClass('selected');
      
      $('.two-tabs-block__tab').css('display', 'none');
      $('[data-attr="' + $(this).attr('data-target') + '"]').css('display', 'flex');
    });
  });
}
const jqueryImageZoom = () => {
  // $('.show-image-payin').zoomImage();
  $('.show-small-img:first-of-type').addClass("active")
  $('.show-small-img:first-of-type').attr('alt', 'now').siblings().removeAttr('alt')
  $('.show-small-img').click(function () {
    $('#show-img-photoviewer').attr('href', $(this).data('img'))
  $('#show-img').attr('src', $(this).attr('src'))
  $('#big-img').attr('src', $(this).attr('src'))
  $(this).attr('alt', 'now').siblings().removeAttr('alt')
  $(this).addClass("active").siblings().removeClass("active")
  if ($('#small-img-roll').children().length > 3) {
      if ($(this).index() >= 2 && $(this).index() < $('#small-img-roll').children().length ){
      $('#small-img-roll').css('left', -($(this).index() - 1) * 76 + 'px')
      } else if ($(this).index() == $('#small-img-roll').children().length - 1) {
      $('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
      } else {
      $('#small-img-roll').css('left', '0')
      }
  }
  });

  $('#next-img').click(function (){
  $('#show-img').attr('src', $(".show-small-img[alt='now']").next().attr('src'))
  $('#big-img').attr('src', $(".show-small-img[alt='now']").next().attr('src'))
  $(".show-small-img[alt='now']").next().addClass("active").siblings().removeClass("active")
  $(".show-small-img[alt='now']").next().attr('alt', 'now').siblings().removeAttr('alt')
  if ($('#small-img-roll').children().length > 3) {
      if ($(".show-small-img[alt='now']").index() >= 2 && $(".show-small-img[alt='now']").index() < $('#small-img-roll').children().length ){
      $('#small-img-roll').css('left', -($(".show-small-img[alt='now']").index() - 1) * 76 + 'px')
      } else if ($(".show-small-img[alt='now']").index() == $('#small-img-roll').children().length - 1) {
      $('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
      } else {
      $('#small-img-roll').css('left', '0')
      }
  }
  });

  $('#prev-img').click(function (){
  $('#show-img').attr('src', $(".show-small-img[alt='now']").prev().attr('src'))
  $('#big-img').attr('src', $(".show-small-img[alt='now']").prev().attr('src'))
  $(".show-small-img[alt='now']").prev().addClass("active").siblings().removeClass("active")
  $(".show-small-img[alt='now']").prev().attr('alt', 'now').siblings().removeAttr('alt')
  if ($('#small-img-roll').children().length > 3) {
      if ($(".show-small-img[alt='now']").index() >= 2 && $(".show-small-img[alt='now']").index() < $('#small-img-roll').children().length){
      $('#small-img-roll').css('left', -($(".show-small-img[alt='now']").index() - 1) * 76 + 'px')
      } else if ($(".show-small-img[alt='now']").index() == $('#small-img-roll').children().length - 1) {
      $('#small-img-roll').css('left', -($('#small-img-roll').children().length - 4) * 76 + 'px')
      } else {
      $('#small-img-roll').css('left', '0')
      }
  }
  });


}

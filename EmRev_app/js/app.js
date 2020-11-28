$(function(){
  // SPメニュー
  //js-toggle-sp-menuを持つ要素をクリックすると
  //.js-toggle-sp-menu-targetクラスを持つ要素に対してactiveクラスを持たせる。
  $('.js-toggle-sp-menu').on('click', function () {
    $('.js-toggle-sp-menu-target').toggleClass('active');
    $('.menuAbout').toggleClass('active');
  });
});
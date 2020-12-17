$(function(){
  // SPメニュー
  //js-toggle-sp-menuを持つ要素をクリックすると
  //.js-toggle-sp-menu-targetクラスを持つ要素に対してactiveクラスを持たせる。
  $('.js-toggle-sp-menu').on('click', function () {
    $('.js-toggle-sp-menu-target').toggleClass('active');
    $('.menuAbout').toggleClass('active');
  });

  //signup・loginフォーム切り替え
  $('.active-login-menu').on('click', function () {
    $('.js-signup-style').addClass('hidden');
    setTimeout(() => {
      $('.js-login-style').removeClass('hidden');
    }, 1000)
    });

  //
});



// $(function() {

//   // フロートヘッダーメニュー
//   var targetHeight = $('.js-float-menu-target').height();
//   $(window).on('scroll', function () {
//     $('.js-float-menu').toggleClass('float-active', $(this).scrollTop() > targetHeight);
//   });

//   // SPメニュー
//   $('.js-toggle-sp-menu').on('click', function () {
//     $(this).toggleClass('active');
//     $('.js-toggle-sp-menu-target').toggleClass('active');
//   });

//   // メッセージ表示
//   var $jsShowMsg = $('#js-show-msg');
//   var msg = $jsShowMsg.text();
//   if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
//     $jsShowMsg.slideToggle('slow');
//     setTimeout(function () {
//       $jsShowMsg.slideToggle('slow');
//     }, 5000);
//   }

//   // 画像ライブプレビュー
//   var $dropArea = $('.area-drop');
//   var $fileInput = $('.input-file');
//   $dropArea.on('dragover', function (e) {
//     e.stopPropagation();
//     e.preventDefault();
//     $(this).css('border', '3px #ccc dashed');
//   });
//   $dropArea.on('dragleave', function (e) {
//     e.stopPropagation();
//     e.preventDefault();
//     $(this).css('border', 'none');
//   });
//   $fileInput.on('change', function (e) {
//     $dropArea.css('border', 'none');
//     var file = this.files[0], // 2. files配列にファイルが入っています
//       $img = $(this).siblings('.prev-img'), // 3. jQueryのsiblingsメソッドで兄弟のimgを取得
//       fileReader = new FileReader(); // 4. ファイルを読み込むFileReaderオブジェクト

//     // 5. 読み込みが完了した際のイベントハンドラ。imgのsrcにデータをセット
//     fileReader.onload = function (event) {
//       // 読み込んだデータをimgに設定
//       $img.attr('src', event.target.result).show();
//     };

//     // 6. 画像読み込み
//     fileReader.readAsDataURL(file);

//   });

//   // テキストエリアカウント
//   var $countUp = $('#js-count'),
//     $countView = $('#js-count-view');
//   $countUp.on('keyup', function (e) {
//     $countView.html($(this).val().length);
//   });

//   //画像切替
//   var $switchImgSubs = $('.js-switch-img-sub'),
//     $switchImgMain = $('#js-switch-img-main');
//   $switchImgSubs.on('click', function (e) {
//     $switchImgMain.attr('src', $(this).attr('src'));
//   });

//   // お気に入り登録・削除
//   var $like,likeProductId;
//   $like = $('.js-click-like') || null; //nullというのはnull値という値で、「変数の中身は空ですよ」と明示するためにつかう値
//   likeProductId = $like.data('productid') || null;
//   // 数値の0はfalseと判定されてしまう。product_idが0の場合もありえるので、0もtrueとする場合にはundefinedとnullを判定する
//   if(likeProductId !== undefined && likeProductId !== null){
//     $like.on('click',function(){
//       var $this = $(this);
//       $.ajax({
//         type: "POST",
//         url: "ajaxLike.php",
//         data: { productId : likeProductId}
//       }).done(function( data ){
//         console.log('Ajax Success');
//         // クラス属性をtoggleでつけ外しする
//         $this.toggleClass('active');
//       }).fail(function( msg ) {
//         console.log('Ajax Error');
//       });
//     });
//   }

// });

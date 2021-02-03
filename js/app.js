$(function(){
  // SPメニュー
  //js-toggle-sp-menuを持つ要素をクリックすると
  //.js-toggle-sp-menu-targetクラスを持つ要素に対してactiveクラスを持たせる。
  $('.js-toggle-sp-menu').on('click', function () {
    $('.menuAbout').toggleClass('active');
    $('.header').toggleClass('active');
  });

  //signup->loginフォーム切り替え
  $('.active-login-menu').on('click', function () {
    $('.js-signup-style').addClass('hidden');
    setTimeout(() => {
      $('.js-login-style').removeClass('hidden');
    }, 1000)
  });

  //login->signupフォーム切り替え
  $('.active-signup-menu').on('click', function () {
    $('.js-login-style').addClass('hidden');
    setTimeout(() => {
      $('.js-signup-style').removeClass('hidden');
    }, 1000)
  });

  // フラッシュメッセージ表示
  // #js-show-msgを持つ要素を取得。$jsShowMsg変数内に入れて処理を当てていく。
  // 要素内に文字が入った際に取得。その後変数に代入。
  // 要素内文字に空文字があった場合""に入れ替える。（空白を消す)。
  // msg内に文字が入った際に処理が走る。
  // その後対象要素に.slideToggle()を当ててメッセージを表示する。
  var $jsShowMsg = $('#js-show-msg');
  var msg = $jsShowMsg.text();
  if (msg.replace(/^[\s　]+|[\s　]+$/g, "").length) {
    $jsShowMsg.addClass('fade-up');
    setTimeout(function () {
      $jsShowMsg.removeClass('fade-up');
    }, 3000);
  }

  //お気に入り登録処理(登録・削除)
  var $like,likeReviewId;
  $like = $('.js-click-like') || null;
  // $like内にある要素(.js-click-like)を参照。同じタグ内のdata・(data-reviewId="<?php echo etc::sanitize($listProp['reviews'][0]['id']); ?>")
  // を引っ張ってlikeProductId内に挿入する。
  // $viewData['id']は閲覧中の個別商品IDになる。
  // .data関数内の要素はスネークケースでは無いとデータの管理対象にならない
  likeReviewId = $like.data('reviewid') || null;
  // 対象レビューの個別IDが取得できているか判定。
  if(likeReviewId !== null){
    $like.on('click',function(){
      // ここの(this)は処理発火地点 $like が対象。
      // （もっと正しく言うなら中で定義されている「.js-click-like」が対象かも)
      var $this = $(this);
      $.ajax({
        // 送信形式
        type: "POST",
        // データ送信先ファイルの指定
        url: "ajaxLike.php",
        // 左・今回の場合だと$_POST内で管理する為のキー指定
        // 右・実際に対象のキーに挿入するデータ
        data: { reviewId : likeReviewId}
        // doneとは
        // https://on-ze.com/archives/7778
        // .done()は後で実行したい処理。
      }).done(function( data ){
        console.log('Ajax Success');
        // function( data )内に保持してある「reviewId」クラスに対して
        // activeクラスを取り外しする。
        $this.toggleClass('activeLike');
        //失敗した場合コンソール上で「Ajax Error」と出力させる。
      }).fail(() => {
          console.log('Ajax Error');
        });

    });
  }
});
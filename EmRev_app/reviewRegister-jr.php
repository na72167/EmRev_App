<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='入社経路や在籍状況について';
  $Intro__Img = 'src="src/img/docs.png"';
  // ヘッドの読み込み
  require('./head.php');
?>
<body>

  <!--ヘッダー読み込み-->
  <?php
    require('./header.php');
  ?>

  <!-- ページ紹介要素ファイルの読み込み -->
  <?php
    require('./intro.php');
  ?>

  <section class="revRegistJr-content">

    <div class="revRegistJr-content__wrap">
      <!-- 登録の進行状況などを表示するファイルを読み込む. -->
      <?php
        require('./revProgress.php');
        ?>

      <div class="revRegistJr-content__form-element">
        <div class="revRegistJr-content__form-wrap">
          <h4 class="revRegistJr-content__title">Post Company Review</h4>
          <h1 class="revRegistJr-content__sub">入社経路や在籍状況について</h1>
          <form  class="revRegistJr-content__form">
            <div class="revRegistJr-content__input-wrap">
              <input class="revRegistJr-content__input" placeholder="入社経路">
              <input class="revRegistJr-content__input" placeholder="在籍状況">
              <input class="revRegistJr-content__input" placeholder="在籍時の職種">
              <input class="revRegistJr-content__input" placeholder="在籍時の役職">
              <input class="revRegistJr-content__input" placeholder="在籍期間">
              <input class="revRegistJr-content__input" placeholder="在籍形態">
              <input class="revRegistJr-content__input" placeholder="福利厚生">
              <input class="revRegistJr-content__input" placeholder="勤務時間">
            </div>

            <div class="revRegistJr-content__bottom-wrap">
              <bottom class="revRegistJr-content__bottom-cancel">レビューを取り消す</bottom>
              <bottom class="revRegistJr-content__bottom-next">次の項目へ</bottom>
            </div>

          </form>
        </div>
    </div>

  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
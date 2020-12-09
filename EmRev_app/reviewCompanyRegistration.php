<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー会社登録申請画面';
  $Intro__Text_Title ='ReviewCompanyRegistration';
  $Intro__Text_Sub ='レビュー会社登録申請画面';
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

  <!-- revcr・・・ReviewCompanyRegistration -->
  <section class="revcrReviewCompanyRegistration">
    <div class="revcrReviewCompanyRegistration__content">
      <div class="revcrReviewCompanyRegistration__title">Review Company Registration</div>

      <div class="revcrReviewCompanyRegistration__infoWrap">
        <form class="">
          <div class="revcrReviewCompanyRegistration__inputComp">会社名  <input placeholder="入力してください"></div>

          <div class="">
            <div class="">代表者  <input placeholder="入力してください"></div>
            <div class="">所在地  <input placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">業界  <input placeholder="入力してください"></div>
            <div class="">設立年度  <input placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">上場年  <input placeholder="入力してください"></div>
            <div class="">従業員数  <input placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">平均年収  <input placeholder="入力してください"></div>
            <div class="">平均年齢  <input placeholder="入力してください"></div>
          </div>

          <div>
            <bottom class="">キャンセル</bottom>
            <bottom class="">申請する</bottom>
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
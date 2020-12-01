<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='社内制度や企業文化について';
  $Intro__Img = 'src="src/img/docs.png"';
  // ヘッドの読み込み
  require('./head.php');
?>
<body>

  <!--ヘッダー読み込み-->
  <?php
    require('./header.php');
  ?>
  <div class="#">
    <!-- ページ紹介要素ファイルの読み込み -->
    <?php
      require('./intro.php');
    ?>


  <section class="revRegistCc-content">

    <div class="revRegistCc-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
      <div class="revRegistCc-content__form-element">
        <div class="revRegistCc-content__form-wrap">
          <h4 class="revRegistCc-content__title">Post Company Review</h4>
          <h1 class="revRegistCc-content__sub">社内制度や企業文化について</h1>
          <from action="" class="revRegistCc-content__wrap">
            <div class="revRegistCc-content__form-title">社内制度</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="社内制度について"></textarea>

            <div class="revRegistCc-content__form-title">企業文化</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="企業文化について"></textarea>

            <div class="revRegistCc-content__form-title">休暇</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="休暇について"></textarea>

            <div class="revRegistCc-content__form-title">組織体制</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="組織体制について"></textarea>

            <div class="revRegistCc-content__form-title">女性の働きやすさ</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="女性の働きやすさについて"></textarea>

            <div class="revRegistCc-content__form-title">福利厚生</div>
            <textarea class="revRegistCc-content__form-areaForm" placeholder="福利厚生について"></textarea>

            <div class="revRegistCc-content__bottom-wrap">
              <bottom class="revRegistCc-content__bottom-return">前の項目へ</bottom>
              <bottom class="revRegistCc-content__bottom-next">次の項目へ</bottom>
            </div>

          </from>
        </div>
      </div>

    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
<!-- GcはgeneralCommentの略 -->
<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='総評';
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

<section class="revRegistGc-content">

    <div class="revRegistGc-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
      <div class="revRegistGc-content__form-element">
        <div class="revRegistGc-content__form-wrap">
          <h4 class="revRegistGc-content__title">Post Company Review</h4>
          <h1 class="revRegistGc-content__sub">総評</h1>
          <from action="" class="revRegistGc-content__wrap">

            <div class="revRegistGc-content__form-conciseTitle">総合的なこの会社の印象や評価を20文字以内でお願いします。</div>
            <textarea class="revRegistGc-content__form-conciseAreaForm" placeholder="総評(簡潔にお願いします)"></textarea>

            <div class="revRegistGc-content__form-title">総評</div>
            <textarea class="revRegistGc-content__form-areaForm" placeholder="総評(詳しくお願いします)"></textarea>

            <div class="revRegistGc-content__bottom-wrap">
              <a href="reviewRegister-jr.php" class="revRegistGc-content__bottom-link"><bottom class="revRegistGc-content__bottom-return" href="reviewRegister-cc.php">前の項目へ</bottom></a>
              <a href="reviewRegister-jw.php" class="revRegistGc-content__bottom-link"><bottom class="revRegistGc-content__bottom-next" href="reviewRegister-pc.php">次の項目へ</bottom></a>
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
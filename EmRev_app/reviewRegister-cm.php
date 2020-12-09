<!-- cmは「completeの略」 -->
<?php
  // タイトルの読み込み
  $Page_Title = '投稿完了';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='投稿完了';
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

  <section class="revRegistCm-content">

    <div class="revRegistCm-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
      <div class="revRegistCm-content__form-element">
        <div class="revRegistCm-content__form-wrap">
          <h4 class="revRegistCm-content__title">投稿完了</h4>
          <h1 class="revRegistCm-content__sub">投稿ありがとうございました</h1>
            <div class="revRegistCm-content__bottom-wrap">
              <a href="reviewRegister-jw.php" class="revRegistCm-content__bottom-link"><bottom class="revRegistCm-content__bottom-next" href="reviewRegister-pc.php">マイページへ</bottom></a>
            </div>
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
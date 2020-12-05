<?php
  // タイトルの読み込み
  $Page_Title = '退会画面';
  $Intro__Text_Title ='Withdrawal';
  $Intro__Text_Sub ='退会画面';
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

  <section class="withdrawal">
    <div class="withdrawal__content">
      <form>
        <bottom class="withdrawal__content-bottom">
          退会する
        </bottom>
      </form>
    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
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

  <!-- ページ紹介要素ファイルの読み込み -->
  <?php
    require('./intro.php');
  ?>


  <section class="">

    <?php
    require('./revProgress.php');
    ?>

    <div class="">
      <h4 class="">会社レビュー投稿画面</h4>
      <h1 class=""></h1>
      <form  class="">
        <div class="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
          <input class="" placeholder="">
        </div>

        <div class="#">
          <bottom class="#"></bottom>
          <bottom class="#"></bottom>
        </div>
      </form>
    </div>

  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
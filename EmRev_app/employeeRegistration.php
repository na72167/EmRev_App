<?php
  // タイトルの読み込み
  $Page_Title = '社員登録画面';
  $Intro__Text_Title ='Employee Registration';
  $Intro__Text_Sub ='社員登録画面';
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

  <?php
    require('./middleElement.php');
  ?>

  <section class="empregEmployeeRegister">
    <div class="empregEmployeeRegister__content">
      <h1 class="empregEmployeeRegister__title">Employee Registration</h1>
      <form>
        <h4>現在ログイン中のメールアドレス</h4>
        <div class="empregEmployeeRegister__outputStyle">
          <div>(ここにメールアドレス出力予定)</div>
        </div>
        <h4 class="empregEmployeeRegister__secondText">で社員登録します。宜しいですか?</h4>
        <div class="empregEmployeeRegister__bottom-wrap">
            <a href="#" class="empregEmployeeRegister__bottom-link"><bottom class="empregEmployeeRegister__bottom-return" href="reviewRegister-jr.php">キャンセル</bottom></a>
            <a href="#" class="empregEmployeeRegister__bottom-link"><bottom class="empregEmployeeRegister__bottom-next" href="reviewRegister-jw.php">登録する</bottom></a>
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
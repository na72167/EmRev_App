<?php
  // タイトルの読み込み
  $Page_Title = 'パスワードリマインダー画面';
  $Intro__Text_Title ='Password Reminder';
  $Intro__Text_Sub ='パスワードリマインダー画面';
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

  <section class="passrePasswordReminder">
    <div class="passrePasswordReminder__content">
      <h1 class="passrePasswordReminder__title">Password Reminder</h1>
      <form>
        <h4>メールアドレス</h4>
        <input class="passrePasswordReminder__input" placeholder="ここにメールアドレスを入力">
        <bottom class="passrePasswordReminder__content-bottom">
          送信する
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
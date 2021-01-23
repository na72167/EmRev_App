<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;
?>

<!-- jwは「joinedGap・workの略」 -->
<?php
  // タイトルの読み込み
  $Page_Title = "レビュー登録画面";
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='入社後のギャップや働きがい';
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


  <section class="revRegistJw-content">

    <div class="revRegistJw-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
    <div class="revRegistJw-content__form-element">
      <div class="revRegistJw-content__form-wrap">
          <h4 class="revRegistJw-content__title">Post Company Review</h4>
          <h1 class="revRegistJw-content__sub">入社後のギャップや働きがい</h1>
          <from action="" method="post" class="revRegistJw-content__wrap">
            <div class="revRegistJw-content__form-title">入社前とのギャップ</div>
            <textarea class="revRegistJw-content__form-areaForm" placeholder="入社前とのギャップ"></textarea>

            <div class="revRegistJw-content__form-title">働きがい</div>
            <textarea class="revRegistJw-content__form-areaForm" placeholder="働きがいについて"></textarea>

            <div class="revRegistJw-content__form-title">強み・弱み</div>
            <textarea class="revRegistJw-content__form-areaForm" placeholder="強み・弱みについて"></textarea>

            <div class="revRegistJw-content__form-title">年収・給与</div>
            <textarea class="revRegistJw-content__form-areaForm" placeholder="年収・給与について"></textarea>

            <div class="revRegistJw-content__form-title">事業展望</div>
            <textarea class="revRegistJw-content__form-areaForm" placeholder="事業展望について"></textarea>

            <div class="revRegistJw-content__bottom-wrap">
              <a href="reviewRegister-cc.php" class="revRegistJw-content__bottom-link"><bottom class="revRegistJw-content__bottom-return">前の項目へ</bottom></a>
              <a href="reviewRegister-gc.php" class="revRegistJw-content__bottom-link"><bottom class="revRegistJw-content__bottom-next">次の項目へ</bottom></a>
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
<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\admin\signup;
  use classes\admin\login;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;
?>

<?php
  // タイトルの読み込み
  $Page_Title = 'DM一覧画面';
  $Intro__Text_Title ='DM List';
  $Intro__Text_Sub ='ダイレクトメール一覧画面';
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


<div class="dlliDmList">
      <div class="dlliDmList__title">Dm List</div>
        <div class="dlliDmList__list">

        <!-- ======================================================= -->
          <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        <div class="dlliDmList__detail">
            <div class="dlliDmList__postingTime">
              <div class="dlliDmList__postingTime-element">投稿日時</div>
              <div class="dlliDmList__postingTime-output">2100/01/01</div>
            </div>
            <div class="dlliDmList__postingDate">
              <div class="dlliDmList__postingDate-element">投稿日時・時刻</div>
              <div class="dlliDmList__postingDate-output">00 月00日 00:00:00</div>
            </div>
            <div class="dlliDmList__postings">
              <div class="dlliDmList__postings-element">投稿内容</div>
              <div class="dlliDmList__postings-output">サンプルサンプルサンプルサンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->

        </div>
      <div class="dlliDmList__pageTransition">
        <div class="dlliDmList__pageTransition-contentWrap">
          <span class="dlliDmList__pageTransition-leftArrow">◁</span>
            <div class="dlliDmList__pageTransition-guideNumber">12345</div>
          <span class="dlliDmList__pageTransition-rightArrow">▷</span>
        </div>
      </div>
    </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
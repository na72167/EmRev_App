<?php
    //関数関係のファイルを纏めたもの
  require('function.php');

  debug('「「「「「「「「「「「「「「「「「「「');
  debug('アカウント作成ページ');
  debug('「「「「「「「「「「「「「');
  debugLogStart();

  // タイトルの読み込み
  $Page_Title = 'プロフィール編集画面';
  $Intro__Text_Title ='Profile Edit';
  $Intro__Text_Sub ='プロフィール編集画面';
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
    require('./designspace.php');
  ?>

  <?php
    require('./middleElement.php');
  ?>


    <section class="profEdiUserProfile">
      <div class="profEdiUserProfile__img-wrap">
        <img class="profEdiUserProfile__img">
      </div>
      <div class="profEdiUserProfile__detail">
        <div class="profEdiUserProfile__name">
          <h1 class="profEdiUserProfile__name-element">name</h1>
          <div class="profEdiUserProfile__name-output">山田太郎</div>
        </div>
        <div class="profEdiUserProfile__ageTel-Wrap">
          <div class="profEdiUserProfile__age">
            <div class="profEdiUserProfile__age-element">age</div>
            <div class="profEdiUserProfile__age-output">00</div>
          </div>
          <div class="profEdiUserProfile__tel">
            <div class="profEdiUserProfile__tel-element">tel</div>
            <div class="profEdiUserProfile__tel-output">000-0000-0000</div>
          </div>
        </div>
        <div class="profEdiUserProfile__address">
          <div class="profEdiUserProfile__address-element">adless</div>
          <div class="profEdiUserProfile__address-output">東京都板橋区〇〇-0000-0</div>
        </div>
        <div class="profEdiUserProfile__state">
          <div class="profEdiUserProfile__state-element">state</div>
          <div class="profEdiUserProfile__state-output">一般会員</div>
        </div>
        <div class="profEdiUserProfile__dmState">
          <div class="profEdiUserProfile__dmState-element">DM可否</div>
          <div class="profEdiUserProfile__dmState-output">可</div>
        </div>
      </div>

      <div class="profEdiUserProfile__employeeInfoWrap">
        <div class="profEdiUserProfile__affiliationCompany">
          <h1 class="profEdiUserProfile__affiliationCompany-element">現所属会社</h1>
          <div class="profEdiUserProfile__affiliationCompany-output">サンプルサンプルサンプル</div>
        </div>
        <div class="profEdiUserProfile__incumbentPositionWrap">
          <div class="profEdiUserProfile__incumbent">
            <div class="profEdiUserProfile__incumbent-element">現職</div>
            <div class="profEdiUserProfile__incumbent-output">サンプルサンプルサンプル</div>
          </div>
          <div class="profEdiUserProfile__Position">
            <div class="profEdiUserProfile__Position-element">現役職</div>
            <div class="profEdiUserProfile__Position-output">サンプルサンプルサンプル</div>
          </div>
        </div>
        <div class="profEdiUserProfile__currentDepartment">
          <div class="profEdiUserProfile__currentDepartment-element">現部署</div>
          <div class="profEdiUserProfile__currentDepartment-output">サンプルサンプルサンプル</div></div>
        </div>
      </div>
    </section>

    <div class="profEdiUserProfile__bottom-wrap">
      <a href="#.php" class="profEdiUserProfile__bottom-link"><bottom class="profEdiUserProfile__bottom-return">変更を取り消す</bottom></a>
      <a href="#.php" class="profEdiUserProfile__bottom-link"><bottom class="profEdiUserProfile__bottom-next">変更する</bottom></a>
    </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
<?php
    // タイトルの読み込み
    $Page_Title = 'ユーザー詳細';
    $Intro__Text_Title ='UserProfile';
    $Intro__Text_Sub ='ユーザープロフィール画面';
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


    <section class="profUserProfile">
      <div class="profUserProfile__img-wrap">
        <img class="profUserProfile__img">
      </div>
      <div class="profUserProfile__detail">
        <div class="profUserProfile__name">
          <h1 class="profUserProfile__name-element">name</h1>
          <div class="profUserProfile__name-output">山田太郎</div>
        </div>
        <div class="profUserProfile__ageTel-Wrap">
          <div class="profUserProfile__age">
            <div class="profUserProfile__age-element">age</div>
            <div class="profUserProfile__age-output">00</div>
          </div>
          <div class="profUserProfile__tel">
            <div class="profUserProfile__tel-element">tel</div>
            <div class="profUserProfile__tel-output">000-0000-0000</div>
          </div>
        </div>
        <div class="profUserProfile__address">
          <div class="profUserProfile__address-element">adless</div>
          <div class="profUserProfile__address-output">東京都板橋区〇〇-0000-0</div>
        </div>
        <div class="profUserProfile__state">
          <div class="profUserProfile__state-element">state</div>
          <div class="profUserProfile__state-output">一般会員</div>
        </div>
        <div class="profUserProfile__dmState">
          <div class="profUserProfile__dmState-element">DM可否</div>
          <div class="profUserProfile__dmState-output">可</div>
        </div>
      </div>

      <div class="profUserProfile__employeeInfoWrap">
        <div class="profUserProfile__affiliationCompany">
          <h1 class="profUserProfile__affiliationCompany-element">現所属会社</h1>
          <div class="profUserProfile__affiliationCompany-output">サンプルサンプルサンプル</div>
        </div>
        <div class="profUserProfile__incumbentPositionWrap">
          <div class="profUserProfile__incumbent">
            <div class="profUserProfile__incumbent-element">現職</div>
            <div class="profUserProfile__incumbent-output">サンプルサンプルサンプル</div>
          </div>
          <div class="profUserProfile__Position">
            <div class="profUserProfile__Position-element">現役職</div>
            <div class="profUserProfile__Position-output">サンプルサンプルサンプル</div>
          </div>
        </div>
        <div class="profUserProfile__currentDepartment">
          <div class="profUserProfile__currentDepartment-element">現部署</div>
          <div class="profUserProfile__currentDepartment-output">サンプルサンプルサンプル</div></div>
        </div>
      </div>
    </section>

    <div class="profUserProfile__bottom-wrap">
      <a href="#.php" class="profUserProfile__bottom-link"><bottom class="profUserProfile__bottom-return">DMを開始する</bottom></a>
      <a href="#.php" class="profUserProfile__bottom-link"><bottom class="profUserProfile__bottom-next">このユーザーをブロックする</bottom></a>
    </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
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
  $Page_Title = 'マイページ';
  $Intro__Text_Title ='Employee UserList';
  $Intro__Text_Sub ='社員登録済みユーザー一覧画面';
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

  <!-- regitedUl・・・RegissteredUserList -->
  <section class="regitedUlEmployeeSearch">
    <h1 class="regitedUlEmployeeSearch__title">Employee Search</h1>
    <form class="regitedUlEmployeeSearch__form">

      <div class="regitedUlEmployeeSearch__inputContentStyle">
        <h1 class="regitedUlEmployeeSearch__inputName">名前</h1>
        <input class="regitedUlEmployeeSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="regitedUlEmployeeSearch__inputContentStyle">
        <h1 class="regitedUlEmployeeSearch__inputName">年齢</h1>
        <input class="regitedUlEmployeeSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="regitedUlEmployeeSearch__inputContentStyle">
        <h1 class="regitedUlEmployeeSearch__inputName">電話番号</h1>
        <input class="regitedUlEmployeeSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="regitedUlEmployeeSearch__inputContentStyle">
        <h1 class="regitedUlEmployeeSearch__inputName">住所</h1>
        <input class="regitedUlEmployeeSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="regitedUlEmployeeSearch__inputContentStyle">
        <h1 class="regitedUlEmployeeSearch__inputName">DM可否</h1>
        <input class="regitedUlEmployeeSearch__inputStyle" placeholder="入力してください">
      </div>
      <bottom class="regitedUlEmployeeSearch__bottomStyle">検索する</bottom>
    </form>
  </section>

  <section class="regitedUlEmployeeSorting">
    <h1 class="regitedUlEmployeeSorting__title">Employee Sorting</h1>
    <form class="regitedUlEmployeeSorting__form">

      <div class="regitedUlEmployeeSorting__inputContentStyle">
        <h1 class="regitedUlEmployeeSorting__inputName">並び替え項目</h1>
        <input class="regitedUlEmployeeSorting__inputStyle" placeholder="入力してください">
      </div>
      <div class="regitedUlEmployeeSorting__inputContentStyle">
        <h1 class="regitedUlEmployeeSorting__inputName">並び替え順序</h1>
        <input class="regitedUlEmployeeSorting__inputStyle" placeholder="入力してください">
      </div>
      <bottom class="regitedUlEmployeeSorting__bottomStyle">並び替えをする</bottom>
    </form>
  </section>

  <div class="regitedUlEmployeeList">
    <div class="regitedUlEmployeeList__header">
      <h1 class="regitedUlEmployeeList__title">Registered Employees User List</h1>
      <h3>検索結果:<span>〇〇</span>件</h3>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>

    <div class="regitedUlEmployeeList__mainContent">
      <!-- コンテンツ -->
      <div class="regitedUlEmployeeList__imgStyle">
        <img class="regitedUlEmployeeList__img">
      </div>
      <div class="regitedUlEmployeeList__userDetail">
        <div class="regitedUlEmployeeList__nameAgeWrap">
          <div class="regitedUlEmployeeList__name">名前:<span>山田太郎</span></div>
          <div class="regitedUlEmployeeList__age">年齢:<span>00</span></div>
        </div>

        <div class="regitedUlEmployeeList__dmIncumbentWrap">
          <div class="regitedUlEmployeeList__dm">DM可否:<span>可</span></div>
          <div class="regitedUlEmployeeList__Incumbent">現職:<span>サンプル</span></div>
        </div>

        <div class="regitedUlEmployeeList__affiliatedCompanyStateWrap">
          <div class="regitedUlEmployeeList__affiliatedCompany">現所属会社:<span>サンプル</span></div>
          <div class="regitedUlEmployeeList__state">ステータス:<span>会員登録済み</span></div>
        </div>
        <h1 class="regitedUlEmployeeList__userProfLink">このユーザーの詳細を見る</h1>
      </div>
    </div>
    <div class="regitedUlEmployeeList__pageTransition">
      <div class="regitedUlEmployeeList__pageTransition-contentWrap">
        <span class="regitedUlEmployeeList__pageTransition-leftArrow">◁</span>
          <div class="regitedUlEmployeeList__pageTransition-guideNumber">12345</div>
        <span class="regitedUlEmployeeList__pageTransition-rightArrow">▷</span>
      </div>
    </div>
  </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
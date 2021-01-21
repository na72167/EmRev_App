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

<?php
  // タイトルの読み込み
  $Page_Title = '登録レビュー一覧';
  $Intro__Text_Title ='RegisterReviewList';
  $Intro__Text_Sub ='登録レビュー一覧画面';
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

<section class="rigisRigisterReviewListSearch">
    <h1 class="rigisRigisterReviewListSearch__title">Employee Search</h1>
    <form class="rigisRigisterReviewListSearch__form">

      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">会社名</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">業界</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">所在地</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">従業員数</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">代表者名</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">上場年</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">口コミ数</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>

      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">平均年収</h1>
        <div class="rigisRigisterReviewListSearch__betweenStyleWrap">
          <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
          <div class="rigisRigisterReviewListSearch__betweenStyleHoge">~</div>
          <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">平均年齢</h1>
        <div class="rigisRigisterReviewListSearch__betweenStyleWrap">
          <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
          <div class="rigisRigisterReviewListSearch__betweenStyleHoge">~</div>
          <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="rigisRigisterReviewListSearch__inputContentStyle">
        <h1 class="rigisRigisterReviewListSearch__inputName">並び替え順序</h1>
        <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
      </div>


      <bottom class="rigisRigisterReviewListSearch__bottomStyle">検索する</bottom>
    </form>
  </section>

  <section class="rigisRigisterReviewListSorting">
    <h1 class="rigisRigisterReviewListSorting__title">Employee Sorting</h1>
    <form class="rigisRigisterReviewListSorting__form">

      <div class="rigisRigisterReviewListSorting__inputContentStyle">
        <h1 class="rigisRigisterReviewListSorting__inputName">並び替え項目</h1>
        <input class="rigisRigisterReviewListSorting__inputStyle" placeholder="入力してください">
      </div>
      <div class="rigisRigisterReviewListSorting__inputContentStyle">
        <h1 class="rigisRigisterReviewListSorting__inputName">並び替え順序</h1>
        <input class="rigisRigisterReviewListSorting__inputStyle" placeholder="入力してください">
      </div>
      <bottom class="rigisRigisterReviewListSorting__bottomStyle">並び替えをする</bottom>
    </form>
  </section>

  <div class="rigisRigisterReviewList">
    <div class="rigisRigisterReviewList__header">
      <h1 class="rigisRigisterReviewList__title">Register Review List</h1>
      <h3>検索結果:<span>〇〇</span>件</h3>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>
    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="rigisRigisterReviewList__mainContent">
      <div class="rigisRigisterReviewList__imgComInfoWrap">
        <div class="rigisRigisterReviewList__imgStyle">
          <img class="rigisRigisterReviewList__img">
        </div>
        <div class="rigisRigisterReviewList__companyWrap">
          <div class="rigisRigisterReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="rigisRigisterReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="rigisRigisterReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="rigisRigisterReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="rigisRigisterReviewList__userDetail">
        <div class="rigisRigisterReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="rigisRigisterReviewList__dmIncumbentWrap">
          <div class="rigisRigisterReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="rigisRigisterReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="rigisRigisterReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="rigisRigisterReviewList__userNameAgeFavoliteWrap">
          <div class="rigisRigisterReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="rigisRigisterReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- ここまで -->
    <div class="rigisRigisterReviewList__pageTransition">
      <div class="rigisRigisterReviewList__pageTransition-contentWrap">
        <span class="rigisRigisterReviewList__pageTransition-leftArrow">◁</span>
          <div class="rigisRigisterReviewList__pageTransition-guideNumber">12345</div>
        <span class="rigisRigisterReviewList__pageTransition-rightArrow">▷</span>
      </div>
    </div>
  </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
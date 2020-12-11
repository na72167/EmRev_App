<?php
  // タイトルの読み込み
  $Page_Title = '会社レビュー一覧';
  $Intro__Text_Title ='Review List';
  $Intro__Text_Sub ='会社レビュー一覧画面';
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

  <!-- revli・・・ReviewList -->
  <section class="revliReviewListSearch">
    <h1 class="revliReviewListSearch__title">Employee Search</h1>
    <form class="revliReviewListSearch__form">

      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">会社名</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">業界</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">所在地</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">従業員数</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">代表者名</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">上場年</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">口コミ数</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>

      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">平均年収</h1>
        <div class="revliReviewListSearch__betweenStyleWrap">
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
          <div class="revliReviewListSearch__betweenStyleHoge">~</div>
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">平均年齢</h1>
        <div class="revliReviewListSearch__betweenStyleWrap">
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
          <div class="revliReviewListSearch__betweenStyleHoge">~</div>
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">並び替え順序</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>


      <bottom class="revliReviewListSearch__bottomStyle">検索する</bottom>
    </form>
  </section>

  <section class="revliReviewListSorting">
    <h1 class="revliReviewListSorting__title">Employee Sorting</h1>
    <form class="revliReviewListSorting__form">

      <div class="revliReviewListSorting__inputContentStyle">
        <h1 class="revliReviewListSorting__inputName">並び替え項目</h1>
        <input class="revliReviewListSorting__inputStyle" placeholder="入力してください">
      </div>
      <div class="revliReviewListSorting__inputContentStyle">
        <h1 class="revliReviewListSorting__inputName">並び替え順序</h1>
        <input class="revliReviewListSorting__inputStyle" placeholder="入力してください">
      </div>
      <bottom class="revliReviewListSorting__bottomStyle">並び替えをする</bottom>
    </form>
  </section>

  <div class="revliReviewList">
    <div class="revliReviewList__header">
      <h1 class="revliReviewList__title">Review List</h1>
      <h3>検索結果:<span>〇〇</span>件</h3>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>
    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="revliReviewList__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="revliReviewList__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name">(総合的な会社の印象が出力される予定)</div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span>0000/00/00</span></div>
          <div class="revliReviewList__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="revliReviewList__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- ここまで -->
    <div class="revliReviewList__pageTransition">
      <div class="revliReviewList__pageTransition-contentWrap">
        <span class="revliReviewList__pageTransition-leftArrow">◁</span>
          <div class="revliReviewList__pageTransition-guideNumber">12345</div>
        <span class="revliReviewList__pageTransition-rightArrow">▷</span>
      </div>
    </div>
  </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
<?php
  // タイトルの読み込み
  $Page_Title = '閲覧履歴画面';
  $Intro__Text_Title ='Browsing History';
  $Intro__Text_Sub ='閲覧履歴画面';
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

    <section class="browsingHistorySearch">
    <h1 class="browsingHistorySearch__title">Employee Search</h1>
    <form class="browsingHistorySearch__form">

      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">会社名</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">業界</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">所在地</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">従業員数</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">代表者名</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">上場年</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">口コミ数</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>

      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">平均年収</h1>
        <div class="browsingHistorySearch__betweenStyleWrap">
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
          <div class="browsingHistorySearch__betweenStyleHoge">~</div>
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">平均年齢</h1>
        <div class="browsingHistorySearch__betweenStyleWrap">
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
          <div class="browsingHistorySearch__betweenStyleHoge">~</div>
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">並び替え順序</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>


      <bottom class="browsingHistorySearch__bottomStyle">検索する</bottom>
    </form>
  </section>

  <section class="browsingHistorySorting">
    <h1 class="browsingHistorySorting__title">Employee Sorting</h1>
    <form class="browsingHistorySorting__form">

      <div class="browsingHistorySorting__inputContentStyle">
        <h1 class="browsingHistorySorting__inputName">並び替え項目</h1>
        <input class="browsingHistorySorting__inputStyle" placeholder="入力してください">
      </div>
      <div class="browsingHistorySorting__inputContentStyle">
        <h1 class="browsingHistorySorting__inputName">並び替え順序</h1>
        <input class="browsingHistorySorting__inputStyle" placeholder="入力してください">
      </div>
      <bottom class="browsingHistorySorting__bottomStyle">並び替えをする</bottom>
    </form>
  </section>

  <div class="browsingHistory">
    <div class="browsingHistory__header">
      <h1 class="browsingHistory__title">Review List</h1>
      <h3>検索結果:<span>〇〇</span>件</h3>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>
    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span>サンプルサンプルサンプルサ</span></div>
          <div class="browsingHistory__companyName">会社名:<span>サンプルサンプルサンプルサン</span></div>
          <div class="browsingHistory__location">所在地:<span>サンプルサンプルサンプルサン</span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span>◯◯</span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name">(総合的な会社の印象が出力される予定)</div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span>0000/00/00</span></div>
          <div class="browsingHistory__dm">総評:<span>サンプルサンプルサンプルサンプル<br>サンプルサンプルサンプルサンプルサ...</span><h1 class="browsingHistory__userProfLink">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="browsingHistory__favorite">☆</div>
        </div>
      </div>
    </div>

    <!-- ここまで -->
    <div class="browsingHistory__pageTransition">
      <div class="browsingHistory__pageTransition-contentWrap">
        <span class="browsingHistory__pageTransition-leftArrow">◁</span>
          <div class="browsingHistory__pageTransition-guideNumber">12345</div>
        <span class="browsingHistory__pageTransition-rightArrow">▷</span>
      </div>
    </div>
  </div>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
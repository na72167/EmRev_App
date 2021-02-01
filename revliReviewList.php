<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\reviewRegister\reviewRegisterJr;
  use classes\userProp\contributorUserProp;
  use classes\companyApply\companyApply;
  use classes\etc\etc;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('会社レビュー一');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  // このあと$_SESSION['user_id']を参照してuserｓテーブルに関した情報のみを管理するuserクラスを作成。
  // 中のrollプロパティにアクセス。その権限情報とuserクラスを元に一般・社員・管理者・退会済み用のSQLを発行・検索を行う。(退会済みは別)。
  // getUserPropクラスを切り分ける。

  //ログインデータ($_SESSION['user_id']の数字)に一致するUsers情報を取得する。
  $userProp = userProp::getUserProp($_SESSION['user_id']);

  //取得した情報をオブジェクト管理する。
  $userDate = new userProp($userProp['id'],$userProp['email'],$userProp['password'],$userProp['roll'],$userProp['report_flg'],$userProp['delete_flg'],$userProp['create_date'],$userProp['update_date']);

  //第二引数にtrueを指定した場合,string型で出力される様になる。
  debugFunction::debug('取得したユーザー情報：'.print_r($userDate,true));

  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('権限確認処理');
  debugFunction::debug('「「「「「「「「「「「「「');

  // ログインユーザーの権限チェック
  if($userDate->getRoll() === 100){
      //ログインidに対応したgeneral_profsテーブルのレコードを取得する。
      $generalUserProp = generalUserProp::getGeneralUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $generalUserDate = new generalUserProp($generalUserProp['id'],$generalUserProp['email'],$generalUserProp['password'],$generalUserProp['roll'],$generalUserProp['report_flg'],$generalUserProp['delete_flg'],$generalUserProp['user_id'],$generalUserProp['username'],(int)$generalUserProp['age'],(int)$generalUserProp['tel'],$generalUserProp['profImg'],(int)$generalUserProp['zip'],$generalUserProp['addr'],$generalUserProp['create_date'],$generalUserProp['update_date'],'','','','','','');
      debugFunction::debug('取得した一般ユーザー情報：'.print_r($generalUserDate,true));
    }elseif($userDate->getRoll() === 50){
      //投稿者ユーザー
      $contributorUserProp = contributorUserProp::getContributorUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],$contributorUserProp['user_id'],$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],$contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'');
      debugFunction::debug('取得した投稿ユーザー情報：'.print_r($contributorUserDate,true));
    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }

  // ====================初期ページ表示処理====================
  // DBから会社データを一括取得
  $companyData = companyApply::companyAndReviewPropListDefault();
  debugFunction::debug('取得した会社情報と関連レビュー一覧：'.print_r($companyData,true));
  // それを多重連想配列形式で保持
  //[会社ID][key(カラム)]=> value(レコード) の形で管理
  //それをページの指定箇所に配置していく。

  // ====================検索会社情報取得処理====================

  // post送信されていてなおかつ投稿者ユーザーだった場合。
  if(!empty($_POST['search'] === '検索する')){

    $companySearchPost = new companyApply($_POST['company_name'],$_POST['representative'],$_POST['location'],$_POST['industry']
    ,$_POST['year_of_establishment'],$_POST['listed_year'],$_POST['number_of_employees'],
    $_POST['average_annual_income'],$_POST['average_age'],$_POST['number_of_reviews'],'','','','','','','','','','');

    debugFunction::debug('POSTされた内容：'.print_r($companySearchPost,true));

    //検索情報を取得後、会社情報を検索する。
    //ここのkey部分は実際に実行するSQL文にも関係する。

    $companySearchResult = $companySearchPost->companyAndReviewSearch(
      array_filter(array(
        //会社名
        'ci.company_name' => $companySearchPost->getCompany_name(),
        //代表者
        'ci.representative' => $companySearchPost->getRepresentative(),
        //所在地
        'ci.location' => $companySearchPost->getLocation(),
        //業界分類
        'ci.industry' => $companySearchPost->getIndustry(),
        //設立年度
        'ci.year_of_establishment' => $companySearchPost->getYearOfEstablishment(),
        //上場年
        'ci.listed_year' => $companySearchPost->getListed_year(),
        //従業員数
        'ci.number_of_employees' => $companySearchPost->getNumber_of_employees(),
        //平均年収
        'ci.average_annual_income' => $companySearchPost->getAverage_annual_income(),
        //平均年齢
        'ci.average_age' => $companySearchPost->getAverage_age(),
        //レビュー数
        'ci.number_of_reviews' => $companySearchPost->getNumber_of_reviews()
      ))
    );

    // $companySearchResult['compDate']が
    // 存在するかどうかを判定する。
    if(isset($companySearchResult['compDate'])){
      // 存在した場合
      debugFunction::debug('判定処理後の検索した会社情報：'.print_r($companySearchResult,true));

      // 値が保持されている場合、上の処理companyPropListDefault()で取得したレコードを初期化。
      $companyData = null;

    // その後$CompanySearchResult内のインスタンス情報へ書き換える。
      $companyData = $companySearchResult;
      debugFunction::debug('新しい会社情報：'.print_r($companyData,true));

    //下のサイトの関数を使ったほうがキレイにできそうなのでそのうち試す。
    //https://www.php.net/manual/ja/function.get-object-vars.php
    //https://www.php.net/manual/ja/function.property-exists.php)
    }elseif(!isset($companySearchResult['compDate'])){
    //空だった場合
    //フラッシュメッセージ内に「検索結果がありませんでした」
    //と表示させてデフォルトの検索結果を表示させる。
    }
  }

?>

<?php
  // タイトルの読み込み
  $Page_Title = '投稿されたレビュー一覧';
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

  <!-- ここの要素はBEMの規則違反になっている -->
  <section class="middleElement" style="min-height: 1800px;">

  <!-- revli・・・ReviewList -->
  <section class="revliReviewListSearch">
    <h1 class="revliReviewListSearch__title">Company Search</h1>
    <form class="revliReviewListSearch__form"  method="POST">

      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">会社名</h1>
        <input class="revliReviewListSearch__inputStyle" name="company_name" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">業界</h1>
        <input class="revliReviewListSearch__inputStyle" name="industry" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">所在地</h1>
        <input class="revliReviewListSearch__inputStyle" name="location" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">従業員数</h1>
        <input class="revliReviewListSearch__inputStyle" name="number_of_employees" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">代表者名</h1>
        <input class="revliReviewListSearch__inputStyle" name="representative" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">上場年</h1>
        <input class="revliReviewListSearch__inputStyle" name="listed_year" placeholder="入力してください">
      </div>
      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">口コミ数</h1>
        <input class="revliReviewListSearch__inputStyle" name="number_of_reviews" placeholder="入力してください">
      </div>

      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">平均年収</h1>
        <div class="revliReviewListSearch__betweenStyleWrap">
          <input class="revliReviewListSearch__betweenStyle" name="average_annual_income" placeholder="入力してください">
          <div class="revliReviewListSearch__betweenStyleHoge">~</div>
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">平均年齢</h1>
        <div class="revliReviewListSearch__betweenStyleWrap">
          <input class="revliReviewListSearch__betweenStyle" name="average_age" placeholder="入力してください">
          <div class="revliReviewListSearch__betweenStyleHoge">~</div>
          <input class="revliReviewListSearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="revliReviewListSearch__inputContentStyle">
        <h1 class="revliReviewListSearch__inputName">並び替え順序</h1>
        <input class="revliReviewListSearch__inputStyle" placeholder="入力してください">
      </div>

      <input type="submit" class="revliReviewListSearch__bottomStyle" name="search" value="検索する">
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
      <h3>検索結果:<span><?php echo $companyData['total'] ?></span>件</h3>
    </div>

    <!-- コンテンツ -->
    <!-- getについての参考記事
        https://qiita.com/Sekky0905/items/dff3d0da059d6f5bfabf -->

    <?php
      // ここで会社情報を取得 asでエイリアス設定
      // 上の処理で取得した会社情報を$key => $valの形で管理
      foreach($companyData['compDate'] as $key => $val):
      ?>
    <div class="revliReviewList__mainContent">
      <div class="revliReviewList__imgComInfoWrap">
        <div class="revliReviewList__imgStyle">
          <img class="revliReviewList__img">
        </div>
        <div class="revliReviewList__companyWrap">
          <div class="revliReviewList__industryClassification">業界分類:<span><?php echo $val['industry'] ?></span></div>
          <div class="revliReviewList__companyName">会社名:<span><?php echo $val['company_name'] ?></span></div>
          <div class="revliReviewList__location">所在地:<span><?php echo $val['location'] ?></span></div>
        </div>
        <div class="revliReviewList__reviewLink">>この会社の他のユーザーレビュー(<span><?php echo $val['number_of_reviews'] ?></span>)件</div>
      </div>
      <div class="revliReviewList__userDetail">
        <div class="revliReviewList__name"><?php echo $val['general_estimation_title'] ?></div>

        <div class="revliReviewList__dmIncumbentWrap">
          <div class="revliReviewList__age">投稿日:<span><?php echo $val['create_date'] ?></span></div>
          <div class="revliReviewList__dm">総評:<span><?php echo $val['general_estimation'] ?></span>
          <!-- 選んだレビューの個別詳細画面へ移動する。 -->
          <h1 class="revliReviewList__userProfLink"  onclick="location.href='reviewDetail.php?rev_id=<?php echo $val['id'] ?>'">このレビューの詳細を見る</h1></div>
        </div>
        <div class="revliReviewList__userNameAgeFavoliteWrap">
          <div class="revliReviewList__userNameAgeWrap">:<span>ユーザー名</span>さん<span>〇〇</span>歳</div>
          <div class="revliReviewList__favorite">☆</div>
        </div>
      </div>
    </div>
    <?php
      endforeach;
      ?>

      <!-- ここまで -->
      <div class="revliReviewList__pageTransition">
        <div class="revliReviewList__pageTransition-contentWrap">
          <span class="revliReviewList__pageTransition-leftArrow">◁</span>
            <div class="revliReviewList__pageTransition-guideNumber">12345</div>
          <span class="revliReviewList__pageTransition-rightArrow">▷</span>
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
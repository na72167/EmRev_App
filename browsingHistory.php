<!--アカウント作成関係処理-->
<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\companyApply\companyApply;
  use classes\profEdit\profEdit;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('閲覧履歴ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  // このあと$_SESSION['user_id']を参照してuserｓテーブルに関した情報のみを管理するuserクラスを作成。
  // 中のrollプロパティにアクセス。その権限情報とuserクラスを元に一般・社員・管理者・退会済み用のSQLを発行・検索を行う。(退会済みは別)。
  // getUserPropクラスを切り分ける。

  //ログインデータ($_SESSION['user_id']の数字)に一致するUsers情報を取得する。
  $userProp = userProp::getUserProp($_SESSION['user_id']);

  //取得した情報をオブジェクト管理する。
  $userDate = new userProp($userProp['id'],$userProp['email'],$userProp['password'],$userProp['roll'],$userProp['report_flg'],$userProp['delete_flg'],$userProp['create_date'],$userProp['update_date']);

  //フォーム送信前にもprofEdit関係のメソッドを扱いたいので先にインスタンス生成する。
  $profEdit = new profEdit('','','','','','','','','','','','');

  //第二引数にtrueを指定した場合,string型で出力される様になる。
  debugFunction::debug('取得したユーザー情報：'.print_r($userDate,true));

  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('権限確認処理');
  debugFunction::debug('「「「「「「「「「「「「「');

  // ================ログインユーザーの権限チェック================
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
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],$contributorUserProp['user_id'],$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],
      $contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'','');
      debugFunction::debug('取得した投稿ユーザー情報：'.print_r($contributorUserDate,true));

    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }

  // ========閲覧レコードとログインユーザーの個別IDを元にレビュー情報と会社情報を取得する処理(初期画面用)========
  $historyRecode = companyReviewContributorProp::browsingHistoryLinkcompanyReviewContributorProp($userDate->getId());
  debugFunction::debug('取得したログインユーザーの閲覧履歴情報：'.print_r($historyRecode,true));

  // ====================検索会社情報取得処理====================

  // post送信されていてなおかつ投稿者ユーザーだった場合。
  if(!empty($_POST['search'] === '検索する')){

    $companySearchPost = new companyApply($_POST['company_name'],$_POST['representative'],$_POST['location'],$_POST['industry']
    ,$_POST['year_of_establishment'],$_POST['listed_year'],$_POST['number_of_employees'],
    $_POST['average_annual_income'],$_POST['average_age'],$_POST['number_of_reviews'],'','','','','','','','','','');

    debugFunction::debug('POSTされた内容：'.print_r($companySearchPost,true));

    //検索情報を取得後、会社情報を検索する。
    //ここのkey部分は実際に実行するSQL文にも関係する。

    $companySearchResult = $companySearchPost->companySearchBrowsingHistory(
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
    ,$userDate->getId());

    // 検索結果の内容表示$companySearchResult
    debugFunction::debug('検索した会社情報：'.print_r($companySearchResult,true));

    // $companySearchResult['compDate']が
    // 存在するかどうかを判定する。
    if(isset($companySearchResult['browsingHistory'])){
      // 存在した場合
      debugFunction::debug('判定処理後の検索した会社情報：'.print_r($companySearchResult,true));

      // 値が保持されている場合、上の処理companyPropListDefault()で取得したレコードを初期化。
      $historyRecode = null;

    // その後historyRecode内のインスタンス情報へ書き換える。
      $historyRecode = $companySearchResult;
      debugFunction::debug('新しい会社情報：'.print_r($companyData,true));

    //下のサイトの関数を使ったほうがキレイにできそうなのでそのうち試す。
    //https://www.php.net/manual/ja/function.get-object-vars.php
    //https://www.php.net/manual/ja/function.property-exists.php)
    }elseif(!isset($companySearchResult['browsingHistory'])){
      //空だった場合
      //フラッシュメッセージ内に「検索結果がありませんでした」
      //と表示させる。
    }
  }

?>

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

  <!-- ここの要素はBEMの規則違反になっている -->
  <section class="middleElement" style="min-height: 1800px;">

    <section class="browsingHistorySearch">
    <h1 class="browsingHistorySearch__title">Company Search</h1>
    <form action="" method="post" class="browsingHistorySearch__form">

      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">会社名</h1>
        <input class="browsingHistorySearch__inputStyle" name="company_name" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">業界</h1>
        <input class="browsingHistorySearch__inputStyle" name="industry" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">設立年度</h1>
        <input class="browsingHistorySearch__inputStyle" name="year_of_establishment" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">所在地</h1>
        <input class="browsingHistorySearch__inputStyle" name="location" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">従業員数</h1>
        <input class="browsingHistorySearch__inputStyle" name="number_of_employees" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">代表者名</h1>
        <input class="browsingHistorySearch__inputStyle" name="representative" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">上場年</h1>
        <input class="browsingHistorySearch__inputStyle" name="listed_year" placeholder="入力してください">
      </div>
      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">口コミ数</h1>
        <input class="browsingHistorySearch__inputStyle" name="number_of_reviews" placeholder="入力してください">
      </div>

      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">平均年収</h1>
        <div class="browsingHistorySearch__betweenStyleWrap">
          <input class="browsingHistorySearch__betweenStyle" name="average_annual_income" placeholder="入力してください">
          <div class="browsingHistorySearch__betweenStyleHoge">~</div>
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">平均年齢</h1>
        <div class="browsingHistorySearch__betweenStyleWrap">
          <input class="browsingHistorySearch__betweenStyle" name="average_age" placeholder="入力してください">
          <div class="browsingHistorySearch__betweenStyleHoge">~</div>
          <input class="browsingHistorySearch__betweenStyle" placeholder="入力してください">
        </div>
      </div>


      <div class="browsingHistorySearch__inputContentStyle">
        <h1 class="browsingHistorySearch__inputName">並び替え順序</h1>
        <input class="browsingHistorySearch__inputStyle" placeholder="入力してください">
      </div>

      <input type="submit" class="browsingHistorySearch__bottomStyle" name="search" value="検索する">

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
      <h3>検索結果:<span><?php echo $historyRecode['total'] ?></span>件</h3>
    </div>

    <?php
      // ここで会社情報を取得 asでエイリアス設定
      // 上の処理で取得した会社情報を$key => $valの形で管理
      foreach($historyRecode['browsingHistory'] as $key => $val):
      ?>
    <!-- コンテンツ -->
    <div class="browsingHistory__mainContent">
      <div class="browsingHistory__imgComInfoWrap">
        <div class="browsingHistory__imgStyle">
          <img class="browsingHistory__img">
        </div>
        <div class="browsingHistory__companyWrap">
          <div class="browsingHistory__industryClassification">業界分類:<span><?php echo $val['industry'] ?></span></div>
          <div class="browsingHistory__companyName">会社名:<span><?php echo $val['company_name'] ?></span></div>
          <div class="browsingHistory__location">所在地:<span><?php echo $val['location'] ?></span></div>
        </div>
        <div class="browsingHistory__reviewLink">>この会社の他のユーザーレビュー(<span><?php echo $val['number_of_reviews'] ?></span>)件</div>
      </div>
      <div class="browsingHistory__userDetail">
        <div class="browsingHistory__name"><?php echo $val['general_estimation_title'] ?></div>

        <div class="browsingHistory__dmIncumbentWrap">
          <div class="browsingHistory__age">投稿日:<span><?php echo $val['create_date'] ?></span></div>
          <div class="browsingHistory__dm">総評:<span><?php echo $val['general_estimation'] ?></span>
          <h1 class="browsingHistory__userProfLink" onclick="location.href='reviewDetail.php?rev_id=<?php echo $val['review_id'] ?>'">このレビューの詳細を見る</h1></div>
        </div>
        <div class="browsingHistory__userNameAgeFavoliteWrap">
          <div class="browsingHistory__userNameAgeWrap">:<span><?php echo $val['username'] ?></span>さん<span><?php echo $val['age'] ?></span>歳</div>
        </div>
      </div>
    </div>
    <?php
      endforeach;
      ?>

    <!-- ここまで -->
    <div class="browsingHistory__pageTransition">
      <div class="browsingHistory__pageTransition-contentWrap">
        <span class="browsingHistory__pageTransition-leftArrow">◁</span>
          <div class="browsingHistory__pageTransition-guideNumber">12345</div>
        <span class="browsingHistory__pageTransition-rightArrow">▷</span>
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
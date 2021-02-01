<?php
  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\reviewRegister\reviewRegisterJr;
  use classes\userProp\contributorUserProp;
  use classes\companyApply\companyApply;
  use classes\etc\etc;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー会社選択画面');
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
      $_SESSION['msg_success'] = 'この機能を使うには投稿者登録する必要があります。';
      debugFunction::debug('取得した一般ユーザー情報：'.print_r($generalUserDate,true));
      debugFunction::debug('マイページへ遷移します。');
      header("Location:mypage.php"); //マイページへ
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

  // ====================レビュー対象になる会社の個別ID送信====================
  if(!empty($_POST['company_id']) && $userDate->getRoll() === 50){
    // レビュー対象になる会社の個別IDをセッションに保持する。
    $_SESSION['company_id'] = $_POST['company_id'];
    header("Location:reviewRegister-jr.php");
  }

  // ====================初期ページ表示処理====================
  // DBから会社データを一括取得
  $companyData = companyApply::companyPropListDefault();
  debugFunction::debug('取得した登録会社一覧情報：'.print_r($companyData,true));
  // それを多重連想配列形式で保持
  //[会社ID][key(カラム)]=> value(レコード) の形で管理
  //それをページの指定箇所に配置していく。


  // ====================検索会社情報取得処理====================

  // post送信されていてなおかつ投稿者ユーザーだった場合。
  if(!empty($_POST['search'] === '検索する' && $userDate->getRoll() === 50)){

    $companySearchPost = new companyApply($_POST['company_name'],$_POST['representative'],$_POST['location'],$_POST['industry']
    ,$_POST['year_of_establishment'],$_POST['listed_year'],$_POST['number_of_employees'],
    $_POST['average_annual_income'],$_POST['average_age'],$_POST['number_of_reviews'],'','','','','','','','','','');

    debugFunction::debug('POSTされた内容：'.print_r($companySearchPost,true));

    //検索情報を取得後、会社情報を検索する。
    //ここのkey部分は実際に実行するSQL文にも関係する。

    $companySearchResult = $companySearchPost->companySearch(
      array_filter(array(
        //会社名
        'company_name' => $companySearchPost->getCompany_name(),
        //代表者
        'representative' => $companySearchPost->getRepresentative(),
        //所在地
        'location' => $companySearchPost->getLocation(),
        //業界分類
        'industry' => $companySearchPost->getIndustry(),
        //設立年度
        'year_of_establishment' => $companySearchPost->getYearOfEstablishment(),
        //上場年
        'listed_year' => $companySearchPost->getListed_year(),
        //従業員数
        'number_of_employees' => $companySearchPost->getNumber_of_employees(),
        //平均年収
        'average_annual_income' => $companySearchPost->getAverage_annual_income(),
        //平均年齢
        'average_age' => $companySearchPost->getAverage_age(),
        //レビュー数
        'number_of_reviews' => $companySearchPost->getNumber_of_reviews()
      ))
    );

    // 検索結果の内容表示$companySearchResult
    debugFunction::debug('検索した会社情報：'.print_r($companySearchResult,true));

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
      //と表示させる。
    }
  }

?>

<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー会社選択画面';
  $Intro__Text_Title ='ReviewCompanySelection';
  $Intro__Text_Sub ='レビュー会社選択画面';
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

  <!-- GETとPOSTの使い分けがよく分かってなかったので
  https://php-junkie.net/beginner/reserved_variables/get_post/
  これを参考に書き換えるかも -->

    <section class="rigisRigisterReviewListSearch">
        <h1 class="rigisRigisterReviewListSearch__title">Company Search</h1>
        <form class="rigisRigisterReviewListSearch__form" method="POST">

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">会社名</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="company_name" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">代表者名</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="representative" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">所在地</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="location" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">業界</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="industry" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">設立年度</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="year_of_establishment" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">上場年</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="listed_year" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">従業員数</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="number_of_employees" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">口コミ数</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" name="number_of_reviews" placeholder="入力してください">
          </div>

          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">平均年収</h1>
            <div class="rigisRigisterReviewListSearch__betweenStyleWrap">
              <input class="rigisRigisterReviewListSearch__betweenStyle" name="average_annual_income" placeholder="入力してください">
              <div class="rigisRigisterReviewListSearch__betweenStyleHoge">~</div>
              <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
            </div>
          </div>


          <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">平均年齢</h1>
            <div class="rigisRigisterReviewListSearch__betweenStyleWrap">
              <input class="rigisRigisterReviewListSearch__betweenStyle" name="average_age" placeholder="入力してください">
              <div class="rigisRigisterReviewListSearch__betweenStyleHoge">~</div>
              <input class="rigisRigisterReviewListSearch__betweenStyle" placeholder="入力してください">
            </div>
          </div>


          <!-- <div class="rigisRigisterReviewListSearch__inputContentStyle">
            <h1 class="rigisRigisterReviewListSearch__inputName">並び替え順序</h1>
            <input class="rigisRigisterReviewListSearch__inputStyle" placeholder="入力してください">
          </div> -->


          <input type="submit" class="rigisRigisterReviewListSearch__bottomStyle" name="search" value="検索する">
        </form>
      </section>

      <section class="rigisRigisterReviewListSorting">
        <h1 class="rigisRigisterReviewListSorting__title">Company Sorting</h1>
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

          <!-- $companyData内のtotalキー内のバリューを出力 -->
          <h3>検索結果:<span><?php echo etc::sanitize($companyData['total']);?></span>件</h3>
        </div>

        <!-- コンテンツ -->
        <!-- getについての参考記事
        https://qiita.com/Sekky0905/items/dff3d0da059d6f5bfabf -->

          <?php
            // ここで会社情報を取得 asでエイリアス設定
            // 上の処理で取得した会社情報を$key => $valの形で管理
            foreach($companyData['compDate'] as $key => $val):
          ?>
            <div class="rigisRigisterReviewList__mainContent">

              <div class="rigisRigisterReviewList__imgComInfoWrap">
                <!-- 個別の写真を表示 -->
                <div class="rigisRigisterReviewList__imgStyle">
                  <!-- alt属性はアプリ使用者が画像を表示できない環境やブラウザを使っている際に
                  代わりの処理を走らせる物 -->
                  <!-- 今回の場合だと会社名を表示させる。 -->
                  <img class="rigisRigisterReviewList__img"
                  src="<?php echo etc::showImg(etc::sanitize($val['pic1'])); ?>"
                  alt="<?php echo etc::sanitize($val['name']); ?>">
                </div>

                <div class="rigisRigisterReviewList__companyWrap">
                  <div class="rigisRigisterReviewList__industryClassification">業界分類:<span><?php echo etc::sanitize($val['industry']); ?></span></div>
                  <div class="rigisRigisterReviewList__companyName">会社名:<span><?php echo etc::sanitize($val['company_name']); ?></span></div>
                  <div class="rigisRigisterReviewList__location">所在地:<span><?php echo etc::sanitize($val['location']); ?></span></div>
                </div>
                <div class="rigisRigisterReviewList__reviewLink">>この会社のレビュー数(<span><?php echo etc::sanitize($val['number_of_reviews']); ?></span>)件</div>
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

              <!-- 参考コードのappendGetParam()について調べる。 -->
              <!-- ここから選択した会社のID情報をreviewRegister-jrへ送信する。 -->
              <form method="post">
                <input type="hidden" name="company_id" value=<?php echo $val['id'] ?>>
                <input class="#" type="submit" value="この会社のレビューをする">
              </form>

            </div>
          <?php
            endforeach;
          ?>


        <!-- ここまで -->
        <div class="rigisRigisterReviewList__pageTransition">
          <div class="rigisRigisterReviewList__pageTransition-contentWrap">
            <span class="rigisRigisterReviewList__pageTransition-leftArrow">◁</span>
              <div class="rigisRigisterReviewList__pageTransition-guideNumber">12345</div>
            <span class="rigisRigisterReviewList__pageTransition-rightArrow">▷</span>
          </div>
        </div>
      </div>
  </section>

  <!-- フッター -->
  <footer class="footer">
    <div class="footer__element-wrap">
      <div class="footer__element-copyright">
        <h1 class="footer__element-copyrightTitle">EmRev</h1>
        Copyright © Y.H<br>All Rights Reserved
      </div>
      <div class="footer__element-link">
        sample<br>
        sample<br>
        sample
      </div>
      <div class="footer__element-sns">
        sample<br>
        sample<br>
        sample
      </div>
    </div>
  </footer>

</body>
</html>
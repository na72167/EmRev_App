<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\reviewRegister\reviewRegisterJw;
  use classes\userProp\userProp;
  use classes\userProp\contributorUserProp;
  use classes\debug\debugFunction;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー投稿ページ(入社後のギャップや働きがい)');
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

  // post送信されていてなおかつ投稿者登録ユーザーだった場合。
  if(!empty($_POST['next'] === '次の項目へ' && $userDate->getRoll() === 50)){

    debugFunction::debug('POST送信があります。');
    debugFunction::debug('POST情報：'.print_r($_POST,true));

    $formTransmission = new reviewRegisterJw($_POST['image_gap'],$_POST['rewarding_work'],$_POST['strengths_and_weaknesses'],
    $_POST['annual_income_salary'],$_POST['business_outlook'],'','','','','','');

    $formTransmission->setImage_gap($formTransmission->getImage_gap());
    $formTransmission->setRewarding_work($formTransmission->getRewarding_work());
    $formTransmission->setStrengths_and_weaknesses($formTransmission->getStrengths_and_weaknesses());
    $formTransmission->setAnnual_income_salary($formTransmission->getAnnual_income_salary());
    $formTransmission->setBusiness_outlook($formTransmission->getBusiness_outlook());

    //キー定義されていないものを指定してvar_dump()するとstring(1) "�"が出力される。
    debugFunction::debug($formTransmission);

    //問題があった場合,バリテーション関数からエラーメッセージが返ってきてるはずなので
    //getErr_msメソッドは返り値が配列になっている。
    //emptyそのままだとkeyのみ割り振られている配列もfalseが返ってくるので
    //keyのみ・value無しの要素は削除する必要があるので
    //array_filterを挟んでいる。
    //https://qiita.com/wonda/items/b4a425edd73880a13e62
    if(empty(array_filter($formTransmission->getErr_msAll()))){

      debugFunction::debug('バリデーションOKです。');

      //セッション内に保持されている情報とフォームから送信されている情報を比較。違う場合は書き換える。
      if($_SESSION['image_gap'] !== $formTransmission->getImage_gap()){
        $_SESSION['image_gap'] = $formTransmission->getImage_gap();
      }

      if($_SESSION['rewarding_work'] !== $formTransmission->getRewarding_work()){
        $_SESSION['rewarding_work'] = $formTransmission->getRewarding_work();
      }

      if($_SESSION['strengths_and_weaknesses'] !== $formTransmission->getStrengths_and_weaknesses()){
        $_SESSION['strengths_and_weaknesses'] = $formTransmission->getStrengths_and_weaknesses();
      }

      if($_SESSION['annual_income_salary'] !== $formTransmission->getAnnual_income_salary()){
        $_SESSION['annual_income_salary'] = $formTransmission->getAnnual_income_salary();
      }

      if($_SESSION['business_outlook'] !== $formTransmission->getBusiness_outlook()){
        $_SESSION['business_outlook'] = $formTransmission->getBusiness_outlook();
      }

      //セッション内情報を出力させる。
      debugFunction::debug($_SESSION);

      //ログイン有効期限（デフォルトを１時間とする）
      $sesLimit = 60*60;
      // 最終ログイン日時を現在日時に
      $_SESSION['login_date'] = time();
      $_SESSION['login_limit'] = $sesLimit;

      debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));
      header("Location:reviewRegister-gc.php"); //総評

    }elseif(!empty(array_filter($formTransmission->getErr_msAll()))){
      debugFunction::debug('バリデーションNGです。');
      debugFunction::debug($formTransmission->getErr_msAll());
    }

  }elseif(!empty($_POST['back'] === '前の項目へ') && $userDate->getRoll() === 50){
    // 配列の初期化
    $_SESSION['image_gap'] = "";
    $_SESSION['rewarding_work'] = "";
    $_SESSION['strengths_and_weaknesses'] = "";
    $_SESSION['annual_income_salary'] = "";
    $_SESSION['business_outlook'] = "";
    //空の値を削除する。
    $_SESSION = array_filter($_SESSION);
  //フラッシュメッセージ挟む。
  //ここのフォームで挿入したセッション情報を削除する。
  debugFunction::debug('「社内制度や企業文化について」のページへ戻ります。');
  header("Location:reviewRegister-cc.php");
  }


?>

<!-- jwは「joinedGap・workの略」 -->
<?php
  // タイトルの読み込み
  $Page_Title = "レビュー登録画面";
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='入社後のギャップや働きがい';
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


  <section class="revRegistJw-content">

    <div class="revRegistJw-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
    <div class="revRegistJw-content__form-element">
      <div class="revRegistJw-content__form-wrap">
          <h4 class="revRegistJw-content__title">Post Company Review</h4>
          <h1 class="revRegistJw-content__sub">入社後のギャップや働きがい</h1>

          <form method="post" class="revRegistJw-content__wrap">
            <div class="revRegistJw-content__form-title">入社前とのギャップ</div>
            <textarea class="revRegistJw-content__form-areaForm" name="image_gap" placeholder="入社前とのギャップ"><?php if(!empty($_SESSION['image_gap'])) echo $_SESSION['image_gap']; ?></textarea>

            <div class="revRegistJw-content__form-title">働きがい</div>
            <textarea class="revRegistJw-content__form-areaForm" name="rewarding_work" placeholder="働きがいについて"><?php if(!empty($_SESSION['rewarding_work'])) echo $_SESSION['rewarding_work']; ?></textarea>

            <div class="revRegistJw-content__form-title">強み・弱み</div>
            <textarea class="revRegistJw-content__form-areaForm" name="strengths_and_weaknesses" placeholder="強み・弱みについて"><?php if(!empty($_SESSION['strengths_and_weaknesses'])) echo $_SESSION['strengths_and_weaknesses']; ?></textarea>

            <div class="revRegistJw-content__form-title">年収・給与</div>
            <textarea class="revRegistJw-content__form-areaForm" name="annual_income_salary" placeholder="年収・給与について"><?php if(!empty($_SESSION['annual_income_salary'])) echo $_SESSION['annual_income_salary']; ?></textarea>

            <div class="revRegistJw-content__form-title">事業展望</div>
            <textarea class="revRegistJw-content__form-areaForm" name="business_outlook" placeholder="事業展望について"><?php if(!empty($_SESSION['business_outlook'])) echo $_SESSION['business_outlook']; ?></textarea>

            <div class="revRegistCc-content__bottom-wrap">
              <input type="submit" class="revRegistJw-content__bottom-return revRegistJw-content__bottom-link" name="back" value="前の項目へ">
              <input type="submit" class="revRegistJw-content__bottom-next revRegistJw-content__bottom-link" name="next" value="次の項目へ">
            </div>
          </form>

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
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
  use classes\etc\etc;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー投稿ページ(入社経路や在籍状況)');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debug('「「「「「「「「「');
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
  if(!empty($_POST['next'] === '次の項目へ') && $userDate->getRoll() === 50){

    debugFunction::debug('POST送信があります。');
    debugFunction::debug('POST情報：'.print_r($_POST,true));

    //フォーム送信前にもprofEdit関係のメソッドを扱いたいので先にインスタンス生成する。
    $formTransmission = new reviewRegisterJr($_POST['joining_route'],$_POST['enrollment_status'],$_POST['occupation'],$_POST['position'],$_POST['enrollment_period']
    ,$_POST['employment_status'],$_POST['welfare_office_environment'],$_POST['working_hours'],'','','','','','','','');

    $formTransmission->setJoining_route($formTransmission->getJoining_route());
    $formTransmission->setOccupation($formTransmission->getOccupation());
    $formTransmission->setPosition($formTransmission->getPosition());
    $formTransmission->setEnrollment_period($formTransmission->getEnrollment_period());
    $formTransmission->setEnrollment_status($formTransmission->getEnrollment_status());
    $formTransmission->setEmployment_status($formTransmission->getEmployment_status());
    $formTransmission->setWelfare_office_environment($formTransmission->getWelfare_office_environment());
    $formTransmission->setWorking_hours($formTransmission->getWorking_hours());

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
      if($_SESSION['joining_route'] !== $formTransmission->getJoining_route()){
        $_SESSION['joining_route'] = $formTransmission->getJoining_route();
      }

      if($_SESSION['enrollment_status'] !== $formTransmission->getEnrollment_status()){
        $_SESSION['enrollment_status'] = $formTransmission->getEnrollment_status();
      }

      if($_SESSION['occupation'] !== $formTransmission->getOccupation()){
        $_SESSION['occupation'] = $formTransmission->getOccupation();
      }

      if($_SESSION['position'] !== $formTransmission->getPosition()){
        $_SESSION['position'] = $formTransmission->getPosition();
      }

      if($_SESSION['enrollment_period'] !== $formTransmission->getEnrollment_period()){
        $_SESSION['enrollment_period'] = $formTransmission->getEnrollment_period();
      }

      if($_SESSION['employment_status'] !== $formTransmission->getEmployment_status()){
        $_SESSION['employment_status'] = $formTransmission->getEmployment_status();
      }

      if($_SESSION['welfare_office_environment'] !== $formTransmission->getWelfare_office_environment()){
        $_SESSION['welfare_office_environment'] = $formTransmission->getWelfare_office_environment();
      }

      if($_SESSION['working_hours'] !== $formTransmission->getWorking_hours()){
        $_SESSION['working_hours'] = $formTransmission->getWorking_hours();
      }

      //ログイン有効期限（デフォルトを１時間とする）
      $sesLimit = 60*60;
      // 最終ログイン日時を現在日時に
      $_SESSION['login_date'] = time();
      $_SESSION['login_limit'] = $sesLimit;

      debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));
      header("Location:reviewRegister-cc.php"); //社内制度や企業文化について

    }elseif(!empty(array_filter($formTransmission->getErr_msAll()))){
      debugFunction::debug('バリデーションNGです。');
      debugFunction::debug($formTransmission->getErr_msAll());
    }

  }elseif(!empty($_POST['cancel'] === '会社選択画面に戻る') && $userDate->getRoll() === 50){
    // レビュー内容の初期化
    $_SESSION['joining_route'] = "";
    $_SESSION['occupation'] = "";
    $_SESSION['position'] = "";
    $_SESSION['enrollment_period'] = "";
    $_SESSION['enrollment_status'] = "";
    $_SESSION['employment_status'] = "";
    $_SESSION['welfare_office_environment'] = "";
    $_SESSION['working_hours'] = "";
    $_SESSION['in_company_system'] = "";
    $_SESSION['corporate_culture'] = "";
    $_SESSION['holiday'] = "";
    $_SESSION['organizational_structure'] = "";
    $_SESSION['ease_of_work_for_women'] = "";
    $_SESSION['image_gap'] = "";
    $_SESSION['rewarding_work'] = "";
    $_SESSION['strengths_and_weaknesses'] = "";
    $_SESSION['annual_income_salary'] = "";
    $_SESSION['business_outlook'] = "";
    $_SESSION['general_estimation_title'] = "";
    $_SESSION['general_estimation'] = "";
    $_SESSION['company_id'] = "";
    //空の値を削除する。
    $_SESSION = array_filter($_SESSION);
    //フラッシュメッセージ挟む。
    debugFunction::debug('変更を取り消しました。レビュー会社選択へ遷移します。');
    header("Location:reviewRegister-cList.php");
  }
?>

<!-- jrはjointed routeの略 -->
<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='入社経路や在籍状況について';
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

  <section class="revRegistJr-content">

    <div class="revRegistJr-content__wrap">
      <!-- 登録の進行状況などを表示するファイルを読み込む. -->
      <?php
        require('./revProgress.php');
        ?>

      <div class="revRegistJr-content__form-element">
        <div class="revRegistJr-content__form-wrap">
          <h4 class="revRegistJr-content__title">Post Company Review</h4>
          <h1 class="revRegistJr-content__sub">入社経路や在籍状況について</h1>
          <form method="post" class="revRegistJr-content__form">
            <div class="revRegistJr-content__input-wrap">
              <!-- あとでここにgetでセッション入れる。 -->
              <input class="revRegistJr-content__input" name="joining_route" placeholder="入社経路" value="<?php if(!empty($_SESSION['joining_route'])) echo $_SESSION['joining_route']; ?>">
              <input class="revRegistJr-content__input" name="enrollment_status" placeholder="在籍状況" value="<?php if(!empty($_SESSION['enrollment_status'])) echo $_SESSION['enrollment_status']; ?>">
              <input class="revRegistJr-content__input" name="occupation" placeholder="在籍時の職種" value="<?php if(!empty($_SESSION['occupation'])) echo $_SESSION['occupation']; ?>">
              <input class="revRegistJr-content__input" name="position" placeholder="在籍時の役職" value="<?php if(!empty($_SESSION['position'])) echo $_SESSION['position']; ?>">
              <input class="revRegistJr-content__input" name="enrollment_period" placeholder="在籍期間" value="<?php if(!empty($_SESSION['enrollment_period'])) echo $_SESSION['enrollment_period']; ?>">
              <input class="revRegistJr-content__input" name="employment_status" placeholder="在籍形態" value="<?php if(!empty($_SESSION['employment_status'])) echo $_SESSION['employment_status']; ?>">
              <input class="revRegistJr-content__input" name="welfare_office_environment" placeholder="福利厚生" value="<?php if(!empty($_SESSION['welfare_office_environment'])) echo $_SESSION['welfare_office_environment']; ?>">
              <input class="revRegistJr-content__input" name="working_hours" placeholder="勤務時間" value="<?php if(!empty($_SESSION['working_hours'])) echo $_SESSION['working_hours']; ?>">
            </div>

            <div class="revRegistJr-content__bottom-wrap">
              <input type="submit" class="revRegistJr-content__bottom-cancel" name="cancel" value="会社選択画面に戻る">
              <input type="submit" class="revRegistJr-content__bottom-next revRegistJr-content__bottom-link" name="next" value="次の項目へ">
            </div>

          </form>
        </div>
    </div>

  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
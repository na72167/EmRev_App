<?php
  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\reviewRegister\reviewRegisterCc;
  use classes\userProp\userProp;
  use classes\userProp\contributorUserProp;
  use classes\debug\debugFunction;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー投稿ページ(社内制度や企業文化について)');
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

    $formTransmission = new reviewRegisterCc($_POST['in_company_system'],$_POST['corporate_culture'],$_POST['holiday'],$_POST['organizational_structure']
    ,$_POST['ease_of_work_for_women'],'','','','','','');

    $formTransmission->setIn_company_system($formTransmission->getIn_company_system());
    $formTransmission->setCorporate_culture($formTransmission->getCorporate_culture());
    $formTransmission->setHoliday($formTransmission->getHoliday());
    $formTransmission->setOrganizational_structure($formTransmission->getOrganizational_structure());
    $formTransmission->setEase_of_work_for_women($formTransmission->getEase_of_work_for_women());

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
      if($_SESSION['in_company_system'] !== $formTransmission->getIn_company_system()){
        $_SESSION['in_company_system'] = $formTransmission->getIn_company_system();
      }

      if($_SESSION['corporate_culture'] !== $formTransmission->getCorporate_culture()){
        $_SESSION['corporate_culture'] = $formTransmission->getCorporate_culture();
      }

      if($_SESSION['occupation'] !== $formTransmission->getCorporate_culture()){
        $_SESSION['occupation'] = $formTransmission->getCorporate_culture();
      }

      if($_SESSION['holiday'] !== $formTransmission->getHoliday()){
        $_SESSION['holiday'] = $formTransmission->getHoliday();
      }

      if($_SESSION['organizational_structure'] !== $formTransmission->getOrganizational_structure()){
        $_SESSION['organizational_structure'] = $formTransmission->getOrganizational_structure();
      }

      if($_SESSION['ease_of_work_for_women'] !== $formTransmission->getEase_of_work_for_women()){
        $_SESSION['ease_of_work_for_women'] = $formTransmission->getEase_of_work_for_women();
      }

      //セッション内情報を出力させる。
      debugFunction::debug($_SESSION);

      //ログイン有効期限（デフォルトを１時間とする）
      $sesLimit = 60*60;
      // 最終ログイン日時を現在日時に
      $_SESSION['login_date'] = time();
      $_SESSION['login_limit'] = $sesLimit;

      debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));
      header("Location:reviewRegister-Jw.php"); //入社後のギャップや働きがいについて

    }elseif(!empty(array_filter($formTransmission->getErr_msAll()))){
      debugFunction::debug('バリデーションNGです。');
      debugFunction::debug($formTransmission->getErr_msAll());
    }

  }elseif(!empty($_POST['back'] === '前の項目へ') && $userDate->getRoll() === 50){
    // 配列の初期化
    $_SESSION['in_company_system'] = "";
    $_SESSION['corporate_culture'] = "";
    $_SESSION['holiday'] = "";
    $_SESSION['organizational_structure'] = "";
    $_SESSION['ease_of_work_for_women'] = "";
    //空の値を削除する。
    $_SESSION = array_filter($_SESSION);
  //フラッシュメッセージ挟む。
  //ここのフォームで挿入したセッション情報を削除する。
  debugFunction::debug('「社内制度や企業文化について」のページへ戻ります。');
  header("Location:reviewRegister-jr.php");
  }
?>

<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='社内制度や企業文化について';
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


  <section class="revRegistCc-content">

    <div class="revRegistCc-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
      <div class="revRegistCc-content__form-element">
        <div class="revRegistCc-content__form-wrap">
          <h4 class="revRegistCc-content__title">Post Company Review</h4>
          <h1 class="revRegistCc-content__sub">社内制度や企業文化について</h1>

            <form method="post" class="revRegistJr-content__form">
              <div class="revRegistCc-content__form-title">社内制度</div>
              <textarea class="revRegistCc-content__form-areaForm" name="in_company_system" placeholder="社内制度について"><?php if(!empty($_SESSION['in_company_system'])) echo $_SESSION['in_company_system']; ?></textarea>

              <div class="revRegistCc-content__form-title">企業文化</div>
              <textarea class="revRegistCc-content__form-areaForm" name="corporate_culture" placeholder="企業文化について"><?php if(!empty($_SESSION['corporate_culture'])) echo $_SESSION['corporate_culture']; ?></textarea>

              <div class="revRegistCc-content__form-title">休暇</div>
              <textarea class="revRegistCc-content__form-areaForm" name="holiday" placeholder="休暇について"><?php if(!empty($_SESSION['holiday'])) echo $_SESSION['holiday']; ?></textarea>

              <div class="revRegistCc-content__form-title">組織体制</div>
              <textarea class="revRegistCc-content__form-areaForm" name="organizational_structure" placeholder="組織体制について"><?php if(!empty($_SESSION['organizational_structure'])) echo $_SESSION['organizational_structure']; ?></textarea>

              <div class="revRegistCc-content__form-title">女性の働きやすさ</div>
              <textarea class="revRegistCc-content__form-areaForm" name="ease_of_work_for_women" placeholder="女性の働きやすさについて"><?php if(!empty($_SESSION['ease_of_work_for_women'])) echo $_SESSION['ease_of_work_for_women']; ?></textarea>

              <div class="revRegistCc-content__bottom-wrap">
                <input type="submit" class="revRegistCc-content__bottom-return revRegistCc-content__bottom-link" name="back" value="前の項目へ">
                <input type="submit" class="revRegistCc-content__bottom-next revRegistCc-content__bottom-link" name="next" value="次の項目へ">
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
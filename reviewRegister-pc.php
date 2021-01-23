<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\reviewRegister\reviewRegisterPc;
  use classes\userProp\userProp;
  use classes\userProp\contributorUserProp;
  use classes\debug\debugFunction;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('投稿内容の確認');
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
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],$contributorUserProp['contributor_id'],$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],$contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'');
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
  if(!empty($_POST['next'] === '投稿する') && $userDate->getRoll() === 50){

    debugFunction::debug('POST送信があります。');
    debugFunction::debug('POST情報：'.print_r($_POST,true));

    //フォーム送信前にもprofEdit関係のメソッドを扱いたいので先にインスタンス生成する。
    $formTransmission = new reviewRegisterPc($_POST['joining_route'],$_POST['enrollment_status'],$_POST['occupation'],$_POST['position'],$_POST['enrollment_period']
    ,$_POST['employment_status'],$_POST['welfare_office_environment'],$_POST['working_hours'],$_POST['in_company_system'],$_POST['corporate_culture'],$_POST['holiday'],$_POST['organizational_structure']
    ,$_POST['ease_of_work_for_women'],$_POST['image_gap'],$_POST['rewarding_work'],$_POST['strengths_and_weaknesses'],$_POST['annual_income_salary'],$_POST['business_outlook'],$_POST['general_estimation_title']
    ,$_POST['general_estimation'],'','','','','','','','','','','','','','','','','','','','','');

    $formTransmission->setJoining_route($formTransmission->getJoining_route());
    $formTransmission->setOccupation($formTransmission->getOccupation());
    $formTransmission->setPosition($formTransmission->getPosition());
    $formTransmission->setEnrollment_period($formTransmission->getEnrollment_period());
    $formTransmission->setEnrollment_status($formTransmission->getEmployment_status());
    $formTransmission->setEmployment_status($formTransmission->getEmployment_status());
    $formTransmission->setWelfare_office_environment($formTransmission->getWelfare_office_environment());
    $formTransmission->setWorking_hours($formTransmission->getWorking_hours());
    $formTransmission->setIn_company_system($formTransmission->getIn_company_system());
    $formTransmission->setCorporate_culture($formTransmission->getCorporate_culture());
    $formTransmission->setHoliday($formTransmission->getHoliday());
    $formTransmission->setOrganizational_structure($formTransmission->getOrganizational_structure());
    $formTransmission->setEase_of_work_for_women($formTransmission->getEase_of_work_for_women());
    $formTransmission->setImage_gap($formTransmission->getImage_gap());
    $formTransmission->setRewarding_work($formTransmission->getRewarding_work());
    $formTransmission->setStrengths_and_weaknesses($formTransmission->getStrengths_and_weaknesses());
    $formTransmission->setAnnual_income_salary($formTransmission->getAnnual_income_salary());
    $formTransmission->setBusiness_outlook($formTransmission->getBusiness_outlook());
    $formTransmission->setGeneral_estimation_title($formTransmission->getGeneral_estimation_title());
    $formTransmission->setGeneral_estimation($formTransmission->getGeneral_estimation());

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

      //例外処理
      try {

          debugFunction::debug('登録処理に入ります。');

          // DBへ接続
          $dbh = new dbConnectPDO();

          //短時間に比較的多めの情報をページ間でやりとりする方法のにちょうど良さそうなものを調べる。
          //今の様に毎回DBに保存するのは、あまり効率が良くなさそう。

          //上のやり方だと途中でブラウザバックなどを挟む事で不自然にDBへデータが残ってしまうので
          //改善案を考える。

          // SQL文作成
          //$signupProp->getDbh()->lastInsertId()で最後に追加したusersテーブル内レコードのidを取得。
          //最後に追加したレコードは直前のINSERT INTO users~なので必ず紐付いたgeneral_profsテーブルのレコードが生成できる。
          $sql = 'INSERT INTO employee_reviews (`employee_id`,`joining_route`,`occupation`,`position`,`enrollment_period`,`
          enrollment_status`,`employment_status`,`welfare_office_environment`,`working_hours`,
          `in_company_system`,`corporate_culture`,`holiday`,`organizational_structure`,`ease_of_work_for_women`,
          `image_gap`,`rewarding_work`,`strengths_and_weaknesses`,`annual_income_salary`,`business_outlook`,
          `general_estimation_title`,`general_estimation`)
          VALUES(:employee_id,:joining_route,:occupation,:position,:enrollment_period,
          :enrollment_status,:employment_status,welfare_office_environment,:working_hours,
          :in_company_system,:corporate_culture:,:holiday,:organizational_structure,:ease_of_work_for_women,
          :image_gap,:rewarding_work,:strengths_and_weaknesses,:annual_income_salary,:business_outlook,
          :general_estimation_title,:general_estimation)';

          $data = array(':employee_id' => $contributorUserDate->getContributor_id(),':joining_route' => $formTransmission->getJoining_route(),':occupation' => $formTransmission->getOccupation(),':position' => $formTransmission->getPosition(),':enrollment_period' => $formTransmission->getEnrollment_period(),
          ':enrollment_status' => $formTransmission->getEnrollment_status(),':employment_status' => $formTransmission->getEmployment_status(),':welfare_office_environment' => $formTransmission->getWelfare_office_environment(),':working_hours' => $formTransmission->getWorking_hours(),
          ':in_company_system' => $formTransmission->getIn_company_system(),':corporate_culture' => $formTransmission->Corporate_culture(),':holiday' => $formTransmission->getHoliday(),':organizational_structure' => $formTransmission->getOrganizational_structure(),
          ':ease_of_work_for_women' => $formTransmission->getEase_of_work_for_women(),':image_gap' => $formTransmission->getImage_gap(),':rewarding_work' => $formTransmission->getRewarding_work(),':strengths_and_weaknesses' => $formTransmission->getStrengths_and_weaknesses(),
          ':annual_income_salary' => $formTransmission->getAnnual_income_salary(),':business_outlook' => $formTransmission->getBusiness_outlook(),':general_estimation_title' => $formTransmission->getGeneral_estimation_title(),':general_estimation' => $formTransmission->getGeneral_estimation());

          debugFunction::debug('取得したdata：'.print_r($data,true));
          // クエリ実行
          $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

        // insert成功の場合
        if($stmt){
            //ログイン有効期限（デフォルトを１時間とする）
            $sesLimit = 60*60;
            // 最終ログイン日時を現在日時に
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $sesLimit;

            debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));
            header("Location:reviewRegister-Cc.php"); //社内制度や企業文化について
          }
        } catch (Exception $e) {
          error_log('エラー発生:' . $e->getMessage());
          $formTransmission->setCommonErr_ms('エラーが発生しました。しばらく経ってからやり直してください。');
          header("Location:index.php");
        }
    }elseif(!empty(array_filter($formTransmission->getErr_msAll()))){
      debugFunction::debug('バリデーションNGです。');
      debugFunction::debug($formTransmission->getErr_msAll());
    }

  }elseif(!empty($_POST['cancel'] === 'レビューを取り消す') && $userDate->getRoll() === 50){
  //フラッシュメッセージ挟む。
  debugFunction::debug('変更を取り消しました。マイページへ遷移します。');
  header("Location:mypage.php");
  }
?>

<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='投稿内容の確認';
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

<section class="revRegistPc-content">

<div class="revRegistPc-content__wrap">
  <?php
  require('./revProgress.php');
  ?>
<div class="revRegistPc-content__form-element">
  <div class="revRegistPc-content__form-wrap">
        <h4 class="revRegistPc-content__title">Post Company Review</h4>
        <h1 class="revRegistPc-content__sub">投稿内容の確認</h1>

        <form method="post" class="revRegistPc-content__wrap">

          <input class="revRegistPc-content__input" name="joining_route" placeholder="入社経路">
          <input class="revRegistPc-content__input" name="enrollment_status" placeholder="在籍状況">
          <input class="revRegistPc-content__input" name="occupation" placeholder="在籍時の職種">
          <input class="revRegistPc-content__input" name="position" placeholder="在籍時の役職">
          <input class="revRegistPc-content__input" name="enrollment_period" placeholder="在籍期間">
          <input class="revRegistPc-content__input" name="employment_status" placeholder="在籍形態">
          <input class="revRegistPc-content__input" name="welfare_office_environment" placeholder="福利厚生">
          <input class="revRegistPc-content__input" name="working_hours" placeholder="勤務時間">

          <div class="revRegistPc-content__form-title">社内制度</div>
          <textarea class="revRegistPc-content__form-areaForm" name="in_company_system" placeholder="社内制度について"></textarea>

          <div class="revRegistPc-content__form-title">企業文化</div>
          <textarea class="revRegistPc-content__form-areaForm" name="corporate_culture" placeholder="企業文化について"></textarea>

          <div class="revRegistPc-content__form-title">休暇</div>
          <textarea class="revRegistPc-content__form-areaForm" name="holiday" placeholder="休暇について"></textarea>

          <div class="revRegistPc-content__form-title">組織体制</div>
          <textarea class="revRegistPc-content__form-areaForm" name="organizational_structure" placeholder="組織体制について"></textarea>

          <div class="revRegistPc-content__form-title">女性の働きやすさ</div>
          <textarea class="revRegistPc-content__form-areaForm" name="ease_of_work_for_women" placeholder="女性の働きやすさについて"></textarea>

          <div class="revRegistPc-content__form-title">入社前とのギャップ</div>
          <textarea class="revRegistPc-content__form-areaForm" name="image_gap" placeholder="入社前とのギャップ"></textarea>

          <div class="revRegistPc-content__form-title">働きがい</div>
          <textarea class="revRegistPc-content__form-areaForm" name="rewarding_work" placeholder="働きがいについて"></textarea>

          <div class="revRegistPc-content__form-title">強み・弱み</div>
          <textarea class="revRegistPc-content__form-areaForm" name="strengths_and_weaknesses" placeholder="強み・弱みについて"></textarea>

          <div class="revRegistPc-content__form-title">年収・給与</div>
          <textarea class="revRegistPc-content__form-areaForm" name="annual_income_salary" placeholder="年収・給与について"></textarea>

          <div class="revRegistPc-content__form-title">事業展望</div>
          <textarea class="revRegistPc-content__form-areaForm" name="business_outlook" placeholder="事業展望について"></textarea>

          <div class="revRegistPc-content__form-conciseTitle">総合的なこの会社の印象や評価を20文字以内でお願いします。</div>
          <textarea class="revRegistPc-content__form-conciseAreaForm" name="corporate_culture" placeholder="総評(簡潔にお願いします)"></textarea>

          <div class="revRegistPc-content__form-title">総評</div>
          <textarea class="revRegistPc-content__form-areaForm" name="general_estimation" placeholder="総評(詳しくお願いします)"></textarea>

          <div class="revRegistPc-content__bottom-wrap">
            <input type="submit" class="revRegistPc-content__bottom-return revRegistPc-content__bottom-link" name="back" value="前の項目へ">
            <input type="submit" class="revRegistPc-content__bottom-next revRegistPc-content__bottom-link" name="next" value="投稿する">
          </div>
        </from>

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
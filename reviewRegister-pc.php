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
  if(!empty($_POST['next'] === '投稿する') && $userDate->getRoll() === 50){

    debugFunction::debug('POST送信があります。');
    debugFunction::debug('POST情報：'.print_r($_POST,true));

    //フォーム送信前にもprofEdit関係のメソッドを扱いたいので先にインスタンス生成する。
    $formTransmission = new reviewRegisterPc($_POST['joining_route'],$_POST['enrollment_status'],$_POST['occupation'],$_POST['position'],$_POST['enrollment_period']
    ,$_POST['employment_status'],$_POST['welfare_office_environment'],$_POST['working_hours'],$_POST['in_company_system'],$_POST['corporate_culture'],$_POST['holiday'],$_POST['organizational_structure']
    ,$_POST['ease_of_work_for_women'],$_POST['image_gap'],$_POST['rewarding_work'],$_POST['strengths_and_weaknesses'],$_POST['annual_income_salary'],$_POST['business_outlook'],$_POST['general_estimation_title']
    ,$_POST['general_estimation'],'','','','','','','','','','','','','','','','','','','','','','');

    //キー定義されていないものを指定してvar_dump()するとstring(1) "�"が出力される。
    debugFunction::debug($formTransmission);

    // バリテーションなど

    //入社経路
    $formTransmission->setJoining_route($formTransmission->getJoining_route());
    //在籍状況
    $formTransmission->setEnrollment_status($formTransmission->getEnrollment_status());
    //在籍時の職種
    $formTransmission->setOccupation($formTransmission->getOccupation());
    //在籍時の役職
    $formTransmission->setPosition($formTransmission->getPosition());
    //在籍期間
    $formTransmission->setEnrollment_period($formTransmission->getEnrollment_period());
    //在籍形態
    $formTransmission->setEmployment_status($formTransmission->getEmployment_status());
    //福祉厚生
    $formTransmission->setWelfare_office_environment($formTransmission->getWelfare_office_environment());
    //勤務時間
    $formTransmission->setWorking_hours($formTransmission->getWorking_hours());
    //社内制度
    $formTransmission->setIn_company_system($formTransmission->getIn_company_system());
    //企業文化
    $formTransmission->setCorporate_culture($formTransmission->getCorporate_culture());
    //休暇
    $formTransmission->setHoliday($formTransmission->getHoliday());
    //組織体制
    $formTransmission->setOrganizational_structure($formTransmission->getOrganizational_structure());
    //女性の働きやすさ
    $formTransmission->setEase_of_work_for_women($formTransmission->getEase_of_work_for_women());
    //入社前とのギャップ
    $formTransmission->setImage_gap($formTransmission->getImage_gap());
    //働きがい
    $formTransmission->setRewarding_work($formTransmission->getRewarding_work());
    //強み・弱み
    $formTransmission->setStrengths_and_weaknesses($formTransmission->getStrengths_and_weaknesses());
    //年収・給与
    $formTransmission->setAnnual_income_salary($formTransmission->getAnnual_income_salary());
    //事業展望
    $formTransmission->setBusiness_outlook($formTransmission->getBusiness_outlook());
    //総評(タイトル)
    $formTransmission->setGeneral_estimation_title($formTransmission->getGeneral_estimation_title());
    //総評
    $formTransmission->setGeneral_estimation($formTransmission->getGeneral_estimation());

    //問題があった場合,バリテーション関数からエラーメッセージが返ってきてるはずなので
    //getErr_msメソッドは返り値が配列になっている。
    //emptyそのままだとkeyのみ割り振られている配列もfalseが返ってくるので
    //keyのみ・value無しの要素は削除する必要があるので
    //array_filterを挟んでいる。
    //https://qiita.com/wonda/items/b4a425edd73880a13e62
    if(empty(array_filter($formTransmission->getErr_msAll()))){

      debugFunction::debug('バリデーションOKです。');

      //今まで登録したセッション内情報とフォームから新たに送信された内容を比較。変更が無いか確認。
      //変更があった場合はセッション内情報を更新する。

      //入社経路
      if($_SESSION['joining_route'] !== $formTransmission->getJoining_route()){
        $_SESSION['joining_route'] = $formTransmission->getJoining_route();
      }

      //在籍状況
      if($_SESSION['enrollment_status'] !== $formTransmission->getEnrollment_status()){
        $_SESSION['enrollment_status'] = $formTransmission->getEnrollment_status();
      }

      //在籍時の職種
      if($_SESSION['occupation'] !== $formTransmission->getOccupation()){
        $_SESSION['occupation'] = $formTransmission->getOccupation();
      }

      //在籍時の役職
      if($_SESSION['position'] !== $formTransmission->getPosition()){
        $_SESSION['position'] = $formTransmission->getPosition();
      }

      //在籍期間
      if($_SESSION['enrollment_period'] !== $formTransmission->getEnrollment_period()){
        $_SESSION['enrollment_period'] = $formTransmission->getEnrollment_period();
      }

      //在籍形態
      if($_SESSION['employment_status'] !== $formTransmission->getEmployment_status()){
        $_SESSION['employment_status'] = $formTransmission->getEmployment_status();
      }

      //福利厚生
      if($_SESSION['welfare_office_environment'] !== $formTransmission->getWelfare_office_environment()){
        $_SESSION['welfare_office_environment'] = $formTransmission->getWelfare_office_environment();
      }

      //勤務時間
      if($_SESSION['working_hours'] !== $formTransmission->getWorking_hours()){
        $_SESSION['working_hours'] = $formTransmission->getWorking_hours();
      }

      // 社内制度
      if($_SESSION['in_company_system'] !== $formTransmission->getIn_company_system()){
        $_SESSION['in_company_system'] = $formTransmission->getIn_company_system();
      }

      // 企業文化
      if($_SESSION['corporate_culture'] !== $formTransmission->getCorporate_culture()){
        $_SESSION['corporate_culture'] = $formTransmission->getCorporate_culture();
      }

      // 休暇
      if($_SESSION['holiday'] !== $formTransmission->getHoliday()){
        $_SESSION['holiday'] = $formTransmission->getHoliday();
      }

      //組織体制
      if($_SESSION['organizational_structure'] !== $formTransmission->getOrganizational_structure()){
        $_SESSION['organizational_structure'] = $formTransmission->getOrganizational_structure();
      }

      //女性の働きやすさ
      if($_SESSION['ease_of_work_for_women'] !== $formTransmission->getEase_of_work_for_women()){
        $_SESSION['ease_of_work_for_women'] = $formTransmission->getEase_of_work_for_women();
      }

      //入社前とのギャップ
      if($_SESSION['image_gap'] !== $formTransmission->getImage_gap()){
        $_SESSION['image_gap'] = $formTransmission->getImage_gap();
      }

      //働きがい
      if($_SESSION['rewarding_work'] !== $formTransmission->getRewarding_work()){
        $_SESSION['rewarding_work'] = $formTransmission->getRewarding_work();
      }

      //強み・弱み
      if($_SESSION['strengths_and_weaknesses'] !== $formTransmission->getStrengths_and_weaknesses()){
        $_SESSION['strengths_and_weaknesses'] = $formTransmission->getStrengths_and_weaknesses();
      }

      //年収・給与
      if($_SESSION['annual_income_salary'] !== $formTransmission->getAnnual_income_salary()){
        $_SESSION['annual_income_salary'] = $formTransmission->getAnnual_income_salary();
      }

      //事業展望
      if($_SESSION['business_outlook'] !== $formTransmission->getBusiness_outlook()){
        $_SESSION['business_outlook'] = $formTransmission->getBusiness_outlook();
      }

      //総評のタイトル
      if($_SESSION['general_estimation_title'] !== $formTransmission->getGeneral_estimation_title()){
        $_SESSION['general_estimation_title'] = $formTransmission->getGeneral_estimation_title();
      }

      //総評(詳しくお願いします)
      if($_SESSION['general_estimation'] !== $formTransmission->getGeneral_estimation()){
        $_SESSION['general_estimation'] = $formTransmission->getGeneral_estimation();
      }

      // ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝登録処理＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝

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

          $sql = 'INSERT INTO employee_reviews (`employee_id`,`review_company_id`,`joining_route`,`occupation`,`position`,`enrollment_period`,`enrollment_status`,`employment_status`,`welfare_office_environment`,`working_hours`,
          `in_company_system`,`corporate_culture`,`holiday`,`organizational_structure`,`ease_of_work_for_women`,
          `image_gap`,`rewarding_work`,`strengths_and_weaknesses`,`annual_income_salary`,`business_outlook`,
          `general_estimation_title`,`general_estimation`)
          VALUES(:employee_id,:review_company_id,:joining_route,:occupation,:position,:enrollment_period,
          :enrollment_status,:employment_status,:welfare_office_environment,:working_hours,
          :in_company_system,:corporate_culture,:holiday,:organizational_structure,:ease_of_work_for_women,
          :image_gap,:rewarding_work,:strengths_and_weaknesses,:annual_income_salary,:business_outlook,
          :general_estimation_title,:general_estimation)';

          $data = array(':employee_id' => $contributorUserDate->getUser_id(),':review_company_id' => $_SESSION['company_id'],':joining_route' => $_SESSION['joining_route'],':occupation' => $_SESSION['occupation'],':position' => $_SESSION['position'],':enrollment_period' => $_SESSION['enrollment_period'],
          ':enrollment_status' => $_SESSION['enrollment_status'] ,':employment_status' => $_SESSION['employment_status'],':welfare_office_environment' => $_SESSION['welfare_office_environment'],':working_hours' => $_SESSION['working_hours'],
          ':in_company_system' => $_SESSION['in_company_system'],':corporate_culture' => $_SESSION['corporate_culture'],':holiday' => $_SESSION['holiday'],':organizational_structure' => $_SESSION['organizational_structure'],
          ':ease_of_work_for_women' => $_SESSION['ease_of_work_for_women'],':image_gap' => $_SESSION['image_gap'],':rewarding_work' => $_SESSION['rewarding_work'],':strengths_and_weaknesses' => $_SESSION['strengths_and_weaknesses'],
          ':annual_income_salary' => $_SESSION['annual_income_salary'],':business_outlook' => $_SESSION['business_outlook'],':general_estimation_title' => $_SESSION['general_estimation_title'],':general_estimation' => $_SESSION['general_estimation']);

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
            $_SESSION['in_corporate_culture'] = "";
            $_SESSION['company_id'] = "";
            //空の値を削除する。
            $_SESSION = array_filter($_SESSION);

            debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));

            header("Location:reviewRegister-cm.php"); //投稿完了画面
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

          <input class="revRegistPc-content__input" name="joining_route" placeholder="入社経路" value="<?php if(!empty($_SESSION['joining_route'])) echo $_SESSION['joining_route']; ?>">

          <input class="revRegistPc-content__input" name="enrollment_status" placeholder="在籍状況" value="<?php if(!empty($_SESSION['enrollment_status'])) echo $_SESSION['enrollment_status']; ?>">
          <input class="revRegistPc-content__input" name="occupation" placeholder="在籍時の職種" value="<?php if(!empty($_SESSION['occupation'])) echo $_SESSION['occupation']; ?>">
          <input class="revRegistPc-content__input" name="position" placeholder="在籍時の役職" value="<?php if(!empty($_SESSION['position'])) echo $_SESSION['position']; ?>">
          <input class="revRegistPc-content__input" name="enrollment_period" placeholder="在籍期間" value="<?php if(!empty($_SESSION['enrollment_period'])) echo $_SESSION['enrollment_period']; ?>">
          <input class="revRegistPc-content__input" name="employment_status" placeholder="在籍形態" value="<?php if(!empty($_SESSION['employment_status'])) echo $_SESSION['employment_status']; ?>">
          <input class="revRegistPc-content__input" name="welfare_office_environment" placeholder="福利厚生" value="<?php if(!empty($_SESSION['welfare_office_environment'])) echo $_SESSION['welfare_office_environment']; ?>">
          <input class="revRegistPc-content__input" name="working_hours" placeholder="勤務時間" value="<?php if(!empty($_SESSION['working_hours'])) echo $_SESSION['working_hours']; ?>">


          <!-- textareaにvalue属性は無い。https://shgam.hatenadiary.jp/entry/2014/12/06/185627 -->
          <div class="revRegistPc-content__form-title">社内制度</div>
          <textarea class="revRegistPc-content__form-areaForm" name="in_company_system" placeholder="社内制度について"><?php if(!empty($_SESSION['in_company_system'])) echo $_SESSION['in_company_system']; ?></textarea>

          <div class="revRegistPc-content__form-title">企業文化</div>
          <textarea class="revRegistPc-content__form-areaForm" name="corporate_culture" placeholder="企業文化について"><?php if(!empty($_SESSION['corporate_culture'])) echo $_SESSION['corporate_culture']; ?></textarea>

          <div class="revRegistPc-content__form-title">休暇</div><textarea class="revRegistPc-content__form-areaForm" name="holiday" placeholder="休暇について" ><?php if(!empty($_SESSION['holiday'])) echo $_SESSION['holiday']; ?></textarea>

          <div class="revRegistPc-content__form-title">組織体制</div>
          <textarea class="revRegistPc-content__form-areaForm" name="organizational_structure" placeholder="組織体制について"><?php if(!empty($_SESSION['organizational_structure'])) echo $_SESSION['organizational_structure']; ?></textarea>

          <div class="revRegistPc-content__form-title">女性の働きやすさ</div>
          <textarea class="revRegistPc-content__form-areaForm" name="ease_of_work_for_women" placeholder="女性の働きやすさについて"><?php if(!empty($_SESSION['ease_of_work_for_women'])) echo $_SESSION['ease_of_work_for_women']; ?></textarea>

          <div class="revRegistPc-content__form-title">入社前とのギャップ</div>
          <textarea class="revRegistPc-content__form-areaForm" name="image_gap" placeholder="入社前とのギャップ"><?php if(!empty($_SESSION['image_gap'])) echo $_SESSION['image_gap'];?></textarea>

          <div class="revRegistPc-content__form-title">働きがい</div>
          <textarea class="revRegistPc-content__form-areaForm" name="rewarding_work" placeholder="働きがいについて"><?php if(!empty($_SESSION['rewarding_work'])) echo $_SESSION['rewarding_work'];?></textarea>

          <div class="revRegistPc-content__form-title">強み・弱み</div>
          <textarea class="revRegistPc-content__form-areaForm" name="strengths_and_weaknesses" placeholder="強み・弱みについて"><?php if(!empty($_SESSION['strengths_and_weaknesses'])) echo $_SESSION['strengths_and_weaknesses']; ?></textarea>

          <div class="revRegistPc-content__form-title">年収・給与</div>
          <textarea class="revRegistPc-content__form-areaForm" name="annual_income_salary" placeholder="年収・給与について"><?php if(!empty($_SESSION['annual_income_salary'])) echo $_SESSION['annual_income_salary']; ?></textarea>

          <div class="revRegistPc-content__form-title">事業展望</div>
          <textarea class="revRegistPc-content__form-areaForm" name="business_outlook" placeholder="事業展望について"><?php if(!empty($_SESSION['business_outlook'])) echo $_SESSION['business_outlook']; ?></textarea>

          <div class="revRegistPc-content__form-conciseTitle">総合的なこの会社の印象や評価を20文字以内でお願いします。</div>
          <textarea class="revRegistPc-content__form-conciseAreaForm" name="general_estimation_title" placeholder="総評(簡潔にお願いします)" ><?php if(!empty($_SESSION['general_estimation_title'])) echo $_SESSION['general_estimation_title']; ?></textarea>

          <div class="revRegistPc-content__form-title">総評</div>
          <textarea class="revRegistPc-content__form-areaForm" name="general_estimation" placeholder="総評(詳しくお願いします)" ><?php if(!empty($_SESSION['general_estimation'])) echo $_SESSION['general_estimation']; ?></textarea>

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
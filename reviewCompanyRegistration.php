<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\generalUserProp;
  use classes\companyApply\companyApply;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー会社登録申請画面');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

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
    debugFunction::debug('一般登録アカウントです。先に投稿者登録を先に行う必要があります.');
    //フラッシュメッセージで「投稿者登録を先に行う必要があります。(リンク表示)
    header("Location:mypage.php");
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

  if(!empty($_POST) && $_POST['apply'] === '申請する'){

    debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
    debugFunction::debug('会社情報申請処理に入りました。');
    debugFunction::debug('「「「「「「「「「「「「「');

    $formTransmission = new companyApply($_POST['company_name'],$_POST['representative'],$_POST['location'],$_POST['industry'],$_POST['year_of_establishment'],$_POST['listed_year'],$_POST['number_of_employees'],$_POST['average_annual_income'],
    $_POST['average_age'],'','','','','','','','','','','');

    $formTransmission->setCompany_name($formTransmission->getCompany_name());
    $formTransmission->setRepresentative($formTransmission->getRepresentative());
    $formTransmission->setLocation($formTransmission->getLocation());
    $formTransmission->setIndustry($formTransmission->getIndustry());
    $formTransmission->setYearOfEstablishment($formTransmission->getYearOfEstablishment());
    $formTransmission->setListed_year($formTransmission->getListed_year());
    $formTransmission->setNumberOfEmployees($formTransmission->getNumber_of_employees());
    $formTransmission->setAverageAnnualIncome($formTransmission->getAverage_annual_income());
    $formTransmission->setAverageAge($formTransmission->getAverage_age());

    debugFunction::debug('フォーム内容：'.print_r($formTransmission,true));

    //ログインユーザーのidと同じ値をcontributor_idと紐付ける。

    if(empty(array_filter($formTransmission->getErr_msAll()))){
      debugFunction::debug('会社申請情報のバリデーションOKです。');

      //例外処理
      try {
        // DBへ接続
        $dbh = new dbConnectPDO();
        // SQL文作成(1で代用している分はあとで書き換える)
        $sql = 'INSERT INTO company_informations(`company_name`,`industry`,`company_url`,`zip1`,`zip2`,`zip3`,`location`,`number_of_employees`,`year_of_establishment`,`representative`,`listed_year`,`average_annual_income`,`average_age`,`number_of_reviews`)
        VALUES(:company_name,:industry,:company_url,:zip1,:zip2,:zip3,:location,:number_of_employees,
        :year_of_establishment,:representative,:listed_year,:average_annual_income,:average_age,:number_of_reviews)';
        $data = array(':company_name' => $formTransmission->getCompany_name(),':industry' => $formTransmission->getIndustry(),':company_url' =>1,
        ':zip1' =>1,':zip2' =>1,':zip3' =>1,':location' =>$formTransmission->getLocation(),':number_of_employees' =>$formTransmission->getNumber_of_employees(),
        ':year_of_establishment' =>$formTransmission->getYearOfEstablishment(),':representative' =>$formTransmission->getRepresentative(),':listed_year' =>$formTransmission->getListed_year(),
        ':average_annual_income' =>$formTransmission->getAverage_annual_income(),':average_age' =>$formTransmission->getAverage_age(),':number_of_reviews' =>1);
        debugFunction::debug('取得したdata：'.print_r($data,true));
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

        debugFunction::debug('実行結果：'.print_r($stmt,true));

        // クエリ成功の場合
        if($stmt){
          $_SESSION['msg_success'] = '会社登録を申請しました。';
          debugFunction::debug('マイページへ遷移します。');
          header("Location:mypage.php"); //マイページへ
        }

      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
      }
    }
    }elseif(!empty($_POST) && $_POST['cancel'] === 'キャンセル'){
      debugFunction::debug('会社情報申請をキャンセルします。');
      // マイページへ遷移する。
      header("Location:mypage.php");
    }
?>

<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー会社登録申請画面';
  $Intro__Text_Title ='ReviewCompanyRegistration';
  $Intro__Text_Sub ='レビュー会社登録申請画面';
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

  <!-- revcr・・・ReviewCompanyRegistration -->
  <section class="revcrReviewCompanyRegistration">
    <div class="revcrReviewCompanyRegistration__content">
      <div class="revcrReviewCompanyRegistration__title">Review Company Registration</div>

      <div class="revcrReviewCompanyRegistration__infoWrap">
        <form class="" action="" method="post">
          <div class="revcrReviewCompanyRegistration__inputComp">
            会社名<input name="company_name" placeholder="入力してください">
          </div>

          <div class="">
            <div class="">代表者  <input name="representative" placeholder="入力してください"></div>
            <div class="">所在地  <input name="location" placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">業界  <input name="industry" placeholder="入力してください"></div>
            <div class="">設立年度  <input name="year_of_establishment" placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">上場年  <input name="listed_year" placeholder="入力してください"></div>
            <div class="">従業員数  <input name="number_of_employees" placeholder="入力してください"></div>
          </div>

          <div class="">
            <div class="">平均年収  <input name="average_annual_income" placeholder="入力してください"></div>
            <div class="">平均年齢  <input name="average_age" placeholder="入力してください"></div>
          </div>

          <div>
            <div>
              <input class="" type="submit" name="cancel" value="キャンセル">
            </div>
            <div>
              <input class="" type="submit" name="apply" value="申請する">
            </div>
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
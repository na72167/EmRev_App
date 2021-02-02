<?php

  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\profEdit\profEdit;
  use classes\profEdit\getFormData;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\etc\etc;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('プロフィール編集ページ');
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
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],'',$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],$contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'');
      debugFunction::debug('取得した投稿ユーザー情報：'.print_r($contributorUserDate,true));
    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }

// post送信されていてなおかつ一般ユーザーだった場合。
if(!empty($_POST['update-button'] === '変更する') && $userDate->getRoll() === 100){

  debugFunction::debug('POST送信があります。');
  debugFunction::debug('POST情報：'.print_r($_POST,true));
  debugFunction::debug('FILE情報：'.print_r($_FILES,true));

  // フォームからの送信情報をインスタンスで管理する
  // プロフ画像(プロパティは左から６つ目が対象)のみ後で挿入する。
  $profEdit = new profEdit($_POST['username'],$_POST['age'],$_POST['tel'],$_POST['zip'],$_POST['addr'],'','','','','','','');

  // 画像をアップロードし、パスを格納
  // $_file属性は
  // $_FILESには、アップロードされたファイルの
  // $_FILES['inputで指定したname']['name']：ファイル名
  // $_FILES['inputで指定したname']['type']：ファイルのMIMEタイプ
  // $_FILES['inputで指定したname']['tmp_name']：一時保存ファイル名
  // $_FILES['inputで指定したname']['error']：アップロード時のエラーコード
  // $_FILES['inputで指定したname']['size']：ファイルサイズ（バイト単位）
  // の5種類のデータが格納される

   //フォームから画像情報が送信されているか判定。入っている場合は$pic内に定義。ない場合は空文字を定義する。
    $profImg = (!empty($_FILES['profImg']['name'])) ? etc::uploadImg($_FILES['profImg'],'profImg') : '';

   // 「1.上の処理を通してフォームから画像が送信されていない」。かつ「2.DB内にプロフィール画像が保持されている」場合は
   // DB内情報の情報を送信する。
   // 1.2どちらかのみ当てはまる。もしくはどちらも当てはまらない場合は一つ上の処理で定義された情報をそのまま再定義する。
    $profImg = (empty($profImg) && !empty($generalUserDate->getProfImg())) ? $generalUserDate->getProfImg() : $profImg;

    //プロフ画像情報を挿入。
    $profEdit->setProfImg($profImg);

    //インスタンス内の確認
    debugFunction::debug(var_dump($profEdit));

    //DBの情報と入力情報が異なる場合は各setter関数を通す。
    if($generalUserDate->getUsername()!== $profEdit->getUserName()){
      $profEdit->setUserName($profEdit->getUserName());
    }

    if($generalUserDate->getTel()!== $profEdit->getTel()){
      $profEdit->setTel($profEdit->getTel());
    }

    if($generalUserDate->getAddr()!== $profEdit->getAddr()){
      $profEdit->setAddr($profEdit->getAddr());
    }

    if( $generalUserDate->getZip() !== $profEdit->getZip()){
      $profEdit->setZip($profEdit->getZip());
    }

    if($generalUserDate->getAge() !== $profEdit->getAge()){
      $profEdit->setAge($profEdit->getAge());
    }

  if(empty($profEdit->getErr_msAll())){
    debugFunction::debug('一般ユーザーフォーム、バリデーションOKです。');

    //例外処理
    try {
      // DBへ接続
      $dbh = new dbConnectPDO();
      // SQL文作成
      $sql = 'UPDATE users AS u LEFT JOIN general_profs AS gp ON u.id = gp.user_id SET gp.username = :gp_name, gp.age = :gp_age, gp.tel = :gp_tel,gp.profImg = :gp_profImg, gp.zip = :gp_zip, gp.addr = :gp_addr WHERE u.id = :u_id';
      $data = array(':gp_name' => $profEdit->getUserName(),':gp_tel' => $profEdit->getTel(), ':gp_zip' => $profEdit->getZip(), ':gp_addr' => $profEdit->getAddr(), ':gp_age' => $profEdit->getAge(),  ':gp_profImg' => $profEdit->getProfImg(),':u_id' => $userDate->getID());
      debugFunction::debug('取得したdata：'.print_r($data,true));
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if($stmt){
        $_SESSION['msg_success'] = 'プロフィールを更新しました。';
        debugFunction::debug('マイページへ遷移します。');
        header("Location:mypage.php"); //マイページへ
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
    }
  }

  }elseif(!empty($_POST) && $userDate->getRoll() === 50){
    // 会社員登録用情報
    // $dmState = $_POST['dmState'];
    // $affiliationCompany = $_POST['affiliationCompany'];
    // $incumbent = $_POST['incumbent'];
    // $position = $_POST['position'];
    // $currentDepartment = $_POST['currentDepartment'];
  }elseif(!empty($_POST) && $userDate->getRoll() === 1){
    // 管理者権限持ち情報
  }else{
    // 権限周りが取得できなかった場合はフラッシュメッセージで「権限が取得できませんでした」
    // と表示させる処理を出力させる。
}

if(!empty($_POST['cancel-button'] === '変更を取り消す')){
  debugFunction::debug('変更を取り消しました。マイページへ遷移します。');
  header("Location:mypage.php");
}


  // タイトルの読み込み
  $Page_Title = 'プロフィール編集画面';
  $Intro__Text_Title ='Profile Edit';
  $Intro__Text_Sub ='プロフィール編集画面';
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
    require('./designspace.php');
  ?>

  <?php
    require('./middleElement.php');
  ?>


<!-- ログインユーザーが一般会員の場合 -->
    <?php
      if(!empty($userDate->getRoll() === 100)){
    ?>
      <!-- 直書きスタイルは一般会員ユーザー用のもの -->
      <section class="profEdiUserProfile" style='height:320px; margin-top:50px;'>

      <!-- 一般ユーザーの場合 -->
      <!-- enctype属性・・・送信する情報のエンコードタイプを指定する。form-dataはフォームにファイルを送信する機能がある場合に指定する。 -->
        <form action="" method="post" enctype="multipart/form-data">

          <!-- 共通エラーの出力 -->
          <div class="area-msg">
            <?php
              if(!empty($generalUserDate->getErr_msCommon())) echo $generalUserDate->getErr_msCommon();
            ?>
          </div>

        <!-- ユーザープロフ画像の登録 -->
        <div class="profEdiUserProfile__img-wrap">
          <img class="profEdiUserProfile__img">

          <!-- ここが写真の入力フォームになる予定 -->
          <!-- <input type="file" name="pic" class="profEdiUserProfile__img" style="height:370px;"> -->

        </div>


        <div class="profEdiUserProfile__detail">

          <label class="<?php if(!empty($generalUserDate->getErr_msUserName())) echo 'err'; ?>">
            <div class="profEdiUserProfile__name">
                <div class="profEdiUserProfile__name-areaMsg">
                  <?php
                    if(!empty($generalUserDate->getErr_msUserName())) echo $generalUserDate->getErr_msUserName();
                  ?>
                </div>
                <h1 class="profEdiUserProfile__name-element">name</h1>
                <input class="profEdiUserProfile__name-output" type="text" name="username" value="<?php if(!empty($generalUserDate->getUsername())) echo $generalUserDate->getUsername(); ?>">
            </div>
          </label>

          <div class="profEdiUserProfile__ageTel-Wrap">

          <label class="<?php if(!empty($generalUserDate->getErr_msAge())) echo 'err'; ?>">
            <div class="profEdiUserProfile__age">
                <div class="profEdiUserProfile__age-areaMsg">
                      <?php
                      if(!empty($generalUserDate->getErr_msAge())) echo $generalUserDate->getErr_msAge();
                      ?>
                </div>
                <div class="profEdiUserProfile__age-element">age</div>
                <input class="profEdiUserProfile__age-output" type="text" name="age" value="<?php echo $generalUserDate->getAge(); ?>">
            </div>
          </label>

          <label class="<?php if(!empty($generalUserDate->getErr_msTel())) echo 'err'; ?>">
            <div class="profEdiUserProfile__tel">
            <div class="profEdiUserProfile__tel-areaMsg">
                  <?php
                    if(!empty($generalUserDate->getErr_msTel())) echo $generalUserDate->getErr_msTel();
                  ?>
                </div>
                <div class="profEdiUserProfile__tel-element">tel</div>
                <input class="profEdiUserProfile__tel-output" type="text" name="tel" value="<?php echo $generalUserDate->getTel(); ?>">
            </div>
          </label>

          </div>

          <label class="<?php if(!empty($generalUserDate->getErr_msAddr())) echo 'err'; ?>">
            <div class="profEdiUserProfile__address">
                <div class="profEdiUserProfile__address-areaMsg">
                  <?php
                  if(!empty($generalUserDate->getErr_msAddr())) echo $generalUserDate->getErr_msAddr();
                  ?>
                </div>
                <div class="profEdiUserProfile__address-element">address</div>
                <input class="profEdiUserProfile__address-output" type="text" name="address" value="<?php echo $generalUserDate->getAddr(); ?>">
            </div>
          </label>

      </section>

      <div class="profEdiUserProfile__bottom-wrap" style="margin-bottom:5px;">
        <!-- post内容を初期化したのち、マイページへ移動 -->
        <input type="submit" name='cancel-button' class="profEdiUserProfile__bottom-return" onclick="location.href='mypage.php'" value="変更を取り消す">
        <!-- 送信処理に沿って画面遷移 -->
        <input type="submit" name='update-button' class="profEdiUserProfile__bottom-next" value="変更する">
      </div>

    </form>

    <?php
        // ログインユーザーが投稿者登録をしていた場合
        }elseif(empty($userDate->getRoll() === 50)){
    ?>

    <!-- 直書きスタイルは一般会員ユーザー用のもの -->
    <section class="profEdiUserProfile">

    <!-- 一般ユーザーの場合 -->
    <!-- enctype属性・・・送信する情報のエンコードタイプを指定する。form-dataはフォームにファイルを送信する機能がある場合に指定する。 -->
      <form action="" method="post" enctype="multipart/form-data">

        <!-- 共通エラーの出力 -->
        <div class="area-msg">
          <?php
            if(!empty($generalUserDate->getErr_msCommon())) echo $generalUserDate->getErr_msCommon();
          ?>
        </div>

      <!-- ユーザープロフ画像の登録 -->
      <div class="profEdiUserProfile__img-wrap">
        <img class="profEdiUserProfile__img">

        <!-- ここが写真の入力フォームになる予定 -->
        <!-- <input type="file" name="pic" class="profEdiUserProfile__img" style="height:370px;"> -->

      </div>


      <div class="profEdiUserProfile__detail">

        <label class="<?php if(!empty($generalUserDate->getErr_msUserName())) echo 'err'; ?>">
          <div class="profEdiUserProfile__name">
              <div class="profEdiUserProfile__name-areaMsg">
                <?php
                  if(!empty($generalUserDate->getErr_msUserName())) echo $generalUserDate->getErr_msUserName();
                ?>
              </div>
              <h1 class="profEdiUserProfile__name-element">name</h1>
              <input class="profEdiUserProfile__name-output" type="text" name="username" value="<?php if(!empty($generalUserDate->getUsername())) echo $generalUserDate->getUsername(); ?>">
          </div>
        </label>

        <div class="profEdiUserProfile__ageTel-Wrap">

        <label class="<?php if(!empty($generalUserDate->getErr_msAge())) echo 'err'; ?>">
          <div class="profEdiUserProfile__age">
              <div class="profEdiUserProfile__age-areaMsg">
                    <?php
                    if(!empty($generalUserDate->getErr_msAge())) echo $generalUserDate->getErr_msAge();
                    ?>
              </div>
              <div class="profEdiUserProfile__age-element">age</div>
              <input class="profEdiUserProfile__age-output" type="text" name="age" value="<?php echo $generalUserDate->getAge(); ?>">
          </div>
        </label>

        <label class="<?php if(!empty($generalUserDate->getErr_msTel())) echo 'err'; ?>">
          <div class="profEdiUserProfile__tel">
          <div class="profEdiUserProfile__tel-areaMsg">
                <?php
                  if(!empty($generalUserDate->getErr_msTel())) echo $generalUserDate->getErr_msTel();
                ?>
              </div>
              <div class="profEdiUserProfile__tel-element">tel</div>
              <input class="profEdiUserProfile__tel-output" type="text" name="tel" value="<?php echo $generalUserDate->getTel(); ?>">
          </div>
        </label>

        </div>

        <label class="<?php if(!empty($generalUserDate->getErr_msAddr())) echo 'err'; ?>">
          <div class="profEdiUserProfile__address">
              <div class="profEdiUserProfile__address-areaMsg">
                <?php
                if(!empty($generalUserDate->getErr_msAddr())) echo $generalUserDate->getErr_msAddr();
                ?>
              </div>
              <div class="profEdiUserProfile__address-element">address</div>
              <input class="profEdiUserProfile__address-output" type="text" name="address" value="<?php echo $generalUserDate->getAddr(); ?>">
          </div>
        </label>

        <label class="<?php if(!empty($err_msg['dmState'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__dmState">
              <div class="profEdiUserProfile__dmState-areaMsg">
                <?php
                if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                ?>
              </div>
              <div class="profEdiUserProfile__dmState-element">DM可否</div>
                <!-- 許可か拒否の二択から選択できる様にする。 -->
                <input class="profEdiUserProfile__dmState-output" type="text" name="dmState" value="">
              </div>
          </div>
        </label>

        <div class="profEdiUserProfile__employeeInfoWrap">
          <label class="<?php if(!empty($err_msg['affiliationCompany'])) echo 'err'; ?>">
            <div class="profEdiUserProfile__affiliationCompany">
              <div class="profEdiUserProfile__affiliationCompany-areaMsg">
                  <?php
                  if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                  ?>
              </div>
              <h1 class="profEdiUserProfile__affiliationCompany-element">現所属会社</h1>
              <input class="profEdiUserProfile__affiliationCompany-output" type="text" name="affiliationCompany" value="">
            </div>
          </label>

          <div class="profEdiUserProfile__incumbentPositionWrap">
            <label class="<?php if(!empty($err_msg['incumbent'])) echo 'err'; ?>">
              <div class="profEdiUserProfile__incumbent">
                <div class="profEdiUserProfile__incumbent-areaMsg">
                    <?php
                    if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                    ?>
                </div>
                <div class="profEdiUserProfile__incumbent-element">現職</div>
                <input class="profEdiUserProfile__incumbent-output" type="text" name="incumbent" value="">
              </div>
            </label>

            <label class="<?php if(!empty($err_msg['position'])) echo 'err'; ?>">
              <div class="profEdiUserProfile__Position">
                <div class="profEdiUserProfile__Position-areaMsg">
                    <?php
                    if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                    ?>
                </div>
                <div class="profEdiUserProfile__Position-element">現役職</div>
                <input class="profEdiUserProfile__Position-output" type="text" name="position" value="">
              </div>
            </label>
          </div>

          <label class="<?php if(!empty($err_msg['currentDepartment'])) echo 'err'; ?>">
            <div class="profEdiUserProfile__currentDepartment">
              <div class="profEdiUserProfile__currentDepartment-areaMsg">
                  <?php
                  if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                  ?>
              </div>
              <div class="profEdiUserProfile__currentDepartment-element">現部署</div>
              <input class="profEdiUserProfile__currentDepartment-output" type="text" name="currentDepartment" value="">
            </div>
          </label>
        </div>

      </section>

      <div class="profEdiUserProfile__bottom-wrap" style="margin-bottom:5px;">
        <!-- post内容を初期化したのち、マイページへ移動 -->
        <input type="submit" name='cancel-button' class="profEdiUserProfile__bottom-return" value="変更を取り消す">
        <!-- 送信処理に沿って画面遷移 -->
        <input type="submit" name='update-button' class="profEdiUserProfile__bottom-next" value="変更する">
      </div>

    </form>

  <?php
    }elseif(empty($userDate->getRoll() === 1)){
  ?>

  <?php
  }
  ?>
  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>



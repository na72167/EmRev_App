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
  use classes\etc\getUserProp;
  use classes\etc\etc;

  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('プロフィール編集ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();


  // このあと$_SESSION['user_id']を参照してuserｓテーブルに関した情報のみを管理するuserクラスを作成。
  // 中のrollプロパティにアクセス。その権限情報とuserクラスを元に一般・社員・管理者・退会済み用のSQLを発行・検索を行う。(退会済みは別)。

  // getUser関数はセッション内のuser_id情報と同じidを持つユーザーデータを

  $dbFormDataInstance = getUserProp::getUserProp($_SESSION['user_id']);

  $dbFormData = new getUserProp('','','','','');

  //第二引数にtrueを指定した場合,厳密比較が行われる。
  debugFunction::debug('取得したユーザー情報：'.print_r($dbFormData,true));

// post送信されていた場合
if(!empty($_POST)){
  debugFunction::debug('POST送信があります。');
  debugFunction::debug('POST情報：'.print_r($_POST,true));
  debugFunction::debug('FILE情報：'.print_r($_FILES,true));

  // フォームからの送信情報をインスタンスで管理する
  // プロフ画像(プロパティは左から６つ目が対象)のみ後で挿入する。。
  $profEdit = new profEdit($_POST['username'],$_POST['age'],$_POST['tel'],$_POST['zip'],$_POST['addr'],'','','','','','');

  // 会社員登録用情報
  // $dmState = $_POST['dmState'];
  // $affiliationCompany = $_POST['affiliationCompany'];
  // $incumbent = $_POST['incumbent'];
  // $position = $_POST['position'];
  // $currentDepartment = $_POST['currentDepartment'];

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
    $pic = ( !empty($_FILES['pic']['name']) ) ? etc::uploadImg($_FILES['pic'],'pic') : '';

   // 「1.上の処理を通してフォームから画像が送信されていない」。かつ「2.DB内にプロフィール画像が保持されている」場合は
   // DB内情報の情報を送信する。
   // 1.2どちらかのみ当てはまる。もしくはどちらも当てはまらない場合は一つ上の処理で定義された情報をそのまま再定義する。
    $pic = ( empty($pic) && !empty($dbFormData['pic']) ) ? $dbFormData['pic'] : $pic;

    //プロフ画像情報を挿入。
    $profEdit->setProfImg($pic);

    //インスタンス内の確認
    debugFunction::debug($profEdit);

    //DBの情報と入力情報が異なる場合は各setter関数を通す。
    if($dbFormData['username'] !== $profEdit->getUserName()){
      $profEdit->setUserName($profEdit->getUserName());
    }

    if($dbFormData['tel'] !== $profEdit->getTel()){
      $profEdit->setTel($profEdit->getTel());
    }

    if($dbFormData['addr'] !== $profEdit->getAddr()){
      $profEdit->setAddr($profEdit->getAddr());
    }

    if( (int)$dbFormData['zip'] !== $profEdit->getZip()){ //DBデータをint型にキャスト（型変換）して比較
      $profEdit->setZip($profEdit->getZip());
    }

    if($dbFormData['age'] !== $profEdit->getAge()){
      $profEdit->setAge($profEdit->getAge());
    }

    // ここができたあとはエラー発生の確認をしたあとのDB更新処理を挟んでいく。


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


    <section class="profEdiUserProfile">

    <!-- enctype属性・・・送信する情報のエンコードタイプを指定する。form-dataはフォームにファイルを送信する機能がある場合に指定する。 -->
      <form action="" method="post" enctype="multipart/form-data">

      <!-- 共通エラーの出力 -->
      <div class="area-msg">
        <?php
        if(!empty($err_msg['common'])) echo $err_msg['common'];
        ?>
      </div>


      <!-- ユーザープロフ画像の登録 -->
      <div class="profEdiUserProfile__img-wrap">
        <img class="profEdiUserProfile__img">

        <!-- ここが写真の入力フォームになる予定 -->
        <!-- <input type="file" name="pic" class="profEdiUserProfile__img" style="height:370px;"> -->

      </div>


      <div class="profEdiUserProfile__detail">

        <label class="<?php if(!empty($err_msg['username'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__name">
              <h1 class="profEdiUserProfile__name-element">name</h1>
              <input class="profEdiUserProfile__name-output" type="text" name="username" value="<?php echo $dbFormData['username']; ?>">
          </div>
        </label>

        <div class="profEdiUserProfile__ageTel-Wrap">

        <label class="<?php if(!empty($err_msg['age'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__age">
              <div class="profEdiUserProfile__age-element">age</div>
              <input class="profEdiUserProfile__age-output" type="text" name="age" value="<?php echo getFormData('age'); ?>">
          </div>
        </label>

        <label class="<?php if(!empty($err_msg['tel'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__tel">
              <div class="profEdiUserProfile__tel-element">tel</div>
              <input class="profEdiUserProfile__tel-output" type="text" name="tel" value="<?php echo getFormData('tel'); ?>">
          </div>
        </label>

        </div>

        <label class="<?php if(!empty($err_msg['address'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__address">
              <div class="profEdiUserProfile__address-element">address</div>
              <input class="profEdiUserProfile__address-output" type="text" name="address" value="<?php echo getFormData('address'); ?>">
          </div>
        </label>

        <label class="<?php if(!empty($err_msg['dmState'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__dmState">
              <div class="profEdiUserProfile__dmState-element">DM可否</div>
                <!-- 許可か拒否の二択から選択できる様にする。 -->
                <input class="profEdiUserProfile__dmState-output" type="text" name="dmState" value="<?php echo getFormData('dmState'); ?>">
              </div>
          </div>
        </label>

      <div class="profEdiUserProfile__employeeInfoWrap">
        <label class="<?php if(!empty($err_msg['affiliationCompany'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__affiliationCompany">
            <h1 class="profEdiUserProfile__affiliationCompany-element">現所属会社</h1>
            <input class="profEdiUserProfile__affiliationCompany-output" type="text" name="affiliationCompany" value="<?php echo getFormData('affiliationCompany'); ?>">
          </div>
        </label>

        <div class="profEdiUserProfile__incumbentPositionWrap">
          <label class="<?php if(!empty($err_msg['incumbent'])) echo 'err'; ?>">
            <div class="profEdiUserProfile__incumbent">
              <div class="profEdiUserProfile__incumbent-element">現職</div>
              <input class="profEdiUserProfile__incumbent-output" type="text" name="incumbent" value="<?php echo getFormData('incumbent'); ?>">
            </div>
          </label>

          <label class="<?php if(!empty($err_msg['position'])) echo 'err'; ?>">
            <div class="profEdiUserProfile__Position">
              <div class="profEdiUserProfile__Position-element">現役職</div>
              <input class="profEdiUserProfile__Position-output" type="text" name="position" value="<?php echo getFormData('position'); ?>">
            </div>
          </label>
        </div>

        <label class="<?php if(!empty($err_msg['currentDepartment'])) echo 'err'; ?>">
          <div class="profEdiUserProfile__currentDepartment">
            <div class="profEdiUserProfile__currentDepartment-element">現部署</div>
            <input class="profEdiUserProfile__currentDepartment-output" type="text" name="currentDepartment" value="<?php echo getFormData('currentDepartment'); ?>">
          </div>
        </label>
      </div>
    </section>

    <div class="profEdiUserProfile__bottom-wrap">
      <!-- post内容を初期化したのち、マイページへ移動 -->
      <input type="submit" class="profEdiUserProfile__bottom-return" value="変更を取り消す">
      <!-- 送信処理に沿って画面遷移 -->
      <input type="submit" class="profEdiUserProfile__bottom-next" value="変更する">

    </div>
  </form>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
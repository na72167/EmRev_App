<?php
    //autoloadやstrict_typesなどクラスでまとめる必要のない基本設定などをまとめている。
    require('defaultSetting.php');

    use classes\debug\debugFunction;
    use classes\db\dbConnectFunction;
    use classes\etc\etc;
    use classes\profEdit\profEdit;

    debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
    debugFunction::debug('プロフィール編集ページ');
    debugFunction::debug('「「「「「「「「「「「「「');
    debugFunction::debugLogStart();

//================================
// 画面処理
//================================
// DBからユーザーデータを取得
// getUser関数はセッション内のuser_id情報と同じidを持つユーザーデータを
// 引っ張ってこれる。
$dbFormData = etc::getUser($_SESSION['user_id']);

//第二引数にtrueを指定した場合,厳密比較が行われる。
debugFunction::debug('取得したユーザー情報：'.print_r($dbFormData,true));

// post送信されていた場合
if(!empty($_POST)){
  debugFunction::debug('POST送信があります。');
  debugFunction::debug('POST情報：'.print_r($_POST,true));
  debugFunction::debug('FILE情報：'.print_r($_FILES,true));

  // フォームからの送信情報をインスタンスで管理する
  $profEdit = new profEdit($_POST['username'],$_POST['age'],$_POST['tel'],$_POST['zip'],$_POST['addr'],$_FILES['pic']);

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

  // インスタンス内にpicの一連情報が保持できていないかも
  $pic = $profEdit->getProfImg(['pic']['name']);

  $pic = ( !empty($_FILES['pic']['name']) ) ? uploadImg($_FILES['pic'],'pic') : '';

  // 画像をPOSTしてない（登録していない）が既にDBに登録されている場合、DBのパスを入れる（POSTには反映されないので）
  $pic = ( empty($pic) && !empty($dbFormData['pic']) ) ? $dbFormData['pic'] : $pic;

  //DBの情報と入力情報が異なる場合にバリデーションを行う
  if($dbFormData['username'] !== $username){
    //名前の最大文字数チェック
    validMaxLen($username, 'username');
  }


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
              <input class="profEdiUserProfile__name-output" type="text" name="username" value="<?php echo getFormData('username'); ?>">
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
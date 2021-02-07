<?php

   // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\profEdit\profEdit;
  use classes\debug\debugFunction;
  use classes\passwordReminder\passwordReminder;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('認証キーとパスワード変更');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  //ログインの確認や権限取得処理などは無し。(パスワード変更機能はログイン出来ない人が使う物なので)

  //ログイン認証はなし（ログインできない人が使う画面なので）

  //SESSIONに認証キーがあるか確認、なければリダイレクト
  //(パスワード再設定は)
  if(empty($_SESSION['auth_key'])){
    header("Location:passwordReminder.php"); //認証キー送信ページへ
  }

//post送信されていた場合
if(!empty($_POST['send'] === "再発行する")){
  debugFunction::debug('POST送信があります。');
  debugFunction::debug('POST情報：'.print_r($_POST,true));

  $formTransmission = new passwordReminder($_POST['email'],$_POST['token'],$_POST['password'],'','','','');

  $formTransmission->setEmail($formTransmission->getEmail());
  // $formTransmission->setToken($formTransmission->getToken());
  $formTransmission->setPass($formTransmission->getPass());

  if(empty(array_filter($formTransmission->getErr_ms()))){

    debugFunction::debug('バリデーションOK。');

    if($_POST['token'] !== $_SESSION['auth_key']){
      $formTransmission->setErr_msCommon("#");
    }
    if(time() > $_SESSION['auth_key_limit']){
      $formTransmission->setErr_msCommon("#");
    }

    if(empty(array_filter($formTransmission->getErr_ms()))){
      debugFunction::debug('認証OK。');

      $pass = $formTransmission->getPass(); //パスワード設定

      //例外処理
      try {
        // DBへ接続
        $dbh = new dbConnectPDO();
        // SQL文作成
        $sql = 'UPDATE users SET password = :pass WHERE email = :email AND delete_flg = 0';
        $data = array(':email' => $_SESSION['auth_email'], ':pass' => password_hash($formTransmission->getPass(),PASSWORD_DEFAULT));
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

        // クエリ成功の場合
        if($stmt){
          debugFunction::debug('クエリ成功。');

          //メールを送信
          $from = 'kaifayongakaunto@gmail.com';
          $to = $_SESSION['auth_email'];
          $subject = '【パスワード再発行完了】｜Em_Rev';
          //EOTはEndOfFileの略。ABCでもなんでもいい。先頭の<<<の後の文字列と合わせること。最後のEOTの前後に空白など何も入れてはいけない。
          //EOT内の半角空白も全てそのまま半角空白として扱われるのでインデントはしないこと
          $comment = <<<EOT
            本メールアドレス宛にパスワードの再発行を致しました。
            下記のURLにて再発行パスワードをご入力頂き、ログインください。

            ログインページ：http://localhost:8888/EmRev/EmRev_app/
            再発行パスワード：{$pass}

          EOT;
          etc::sendMail($from, $to, $subject, $comment);

          //セッション削除
          session_unset();
          $_SESSION['msg_success'] = "#";
          debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));

          header("Location:index.php"); //ログインページへ

        }else{
          debugFunction::debug('クエリに失敗しました。');
          $err_msg['common'] = "#";
        }

      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_msg['common'] = "#";
      }
    }
  }
}
?>


<?php
  // タイトルの読み込み
  $Page_Title = 'パスワード変更画面';
  $Intro__Text_Title ='Password Reminder';
  $Intro__Text_Sub ='パスワード変更画面';
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

  <?php
    require('./middleElement.php');
  ?>

  <section class="passrePasswordReminder">
    <div class="passreReminder__content">
      <h1 class="passrePasswordReminder__title">Password Reminder</h1>

      <form action="" method="post" class="form">
        <p>ご指定のメールアドレスお送りした【パスワード再発行認証】メール内にある「認証キー」をご入力ください。</p>
          <div class="area-msg">
          </div>

          <label class="">
            Email
            <input type="text" name="email" value="">
          </label>

        <div class="area-msg">
        </div>

        <label class="">
          認証キー
          <input type="text" name="token" placeholder="受信した認証キーを入力">
        </label>

        <label class="">
          変更後パスワード
          <input type="text" name="password" placeholder="変更後パスワードを入力">
        </label>

        <div class="area-msg">
        </div>
        <div class="btn-container">
          <input type="submit" class="btn btn-mid" name="send" value="再発行する">
        </div>
      </form>

    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
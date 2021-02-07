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
  debugFunction::debug('パスワード変更ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

//ログインの確認や権限取得処理などは無し。(パスワード変更機能はログイン出来ない人が使う物なので)


//==============POST送信があります==================

//post送信されていた場合
if(!empty($_POST['ChangePassword'] === "変更画面へ")){
  debugFunction::debug('POST送信(変更)があります。');
  debugFunction::debug('POST情報：'.print_r($_POST,true));
  $formTransmission = new passwordReminder($_POST['email'],'','','','','','');

  if(empty(array_filter($formTransmission->getErr_ms()))){
    debugFunction::debug('バリデーションOK。');

    //例外処理
    try {
      // DBへ接続
      $dbh = new dbConnectPDO();

      // SQL文作成
      $sql = 'SELECT * FROM users WHERE email = :email AND delete_flg = 0';
      $data = array(':email' => $formTransmission->getEmail());

      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
      // クエリ結果の値を取得
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // EmailがDBに登録されている場合
      if($stmt && array_shift($result)){
        debugFunction::debug('クエリ成功。DB登録あり。');

        $auth_key = etc::makeRandKey(); //認証キー生成

        //メールを送信
        $from = 'kaifayongakaunto@gmail.com';
        $to = $formTransmission->getEmail();
        $subject = '【パスワード再発行認証】｜Em_Rev';
        //EOTはEndOfFileの略。ABCでもなんでもいい。先頭の<<<の後の文字列と合わせること。最後のEOTの前後に空白など何も入れてはいけない。
        //EOT内の半角空白も全てそのまま半角空白として扱われるのでインデントはしないこと
        $comment = <<<EOT
        本メールアドレス宛にパスワード再発行のご依頼がありました。
        下記のURLにて認証キーをご入力頂くとパスワードが再発行されます。

        パスワード再発行認証キー入力ページ：http://localhost:8888/EmRev/EmRev_app/passRemindRecieve.php
        認証キー：{$auth_key}
        ※認証キーの有効期限は30分となります

        認証キーを再発行されたい場合は下記ページより再度再発行をお願い致します。
        http://localhost:8888/EmRev/EmRev_app/passwordReminder.php
        EOT;
        etc::sendMail($from, $to, $subject, $comment);

        //認証に必要な情報をセッションへ保存
        $_SESSION['auth_key'] = $auth_key;
        $_SESSION['auth_email'] = $formTransmission->getEmail();
        $_SESSION['auth_key_limit'] = time()+(60*30); //現在時刻より30分後のUNIXタイムスタンプを入れる
        debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));

        header("Location:passRemindRecieve.php"); //認証キー入力ページへ

      }else{
        debugFunction::debug('クエリに失敗したかDBに登録のないEmailが入力されました。');
        $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
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
      <form action="" method="post">
        <h4>メールアドレス</h4>
        <p>ご指定のメールアドレス宛にパスワード再発行用のURLと認証キーをお送り致します。</p>
        <input type="text" class="passrePasswordReminder__input" name="email" placeholder="ここにメールアドレスを入力">
        <input type="submit" class="passrePasswordReminder__content-bottom" name="ChangePassword" value="変更画面へ">
      </form>
    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
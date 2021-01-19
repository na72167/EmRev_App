<!--アカウント作成関係処理-->
<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\admin\signup;
  use classes\admin\login;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('アカウント作成ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  //登録処理を行う前に$formTransmission内にインスタンスを用意していないと
  //入力フォーム内にsignupクラスのgetterメソッドを使っている為,最初のホーム画面が部分的にしか映らなくなる。
  $formTransmission = new signup('','','','','','','');

  // 名前空間とuse指定後定義。
  $loginFormTransmission = new login('','','','','','');

  //接続情報をまとめたクラス
  $dbh = new dbConnectPDO();

  // ユーザー登録フォームから送信されたか判定
  if(!empty($_POST) && $_POST['user_register'] === '登録する'){

    debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
    debugFunction::debug('ユーザー登録処理に入りました。');
    debugFunction::debug('「「「「「「「「「「「「「');

    $formTransmission = new signup($_POST['email'], $_POST['pass'], $_POST['password_re'],'','','','');

    //バリテーションはset内で完結させてる。
    // アクセス修飾子で制御しているプロパティは直接引っ張り出せない。(例:$formTransmission->emailはFatal errorが発生する。)
    // なので同じクラス内で管理している個別のgetterメソッドで取得する。
    $formTransmission->setEmail($formTransmission->getEmail());
    $formTransmission->setPass($formTransmission->getPass());
    $formTransmission->setPass_re($formTransmission->getPass_re());

    //キー定義されていないものを指定してvar_dump()するとstring(1) "�"が出力される。
    debugFunction::debug($formTransmission);

    //問題があった場合,バリテーション関数からエラーメッセージが返ってきてるはずなので
    if(empty($formTransmission->getErr_ms())){

      debugFunction::debug('バリデーションOKです。');

      //例外処理
      //dbConnectPDO()を記述したファイルのみクラス・トレイト化・namespaceを使用していない。(PDOが上手く行かない為)
      try {

        $signupProp = new dbConnectFunction($dbh->getPDO(),
        'INSERT INTO users (email,password,create_date) VALUES(:email,:pass,:create_date)',
        array(':email' => $formTransmission->getEmail(),':pass' => password_hash($formTransmission->getPass(),PASSWORD_DEFAULT),':create_date' => date('Y-m-d H:i:s')));

        //sql文を実際に実行。insert文を使ってuserデータを登録する。
        $stmt = dbConnectFunction::queryPost($signupProp->getDbh(), $signupProp->getSql(), $signupProp->getData());

        // insert成功の場合
        if($stmt){
        //ログイン有効期限（デフォルトを１時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time();
        $_SESSION['login_limit'] = $sesLimit;
        // ユーザーIDを格納
        // 新しくユーザー登録をした = 対応テーブル最後尾にデータ追加されるのでlastInsertId()でID属性を取得してくる。
        $_SESSION['user_id'] = $signupProp->getDbh()->lastInsertId();

        // ポスト内情報の初期化
        $_POST = [];
        debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));

        header("Location:mypage.php"); //マイページへ
        }
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $formTransmission->setCommonErr_ms('エラーが発生しました。しばらく経ってからやり直してください。');
        header("Location:index.php");
      }
    }
  }else{
    $_POST['user_register'] === '';
  }


  //次はログイン機能をクラス化する。
  //あとユーザー登録機能のバリテーション処理などがちゃんと機能しているか確認。
  //クラスを使ったテストコードの書き方も確認する。

  //エラーメッセージの出力をgetに書き換える。


//================================
// ログイン画面処理
//================================
// post送信されていた場合

if(!empty($_POST) && $_POST['user_login'] === 'ログイン'){

  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debug('ログイン機能処理に入りました。');
  debugFunction::debug('「「「「「「「「「「「「「');

  //インスタンス生成時の情報挿入の際もアクセス修飾子周りで引っかかった場合、set関数を使う様にする。
  //なるべくごちゃごちゃさせたくないのと、アクセス修飾子についてより深く知りたいので、このまま一度インスタンス化させる。
  $loginFormTransmission = new login($_POST['login-email'], $_POST['login-pass'],!empty(($_POST['login-pass_save'])) ? true : false,'','','');

  //判定元オブジェクトの内容確認
  debugFunction::debug($loginFormTransmission);

  // バリテーションはset内で完結させてる。
  // アクセス修飾子で制御しているプロパティは直接引っ張り出せない。(例:$formTransmission->emailはFatal errorが発生する。)
  // なので同じクラス内で管理している個別のgetterメソッドで取得する。
  $loginFormTransmission->setLoginEmail($loginFormTransmission->getLoginEmail());
  $loginFormTransmission->setLoginPass($loginFormTransmission->getLoginPass());
  $loginFormTransmission->getLoginPassSave();

  debugFunction::debug($loginFormTransmission);

  //問題があった場合set関数内のバリテーションで変数err_ms内にメッセージが入るのでそれを元に判定する
  if(empty($loginFormTransmission->getErr_ms())){

    debugFunction::debug('バリデーションOKです。');

    //例外処理
    //dbConnectPDO()を記述したファイルのみクラス・トレイト化・namespaceを使用していない。(PDOが上手く行かない為)
    //SELECTで指定しているカラム順序がおかしいのは、のちのpass比較時に
    //array_shiftを利用して配列の１つ目を取得してフォーム送信passと比較するので、
    //idが先に来ると照合が上手くいかなくなる。

    try {
      $loginProp = new dbConnectFunction($dbh->getPDO(),
      'SELECT password,id  FROM users WHERE email = :email AND delete_flg = 0',
      array(':email' => $loginFormTransmission->getLoginEmail()));

      //sql文を実際に実行。SELECT文を使ってuserテーブルから入力したemail情報と合致するレコードを探す。
      //合致した場合、対応レコードが保持するpassword・id情報を取得する。
      $stmt = dbConnectFunction::queryPost($loginProp->getDbh(), $loginProp->getSql(), $loginProp->getData());

      //クエリ文の実行結果から取得したレコードをfetch関数を使ってkey・valueの連想配列配形式で管理する。
      //カラムがkey。レコードがvalueになる。
      //emailはuniqueである為、取得レコードは1つのみになるのでfetch。
      //複数の場合はfetchAllを扱う。

      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      // 無事に取得できていればpasswordとid情報が入っている。
      debugFunction::debug('クエリ結果の中身：'.print_r($result,true));

      // パスワード情報が取得されているかを確認。
      // password_verifyで対象ユーザーのDB内passとフォームから送信されたpassが合致するかを確認。
      if(!empty($result) && password_verify($loginFormTransmission->getLoginPass(), array_shift($result))){
        debugFunction::debug('パスワードがマッチしました。');

        //ログイン有効期限（デフォルトを１時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time(); //time関数は1970年1月1日 00:00:00 を0として、1秒経過するごとに1ずつ増加させた値が入る

        // ログイン保持にチェックがある場合
        if($loginFormTransmission->getLoginPassSave()){
          debugFunction::debug('ログイン保持にチェックがあります。');
          // ログイン有効期限を30日にしてセット
          $_SESSION['login_limit'] = $sesLimit * 24 * 30;
        }else{
          debugFunction::debug('ログイン保持にチェックはありません。');
          // 次回からログイン保持しないので、ログイン有効期限を1時間後にセット
          $_SESSION['login_limit'] = $sesLimit;
        }

        // ユーザーIDを格納
        // 比較元のid属性は上のfetch処理で取得している。
        $_SESSION['user_id'] = $result['id'];

        debugFunction::debug('セッション変数の中身：'.print_r($_SESSION,true));
        debugFunction::debug('マイページへ遷移します。');

        // ポスト内情報の初期化
        $_POST = [];
        // 個別のマイページへ返す為,あとで$_getを使ったクエリパラメータを保持させる処理を書く。
        header("Location:mypage.php"); //マイページへ
      }else{
        debugFunction::debug('パスワードがアンマッチです。');
        $err_ms['login-common'] = 'メールアドレスまたはパスワードが違います';

      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $loginFormTransmission->setErr_msCommon('エラーが発生しました。しばらく経ってからやり直してください。');
      header("Location:index.php");
    }
  }
}else{
  $_POST['user_login'] === '';
}


?>

<?php
  // タイトルの読み込み
  $Page_Title = 'ホーム';
  // ヘッドの読み込み
  require('./head.php');
?>
<body>
  <!--ヘッダー読み込み-->
  <?php
    require('./header.php');
    ?>
  <!-- ヒーローバナー -->
  <section class="hero">

    <!-- テキスト関係 -->
      <div class="hero__content">

        <div class="hero__text-wrap">
          <h1 class="hero__text-catchTheam">
          Easier Deployment
          </h1>
          <div class="hero__text-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサン
          </div>
          <a class="hero__text-aboutLink" href="#index-about">このアプリについて</a>
        </div>

        <div class="hero__signup-loginWrap">
          <!-- 会員登録関係 -->
          <div class="hero__signup js-signup-style">
            <form action="" method="post" class="hero__signup-formStyle">
              <h2 class="hero__signup-title">SignUp</h2>
                <div class="hero__signup-commonMsgArea">
                  <!-- 接続エラー等のメッセージをここに出力させる。 -->
                  <!--例外処理発生時に出力されるメッセージを出す処理-->

                  <?php if(!empty($formTransmission->getCommonErr_ms())) echo $formTransmission->getCommonErr_ms();?>
                </div>

              <!-- メールアドレス入力欄 -->
              <div class="hero__signup-emailaddressField">
                <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->

                <label class="#">
                    <!-- バリに引っかかった際には$err_msに関連するvalueが入るので、それを判定元にerrクラスを付属させる。 -->
                    <!-- value内は入力記録の保持 -->
                    <input class="hero__signup-emailForm <?php if(!empty($formTransmission->getEmailErr_ms())) echo 'err'; ?>" type="text" name="email" placeholder="Email" value="<?php if(!empty($formTransmission->getEmail())) echo $formTransmission->getEmail(); ?>">
                    <!-- 後にphpでエラーメッセージを出力させる様にする。-->
                    <div class="hero__signup-areaMsg">
                    <?php
                      if(!empty($formTransmission->getEmailErr_ms())) echo $formTransmission->getEmailErr_ms();
                    ?>
                    </div>
                </label>
              </div>

              <!-- パスワード入力 -->
              <div class="hero__signup-passwardField">
                <label class="#">
                  <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                  <input class="hero__signup-passwordForm <?php if(!empty($formTransmission->getPassErr_ms())) echo 'err'; ?>" type="password" name="pass" placeholder="Password" value="<?php if(!empty($formTransmission->getPass())) echo $formTransmission->getPass(); ?>">
                  <div class="hero__signup-areaMsg">
                    <?php
                    if(!empty($formTransmission->getPassErr_ms())) echo $formTransmission->getPassErr_ms();
                    ?>
                  </div>
                </label>
              </div>

              <!-- 確認用パスワード入力 -->
              <div class="hero__signup-confirmationPasswardField">
                <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                <label class="#">
                  <input class="hero__signup-passwordConfirmationForm" name="password_re" type="password" placeholder="Confirmation Password" value="<?php if(!empty($formTransmission->getPass_re())) echo $formTransmission->getPass_re(); ?>">
                </label>
                <div class="hero__signup-areaMsg">
                  <?php
                  if(!empty($formTransmission->getPassReErr_ms())) echo $formTransmission->getPassReErr_ms();
                  ?>
                </div>
              </div>

              <div class="hero__signup-registerBtnField">
                <input class="hero__signup-registerBtn" type="submit" name="user_register" value="登録する">
              </div>

            </form>
          </div>


          <!-- ログイン関係 -->
          <div class="hero__login js-login-style hidden">

            <form action="" method="post" class="hero__login-formStyle">
                <h2 class="hero__login-title">Login</h2>
                  <div class="hero__login-commonMsgArea">
                    <!-- 接続エラー等のメッセージをここに出力させる。 -->
                    <!--例外処理発生時に出力されるメッセージを出す処理-->
                    <?php if(!empty($err_ms['login-common'])) echo $err_ms['login-common'];?>
                  </div>

                <!-- メールアドレス入力欄 -->
                <div class="hero__login-emailaddressField">
                  <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->

                  <label class="#">
                      <!-- バリに引っかかった際には$err_msに関連するvalueが入るので、それを判定元にerrクラスを付属させる。 -->
                      <!-- value内は入力記録の保持 -->
                      <input class="hero__login-emailForm <?php if(!empty($loginFormTransmission->getEmailErr_ms())) echo 'err'; ?>" type="text" name="login-email" placeholder="Email" value="<?php if(!empty($loginFormTransmission->getEmailErr_ms())) echo $loginFormTransmission->getLoginEmail(); ?>">
                      <!-- 後にphpでエラーメッセージを出力させる様にする。-->
                      <div class="hero__login-areaMsg">
                      <?php
                      if(!empty($loginFormTransmission->getEmailErr_ms())) echo $loginFormTransmission->getEmailErr_ms();
                      ?>
                      </div>
                  </label>
                </div>

                <!-- パスワード入力 -->
                <div class="hero__login-passwardField">
                  <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                  <input class="hero__login-passwordForm <?php if(!empty($loginFormTransmission->getPassErr_ms())) echo 'err'; ?>" type="password" name="login-pass" placeholder="Password" value="<?php if(!empty($loginFormTransmission->getPassErr_ms())) echo $loginFormTransmission->getLoginPass(); ?>">
                  <div class="hero__login-areaMsg">
                    <?php
                    if(!empty($loginFormTransmission->getPassErr_ms())) echo $loginFormTransmission->getPassErr_ms();
                    ?>
                  </div>
                </div>

                <div class="hero__login-registerBtnField">
                  <input class="hero__login-registerBtn" type="submit" name="user_login" value="ログイン">
                </div>
            </form>

          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- 新着レビューコンテンツ -->
  <section class="review">

    <div class="review__content-block">
      <h3 class="review__content-title">New reviews</h3>
      <!-- 新着レビューコンテンツ(今は仮レイアウトの都合上複数同じ要素を作っているがphpを書き始めた際にはfor文で回す) -->
      <div class="review__content-wrap">
        <div class="review__content-individual">

          <!-- イメージ画像 -->
          <img class="review__image" rel="#">

          <!-- ユーザー名 -->
          <div href="#" class="review__userName-style">
            <span class="review__userName">
              ユーザー名
            </span>
          </div>

          <!-- 会社名 -->
          <div href="#" class="review__companyName-style">
            <span class="review__companyName">会社名</span>
          </div>

          <!-- 会社の業界 -->
          <div href="#" class="review__industry-style">
            <span class="review__industry">会社の業界</span>
          </div>

          <!-- レビュー内容(総評) -->
          <div class="review__generalComment-style">
            <div class="review__generalComment">
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル...
            </div>
          </div>

          <!-- 詳細を見る -->
          <div href="#" class="review__detail-style">
            <span class="review__detail">
            詳細を見る
            </span>
          </div>
        </div>

        <!-- レビューコンテンツ(今は仮レイアウトの都合上複数同じ要素を作っているがphpを書き始めた際にはfor文で回す) -->
        <div class="review__content-individual">

          <!-- イメージ画像 -->
          <img class="review__image" rel="#">

          <!-- ユーザー名 -->
          <div href="#" class="review__username-style">
            <span class="review__userName">
              ユーザー名
            </span>
          </div>

          <!-- 会社名 -->
          <div href="#" class="review__companyName-style">
            <span class="review__companyName">会社名</span>
          </div>

          <!-- 会社の業界 -->
          <div href="#" class="review__industry-style">
            <span class="review__industry">会社の業界</span>
          </div>

          <!-- レビュー内容(総評) -->
          <div class="review__generalComment-style">
            <div class="review__generalComment">
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル...
            </div>
          </div>

          <!-- 詳細を見る -->
          <div href="#" class="review__detail-style">
            <span class="review__detail">
            詳細を見る
            </span>
          </div>
        </div>

        <!-- レビューコンテンツ(今は仮レイアウトの都合上複数同じ要素を作っているがphpを書き始めた際にはfor文で回す) -->
        <div class="review__content-individual">

          <!-- イメージ画像 -->
          <img class="review__image" rel="#">

          <!-- ユーザー名 -->
          <div href="#" class="review__userName-style">
            <span class="review__userName">
              ユーザー名
            </span>
          </div>

          <!-- 会社名 -->
          <div href="#" class="review__companyName-style">
            <span class="review__companyName">会社名</span>
          </div>

          <!-- 会社の業界 -->
          <div href="#" class="review__industry-style">
            <span class="review__industry">会社の業界</span>
          </div>

          <!-- レビュー内容(総評) -->
          <div class="review__generalComment-style">
            <div class="review__generalComment">
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル<br>
              サンプルサンプルサンプル...
            </div>
          </div>

          <!-- 詳細を見る -->
          <div href="#" class="review__detail-style">
            <span class="review__detail">
            詳細を見る
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- このアプリについて -->
  <section id="index-about" class="about">
    <div class="about__content-wrap">
      <h3 class="about__content-title">
      About app
      </h3>
      <div class="about__content-text">
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
      </div>
      <!-- リンク先はセッション内のログイン情報に沿ってif文で変更する。ログインしている場合はマイページへ。していない場合はサインアップ画面へ移動する。-->
      <a href="#index-top" class="about__content-link active-signup-menu">
        このアプリを使ってみる
      </a>
    </div>
  </section>

    <!-- お問い合わせフォーム -->
  <section class="contact" id="index-contact">
    <div class="contact__content-wrap">
      <div class="contact__content-title">
        CONTACT
      </div>
      <div class="contact__content-body">
        <from action="" class="">
          <input class="contact__content-form" type="text" placeholder="お名前">
          <input class="contact__content-form" type="email" placeholder="E-Mail">
          <input class="contact__content-form" placeholder="お問い合わせの種類">
          <textarea class="contact__content-areaForm" placeholder="お問い合わせ内容"></textarea>
          <button class="contact__content-buttom">送信する</button>
        </from>
      </div>
    </div>
  </section>

<?php
// フッター要素の読み込み
  require('./footer.php');
?>
</body>
</html>
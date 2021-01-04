<!--アカウント作成関係処理-->
<?php

  require('vendor/autoload.php');

  use classes\admin\signup;
  use classes\db\dbConnectObj;
  use classes\debug\debugFunction;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('アカウント作成ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  // post送信された情報を管理する配列
  $formTransmission = array();
  $successFormTransmission = array();

  // ユーザー登録フォームから送信されたか判定
  if(!empty($_POST) && $_POST['user_register'] === '登録する'){

    $formTransmission = new signup( $_POST['email'], $_POST['pass'], $_POST['password_re'],'');
    var_dump($formTransmission);

    //バリテーションはset内で完結させてる。
    $formTransmission->setEmail($this->email);
    $formTransmission->setPass($this->pass);
    $formTransmission->setPass_re($this->password_re);

    //問題があった場合set関数内のバリテーションで変数err_ms内にメッセージが入るのでそれを元に判定する
    if(empty($formTransmission->getErr_ms())){
      //例外処理
      try {
        $signupProp[] = new dbConnect(dbConnectProp::dbConnectProp(),
        'INSERT INTO users (email,password,create_date) VALUES(:email,:pass,:create_date)',
        array(':email' => $formTransmission->getEmail(),':pass' => $formTransmission->getPass(),':create_date' => date('Y-m-d H:i:s')));

        //sql文を実際に実行。insert文を使ってuserデータを登録する。
        $stmt = dbConnect::queryPost($signupProp[]->dbh, $signupProp[]->sql, $signupProp[]->data);

        // insert成功の場合
        if($stmt){
        //ログイン有効期限（デフォルトを１時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time();
        $_SESSION['login_limit'] = $sesLimit;
        // ユーザーIDを格納
        // 新しくユーザー登録をした = 対応テーブル最後尾にデータ追加されるのでlastInsertId()でID属性を取得してくる。
        $_SESSION['user_id'] = $signupProp->dbh->lastInsertId();

        debug('セッション変数の中身：'.print_r($_SESSION,true));
        header("Location:mypage.php"); //マイページへ
        }
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        //クラス内プロパティを直接引っ張ってくる方法を調べる。
        $formTransmission[]->err_ms = 'エラーが発生しました。しばらく経ってからやり直してください。';
        header("Location:index.php");
      }
    }
  }


  //エラーメッセージの出力をgetに書き換える。


//================================
// ログイン画面処理
//================================
// post送信されていた場合
if(!empty($_POST) && $_POST['user_login'] === 'ログイン'){
  debug('POST送信があります。');

  //変数にユーザー情報を代入
  $email = $_POST['login-email'];
  $pass = $_POST['login-pass'];
  $pass_save = (!empty($_POST['login-pass_save'])) ? true : false; //ショートハンド（略記法）という書き方

  //emailの形式チェック
  validEmail($email, 'login-email');
  //emailの最大文字数チェック
  validMaxLen($email, 'login-email');

  //パスワードの半角英数字チェック
  validHalf($pass, 'login-pass');
  //パスワードの最大文字数チェック
  validMaxLen($pass, 'login-pass');
  //パスワードの最小文字数チェック
  validMinLen($pass, 'login-pass');

  //未入力チェック
  validRequired($email, 'login-email');
  validRequired($pass, 'login-pass');

  if(empty($err_ms)){
    debug('バリデーションOKです。');

    //例外処理
    try {
      // DBへ接続
      $dbh = dbConnect();
      // SQL文作成
      $sql = 'SELECT password,id  FROM users WHERE email = :email AND delete_flg = 0';
      $data = array(':email' => $email);
      // クエリ実行
      $stmt = queryPost($dbh, $sql, $data);
      // クエリ結果の値を取得
      $result = $stmt->fetch(PDO::FETCH_ASSOC);

      debug('クエリ結果の中身：'.print_r($result,true));

      // パスワード照合
      if(!empty($result) && password_verify($pass, array_shift($result))){
        debug('パスワードがマッチしました。');

        //ログイン有効期限（デフォルトを１時間とする）
        $sesLimit = 60*60;
        // 最終ログイン日時を現在日時に
        $_SESSION['login_date'] = time(); //time関数は1970年1月1日 00:00:00 を0として、1秒経過するごとに1ずつ増加させた値が入る

        // ログイン保持にチェックがある場合
        if($pass_save){
          debug('ログイン保持にチェックがあります。');
          // ログイン有効期限を30日にしてセット
          $_SESSION['login_limit'] = $sesLimit * 24 * 30;
        }else{
          debug('ログイン保持にチェックはありません。');
          // 次回からログイン保持しないので、ログイン有効期限を1時間後にセット
          $_SESSION['login_limit'] = $sesLimit;
        }
        // ユーザーIDを格納
        $_SESSION['user_id'] = $result['id'];

        debug('セッション変数の中身：'.print_r($_SESSION,true));
        debug('マイページへ遷移します。');
        header("Location:mypage.php"); //マイページへ
      }else{
        debug('パスワードがアンマッチです。');
        $err_ms['login-common'] = 'メールアドレスまたはパスワードが違います';
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_ms['login-common'] = ERROR_MS_07;
      header("Location:index.php");
    }
  }
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
                  <?php if(!empty($err_ms['common'])) echo $err_ms['common'];?>
                </div>

              <!-- メールアドレス入力欄 -->
              <div class="hero__signup-emailaddressField">
                <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->

                <label class="#">
                    <!-- バリに引っかかった際には$err_msに関連するvalueが入るので、それを判定元にerrクラスを付属させる。 -->
                    <!-- value内は入力記録の保持 -->
                    <input class="hero__signup-emailForm <?php if(!empty($err_ms['email'])) echo 'err'; ?>" type="text" name="email" placeholder="Email" value="<?php if(!empty($_POST['email'])) echo $_POST['email']; ?>">
                    <!-- 後にphpでエラーメッセージを出力させる様にする。-->
                    <div class="hero__signup-areaMsg">
                    <?php
                      if(!empty($err_ms['email'])) echo $err_ms['email'];
                    ?>
                    </div>
                </label>
              </div>

              <!-- パスワード入力 -->
              <div class="hero__signup-passwardField">
                <label class="#">
                  <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                  <input class="hero__signup-passwordForm <?php if(!empty($err_ms['pass'])) echo 'err'; ?>" type="password" name="pass" placeholder="Password" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
                  <div class="hero__signup-areaMsg">
                    <?php
                    if(!empty($err_ms['pass'])) echo $err_ms['pass'];
                    ?>
                  </div>
                </label>
              </div>

              <!-- 確認用パスワード入力 -->
              <div class="hero__signup-confirmationPasswardField">
                <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                <label class="#">
                  <input class="hero__signup-passwordConfirmationForm" name="password_re" type="password" placeholder="Confirmation Password" value="<?php if(!empty($_POST['password_re'])) echo $_POST['password_re']; ?>">
                </label>
                <div class="hero__signup-areaMsg">
                  <?php
                  if(!empty($err_ms['password_re'])) echo $err_ms['password_re'];
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
                      <input class="hero__login-emailForm <?php if(!empty($err_ms['login-email'])) echo 'err'; ?>" type="text" name="login-email" placeholder="Email" value="<?php if(!empty($_POST['login-email'])) echo $_POST['login-email']; ?>">
                      <!-- 後にphpでエラーメッセージを出力させる様にする。-->
                      <div class="hero__login-areaMsg">
                      <?php
                      if(!empty($err_ms['login-email'])) echo $err_ms['login-email'];
                      ?>
                      </div>
                  </label>
                </div>

                <!-- パスワード入力 -->
                <div class="hero__login-passwardField">
                  <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                  <input class="hero__login-passwordForm <?php if(!empty($err_ms['login-pass'])) echo 'err'; ?>" type="password" name="login-pass" placeholder="Password" value="<?php if(!empty($_POST['login-pass'])) echo $_POST['login-pass']; ?>">
                  <div class="hero__login-areaMsg">
                    <?php
                    if(!empty($err_ms['login-pass'])) echo $err_ms['login-pass'];
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
<!--アカウント作成関係処理-->
<?php
  //関数関係のファイルを纏めたもの
  require('function.php');

  debug('「「「「「「「「「「「「「「「「「「「');
  debug('アカウント作成ページ');
  debug('「「「「「「「「「「「「「');
  debugLogStart();

  //post送信された後の処理
  //_post等はsession_start()を使った時点で用意される。

  if(!empty($_POST)){

    //変数にユーザー情報を代入
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $password_re = $_POST['password_re'];

    //未入力チェック
    validRequired($email, 'email');
    validRequired($pass, 'pass');
    validRequired($password_re, 'password_re');

    if(empty($err_ms)){

      //emailの形式チェック
      validEmail($email, 'email');
      //最大文字数チェック
      validMaxLen($email, 'email');
      //重複チェック
      validEmailDup($email);


      //パスワードの半角英数字チェック
      validHalf($pass, 'pass');
      //最大文字数チェック
      validMaxLen($pass, 'pass');
      //最小文字数チェック
      validMinLen($pass, 'pass');


      //パスワード（再入力）の最大文字数チェック
      validMaxLen($password_re, 'password_re');
      //最小文字数チェック
      validMinLen($pass, 'password_re');

      if(empty($err_ms)){

        //パスワードとパスワード再入力が合っているかチェック
        validMatch($pass, $password_re, 'password_re');

        if(empty($err_ms)){

          //例外処理
          try {
            // DBへ接続
            $dbh = dbConnect();
            // SQL文作成
            $sql = 'INSERT INTO users (email,password,login_time,create_date) VALUES(:email,:pass,:login_time,:create_date)';
            $data = array(':email' => $email, ':pass' => password_hash($pass, PASSWORD_DEFAULT),
                          ':login_time' => date('Y-m-d H:i:s'),
                          ':create_date' => date('Y-m-d H:i:s'));
            // クエリ実行
            $stmt = queryPost($dbh, $sql, $data);

            // クエリ成功の場合
            if($stmt){
            //ログイン有効期限（デフォルトを１時間とする）
            $sesLimit = 60*60;
            // 最終ログイン日時を現在日時に
            $_SESSION['login_date'] = time();
            $_SESSION['login_limit'] = $sesLimit;
            // ユーザーIDを格納
            // 新しくユーザー登録をした = 対応テーブル最後尾にデータ追加されるのでlastInsertId()でID属性を取得してくる。
            $_SESSION['user_id'] = $dbh->lastInsertId();

            debug('セッション変数の中身：'.print_r($_SESSION,true));

            header("Location:mypage.php"); //マイページへ
            }
          } catch (Exception $e) {
            error_log('エラー発生:' . $e->getMessage());
            $err_msg['common'] = ERROR_MS_07;
          }

        }
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
  <section id="index-signup" class="hero">

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

        <!-- 会員登録関係 -->
        <div class="hero__signup">
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
                <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
                  <input class="hero__signup-passwordForm <?php if(!empty($err_ms['pass'])) echo 'err'; ?>" type="password" name="pass" placeholder="Password" value="<?php if(!empty($_POST['pass'])) echo $_POST['pass']; ?>">
              <div class="hero__signup-areaMsg">
                <?php
                if(!empty($err_ms['password'])) echo $err_ms['password'];
                ?>
              </div>
            </div>

            <!-- 確認用パスワード入力 -->
            <div class="hero__signup-confirmationPasswardField">
              <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
              <label class="#">
                <input class="hero__signup-passwordConfirmationForm" type="password" name="password_re" placeholder="Confirmation Password" value="<?php if(!empty($_POST['password_re'])) echo $_POST['password_re']; ?>">
              </label>
              <div class="hero__signup-areaMsg">
                <?php
                if(!empty($err_ms['password_re'])) echo $err_ms['password_re'];
                ?>
              </div>
            </div>

            <div class="hero__signup-registerBtnField">
              <input class="hero__signup-registerBtn" type="submit" value="登録する">
            </div>

          </form>
        </div>

        <!-- ログイン関係
        <div class="hero__login">
          <span class="hero__login-title">Login</span>
          メールアドレス入力欄
          <div class="hero__signup-emailaddressField">
            <span>Name</span>
          </div>
          パスワード入力
          <div class="hero__signup-passwardField">
            あとからプレースホルダーにする。
            <span>password</span>
          </div>
        </div> -->
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
      <a href="#index-signup" class="about__content-link">
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
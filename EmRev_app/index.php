<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Project</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
  <link rel="stylesheet" href="root/css/style.css">
</head>
<body>
  <!-- ヘッダー関係 -->
  <header class="header">
    <div class="header__content-wrap">
      <!-- タイトル -->
      <h1 class="header__title">EmRev</h1>
      <!-- ナビゲーション(セッション内容で切り替える) -->
      <nav class="header__nav">
        <ul class="header__nav-ul">
          <li class="header__nav-list">LOGIN</li>
          <li class="header__nav-list">SIGNUP</li>
        </ul>
      </nav>
    </div>
  </header>

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
          <a class="hero__text-aboutLink" href="#about">このアプリについて</a>
        </div>

        <!-- 会員登録関係 -->
        <div class="hero__signup">
          <form action="" method="post" class="hero__signup-formStyle">
            <h2 class="hero__signup-title">SignuUp</h2>
              <div class="hero__signup-commonMsgArea">
                <!-- 接続エラー等のメッセージをここに出力させる。 -->
              </div>

            <!-- メールアドレス入力欄 -->
            <div class="hero__signup-emailaddressField">
              <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
              <label class="#">
                <input class="hero__signup-emailForm" type="text" name="email" placeholder="Email" value="">
              </label>
              <div class="hero__signup-areaMsg">
              <!-- 後にphpでエラーメッセージを出力させる様にする。-->
              </div>
            </div>

            <!-- パスワード入力 -->
            <div class="hero__signup-passwardField">
              <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
              <label class="#">
                <input class="hero__signup-passwordForm" type="password" name="password" placeholder="Password" value="">
              </label>
              <div class="hero__signup-areaMsg">
              <!-- 後にphpでエラーメッセージを出力させる様にする。-->
              </div>
            </div>

            <!-- 確認用パスワード入力 -->
            <div class="hero__signup-confirmationPasswardField">
              <!-- 後にphpでエラー時用のスタイルを付属させる様にする。 -->
              <label class="#">
                <input class="hero__signup-passwordConfirmationForm" type="password" name="password_re" placeholder="Confirmation Password" value="">
              </label>
              <div class="hero__signup-areaMsg">
              <!-- 後にphpでエラーメッセージを出力させる様にする。-->
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
  <section id="about" class="about">
    <div class="about__content-style">

      <div class="about__title">
      このアプリについて
      </div>

      <div class="about__text">
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
        サンプルサンプルサンプルサンプルサンプルサンプルサンプル
      </div>

      <div class="about__link-style">

      <!-- リンク先はセッション内のログイン情報に沿ってif文で変更する。ログインしている場合はマイページへ。していない場合はサインアップ画面へ移動する。-->
        <div href="#" class="about__link">
          このアプリを使ってみる
        </div>
      </div>
    </div>
  </section>

    <!-- お問い合わせフォーム -->
  <section class="contact">
    <div class="contact__usernName">
      お問い合わせ
    </div>
    <div class="contact__type-style">
      <div class="contact__type">
        お問い合わせの種類
      </div>
      <option>
      </option>
    </div>
    <div class="contact__about">
      <textarea name="" id="" cols="30" rows="10">
      </textarea>
    </div>
    <div>送信</div>
  </section>

  <!-- フッター -->
  <footer class="footer">
  Copyright © yuitoHigashihara. All Rights Reserved
  </footer>
</body>
</html>
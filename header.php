  <!-- ヘッダー関係 -->
  <header id="index-top" class="header js-toggle-sp-menu-target">
    <div class="header__content-wrap">
      <!-- タイトル -->
      <h1 class="header__title" href="index.php"><a href="index.php" class="header__title-link">EmRev</a></h1>
      <?php
        if(empty($_SESSION['user_id'])){
      ?>
        <!-- ナビゲーション(ログイン前のもの。セッション内容で切り替える。) -->
        <nav class="header__nav">
          <li class="header__nav-list active-login-menu">LOGIN</li>
          <li class="header__nav-list active-signup-menu">SIGNUP</li>
        </nav>
      <?php
          }elseif(!empty($_SESSION['user_id'])){
        ?>
        <!-- ナビゲーション(ログイン後のもの。セッション内容で切り替える。) -->
        <nav class="header__nav">
          <li class="header__nav-list js-toggle-sp-menu">MENU</li>
          <li class="header__nav-list" href="./reviewRegister-jr.php">REVIEW REGISTRATION</li>
          <li class="header__nav-list"><a href="./logout.php">LOGOUT</a></li>
        </nav>
      <?php
          }
        ?>
    </div>
  </header>

  <div id="js-show-msg" class="msg-slide">
    <?php debug('セッション変数の中身：'.print_r($_SESSION['msg_success'],true)); ?>
    <?php echo getSessionFlash('msg_success'); ?>
  </div>

  <!-- メニューバーの内容部分 -->
  <nav class="menuAbout">
    <ul class="menuAbout__itemWrap">
      <li class="menuAbout__itemWrap-item">マイページ</li>
      <li class="menuAbout__itemWrap-item">お気に入りレビュー一覧</li>
      <li class="menuAbout__itemWrap-item">登録レビュー一覧</li>
      <li class="menuAbout__itemWrap-item">閲覧履歴</li>
      <li class="menuAbout__itemWrap-item">会社側登録</li>
      <li class="menuAbout__itemWrap-item">登録社員一覧</li>
      <li class="menuAbout__itemWrap-item">パスワード変更</li>
      <li class="menuAbout__itemWrap-item">レビュー会社登録申請</li>
      <li class="menuAbout__itemWrap-item"><a class="menuLink-color" href="./withdrawal.php">退会する</a></li>
    </ul>
  </nav>
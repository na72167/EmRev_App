<?php

  //関数関係のファイルを纏めたもの
  require('function.php');

  debug('「「「「「「「「「「「「「「「「「「「');
  debug('退会ページ');
  debug('「「「「「「「「「「「「「');
  debugLogStart();



//   //ログイン認証
// require('auth.php');

//================================
// 画面処理
//================================
// post送信されていた場合
if(!empty($_POST)){
  debug('POST送信があります。');
  //例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql1 = 'UPDATE users SET  delete_flg = 1 WHERE id = :us_id';
    // $sql2 = 'UPDATE product SET  delete_flg = 1 WHERE user_id = :us_id';
    // $sql3 = 'UPDATE like SET  delete_flg = 1 WHERE user_id = :us_id';
    // データ流し込み
    $data = array(':us_id' => $_SESSION['user_id']);
    // クエリ実行
    $stmt1 = queryPost($dbh, $sql1, $data);
    // $stmt2 = queryPost($dbh, $sql2, $data);
    // $stmt3 = queryPost($dbh, $sql3, $data);

    // クエリ実行成功の場合（最悪userテーブルのみ削除成功していれば良しとする）
    if($stmt1){
      // セッション情報の初期化
      $_SESSION = [];
      // 退会メッセージの代入
      $_SESSION['msg_success'] = SUCCESS_MS_02;
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('トップページへ遷移します。');
      header("Location:index.php");
    }else{
      debug('クエリが失敗しました。');
      $err_ms['common'] = ERROR_MS_07;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
    $err_ms['common'] = ERROR_MS_07;
  }
}
debug('画面表示処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');


  // タイトルの読み込み
  $Page_Title = '退会画面';
  $Intro__Text_Title ='Withdrawal';
  $Intro__Text_Sub ='退会画面';
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

  <section class="withdrawal">
    <div class="withdrawal__content">
      <form action="" method="post">
        <input name="withdrawal" class="withdrawal__content-bottom" value="退会する" type="submit">
      </form>
    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
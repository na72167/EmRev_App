<?php
//ログ出力関係の設定
ini_set('log_errors','on');
//ログの出力ファイルを指定
ini_set('error_log','php.log');

$debug_flg = true;

function debug($string){
  global $debug_flg;
  if(!empty($debug_flg)){
    error_log('デバッグ：'.$string);
  }
}

function debugLogStart(){
  debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
  debug('セッションID：'.session_id());
  debug('セッション変数の中身：'.print_r($_SESSION,true));
  debug('現在日時タイムスタンプ：'.time());
  if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
    debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
  }
}

// デバッグ関係ここまで



// セッション準備・セッション有効期限を延長する

//セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
session_save_path("/var/tmp/");

//ガーベージコレクションが削除するセッションの有効期限を設定（第二引数の数字はセッションの有効期限を1ヶ月にする為の式。30日以上経っているものに対してだけ１００分の１の確率で削除）
ini_set('session.gc_maxlifetime', 60*60*24*30);

//ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
ini_set('session.cookie_lifetime ', 60*60*24*30);

//セッションを使う
session_start();

//現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
session_regenerate_id();

//セッション関係はここまで

//ここからバリテーション関係やDB関係の関数

  //エラーメッセージ関係の定数
  define('ERROR_MS_01','入力必須です');
  define('ERROR_MS_02','Emailの形式で入力してください');
  define('ERROR_MS_03','パスワード(再入力)が合っていません');
  define('ERROR_MS_04','半角英数字のみご利用いただけます');
  define('ERROR_MS_05','6文字以上で入力してください');
  define('ERROR_MS_06','256文字以内で入力してください');
  define('ERROR_MS_07','エラーが発生しました。しばらく経ってからやり直してください。');
  define('ERROR_MS_08','そのEmailはすでに登録されています');

  //エラメ出力用の空配列
  $err_ms = array();

    //DB接続関数
  function dbConnect(){
    //DBへの接続準備
    $dsn = 'mysql:dbname=EmRevDB;host=localhost;charset=utf8';
    $user = 'root';
    $password = 'root';
    $options = array(
      // SQL実行失敗時にはエラーコードのみ設定
      PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
      // デフォルトフェッチモードを連想配列形式に設定
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
      // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );
    // PDOオブジェクト生成（DBへ接続）
    $dbh = new PDO($dsn, $user, $password, $options);
    return $dbh;
  }

  //バリテーション関係の関数

  //入力チェック
  function validRequired($string,$key){
    if(empty($string)){
      global $err_ms;
      $err_ms[$key] = ERROR_MS_01;
    }
  }

  //email確認
  function validEmail($string, $key){
    if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $string)){
      global $err_ms;
      $err_ms[$key] = ERROR_MS_02;
    }
  }

  //確認用パスワードのチェック
  function validMatch($string1, $string2, $key){
    if($string1 !== $string2){
      global $err_ms;
      $err_ms[$key] = ERROR_MS_03;
    }
  }

  //半角チェック
  function validHalf($string, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $key)){
      global $err_ms;
      $err_ms[$key] = ERROR_MS_04;
    }
}

      //最小文字数チェック
    function validMinLen($string, $key, $min = 6){
      if(mb_strlen($string) < $min){
        global $err_ms;
        $err_ms[$key] = ERROR_MS_05;
      }
    }

    //最大文字数チェック
    function validMaxLen($string, $key, $max = 255){
      if(mb_strlen($string) > $max){
        global $err_ms;
        $err_ms[$key] = ERROR_MS_06;
      }
    }

    //email重複確認
    function validEmailDup($email){
      global $err_ms;

      try {
      //DB接続処理関数
        $dbh = dbConnect();
      //DBからemailデータを引っ張ってくる処理を詰める処理等
        $sql = 'SELECT count(*) FROM users WHERE email = :email';
        $data = array(':email' => $email);
      //クエリ実行
        $stmt = queryPost($dbh, $sql, $data);
      // クエリ結果を変数に代入
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

      if(!empty(array_shift($result))){
          $err_ms['email'] = ERROR_MS_08;
        }
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        $err_ms['common'] = ERROR_MS_07;
      }
    }

  //==============その他関数====================

  //SQL実行関数
  function queryPost($dbh, $sql, $data){
    //クエリー作成
    $stmt = $dbh->prepare($sql);
    //プレースホルダに値をセットし、SQL文を実行
    $stmt->execute($data);
    return $stmt;
  }

?>
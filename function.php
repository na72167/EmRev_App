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

//====================ここからバリテーション関係やDB関係の関数===========================

  //エラーメッセージ関係の定数
  define('ERROR_MS_01','入力必須です');
  define('ERROR_MS_02','Emailの形式で入力してください');
  define('ERROR_MS_03','パスワード(再入力)が合っていません');
  define('ERROR_MS_04','半角英数字のみご利用いただけます');
  define('ERROR_MS_05','6文字以上で入力してください');
  define('ERROR_MS_06','256文字以内で入力してください');
  define('ERROR_MS_07','エラーが発生しました。しばらく経ってからやり直してください。');
  define('ERROR_MS_08','そのEmailはすでに登録されています');
  define('ERROR_MS_09','31文字以内で入力してください');
  define('SUCCESS_MS_01','ログアウトしました');
  define('SUCCESS_MS_02','退会しました');

  //エラメ出力用の空配列
  $err_ms = array();

    //DB接続関数
  function dbConnect(){
    //DBへの接続準備
    $dsn = 'mysql:dbname=EmRevDB;host=localhost:8889;charset=utf8';
    $user = 'root';
    $password = 'root';
    // ここのオプション関係はコピペ
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

  //半角チェック(半角のみしか打てないのにこの正規表現だと全角アルファベットが打てる。)
  //でも半角英数字の正規表現で調べるとこれが出てくるのでこのままにしておく。
  function validHalf($string, $key){
    if(!preg_match("/^[a-zA-Z0-9]+$/", $string)){
      global $err_ms;
      $err_ms[$key] = ERROR_MS_04;
    }
  }

      //最小文字数チェック(以下「<=」がうまく動かないのでorを使ってる。)
    function validMinLen($string, $key, $min = 5){
      if(mb_strlen($string) < $min or mb_strlen($string) == $min){
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

    //最大文字数チェック(email専用)
    function validMaxLenEmail($string, $key, $max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        global $err_ms;
        $err_ms[$key] = ERROR_MS_09;
      }
    }

     //最大文字数チェック(password専用)
    function validMaxLenPassword($string, $key, $max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        global $err_ms;
        $err_ms[$key] = ERROR_MS_09;
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

     //電話番号形式チェック
    function validTel($str, $key){
      if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $str)){
        global $err_msg;
        $err_msg[$key] = MSG10;
      }
    }

  //==============その他関数====================

      //エラーメッセージ表示
    function getErrMsg($key){
      global $err_ms;
      if(!empty($err_ms[$key])){
        return $err_ms[$key];
      }
    }

  //SQL実行関数
  function queryPost($dbh, $sql, $data){
    //クエリー作成
    $stmt = $dbh->prepare($sql);
    //プレースホルダに値をセットし、SQL文を実行
    $stmt->execute($data);
    return $stmt;
  }

 //sessionを１回だけ取得できる
function getSessionFlash($key){
  if(!empty($_SESSION[$key])){
    $data = $_SESSION[$key];
    $_SESSION[$key] = '';
    return $data;
  }
}

//ログイン中のユーザー情報をセッション内idを元にDBから引っ張ってくる。
function getUser($u_id){
  debug('ユーザー情報を取得します。');
  //例外処理
  try {
    // DBへ接続
    $dbh = dbConnect();
    // SQL文作成
    $sql = 'SELECT * FROM users  WHERE id = :u_id AND delete_flg = 0';
    $data = array(':u_id' => $u_id);
    // クエリ実行
    $stmt = queryPost($dbh, $sql, $data);

    // クエリ結果のデータを１レコード返却
    if($stmt){
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
//  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// サニタイズ(対象の文字列をhtml化。その後文字列として返す。)
function sanitize($str){
  return htmlspecialchars($str,ENT_QUOTES);
}

// フォーム入力保持
// 入力情報を第一。get,postの切り替えをflgで管理する。
// trueでget,falseでpost。デフォルトだと_post内を比較対象にする。
function getFormData($str, $flg = false){
  if($flg){
    $method = $_GET;
  }else{
    $method = $_POST;
  }
  global $dbFormData;
  // ユーザーデータがある場合(ログインしているかの確認)
  if(!empty($dbFormData)){
    //フォームのエラーがある場合(上のフラグ管理でアクセスするスーパーグローバル変数を切り替える。)
    if(!empty($err_msg[$str])){
      //POSTにデータがある場合
      if(isset($method[$str])){
        return sanitize($method[$str]);
      }else{
        //ない場合はDBの情報を表示（基本ありえない。上の処理でエラーメッセージがあるか確認してあると判定されているので、
        //エラーの判定物[送信情報]が無いとこっちのif文にそもそも入れない。）
        return sanitize($dbFormData[$str]);
      }
    }else{
      //POSTにエラーに引っかからないデータがあり、_post OR _get内の情報とDBの情報と違う場合
      //_変数内にnull以外の情報があり、_変数内の情報(入力情報)と$dbFormDataに保持された入力情報
      //(他のエラー等が原因で問題が無くても送信ができなかった情報など)を比較。
      //if文内の条件に合致した場合,サニタイズを通して入力情報をフォームへ返す。
      if(isset($method[$str]) && $method[$str] !== $dbFormData[$str]){
        return sanitize($method[$str]);
      }else{
        //falseの場合(入力情報がない。もしくは前回の入力情報と今回の入力情報が一緒の場合は前回の入力情報を送信する。)
        return sanitize($dbFormData[$str]);
      }
    }
  }else{
    // 中にnull以外のものが入っているのか確認。別のものが入っていたら
    // html化->文字列に変更
    if(isset($method[$str])){
      return sanitize($method[$str]);
    }
  }
}


// 画像処理
function uploadImg($file, $key){
  debug('画像アップロード処理開始');
  debug('FILE情報：'.print_r($file,true));

  if (isset($file['error']) && is_int($file['error'])) {
    try {
      // バリデーション
      // $file['error'] の値を確認。配列内には「UPLOAD_ERR_OK」などの定数が入っている。
      //「UPLOAD_ERR_OK」などの定数はphpでファイルアップロード時に自動的に定義される。定数には値として0や1などの数値が入っている。
      switch ($file['error']) {
          case UPLOAD_ERR_OK: // OK
              break;
          case UPLOAD_ERR_NO_FILE:   // ファイル未選択の場合
              throw new RuntimeException('ファイルが選択されていません');
          case UPLOAD_ERR_INI_SIZE:  // php.ini定義の最大サイズが超過した場合
          case UPLOAD_ERR_FORM_SIZE: // フォーム定義の最大サイズ超過した場合
              throw new RuntimeException('ファイルサイズが大きすぎます');
          default: // その他の場合
              throw new RuntimeException('その他のエラーが発生しました');
      }

      // $file['mime']の値はブラウザ側で偽装可能なので、MIMEタイプを自前でチェックする
      // exif_imagetype関数は「IMAGETYPE_GIF」「IMAGETYPE_JPEG」などの定数を返す
      $type = @exif_imagetype($file['tmp_name']);
      if (!in_array($type, [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG], true)) { // 第三引数にはtrueを設定すると厳密にチェックしてくれるので必ずつける
          throw new RuntimeException('画像形式が未対応です');
      }

      // ファイルデータからSHA-1ハッシュを取ってファイル名を決定し、ファイルを保存する
      // ハッシュ化しておかないとアップロードされたファイル名そのままで保存してしまうと同じファイル名がアップロードされる可能性があり、
      // DBにパスを保存した場合、どっちの画像のパスなのか判断つかなくなってしまう
      // image_type_to_extension関数はファイルの拡張子を取得するもの
      $path = 'uploads/'.sha1_file($file['tmp_name']).image_type_to_extension($type);
      if (!move_uploaded_file($file['tmp_name'], $path)) { //ファイルを移動する
          throw new RuntimeException('ファイル保存時にエラーが発生しました');
      }
      // 保存したファイルパスのパーミッション（権限）を変更する
      chmod($path, 0644);

      debug('ファイルは正常にアップロードされました');
      debug('ファイルパス：'.$path);
      return $path;

    } catch (RuntimeException $e) {

      debug($e->getMessage());
      global $err_msg;
      $err_msg[$key] = $e->getMessage();

    }
  }
}

?>
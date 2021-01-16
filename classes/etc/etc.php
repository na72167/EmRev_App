<?php

  declare(strict_types=1);
  namespace classes\etc;
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');
  //このファイルのみ名前空間を使うとPDOが上手く使えなくなる為
  //requireを使う。
  use classes\db\dbConnectFunction;
  use classes\debug\debugFunction;

  class etc{
  //sessionを１回だけ取得できる
  public static function getSessionFlash($key){
    if(!empty($_SESSION[$key])){
      $data = $_SESSION[$key];
      $_SESSION[$key] = '';
      return $data;
    }
  }

  // サニタイズ(対象の文字列をhtml化。その後文字列として返す。)
  public static function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
  }

  // ユーザー情報の取得
  public static function getUser($u_id){
    debugFunction::debug('ユーザー情報を取得します。');
    //例外処理
    try {
      // DBへ接続(dbConnect()内は主に接続情報をまとめている)
      $dbh = dbConnect();

      // SQL文作成
      $sql = 'SELECT * FROM users  WHERE id = :u_id';
      $data = array(':u_id' => $u_id);

      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh, $sql, $data);
      // クエリ成功の場合
      if($stmt){
        debugFunction::debug('クエリ成功。');
      }else{
        debugFunction::debug('クエリに失敗しました。');
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
    // クエリ結果のデータを返却
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }



// 画像処理(後半のバリ関係の処理がまだイマイチなのでも少し詰める)
public static function uploadImg($file, $key){
  debugFunction::debug('画像アップロード処理開始');
  debugFunction::debug('ファイル情報：'.print_r($file,true));

  //isset関数は対象変数内に値があるかつnullでは無い事を確認する関数。
  //is_intは整数型かどうか確認するための関数。
  if (isset($file['error']) && is_int($file['error'])) {
    try {
      // バリデーション
      // $file['error'] の値を確認。
      //「UPLOAD_ERR_OK」などの定数はphpでファイルアップロード時に自動的に定義される。定数には値として0や1などの数値が入っている。
      switch ($file['error']) {
          case UPLOAD_ERR_OK: // OK
              break;
          case UPLOAD_ERR_NO_FILE: // ファイル未選択の場合
            debugFunction::debug('ファイルが選択されていません');
//          case UPLOAD_ERR_INI_SIZE:  // php.ini規定の画像サイズを越した場合
//          case UPLOAD_ERR_FORM_SIZE: // フォーム定義の画像サイズ超した場合
//              debug('ファイルサイズが大きすぎます');
          default: // その他の場合
              ('その他のエラーが発生しました');
      }


      //============ここから

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

      debugFunction::debug('ファイルは正常にアップロードされました');
      debugFunction::debug('ファイルパス：'.$path);
      return $path;

    } catch (RuntimeException $e) {

      debugFunction::debug($e->getMessage());
      global $err_msg;
      $err_msg[$key] = $e->getMessage();

    }
  }
}
}
?>
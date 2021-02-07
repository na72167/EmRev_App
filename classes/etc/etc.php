<?php

  namespace classes\etc;
  //php側で予め定義されているクラスを別クラス内で使いたい場合はuseで宣言しておく。
  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
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

  //画像表示用関数
  public static function showImg($path){
    // 画像情報があるか確認
    if(empty($path)){
      //ない場合
      return 'images/sample-img.png';
    }else{
      //ある場合
      return $path;
    }
  }

  //お気に入り関係の処理
  public static function isLike($u_id, $r_id){
    debugFunction::debug('お気に入り情報があるか確認します。');
    debugFunction::debug('ユーザーID：'.$u_id);
    debugFunction::debug('個別レビューID：'.$r_id);
    //例外処理
    try {
      // DBへ接続
      $dbh = new dbConnectPDO();
      // SQL文作成
      // ログインユーザーがお気に入り対象としたレビューが以前登録したかを確認。
      $sql = 'SELECT * FROM review_likes WHERE favorite_recode = :r_id AND user_id = :u_id';
      $data = array(':u_id' => $_SESSION['user_id'], ':r_id' => $r_id);
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // レコードがあるか確認
      if($stmt->rowCount()){
        debugFunction::debug('お気に入りです');
        return true;
      }else{
        debugFunction::debug('特に気に入ってません');
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
}

  //認証キー生成
  //$chars変数内の62文字の中からランダムで8文字選ぶ。
  public static function makeRandKey($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789';
    $str = '';
    for ($i = 0; $i < $length; ++$i) {
        $str .= $chars[mt_rand(0, 61)];
    }
    return $str;
  }

  // ==============メール送信=================
  public static function sendMail($from, $to, $subject, $comment){
    //送信に必要な情報が一通り揃っているか
    if(!empty($to) && !empty($subject) && !empty($comment)){
        //文字化けしないように設定（お決まりパターン）
        mb_language("Japanese"); //現在使っている言語を設定する
        mb_internal_encoding("UTF-8"); //内部の日本語をどうエンコーディング（機械が分かる言葉へ変換）するかを設定

        //メールを送信（送信結果はtrueかfalseで返ってくる）
        $result = mb_send_mail($to, $subject, $comment, "From: ".$from);
        //送信結果を判定
        if ($result) {
          debugFunction::debug('メールを送信しました。');
        } else {
          debugFunction::debug('【エラー発生】メールの送信に失敗しました。');
        }
    }
  }


// 画像処理(後半のバリ関係の処理がまだイマイチなのでも少し詰める)
public static function uploadImg($file, $key){
  debugFunction::debug('画像アップロード処理開始');
  // print_rの第二引数にtrueを指定すると出力要素が文字列になる。
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
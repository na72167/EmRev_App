<?php
  //名前空間を使うとPDOクラスへのアクセスが上手くいかなくなる為
  //このファイルのみrequireで読み込み事にする。

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
?>
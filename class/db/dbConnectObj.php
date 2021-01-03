<?php
  namespace classFolder\db\dbConnectProp;

  class dbConnectProp{
    //DBへの接続準備
    const dsn = 'mysql:dbname=EmRevDB;host=localhost:8889;charset=utf8';
    const user = 'root';
    const password = 'root';
    const options = array(
      // SQL実行失敗時にはエラーコードのみ設定
      PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
      // デフォルトフェッチモードを連想配列形式に設定
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
      // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
      PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    );

    //PDOオブジェクト生成
    //$thisでキーを引っ張ってきた段階で対象オブジェクトがキーを保持しているか確認。
    function dbConnectProperty(){
      return new PDO(dsn, user, password,options);
    }
  }
?>
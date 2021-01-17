<?php

  namespace classes\db;
  //PDOクラスを参照したい場合はuseで宣言する。
  //(PDO自体はphp5.1.0以降だと初めから定義されている。)
  use \PDO;
  use \RuntimeException;
  use \Exception;

  class dbConnectPDO{
      //DB接続情報関係をまとめたプロパティ
      const dsn = 'mysql:dbname=EmRevDB;host=localhost:8889;charset=utf8';
      const username = 'root';
      const password = 'root';
      const driver_options = array(
        // SQL実行失敗時にはエラーコードのみ設定
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT,
        // デフォルトフェッチモードを連想配列形式に設定
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // バッファードクエリを使う(一度に結果セットをすべて取得し、サーバー負荷を軽減)
        // SELECTで得た結果に対してもrowCountメソッドを使えるようにする
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
      );

    // PDOを使う為にコンストラクタ内で定義している。
    // https://teratail.com/questions/84055
    public function __construct(){
      $this->pdo = new PDO(self::dsn,self::username,self::password,self::driver_options);
    }

    // ============getter関数============
    public function getPDO(){
      return $this->pdo;
    }
  }
?>
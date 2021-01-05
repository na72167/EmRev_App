<?php
  namespace classes\db;

  class dbConnectFunction{
    protected $dbh;
    protected $sql;
    protected $data;

    public function __construct($dbh,$sql,$data){
      $this->dbh = $dbh;
      $this->sql = $sql;
      $this->data = $data;
    }

    //SQL実行関数
    public static function queryPost($dbh, $sql, $data){
      //クエリー作成
      $stmt = $dbh->prepare($sql);
      //プレースホルダに値をセットし、SQL文を実行
      $stmt->execute($data);
      return $stmt;
    }

    // dbh取得用getter
    public function getDbh(){
      return $this->dbh;
    }

    // sql取得用getter
    public function getSql(){
      return $this->sql;
    }

    // data取得用getter
    public function getData(){
      return $this->data;
    }
  }

?>
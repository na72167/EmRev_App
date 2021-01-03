<?php
  namespace classFolder\db\dbConnect;

  class dbConnect{
    private $dbh;
    private $sql;
    private $data;

    function __construct($dbh,$sql,$data){
      $this->dbh = $dbh;
      $this->sql = $sql;
      $this->data = $data;
    }

    //SQL実行関数
    function queryPost($dbh, $sql, $data){
      //クエリー作成
      $stmt = $dbh->prepare($sql);
      //プレースホルダに値をセットし、SQL文を実行
      $stmt->execute($data);
      return $stmt;
    }
  }
?>
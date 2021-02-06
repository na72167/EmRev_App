<?php

  namespace classes\msg;

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\debug\debugFunction;
  use classes\etc\etc;
  use classes\validate\validation;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;

  class directMessageSearch extends validation{

    protected $searchName;
    protected $err_msSearchName;

    //=========コンストラクタ=========
    public function __construct($searchName,$err_msSearchName){
      $this->searchName = $searchName;
      $this->err_msSearchName = $err_msSearchName;
    }

    //=========setter=========
    public function setSearchName($str){
      //未入力チェック
      $this->validRequired($str,'err_msSearchName');
      //最大文字数チェック
      $this->validMaxLen($str,'err_msSearchName');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      if(empty($this->err_msSearchName)){
        $this->searchName = etc::sanitize($str);
      }
    }

    //=========getter=========
    public function getSearchName(){
      return $this->searchName;
    }

    public function getErr_msSearchName(){
      return $this->err_msMsg;
    }

    public function getErr_msAll():?array{
      return [$this->err_msMsg];
    }
  }
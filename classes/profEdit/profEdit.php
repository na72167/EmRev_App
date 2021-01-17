<?php
  namespace classes\profEdit;
  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\validate\validation;
  use classes\debug\debugFunction;
  use classes\etc\etc;

  class profEdit extends validation{

    protected $userName;
    protected $age;
    protected $tel;
    protected $zip;
    protected $addr;
    protected $profImg;
    protected $err_msUsername;
    protected $err_msTel;
    protected $err_msAddr;
    protected $err_msZip;
    protected $err_msAge;

    public function __construct($userName,$age,$tel,$zip,$addr,$profImg,$err_msUsername,$err_msTel,$err_msAddr,$err_msZip,$err_msAge){
      $this->userName = $userName;
      $this->age = $age;
      $this->tel = $tel;
      $this->zip = $zip;
      $this->addr = $addr;
      $this->profImg = $profImg;
      $this->err_msUsername = $err_msUsername;
      $this->err_msTel = $err_msTel;
      $this->err_msAddr = $err_msAddr;
      $this->err_msZip = $err_msZip;
      $this->err_msAge = $err_msAge;
    }

    // =======setter関数=======

    public function setUserName($str){
      //名前の最大文字数チェック
      $this->validMaxLen($str, 'err_msUsername');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      //フォーム内の値に問題が合っても入力フォーム内に再表示させたいので初期化はさせない。
      if(empty($this->err_msUsername)){
        $this->userName = etc::sanitize($str);
      }
    }

    public function setTel($str){
      //名前の最大文字数チェック
      $this->validTel($str, 'err_msTel');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      //フォーム内の値に問題が合っても入力フォーム内に再表示させたいので初期化はさせない。
      if(empty($this->err_msTel)){
        $this->tel = etc::sanitize($str);
      }
    }

    public function setAddr($str){
      // 住所の長さチェック
      $this->validMaxLen($str, 'err_msAddr');
      if(empty($this->err_msAddr)){
        $this->addr = etc::sanitize($str);
      }
    }

    public function setZip($str){
    //郵便番号形式チェック
      $this->validZip($str, 'err_msZip');
      if(empty($this->err_msZip)){
        $this->zip = etc::sanitize($str);
      }
    }

    public function setAge($str){
      //年齢の最大文字数チェック
      $this->validMaxLen($str, 'err_msAge');
      //年齢の半角数字チェック
      $this->validNumber($str, 'err_msAge');
      if(empty($this->err_msAge)){
        $this->age = etc::sanitize($str);
      }
    }

    public function setProfImg($str){
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      if(empty($this->$_FILES['pic']['error'])){
        $this->profImg = etc::sanitize($str);
      }
    }


    // =======getter関数=======
    public function getUserName(){
      return $this->userName;
    }

    public function getAge(){
      return $this->age;
    }

    public function getTel(){
      return $this->tel;
    }

    public function getZip(){
      return $this->zip;
    }

    public function getAddr(){
      return $this->addr;
    }

    public function getProfImg(){
      return $this->profEdit;
    }
  }


?>
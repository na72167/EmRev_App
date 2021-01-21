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
    protected $err_msProfImg;

    public function __construct($userName,$age,$tel,$zip,$addr,$profImg,$err_msUsername,$err_msTel,$err_msAddr,$err_msZip,$err_msAge,$err_msProfImg){
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
      $this->err_msProfImg = $err_msProfImg;
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
        $this->tel = (int)etc::sanitize($str);
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
        $this->zip = (int)etc::sanitize($str);
      }
    }

    public function setAge($str){
      //年齢の最大文字数チェック
      $this->validMaxLen($str, 'err_msAge');
      //年齢の半角数字チェック
      $this->validNumber($str, 'err_msAge');
      if(empty($this->err_msAge)){
        $this->age = (int)etc::sanitize($str);
      }
    }

    public function setProfImg($str){
      //$_FILESに挿入した際にバリテーションが一通り入るので
      //ここでは特にしない。
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      if(empty($this->$_FILES['pic']['error'])){
        $this->profImg = etc::sanitize($str);
      }
    }

    // =======getter関数=======

    public function getUserName():?string{
      return $this->userName;
    }

    public function getAge():?string{
      return $this->age;
    }

    public function getTel():?string{
      return $this->tel;
    }

    public function getZip():?string{
      return $this->zip;
    }

    public function getAddr():?string{
      return $this->addr;
    }

    public function getProfImg():?string{
      return $this->profEdit;
    }



    public function getErr_msUsername():?string{
      return $this->err_msUsername;
    }

    public function getErr_msTel():?string{
      return $this->err_msTel;
    }

    public function getErr_msAddr():?string{
      return $this->err_msAddr;
    }

    public function getErr_msZip():?string{
      return $this->err_msZip;
    }

    public function getErr_msAge():?string{
      return $this->err_msAge;
    }

    public function getErr_msAll():?array{
      return [$this->err_msUsername,$this->err_msTel,$this->err_msAddr,$this->err_msZip,$this->err_msAge];
    }
  }


?>
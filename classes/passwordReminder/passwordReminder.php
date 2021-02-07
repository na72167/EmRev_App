<?php

  namespace classes\passwordReminder;

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\etc\etc;
  use classes\validate\validation;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;

  class passwordReminder extends validation{

    // これを参考にerr_msプロパティ内を連想配列形式で管理できるか確認する。companyAndReviewSearch
    // (これができないとエラー文が一つしか保持できない。)
    // https://qiita.com/ucan-lab/items/6decbe9cdf674ad11c8d#comments

    //=========送信内容を管理する為のプロパティ群=========
    //err_msについては指定したインスタンス内プロパティに対して連想配列形式で
    //データを挿入する方法を見つけ次第まとめる。
    //==試したこと==
    //1.コンストラクタ内で変数に管理用ネーム(?)を指定して$thisで引っ張っきてエラー文挿入。->キー部分の保持ができない。
    //2.コンストラクタ内での割り振りはせずに変数のままで用意。$thisで呼び出したのち、連想配列形式で挿入。->やり方が悪いせいか
    //配列内に別の配列ができてしまい、管理が面倒になった。(挿入先の変数名と挿入データの変数を合わせても✗)。
    //3.別ファイルにエラーメッセージ管理用変数を用意。バリ関数内でグローバル宣言をして管理する。
    //->他機能を追加時にバグの温床になりそうなので✗。
    //現在は各エラーメッセージ毎に切り分けている

    protected $email;
    protected $token;
    protected $password;
    protected $err_msPass;
    protected $err_msToken;
    protected $err_msEmail;
    protected $err_msCommon;

    //=========コンストラクタ=========
    public function __construct($email,$token,$password,$err_msPass,$err_msToken,$err_msEmail,$err_msCommon){
      $this->email = $email;
      $this->token = $token;
      $this->pass = $password;
      $this->err_msPass = $err_msPass;
      $this->err_msToken = $err_msToken;
      $this->err_msEmail = $err_msEmail;
      $this->err_msCommon = $err_msCommon;
    }

    //=========setter=========
    public function setEmail($str):void{
      //emailの未入力チェック
      $this->validRequired($str,'err_msEmail');
      //emailの形式チェック
      $this->validEmail($str,'err_msEmail');
      //email最大文字数チェック
      $this->validMaxLenEmail($str,'err_msEmail');
      //重複チェック
      // $this->validEmailDup($str);
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      //フォーム内の値に問題が合っても入力フォーム内に再表示させたいので初期化はさせない。
      if(empty($this->err_msEmail)){
        $this->email = etc::sanitize($str);
      }
    }

    public function setToken($str):void{
      //未入力チェック
      $this->validRequired($str,'err_msToken');
      //固定長チェック
      $this->validLength($str,'err_msToken');
      //半角チェック
      $this->validHalf($str,'err_msToken');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      //フォーム内の値に問題が合っても入力フォーム内に再表示させたいので初期化はさせない。
      if(empty($this->err_msToken)){
        $this->token = etc::sanitize($str);
      }
    }

    public function setPass($str){
      //未入力チェック
      $this->validRequired($str,'err_msPass');
      //パスワードの半角英数字チェック
      $this->validHalf($str,'err_msPass');
      //最大文字数チェック
      $this->validMaxLen($str,'err_msPass');
      //最小文字数チェック
      $this->validMinLen($str,'err_msPass');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      if(empty($this->err_msPass)){
        $this->pass = etc::sanitize($str);
      }
    }

    // 共通エラーメッセージ挿入用セッター
    public function setErr_msCommon(string $str):void{
      //エラーメッセージの挿入
      $this->err_msCommon = $str;
    }

  //=========getter=========

  // email情報取得用ゲッター
  public function getEmail(){
    return $this->email;
  }

  // トークン取得専用エラーメッセージ取得ゲッター
  public function getToken(){
    return $this->token;
  }

  // パスワード入力取得ゲッター
  public function getPass(){
    return $this->pass;
  }

  // email専用エラーメッセージ取得ゲッター
  public function getErr_msEmail(){
    return $this->err_msEmail;
  }

  // トークン取得専用エラーメッセージ取得ゲッター
  public function getErr_msToken(){
    return $this->err_msToken;
  }

  // パスワード用エラーメッセージ取得ゲッター
  public function getErr_msPass(){
    return $this->err_msPass;
  }

  // 共通エラーメッセージ取得ゲッター
  public function getCommonErr_ms(){
    return $this->err_msCommon;
  }

  // エラーメッセージ一括取得用ゲッター
  public function getErr_ms():?array{
    return [$this->err_msEmail,$this->err_msToken,$this->err_msCommon];
  }

}
?>
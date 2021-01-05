<?php
  namespace classes\admin;
  use classes\etc\etc;
  use classes\traits\validation;

class signup{

  //ユーザー登録関係のエラーやサクセスメッセージ関係
  //クラス内で完結させたい為,defineでは無くconstを使う。
  // =========エラーメッセージ関係=========
  const ERROR_MS_01 = '入力必須です';
  const ERROR_MS_02 = 'Emailの形式で入力してください';
  const ERROR_MS_03 = 'パスワード(再入力)が合っていません';
  const ERROR_MS_04 = '半角英数字のみご利用いただけます';
  const ERROR_MS_05 = '6文字以上で入力してください';
  const ERROR_MS_06 = '256文字以内で入力してください';
  const ERROR_MS_07 = 'エラーが発生しました。しばらく経ってからやり直してください。';
  const ERROR_MS_08 = 'そのEmailはすでに登録されています';
  const ERROR_MS_09 = '31文字以内で入力してください';

  // =========サクセスメッセージ関係=========
  const SUCCESS_MS_01 = '31文字以内で入力してください';
  const SUCCESS_MS_02 = '退会しました';

  //=========送信内容を管理する為のプロパティ群=========
  protected $email;
  protected $pass;
  protected $password_re;
  protected $err_ms = array();

  //=========生成オブジェクト毎に変数を管理できる様にするコンストラクタ。=========
  public function __construct($email, $pass, $password_re,$err_ms) {
    $this->email = $email;
    $this->pass = $pass;
    $this->password_re = $password_re;
    $this->err_ms = $err_ms;
  }

  // =====getter=====

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させることができる

  //アクセス修飾子関係でvalidation::~にエラーが発生した際,trait「validation」をクラスに変更のち
  //$thisでいけるか確認。

  public function setEmail($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'email');
    //emailの形式チェック
    $this->err_ms = validation::validEmail($str, 'email');
      //email最大文字数チェック
    $this->err_ms = validation::validMaxLenEmail($str, 'email');
    //重複チェック
    // $this->err_ms = validation::validEmailDup($str);
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_ms)){
      $this->email = etc::sanitize($str);
    }
  }

  // password挿入用セッター
  public function setPass($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'pass');
    //パスワードの半角英数字チェック
    $this->err_ms = validation::validHalf($str, 'pass');
    //最大文字数チェック
    $this->err_ms = validation::validMaxLen($str, 'pass');
    //最小文字数チェック
    $this->err_ms = validation::validMinLen($str, 'pass');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_ms)){
      $this->pass = etc::sanitize($str);
    }
  }

  // password(再入力)挿入用セッター
  public function setPass_re($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'pass_re');
    //最大文字数チェック
    $this->err_ms = validation::validMaxLen($str, 'pass_re');
    //最小文字数チェック
    $this->err_ms = validation::validMinLen($str, 'pass_re');
    //再入力分のチェック
    $this->err_ms = validation::validMatch($str,$this->pass,'pass_re');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_ms)){
      $this->pass_re = etc::sanitize($str);
    }
  }

  // エラーメッセージ挿入用セッター
  public function setErr_ms($str){
    //エラーメッセージの挿入
    $this->err_ms = $str;
  }

  // =====setter=====

  // email情報取得用ゲッター
  public function getEmail(){
    return $this->email;
  }

  // パスワード情報取得用ゲッター
  public function getPass(){
    return $this->pass;
  }

  // パスワード情報(再入力)取得用ゲッター
  public function getPass_re(){
    return $this->password_re;
  }

  // エラーメッセージ取得用ゲッター
  public function getErr_ms(){
    return $this->err_ms;
  }

}
?>
<?php
  namespace classFolder\admin\signup;
  use classFolder\db\validation;

class signup extends dbConnect{

  // =========サクセスメッセージ関係=========
  const SUCCESS_MS_01 = '31文字以内で入力してください';
  const SUCCESS_MS_02 = '退会しました';

  //=========送信内容を管理する為のプロパティ群=========
  private $email;
  private $pass;
  private $password_re;
  private $err_ms = array();

  //=========生成オブジェクト毎に変数を管理できる様にするコンストラクタ。=========
  private function __construct($email, $pass, $password_re,$err_ms) {
    $this->email = $email;
    $this->pass = $pass;
    $this->password_re = $password_re;
    $this->err_ms = $err_ms;
  }

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させることができる
  private function setEmail($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'email');
    //emailの形式チェック
    $this->err_ms = validation::validEmail($str, 'email');
      //email最大文字数チェック
    $this->err_ms = validation::validMaxLenEmail($str, 'email');
    //重複チェック
    // $this->err_ms = validEmailDup($str);
  }

  // password挿入用セッター
  private function setPass($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'pass');
    //パスワードの半角英数字チェック
    $this->err_ms = validation::validHalf($str, 'pass');
    //最大文字数チェック
    $this->err_ms = validation::validMaxLen($str, 'pass');
    //最小文字数チェック
    $this->err_ms = validation::validMinLen($str, 'pass');
  }

  // password(再入力)挿入用セッター
  private function setPass_re($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'pass_re');
    //最大文字数チェック
    $this->err_ms = validation::validMaxLen($str, 'pass_re');
    //最小文字数チェック
    $this->err_ms = validation::validMinLen($str, 'pass_re');
    //再入力分のチェック
    $this->err_ms = validation::validMatch($str,$this->pass,'pass_re');
  }

  // email情報取得用ゲッター
  private function getEmail(){
    return $this->email;
  }

  // パスワード情報取得用ゲッター
  private function getPass(){
    return $this->pass;
  }

  // パスワード情報(再入力)取得用ゲッター
  private function getPass_re(){
    return $this->password_re;
  }

  // エラーメッセージ取得用ゲッター
  private function getErr_ms(){
    return $this->err_ms;
  }

}
?>
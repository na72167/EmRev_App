<?php

  namespace classes\admin\login;
  use classes\etc\etc;
  use classes\traits\validation;

  class login{

    // エラーメッセージの内容は基本変わらないので定数でまとめる。
    const ERROR_MS_01 = '入力必須です';
    const ERROR_MS_02 = 'Emailの形式で入力してください';
    const ERROR_MS_03 = 'パスワード(再入力)が合っていません';
    const ERROR_MS_04 = '半角英数字のみご利用いただけます';
    const ERROR_MS_05 = '6文字以上で入力してください';
    const ERROR_MS_06 = '256文字以内で入力してください';
    const ERROR_MS_07 = 'エラーが発生しました。しばらく経ってからやり直してください。';
    const ERROR_MS_08 = 'そのEmailはすでに登録されています';
    const ERROR_MS_09 = '31文字以内で入力してください';

    //=========送信内容を管理する為のプロパティ群=========
    //インスタンス内プロパティは基本変更前提のものなので、変数でまとめる。
    //クラス内で完結させたいのでアクセス修飾子は今の所protectedにする。
    protected $loginEmail;
    protected $loginPass;
    protected $loginPassSave;
    //エラーメッセージの配列はユーザー登録機能ののモノと共有して扱う為,あえて接頭辞を付けてない.

  //=========生成オブジェクト毎に変数を管理できる様にするコンストラクタ。=========
  public function __construct($loginEmail,$loginPass,$loginPassSave,$err_ms) {
    $this->loginEmail = $loginEmail;
    $this->loginPass = $loginPass;
    $this->loginPassSave = $loginPassSave;
  }

  // =====setter=====

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させることができる


  // アクセス修飾子関係でvalidation::~にエラーが発生した際,trait「validation」をクラスに変更のち
  // $thisでいけるか確認。

  // ===========メールアドレスのバリテーション=============
  //email未入力チェック
  //email形式チェック
  //email最大文字数チェック

  public function setLoginEmail($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'login-email');
    //emailの形式チェック
    $this->err_ms = validation::validEmail($str, 'login-email');
      //email最大文字数チェック
    $this->err_ms = validation::validMaxLenEmail($str, 'login-email');
    //重複チェック
    // $this->err_ms = validation::validEmailDup($str);
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_ms)){
      $this->loginEmail = etc::sanitize($str);
    }
  }


  // ===========パスワードのバリテーション=============
  //未入力チェック
  //パスワード半角英数字チェック
  //パスワードの最大文字数チェック
  //パスワードの最小文字数チェック

  // password挿入用セッター
  public function setLoginPass($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'login-pass');
    //パスワードの半角英数字チェック
    $this->err_ms = validation::validHalf($str, 'login-pass');
    //最大文字数チェック
    $this->err_ms = validation::validMaxLen($str, 'login-pass');
    //最小文字数チェック
    $this->err_ms = validation::validMinLen($str, 'login-pass');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_ms)){
      $this->loginPass = etc::sanitize($str);
    }
  }

  // ログイン時間延長用セッター(予備用。インスタンス生成時点でpost内情報を元にtrueかfalseが挿入される予定なので)
  // 生成時にアクセス修飾子が影響する事が判明した際にこの予備セッターを扱うようにする。)
  public function setLoginPassSave($str){
    //延長情報の挿入
    $this->loginPassSave = $str;
  }

  // エラーメッセージ挿入用セッター
  public function setErr_ms($str){
    //エラーメッセージの挿入
    $this->err_ms = $str;
  }



  // =====getter=====

  // ログインemail情報取得用ゲッター
  public function getLoginEmail(){
    return $this->loginEmail;
  }

  // ログインパスワード情報取得用ゲッター
  public function getLoginPass(){
    return $this->loginPass;
  }

  // ログイン時間延長用ゲッター
  public function getLoginPassSave(){
    return $this->loginPassSave;
  }

  // エラーメッセージ取得用ゲッター
  public function getErr_ms(){
    return $this->err_ms;
  }

}
?>
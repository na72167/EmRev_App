<?php

  declare(strict_types=1);
  namespace classes\admin;
  use classes\validate\validation;
  use classes\etc\etc;

  class login extends validation{

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
    protected $err_msEmail;
    protected $err_msPass;
    protected $err_msCommon;

  //=========生成オブジェクト毎に変数を管理できる様にするコンストラクタ。=========
  public function __construct($loginEmail,$loginPass,$loginPassSave,$err_msEmail,$err_msPass,$err_msCommon) {
    $this->loginEmail = $loginEmail;
    $this->loginPass = $loginPass;
    $this->loginPassSave = $loginPassSave;
    $this->err_msEmail = $err_msEmail;
    $this->err_msPass = $err_msPass;
    $this->err_msCommon = $err_msCommon;
  }


  // =====setter=====

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させることができる
  // アクセス修飾子関係でvalidation::~にエラーが発生した際,trait「validation」をクラスに変更のち
  // $thisでいけるか確認。

  // ===========メールアドレスのバリテーション=============

  public function setLoginEmail($str){
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
      $this->loginPass = etc::sanitize($str);
    }
  }

  // ログイン時間延長用セッター(予備用。インスタンス生成時点でpost内情報を元にtrueかfalseが挿入される予定なので)
  // 生成時にアクセス修飾子が影響する事が判明した際にこの予備セッターを扱うようにする。)
  public function setLoginPassSave($str){
    //延長情報の挿入
    $this->loginPassSave = $str;
  }

  // 共通エラーメッセージ挿入用セッター
  public function setErr_msCommon($str){
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
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

  // エラーメッセージ一括取得用ゲッター
  public function getErr_ms():?array{
    return [$this->err_msEmail,$this->err_msPass,$this->err_msCommon];
  }

  //Email用エラーメッセージ取得ゲッター
  public function getEmailErr_ms(){
    return $this->err_msEmail;
  }

  //パスワード用エラーメッセージ取得ゲッター
  public function getPassErr_ms(){
    return $this->err_msPass;
  }

  //共通エラーメッセージ取得用ゲッター
  public function getCommonErr_ms(){
    return $this->err_msCommon;
  }

}
?>
<?php
  namespace classes\admin;
  use classes\validate\validation;
  use classes\etc\etc;

class signup{

  // これを参考にerr_msプロパティ内を連想配列形式で管理できるか確認する。
  // (これができないとエラー文が一つしか保持できない。)
  // https://qiita.com/ucan-lab/items/6decbe9cdf674ad11c8d#comments

  //=========送信内容を管理する為のプロパティ群=========
  protected $email;
  protected $pass;
  protected $password_re;
  public $err_ms;

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
  //$this->でいけるか確認。
  //↑アクセスするプロパティがprivate以上でも実行メソッドがプロパティと同一クラス内ならその中で別クラスのメソッドを呼んで戻り値を
  //用意しても大丈夫っぽい。

  //$thisオンリーだとそのインスタンス内で保持しているプロパティ群が処理対象になる。
  public function setEmail($str){
    //未入力チェック
    $this->err_ms = validation::validRequired($str, 'email');
    // //emailの形式チェック
    // $this->err_ms = validation::validEmail($str, 'email');
    //   //email最大文字数チェック
    // $this->err_ms = validation::validMaxLenEmail($str, 'email');
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
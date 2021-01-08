<?php
  namespace classes\admin;
  use classes\etc\etc;
  use classes\validate\validation;

class signup extends validation{

  // これを参考にerr_msプロパティ内を連想配列形式で管理できるか確認する。
  // (これができないとエラー文が一つしか保持できない。)
  // https://qiita.com/ucan-lab/items/6decbe9cdf674ad11c8d#comments

  //=========送信内容を管理する為のプロパティ群=========
  protected $email;
  protected $pass;
  protected $password_re;
  protected $err_ms;

  //=========コンストラクタ=========
  public function __construct($email, $pass, $password_re) {
    $this->email = $email;
    $this->pass = $pass;
    $this->password_re = $password_re;
  }

  // =====setter=====

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させてる。
  //アクセスするプロパティがprivate以上でも実行メソッドがプロパティと同一クラス内ならその中で別クラスのメソッドを呼んで戻り値を
  //用意しても大丈夫っぽい。
  //$thisオンリーだとそのインスタンス内で保持しているプロパティ群が処理対象になる。


  //バリテーションの流れとしては
  //継承した親クラスvalidationから各バリ関数を呼び出す。
  //その関数内からプロパティ$err_msを引っ張ってきて問題が合った場合setter関数の第二引数に合わせたキーとともに直接エラーメッセージを代入する。

  public function setEmail($str){
    //emailの未入力チェック
    $this->validRequired($str,'email');
    //emailの形式チェック
    $this->validEmail($str,'email');
    // //email最大文字数チェック
    $this->validMaxLenEmail($str,'email');
    // //重複チェック
    // validation::validEmailDup($str);

    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->$err_ms['email'])){
      $this->email = etc::sanitize($str);
    }
  }

  // // password挿入用セッター
  public function setPass($str){
    //未入力チェック
    $this->validRequired($str,'pass');
    //パスワードの半角英数字チェック
    $this->validHalf($str,'pass');
    //最大文字数チェック
    $this->validMaxLen($str,'pass');
    //最小文字数チェック
    $this->validMinLen($str,'pass');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->$err_ms['pass'])){
      $this->pass = etc::sanitize($str);
    }
  }

  // password(再入力)挿入用セッター
  public function setPass_re($str){
    //未入力チェック
    $this->validRequired($str,'pass_re');
    // //最大文字数チェック
    $this->validMaxLen($str,'pass_re');
    // //最小文字数チェック
    $this->validMinLen($str,'pass_re');
    // //再入力分のチェック
    $this->validMatch($str,'pass_re',$this->pass);
    // //上のバリテーション処理を行い,エラーメッセージが無い場合
    // //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->$err_ms['pass_re'])){
      $this->pass_re = etc::sanitize($str);
    }
  }

  // エラーメッセージ挿入用セッター
  public function setErr_ms($str){
    //エラーメッセージの挿入
    $this->err_ms = $str;
  }

  // =====getter=====

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

  // エラーメッセージ一括取得用ゲッター
  public function getErr_ms(){
    return $this->$err_ms;
  }

}
?>
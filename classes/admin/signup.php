<?php

  namespace classes\admin;
  use classes\etc\etc;
  use classes\validate\validation;

class signup extends validation{

  // これを参考にerr_msプロパティ内を連想配列形式で管理できるか確認する。
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
  protected $pass;
  protected $password_re;
  protected $err_msEmail;
  protected $err_msPass;
  protected $err_msPassRe;
  protected $err_msCommon;


  //=========コンストラクタ=========
  public function __construct($email, $pass, $password_re,$err_msEmail,$err_msPass,$err_msPassRe,$err_msCommon){
    $this->email = $email;
    $this->pass = $pass;
    $this->password_re = $password_re;
    $this->err_msEmail = $err_msEmail;
    $this->err_msPass = $err_msPass;
    $this->err_msPassRe = $err_msPassRe;
    $this->err_msCommon = $err_msCommon;
  }

  // =====setter=====

  // email挿入用セッター
  // セッターを使うことで、直接代入させずにバリデーションチェックを行ってから代入させてる。
  //アクセスするプロパティがprivate以上でも実行メソッドがプロパティと同一クラス内ならその中で別クラスのメソッドを呼んで戻り値を
  //用意しても大丈夫っぽい。
  //$thisオンリーだとそのインスタンス内で保持しているプロパティ群が処理対象になる。


  //バリテーションの流れとしては
  //継承した親クラスvalidationから各バリ関数を呼び出す。
  //その関数内から各フォームに合わせたプロパティを引っ張ってきて,問題が合った場合第二引数で指定したプロパティに沿ってエラー文を挿入する。

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

  // password挿入用セッター
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

  // password(再入力)挿入用セッター
  public function setPass_re($str){
    //未入力チェック
    $this->validRequired($str,'err_msPassRe');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msPassRe');
    //最小文字数チェック
    $this->validMinLen($str,'err_msPassRe');
    //再入力分のチェック
    $this->validMatch($str,'err_msPassRe',$this->pass);
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msPassRe)){
      $this->pass_re = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str){
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  // =====getter=====

  // id情報取得用ゲッター
  public function getId(){
    return $this->id;
  }

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

  //エラーメッセージ取得用ゲッター

  // email専用エラーメッセージ取得ゲッター
  public function getEmailErr_ms(){
    return $this->err_msEmail;
  }

  // パスワード専用エラーメッセージ取得ゲッター
  public function getPassErr_ms(){
    return $this->err_msPass;
  }

  // パスワード(再入力)専用エラーメッセージ取得ゲッター
  public function getPassReErr_ms(){
    return $this->err_msPassRe;
  }

  // 共通エラーメッセージ取得ゲッター
  public function getCommonErr_ms(){
    return $this->err_msCommon;
  }

  // エラーメッセージ一括取得用ゲッター
  public function getErr_ms():?array{
    return [$this->err_msEmail,$this->err_msPass,$this->err_msPassRe,$this->err_msCommon];
  }
}
?>
<?php

  namespace classes\reviewRegister;
  use classes\etc\etc;
  use classes\validate\validation;

class reviewRegisterJw extends validation{

  protected $image_gap;
  protected $rewarding_work;
  protected $strengths_and_weaknesses;
  protected $annual_income_salary;
  protected $business_outlook;
  protected $err_msImage_gap;
  protected $err_msRewarding_work;
  protected $err_msStrengths_and_weaknesses;
  protected $err_msAnnual_income_salary;
  protected $err_msBusiness_outlook;
  protected $err_msCommon;

  public function __construct($image_gap,$rewarding_work,$strengths_and_weaknesses,
  $annual_income_salary,$business_outlook,$err_msImage_gap,$err_msRewarding_work,
  $err_msStrengths_and_weaknesses,$err_msAnnual_income_salary,$err_msBusiness_outlook,$err_msCommon){
    $this->image_gap = $image_gap;
    $this->rewarding_work = $rewarding_work;
    $this->strengths_and_weaknesses = $strengths_and_weaknesses;
    $this->annual_income_salary = $annual_income_salary;
    $this->business_outlook = $business_outlook;

    $this->err_msImage_gap = $err_msImage_gap;
    $this->err_msRewarding_work = $err_msRewarding_work;
    $this->err_msStrengths_and_weaknesses = $err_msStrengths_and_weaknesses;
    $this->err_msAnnual_income_salary = $err_msAnnual_income_salary;
    $this->err_msBusiness_outlook = $err_msBusiness_outlook;
    $this->err_msCommon = $err_msCommon;
  }

  // =====setter=====

  //入社前とのギャップ用セッター
  public function setImage_gap($str){
    //未入力チェック
    $this->validRequired($str,'err_msImage_gap');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msImage_gap');
    //最小文字数チェック
    $this->validMinLen($str,'err_msImage_gap');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msImage_gap)){
      $this->image_gap = etc::sanitize($str);
    }
  }

 //働きがい用セッター
  public function setRewarding_work($str){
    //未入力チェック
    $this->validRequired($str,'err_msRewarding_work');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msRewarding_work');
    //最小文字数チェック
    $this->validMinLen($str,'err_msRewarding_work');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msRewarding_work)){
      $this->rewarding_work = etc::sanitize($str);
    }
  }

 //強み・弱み用セッター
  public function setStrengths_and_weaknesses($str){
    //未入力チェック
    $this->validRequired($str,'err_msStrengths_and_weaknesses');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msStrengths_and_weaknesses');
    //最小文字数チェック
    $this->validMinLen($str,'err_msStrengths_and_weaknesses');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msStrengths_and_weaknesses)){
      $this->strengths_and_weaknesses = etc::sanitize($str);
    }
  }

 //年収・給与用セッター
  public function setAnnual_income_salary($str){
    //未入力チェック
    $this->validRequired($str,'err_msAnnual_income_salary');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msAnnual_income_salary');
    //最小文字数チェック
    $this->validMinLen($str,'err_msAnnual_income_salary');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msAnnual_income_salary)){
      $this->annual_income_salary = etc::sanitize($str);
    }
  }

 //事業展望用セッター
  public function setBusiness_outlook($str){
    //未入力チェック
    $this->validRequired($str,'err_msBusiness_outlook');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msBusiness_outlook');
    //最小文字数チェック
    $this->validMinLen($str,'err_msBusiness_outlook');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msBusiness_outlook)){
      $this->business_outlook = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str){
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  // =====getter=====

  // 入社前とのギャップ用ゲッター
  public function getImage_gap(){
    return $this->image_gap;
  }

  // 働きがい用ゲッター
  public function getRewarding_work(){
    return $this->rewarding_work;
  }

  // 強み・弱い用ゲッター
  public function getStrengths_and_weaknesses(){
    return $this->strengths_and_weaknesses;
  }

  // 年収・給与用ゲッター
  public function getAnnual_income_salary(){
    return $this->annual_income_salary;
  }

  // 事業展望用ゲッター
  public function getBusiness_outlook(){
    return $this->business_outlook;
  }

  // 入社前とのギャップ用エラーメッセージゲッター
  public function getErr_msImage_gap(){
    return $this->err_msImage_gap;
  }

  // 働きがい用エラーメッセージゲッター
  public function getErr_msRewarding_work(){
    return $this->err_msRewarding_work;
  }

  // 強み・弱み用エラーメッセージゲッター
  public function getErr_msStrengths_and_weaknesses(){
    return $this->err_msStrengths_and_weaknesses;
  }

  // 年収・給与用エラーメッセージゲッター
  public function getErr_msAnnual_income_salary(){
    return $this->err_msAnnual_income_salary;
  }

  // 事業展望用エラーメッセージゲッター
  public function getErr_msBusiness_outlook(){
    return $this->err_msBusiness_outlook;
  }

  // エラー一括取得用ゲッター
  public function getErr_msAll():?array{
    return [$this->err_msImage_gap,$this->err_msRewarding_work,
    $this->err_msStrengths_and_weaknesses,$this->err_msAnnual_income_salary,
    $this->err_msBusiness_outlook];
  }
}
?>
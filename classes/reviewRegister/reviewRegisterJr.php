<?php

namespace classes\reviewRegister;
use classes\etc\etc;
use classes\validate\validation;

class reviewRegisterJr extends validation{
  protected $joining_route;
  protected $enrollment_status;
  protected $occupation;
  protected $position;
  protected $enrollment_period;
  protected $employment_status;
  protected $welfare_office_environment;
  protected $working_hours;
  protected $err_msJoining_route;
  protected $err_msEnrollment_status;
  protected $err_msOccupation;
  protected $err_msPosition;
  protected $err_msEnrollment_period;
  protected $err_msEmployment_status;
  protected $err_msWelfare_office_environment;
  protected $err_msWorking_hours;

  public function __construct($joining_route,$enrollment_status,$occupation,$position,$enrollment_period,
  $employment_status,$welfare_office_environment,$working_hours,$err_msJoining_route,$err_msEnrollment_status,
  $err_msOccupation,$err_msPosition,$err_msEnrollment_period,$err_msEmployment_status,
  $err_msWelfare_office_environment,$err_msWorking_hours){
    $this->joining_route = $joining_route;
    $this->enrollment_status = $enrollment_status;
    $this->occupation = $occupation;
    $this->position = $position;
    $this->enrollment_period = $enrollment_period;
    $this->employment_status = $employment_status;
    $this->welfare_office_environment = $welfare_office_environment;
    $this->working_hours = $working_hours;

    $this->err_msJoining_route = $err_msJoining_route;
    $this->err_msEnrollment_status = $err_msEnrollment_status;
    $this->err_msOccupation = $err_msOccupation;
    $this->err_msPosition = $err_msPosition;
    $this->err_msEnrollment_period = $err_msEnrollment_period;
    $this->err_msEmployment_status = $err_msEmployment_status;
    $this->err_msWelfare_office_environment = $err_msWelfare_office_environment;
    $this->err_msWorking_hours = $err_msWorking_hours;
  }

  //入社経路用セッター用セッター
  public function setJoining_route($str){
    //未入力チェック
    $this->validRequired($str,'err_msJoining_route');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msJoining_route');
    //最小文字数チェック
    $this->validMinLen($str,'err_msJoining_route');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msJoining_route)){
      $this->joining_route = etc::sanitize($str);
    }
  }

  //在籍時の職種用セッター
  public function setOccupation($str){
    //未入力チェック
    $this->validRequired($str,'err_msOccupation');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msOccupation');
    //最小文字数チェック
    $this->validMinLen($str,'err_msOccupation');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msOccupation)){
      $this->occupation = etc::sanitize($str);
    }
  }

  //在籍時の役職用セッター
  public function setPosition($str){
    //未入力チェック
    $this->validRequired($str,'err_msPosition');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msPosition');
    //最小文字数チェック
    $this->validMinLen($str,'err_msPosition');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msPosition)){
      $this->position = etc::sanitize($str);
    }
  }

  //在籍期間用セッター
  public function setEnrollment_period($str){
    //未入力チェック
    $this->validRequired($str,'err_msEnrollment_period');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msEnrollment_period');
    //最小文字数チェック
    $this->validMinLen($str,'err_msEnrollment_period');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msEnrollment_period)){
      $this->enrollment_period = etc::sanitize($str);
    }
  }

   //在籍状況用セッター
  public function setEnrollment_status($str){
    //未入力チェック
    $this->validRequired($str,'err_msEnrollment_status');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msEnrollment_status');
    //最小文字数チェック
    $this->validMinLen($str,'err_msEnrollment_status');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msEnrollment_status)){
      $this->enrollment_status = etc::sanitize($str);
    }
  }

   //雇用形態用セッター
  public function setEmployment_status($str){
    //未入力チェック
    $this->validRequired($str,'err_msEmployment_status');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msEmployment_status');
    //最小文字数チェック
    $this->validMinLen($str,'err_msEmployment_status');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msEmployment_status)){
      $this->employment_status = etc::sanitize($str);
    }
  }

  // 福利厚生・オフィス環境用セッター
  public function setWelfare_office_environment($str){
    //未入力チェック
    $this->validRequired($str,'err_msWelfare_office_environment');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msWelfare_office_environment');
    //最小文字数チェック
    $this->validMinLen($str,'err_msWelfare_office_environment');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msWelfare_office_environment)){
      $this->welfare_office_environment = etc::sanitize($str);
    }
  }

  // 勤務時間用セッター
  public function setWorking_hours($str){
    //未入力チェック
    $this->validRequired($str,'err_msWorking_hours');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msWorking_hours');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msWorking_hours)){
      $this->working_hours = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str){
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  // =====getter=====

  // 入社経路用ゲッター
  public function getJoining_route(){
    return $this->joining_route;
  }

  // 在籍状況用ゲッター
  public function getEnrollment_status(){
    return $this->enrollment_status;
  }

  // 在籍時の職種用ゲッター
  public function getOccupation(){
    return $this->occupation;
  }

  // 在籍時の役職用ゲッター
  public function getPosition(){
    return $this->position;
  }

  // 在籍期間用ゲッター
  public function getEnrollment_period(){
    return $this->enrollment_period;
  }

  // 雇用形態取得用ゲッター
  public function getEmployment_status(){
    return $this->employment_status;
  }

  // 福利厚生・オフィス環境取得用ゲッター
  public function getWelfare_office_environment(){
    return $this->welfare_office_environment;
  }

  // 勤務時間取得用ゲッター
  public function getWorking_hours(){
    return $this->working_hours;
  }


  // 入社経路用エラーメッセージゲッター
  public function getJoining_routeErr_ms(){
    return $this->err_msJoining_route;
  }

  // 在籍時の職種用エラーメッセージゲッター
  public function getOccupationErr_ms(){
    return $this->err_msOccupation;
  }

  // 在籍時の役職用エラーメッセージゲッター
  public function getPositionErr_ms(){
    return $this->err_msPosition;
  }

  // 在籍期間用エラーメッセージゲッター
  public function getEnrollment_periodErr_ms(){
    return $this->err_msEsnrollment_period;
  }

  // 雇用形態取得用エラーメッセージゲッター
  public function getEmployment_statusErr_ms(){
    return $this->err_msEmployment_status;
  }

  // 福利厚生・オフィス環境取得用エラーメッセージゲッター
  public function getWelfare_office_environmentErr_ms(){
    return $this->err_msWelfare_office_environment;
  }

  // 勤務時間取得用エラーメッセージゲッター
  public function getWorking_hoursErr_ms(){
    return $this->err_msWorking_hours;
  }

  // エラーメッセージ一括取得ゲッター
  public function getErr_msAll():?array{
    return [$this->err_msJoining_route,$this->err_msEnrollment_status,
    $this->err_msOccupation,$this->err_msPosition,
    $this->err_msEnrollment_period,$this->err_msEmployment_status,
    $this->err_msWelfare_office_environment,$this->err_msWorking_hours];
  }
}
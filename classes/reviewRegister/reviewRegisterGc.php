<?php

  namespace classes\reviewRegister;
  use classes\etc\etc;
  use classes\validate\validation;

class reviewRegisterGc extends validation{

  protected $general_estimation_title;
  protected $general_estimation;
  protected $err_msGeneral_estimation_title;
  protected $err_msGeneral_estimation;
  protected $err_msCommon;

  public function __construct($general_estimation_title,$general_estimation,
  $err_msGeneral_estimation_title,$err_msGeneral_estimation,$err_msCommon){
    $this->general_estimation_title = $general_estimation_title;
    $this->general_estimation = $general_estimation;
    $this->err_msGeneral_estimation_title = $err_msGeneral_estimation_title;
    $this->err_msGeneral_estimation = $err_msGeneral_estimation;
    $this->err_msCommon = $err_msCommon;
  }

  // =====setter=====

  //総評タイトル用セッター
  public function setGeneral_estimation_title(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msGeneral_estimation_title');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msGeneral_estimation_title');
    //最小文字数チェック
    $this->validMinLen($str,'err_msGeneral_estimation_title');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msGeneral_estimation_title)){
      $this->general_estimation_title = etc::sanitize($str);
    }
  }

  //総評用セッター
  public function setGeneral_estimation(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msGeneral_estimation');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msGeneral_estimation');
    //最小文字数チェック
    $this->validMinLen($str,'err_msGeneral_estimation');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msGeneral_estimation)){
      $this->general_estimation = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str):void{
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  // =====getter=====

  // 総評タイトル用エラーメッセージゲッター
  public function getGeneral_estimation_title():?string{
    return $this->general_estimation_title;
  }

  // 総評用エラーメッセージゲッター
  public function getGeneral_estimation():?string{
    return $this->general_estimation;
  }

  // 総評タイトル用エラーメッセージゲッター
  public function getGeneral_estimation_titleErr_ms():?string{
    return $this->err_msGeneral_estimation_title;
  }

  // 総評用エラーメッセージゲッター
  public function getGeneral_estimationErr_ms():?string{
    return $this->err_msGeneral_estimation;
  }

  // エラーメッセージ一括取得用ゲッター
  public function getErr_msAll():?array{
    return [$this->err_msGeneral_estimation_title,
    $this->err_msGeneral_estimation];
  }
}
?>
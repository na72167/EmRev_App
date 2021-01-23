<?php

  namespace classes\reviewRegister;
  use classes\etc\etc;
  use classes\validate\validation;

  class reviewRegisterCc extends validation{
    protected $in_company_system;
    protected $corporate_culture;
    protected $holiday;
    protected $organizational_structure;
    protected $ease_of_work_for_women;
    protected $err_msIn_company_system;
    protected $err_msCorporate_culture;
    protected $err_msHoliday;
    protected $err_msOrganizational_structure;
    protected $err_msEase_of_work_for_women;
    protected $err_msCommon;

    public function __construct($in_company_system,$corporate_culture,$holiday,
    $organizational_structure,$ease_of_work_for_women,$err_msIn_company_system,
    $err_msCorporate_culture,$err_msHoliday,$err_msOrganizational_structure,$err_msEase_of_work_for_women
    ,$err_msCommon){
      $this->in_company_system = $in_company_system;
      $this->corporate_culture = $corporate_culture;
      $this->holiday = $holiday;
      $this->organizational_structure = $organizational_structure;
      $this->ease_of_work_for_women = $ease_of_work_for_women;
      $this->err_msIn_company_system = $err_msIn_company_system;
      $this->err_msCorporate_culture = $err_msCorporate_culture;
      $this->err_msHoliday = $err_msHoliday;
      $this->err_msOrganizational_structure = $err_msOrganizational_structure;
      $this->err_msEase_of_work_for_women = $err_msEase_of_work_for_women;
      $this->err_msCommon = $err_msCommon;
    }

    // =====setter=====

    //社内制度用セッター
  public function setIn_company_system(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msIn_company_system');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msIn_company_system');
    //最小文字数チェック
    $this->validMinLen($str,'err_msIn_company_system');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msIn_company_system)){
      $this->in_company_system = etc::sanitize($str);
    }
  }

  //企業文化用セッター
  public function setCorporate_culture(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msCorporate_culture');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msCorporate_culture');
    //最小文字数チェック
    $this->validMinLen($str,'err_msCorporate_culture');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msCorporate_culture)){
      $this->corporate_culture = etc::sanitize($str);
    }
  }

//休暇用セッター用セッター
  public function setHoliday(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msHoliday');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msHoliday');
    //最小文字数チェック
    $this->validMinLen($str,'err_msHoliday');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msHoliday)){
      $this->holiday = etc::sanitize($str);
    }
  }

//組織体制用セッター用セッター
  public function setOrganizational_structure(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msOrganizational_structure');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msOrganizational_structure');
    //最小文字数チェック
    $this->validMinLen($str,'err_msOrganizational_structure');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msOrganizational_structure)){
      $this->organizational_structure = etc::sanitize($str);
    }
  }

//女性の働きやすさ用セッター用セッター
  public function setEase_of_work_for_women(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msEase_of_work_for_women');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msEase_of_work_for_women');
    //最小文字数チェック
    $this->validMinLen($str,'err_msEase_of_work_for_women');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msEase_of_work_for_women)){
      $this->ease_of_work_for_women = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str):void{
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  // =====getter=====

    // 社内制度用ゲッター
    public function getIn_company_system():?string{
      return $this->in_company_system;
    }

    // 企業文化用ゲッター
    public function getCorporate_culture():?string{
      return $this->corporate_culture;
    }

    // 休暇用ゲッター
    public function getHoliday():?string{
      return $this->holiday;
    }

    // 組織体制用ゲッター
    public function getOrganizational_structure():?string{
      return $this->organizational_structure;
    }

    // 女性の働きやすさ用ゲッター
    public function getEase_of_work_for_women():?string{
      return $this->ease_of_work_for_women;
    }

    // 社内制度用エラーメッセージゲッター
    public function getErr_msIn_company_system():?string{
      return $this->err_msIn_company_system;
    }

    // 企業文化用エラーメッセージゲッター
    public function getErr_msCorporate_culture():?string{
      return $this->err_msCorporate_culture;
    }

    // 休暇用エラーメッセージゲッター
    public function getErr_msHoliday():?string{
      return $this->err_msHoliday;
    }

    // 組織体制用エラーメッセージゲッター
    public function getErr_msOrganizational_structure():?string{
      return $this->err_msOrganizational_structure;
    }

    // 女性の働きやすさ用エラーメッセージゲッター
    public function getErr_msEase_of_work_for_women():?string{
      return $this->err_msEase_of_work_for_women;
    }

  // エラーメッセージ一括取得ゲッター
  public function getErr_msAll():?array{
    return [$this->err_msIn_company_system,$this->err_msCorporate_culture,$this->err_msHoliday,$this->err_msHoliday,
    $this->err_msHoliday,$this->err_msEase_of_work_for_women];
  }
}
?>
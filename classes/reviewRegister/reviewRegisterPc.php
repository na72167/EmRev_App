<?php

  namespace classes\reviewRegister;
  use classes\etc\etc;
  use classes\validate\validation;

class reviewRegisterPc extends validation{
  protected $joining_route;
  protected $enrollment_status;
  protected $occupation;
  protected $position;
  protected $enrollment_period;
  protected $employment_status;
  protected $welfare_office_environment;
  protected $working_hours;
  protected $in_company_system;
  protected $corporate_culture;
  protected $holiday;
  protected $organizational_structure;
  protected $ease_of_work_for_women;
  protected $image_gap;
  protected $rewarding_work;
  protected $strengths_and_weaknesses;
  protected $annual_income_salary;
  protected $business_outlook;
  protected $general_estimation_title;
  protected $general_estimation;
  protected $company_id;

  protected $err_msJoining_route;
  protected $err_msEnrollment_status;
  protected $err_msOccupation;
  protected $err_msPosition;
  protected $err_msEnrollment_period;
  protected $err_msEmployment_status;
  protected $err_msWelfare_office_environment;
  protected $err_msWorking_hours;
  protected $err_msIn_company_system;
  protected $err_msCorporate_culture;
  protected $err_msHoliday;
  protected $err_msOrganizational_structure;
  protected $err_msEase_of_work_for_women;
  protected $err_msImage_gap;
  protected $err_msRewarding_work;
  protected $err_msStrengths_and_weaknesses;
  protected $err_msAnnual_income_salary;
  protected $err_msBusiness_outlook;
  protected $err_msGeneral_estimation_title;
  protected $err_msGeneral_estimation;
  protected $err_msCommon;

  public function __construct($joining_route,$enrollment_status,$occupation,$position,$enrollment_period,
  $employment_status,$welfare_office_environment,$working_hours,$in_company_system,$corporate_culture,$holiday,
  $organizational_structure,$ease_of_work_for_women,$image_gap,$rewarding_work,$strengths_and_weaknesses,
  $annual_income_salary,$business_outlook,$general_estimation_title,$general_estimation,$company_id,$err_msJoining_route,$err_msEnrollment_status,
  $err_msOccupation,$err_msPosition,$err_msEnrollment_period,$err_msEmployment_status,
  $err_msWelfare_office_environment,$err_msWorking_hours,$err_msIn_company_system,
  $err_msCorporate_culture,$err_msHoliday,$err_msOrganizational_structure,$err_msEase_of_work_for_women,$err_msImage_gap,$err_msRewarding_work,
  $err_msStrengths_and_weaknesses,$err_msAnnual_income_salary,$err_msBusiness_outlook,$err_msGeneral_estimation_title,$err_msGeneral_estimation,$err_msCommon){
    $this->joining_route = $joining_route;
    $this->enrollment_status = $enrollment_status;
    $this->occupation = $occupation;
    $this->position = $position;
    $this->enrollment_period = $enrollment_period;
    $this->employment_status = $employment_status;
    $this->welfare_office_environment = $welfare_office_environment;
    $this->working_hours = $working_hours;
    $this->in_company_system = $in_company_system;
    $this->corporate_culture = $corporate_culture;
    $this->holiday = $holiday;
    $this->organizational_structure = $organizational_structure;
    $this->ease_of_work_for_women = $ease_of_work_for_women;
    $this->image_gap = $image_gap;
    $this->rewarding_work = $rewarding_work;
    $this->strengths_and_weaknesses = $strengths_and_weaknesses;
    $this->annual_income_salary = $annual_income_salary;
    $this->business_outlook = $business_outlook;
    $this->general_estimation_title = $general_estimation_title;
    $this->general_estimation = $general_estimation;
    $this->company_id = $company_id;

    $this->err_msJoining_route = $err_msJoining_route;
    $this->err_msEnrollment_status = $err_msEnrollment_status;
    $this->err_msOccupation = $err_msOccupation;
    $this->err_msPosition = $err_msPosition;
    $this->err_msEnrollment_period = $err_msEnrollment_period;
    $this->err_msEmployment_status = $err_msEmployment_status;
    $this->err_msWelfare_office_environment = $err_msWelfare_office_environment;
    $this->err_msWorking_hours = $err_msWorking_hours;
    $this->err_msIn_company_system = $err_msIn_company_system;
    $this->err_msCorporate_culture = $err_msCorporate_culture;
    $this->err_msHoliday = $err_msHoliday;
    $this->err_msOrganizational_structure = $err_msOrganizational_structure;
    $this->err_msEase_of_work_for_women = $err_msEase_of_work_for_women;
    $this->err_msImage_gap = $err_msImage_gap;
    $this->err_msRewarding_work = $err_msRewarding_work;
    $this->err_msStrengths_and_weaknesses = $err_msStrengths_and_weaknesses;
    $this->err_msAnnual_income_salary = $err_msAnnual_income_salary;
    $this->err_msBusiness_outlook = $err_msBusiness_outlook;
    $this->err_msGeneral_estimation_title = $err_msGeneral_estimation_title;
    $this->err_msGeneral_estimation = $err_msGeneral_estimation;
    $this->err_msCommon = $err_msCommon;
  }

  // =====setter=====

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

  //会社識別用IDセッター
  public function setCompany_id(int $str):void{
    $this->company_id = etc::sanitize($str);
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

  //在籍状況用ゲッター
  public function getEnrollment_status(){
    return $this->enrollment_status;
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

  // 総評タイトル用ゲッター
  public function getGeneral_estimation_title():?string{
    return $this->general_estimation_title;
  }

  // 総評用ゲッター
  public function getGeneral_estimation():?string{
    return $this->general_estimation;
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
    return $this->err_msEnrollment_period;
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
    return [$this->err_msJoining_route,$this->err_msEnrollment_status,
    $this->err_msOccupation,$this->err_msPosition,
    $this->err_msEnrollment_period,$this->err_msEmployment_status,
    $this->err_msWelfare_office_environment,$this->err_msWorking_hours,
    $this->err_msIn_company_system,$this->err_msCorporate_culture,$this->err_msHoliday,$this->err_msHoliday,
    $this->err_msHoliday,$this->err_msEase_of_work_for_women,
    $this->err_msImage_gap,$this->err_msRewarding_work,
    $this->err_msStrengths_and_weaknesses,$this->err_msAnnual_income_salary,
    $this->err_msBusiness_outlook,$this->err_msGeneral_estimation_title,
    $this->err_msGeneral_estimation
  ];
  }
}
?>
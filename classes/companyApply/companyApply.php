<?php

namespace classes\companyApply;
use classes\etc\etc;
use classes\validate\validation;
use Webmozart\Assert\Mixin;

class companyApply extends validation{
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

  protected $representative;
  protected $location;
  protected $industry;
  protected $year_of_establishment;
  protected $listed_year;
  protected $number_of_employees;
  protected $average_annual_income;
  protected $average_age;

  protected $err_msRepresentative;
  protected $err_msLocation;
  protected $err_msIndustry;
  protected $err_msYear_of_establishment;
  protected $err_msListed_year;
  protected $err_msNumber_of_employees;
  protected $err_msAverage_annual_income;
  protected $err_msAverage_age;
  protected $err_msCommon;

  //=========コンストラクタ=========
  public function __construct($representative,$location,$industry,$year_of_establishment,$listed_year,$number_of_employees,$average_annual_income,$average_age,$err_msRepresentative
  ,$err_msLocation,$err_msIndustry,$err_msYear_of_establishment,$err_msListed_year,$err_msNumber_of_employees,$err_msAverage_annual_income,$err_msAverage_age,$err_msCommon){
    $this->representative = $representative;
    $this->location = $location;
    $this->industry = $industry;
    $this->year_of_establishment = $year_of_establishment;
    $this->listed_year = $listed_year;
    $this->number_of_employees = $number_of_employees;
    $this->average_annual_income = $average_annual_income;
    $this->average_age = $average_age;

    $this->err_msRepresentative = $err_msRepresentative;
    $this->err_msLocation = $err_msLocation;
    $this->err_msIndustry = $err_msIndustry;
    $this->err_msYear_of_establishment = $err_msYear_of_establishment;
    $this->err_msListed_year = $err_msListed_year;
    $this->err_msNumber_of_employees = $err_msNumber_of_employees;
    $this->err_msAverage_annual_income = $err_msAverage_annual_income;
    $this->err_msAverage_age = $err_msAverage_age;
    $this->err_msCommon = $err_msCommon;
  }

  //===============setter関数関係=================

  // 代表者情報挿入用セッター
  public function setRepresentative(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msRepresentative');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msRepresentative');
    //最小文字数チェック
    $this->validMinLen($str,'err_msRepresentative');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msRepresentative)){
      $this->representative = etc::sanitize($str);
    }
  }

  // 所在地情報挿入用セッター
  public function setLocation(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msLocation');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msLocation');
    //最小文字数チェック
    $this->validMinLen($str,'err_msLocation');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msLocation)){
      $this->Location = etc::sanitize($str);
    }
  }

  // 業界情報挿入用セッター
  public function setIndustry(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msIndustry');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msIndustry');
    //最小文字数チェック
    $this->validMinLen($str,'err_msIndustry');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msIndustry)){
      $this->Industry = etc::sanitize($str);
    }
  }

  // 設立年度情報挿入用セッター
  public function setYearOfEstablishment(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msYear_of_establishment');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msYear_of_establishment');
    //最小文字数チェック
    $this->validMinLen($str,'err_msYear_of_establishment');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msYear_of_establishment)){
      $this->year_of_establishment = etc::sanitize($str);
    }
  }

  // 上場年情報挿入用セッター
  public function setListed_year(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msRepresentative');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msRepresentative');
    //最小文字数チェック
    $this->validMinLen($str,'err_msRepresentative');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msListed_year)){
      $this->listed_year = etc::sanitize($str);
    }
  }

  // 従業員数情報挿入用セッター
  public function setNumberOfEmployees(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msNumber_of_employees');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msNumber_of_employees');
    //最小文字数チェック
    $this->validMinLen($str,'err_msNumber_of_employees');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msNumber_of_employees)){
      $this->number_of_employees = etc::sanitize($str);
    }
  }

  // 平均年収情報挿入用セッター
  public function setAverageAnnualIncome(int $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msNumber_of_employees');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msNumber_of_employees');
    //最小文字数チェック
    $this->validMinLen($str,'err_msNumber_of_employees');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msNumber_of_employees)){
      $this->number_of_employees = etc::sanitize($str);
    }
  }

  // 平均年齢情報挿入用セッター
  public function setAverageAge(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msAverage_age');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msAverage_age');
    //最小文字数チェック
    $this->validMinLen($str,'err_msAverage_age');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msAverage_age)){
      $this->average_age = etc::sanitize($str);
    }
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str):void{
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  //===============getter関数関係=================

  public function getRepresentative():string{
    return $this->representative;
  }

  public function getLocation():string{
    return $this->location;
  }

  public function getIndustry():string{
    return $this->industry;
  }

  public function getYearOfEstablishment():string{
    return $this->year_of_establishment;
  }

  public function getListed_year():string{
    return $this->listed_year;
  }

  public function getNumber_of_employees():string{
    return $this->number_of_employees;
  }

  public function getAverage_annual_income():int{
    return $this->average_annual_income;
  }

  public function getAverage_age():string{
    return $this->average_age;
  }

  public function getErr_msRepresentative():string{
    return $this->err_msRepresentative;
  }

  public function getErr_msLocation():string{
    return $this->err_msLocation;
  }

  public function getErr_msIndustry():string{
    return $this->err_msIndustry;
  }

  public function getErr_msYear_of_establishment():string{
    return $this->err_msYear_of_establishment;
  }

  public function getErr_msListed_year():int{
    return $this->err_msListed_year;
  }

  public function getErr_msNumber_of_employees():int{
    return $this->err_msNumber_of_employees;
  }

  public function getErr_msAverage_age():int{
    return $this->err_msAverage_age;
  }

  public function getErr_msCommon():string{
    return $this->err_msCommon;
  }

  public function getErr_msAll(){
    return [$this->err_msRepresentative,$this->err_msLocation,$this->err_msIndustry,
    $this->err_msYear_of_establishment,$this->err_msListed_year,$this->err_msNumber_of_employees,$this->err_msAverage_age,$this->err_msCommon];
  }
}

?>
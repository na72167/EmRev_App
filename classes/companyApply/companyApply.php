<?php

namespace classes\companyApply;

use \PDO;
use \RuntimeException;
use \Exception;
use classes\debug\debugFunction;
use classes\etc\etc;
use classes\validate\validation;
use classes\db\dbConnectFunction;
use classes\db\dbConnectPDO;
use Webmozart\Assert\Mixin;

class companyApply extends validation{
  // これを参考にerr_msプロパティ内を連想配列形式で管理できるか確認する。companyAndReviewSearch
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

  protected $company_name;
  protected $representative;
  protected $location;
  protected $industry;
  protected $year_of_establishment;
  protected $listed_year;
  protected $number_of_employees;
  protected $average_annual_income;
  protected $average_age;
  protected $number_of_reviews;

  protected $err_msCompany_name;
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
  public function __construct($company_name,$representative,$location,$industry,$year_of_establishment,$listed_year,$number_of_employees,$average_annual_income,$average_age,$number_of_reviews,
  $err_msCompany_name,$err_msRepresentative,$err_msLocation,$err_msIndustry,$err_msYear_of_establishment,$err_msListed_year,$err_msNumber_of_employees,$err_msAverage_annual_income,$err_msAverage_age,$err_msCommon){
    $this->company_name = $company_name;
    $this->representative = $representative;
    $this->location = $location;
    $this->industry = $industry;
    $this->year_of_establishment = $year_of_establishment;
    $this->listed_year = $listed_year;
    $this->number_of_employees = $number_of_employees;
    $this->average_annual_income = $average_annual_income;
    $this->average_age = $average_age;
    $this->number_of_reviews = $number_of_reviews;

    $this->err_msCompany_name = $err_msCompany_name;
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


  //===============会社情報出力関係=================companySearchBrowsingHistor

  // 一連の会社情報を取得するメソッド
  // 削除予定(接頭辞のgetはミス)
  public static function getCompanyProp(){
    //例外処理
    try {
      //接続情報をまとめたクラス
      $dbh = new dbConnectPDO();
      //SQL文作成(user情報一覧取得)
      //ON句は結合条件を指定するもの。今回の場合だとuserテーブル内のidカラムとemployee_profsテーブルの
      //user_idテーブルのuser_idカラム内のレコードがWHERE句で当てはまった値(session['user_id']の数字)と一緒のものを取得する。
      $sql = 'SELECT * FROM company_informations';
      $data = array();
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if($stmt){
        debugFunction::debug('クエリ成功。');
      }else{
        debugFunction::debug('クエリに失敗しました。');
      }
    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
    // 全てのクエリ結果のデータを返却
    // 最初に条件に当てはまった物のみ返す場合はfetch
    // https://kinocolog.com/pdo_fetch_pattern/
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  //$span内の数字は総ページ数を割り出す為のもの。
  //10個のレコード毎に1ページで想定している。
  public static function companyPropListDefault($span = 10){
    debugFunction::debug('会社情報を取得します。');
    //例外処理
    try {

      //接続情報をまとめたクラス
      $dbh = new dbConnectPDO();
      // 会社情報を降順で取得するSQL文作成
      $sql = 'SELECT * FROM company_informations ORDER BY id DESC';
      $data = array();
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      if($stmt){
        // クエリ結果のデータを全レコードを格納
        $rst['compDate'] = $stmt->fetchAll();
        // 取得したレコード数をカウント。その数字を
        // totalキーを割り振って挿入する。
        $rst['total'] = $stmt->rowCount(); //総レコード数
        // カウントした
        $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

        debugFunction::debug('会社情報を取得しました');
        debugFunction::debug('取得した会社情報：'.print_r($rst['compDate'],true));

        // compDate内にレコードが無い場合、
        // keyごと削除する。
        if(empty($rst['compDate'])){
          unset($rst['compDate']);
        };

        return $rst;
      }else{
        debugFunction::debug('会社情報を取得できませんでした');
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

   // =================会社情報検索メソッド=================
  public function companySearch(?array $search_prop,int $span = 10){
      //例外処理
    try {
      //接続情報をまとめたクラス
      $dbh = new dbConnectPDO();

      // 件数用のSQL文作成 AND
      $sql = 'SELECT * FROM company_informations';
      if(!empty($search_prop)){
        $i = 1;
          //配列内のキーをWHERE内の指定カラムにする。
          foreach($search_prop as $key => $value){
            debugFunction::debug('配列内：'.print_r([$key => $value],true));
            //最初のみWHEREをつける。
            if($i === 1){
              $sql .= ' WHERE '.$key.'='.'"'.$value.'"';
              $i++;
            }else{
              $sql .= ' AND '.$key.'='.'"'.$value.'"';
              $i++;
            }
          }
      }

      // 会社の順序を昇順・降順に切り替える処理
      // if(!empty($sort)){
      //   switch($sort){
      //     case 1:
      //       $sql .= ' ORDER BY price ASC';
      //       break;
      //     case 2:
      //       $sql .= ' ORDER BY price DESC';
      //       break;
      //   }
      // }

      $data = array();
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      if($stmt){
        $rst['compDate'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納
        $rst['total'] = $stmt->rowCount(); //総レコード数
        $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

        // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
        // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
        // https://qiita.com/inaling/items/349e40bf8e4334225d92
        // https://qiita.com/Quantum/items/767dba44af81d1825248
        // https://gray-code.com/php/delete-specified-value-from-array/
        // https://qiita.com/Quantum/items/767dba44af81d1825248

        // compDate内にレコードが無い場合、
        // keyごと削除する。
        if(empty($rst['compDate'])){
          unset($rst['compDate']);
        };
        return $rst;
      }else{
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

  // =================一連の会社情報と関連レビューを取得するメソッド=================
  public static function companyAndReviewPropListDefault($span = 10){
    debugFunction::debug('会社情報と関連レビュー情報を取得します。');
    //例外処理
    try {
      //接続情報をまとめたクラス
      $dbh = new dbConnectPDO();
      // 会社情報と関連レビューを降順で取得するクエリ文
      $sql = 'SELECT ci.id,ci.company_name,ci.industry,ci.location,ci.number_of_reviews,er.id,er.general_estimation_title,er.general_estimation,er.create_date
      FROM company_informations AS ci LEFT JOIN employee_reviews AS er ON ci.id = er.review_company_id WHERE ci.id = er.review_company_id ORDER BY ci.id DESC';
      $data = array();

      // 会社情報を降順で取得するクエリ文
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      if($stmt){
        // 会社情報と関連レビューのクエリ結果データを全レコード格納
        $rst['compDate'] = $stmt->fetchAll();

        // 取得したレコード数をカウント。その数字を
        // totalキーを割り振って挿入する。
        $rst['total'] = $stmt->rowCount(); //総レコード数
        $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

        debugFunction::debug('クエリで取得した会社情報と関連レビュー：'.print_r($rst['compDate'],true));

        // compDate内にレコードが無い場合、
        // keyごと削除する。
        if(empty($rst['compDate'])){
          unset($rst['compDate']);
        };

        return $rst;
      }else{
        debugFunction::debug('会社情報と関連レビューを取得できませんでした');
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

  // =================一連の会社情報と関連レビューを検索するメソッド=================
  public function companyAndReviewSearch(?array $search_prop,int $span = 10){
    //例外処理
  try {
    //接続情報をまとめたクラス
    $dbh = new dbConnectPDO();
    // 件数用のSQL文作成 AND
    $sql = 'SELECT * FROM company_informations AS ci LEFT JOIN employee_reviews AS er ON ci.id = er.review_company_id';
    if(!empty($search_prop)){
      $i = 1;
      //配列内のキーをWHERE内の指定カラムにする。
      foreach($search_prop as $key => $value){
        debugFunction::debug('配列内：'.print_r([$key => $value],true));
        //最初のみWHEREをつける。
        if($i === 1){
          $sql .= ' WHERE '.$key.'='.'"'.$value.'"';
          $i++;
        }else{
          $sql .= ' AND '.$key.'='.'"'.$value.'"';
          $i++;
        }
      }
    }

    // 会社の順序を昇順・降順に切り替える処理
    // if(!empty($sort)){
    //   switch($sort){
    //     case 1:
    //       $sql .= ' ORDER BY price ASC';
    //       break;
    //     case 2:
    //       $sql .= ' ORDER BY price DESC';
    //       break;
    //   }
    // }

    $data = array();
    // クエリ実行
    $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

    if($stmt){
      $rst['compDate'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納
      $rst['total'] = $stmt->rowCount(); //総レコード数
      $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

      // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
      // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
      // https://qiita.com/inaling/items/349e40bf8e4334225d92
      // https://qiita.com/Quantum/items/767dba44af81d1825248
      // https://gray-code.com/php/delete-specified-value-from-array/
      // https://qiita.com/Quantum/items/767dba44af81d1825248

      // compDate内にレコードが無い場合、
      // keyごと削除する。
      if(empty($rst['compDate'])){
        unset($rst['compDate']);
      };
      return $rst;
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}

  //===============閲覧履歴画面専用検索画面=================

  public function companySearchBrowsingHistory(?array $search_prop,$user_id,int $span = 10){
    //例外処理
  try {
    //接続情報をまとめたクラス
    $dbh = new dbConnectPDO();
    // 件数用のSQL文作成 AND
    $sql = 'SELECT er.id,er.id,er.employee_id,er.review_company_id,er.joining_route,er.occupation,er.position,er.enrollment_period,
    er.enrollment_status,er.employment_status,er.welfare_office_environment,er.working_hours,er.holiday,er.in_company_system,
    er.corporate_culture,er.organizational_structure,er.ease_of_work_for_women,er.rewarding_work,er.image_gap,er.business_outlook,
    er.strengths_and_weaknesses,er.annual_income_salary,er.general_estimation_title,er.general_estimation,er.like_count,
    er.delete_flg,er.create_date,er.update_date,bh.review_id,bh.user_id,bh.delete_flg, bh.browsing_history_date,bh.create_date,bh.update_date,
    ci.company_name,ci.industry,ci.company_url,ci.zip1,ci.zip2,ci.zip3,
    ci.location,ci.number_of_employees,ci.year_of_establishment,ci.representative,
    ci.listed_year,ci.average_annual_income,ci.average_age,ci.number_of_reviews,ci.delete_flg,ci.create_date,ci.update_date
    FROM browsing_historys_recodes AS bh LEFT JOIN employee_reviews as er on bh.review_id = er.id LEFT JOIN company_informations as ci
    ON er.review_company_id = ci.id WHERE bh.user_id = :u_id';

    // ORDER BY bh.browsing_history_date DESC
    if(!empty($search_prop)){
      //配列内のキーをWHERE内の指定カラムにする。
      foreach($search_prop as $key => $value){
        debugFunction::debug('配列内：'.print_r([$key => $value],true));
          $sql .= ' AND '.$key.'='.'"'.$value.'"';
        }
      }


    // 会社の順序を昇順・降順に切り替える処理
    // if(!empty($sort)){
    //   switch($sort){
    //     case 1:
    //       $sql .= ' ORDER BY price ASC';
    //       break;
    //     case 2:
    //       $sql .= ' ORDER BY price DESC';
    //       break;
    //   }
    // }

    $data = array(':u_id' => $user_id);
    // クエリ実行
    $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

    if($stmt){
      $rst['browsingHistory'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納
      $rst['total'] = $stmt->rowCount(); //総レコード数
      $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

      // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
      // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
      // https://qiita.com/inaling/items/349e40bf8e4334225d92
      // https://qiita.com/Quantum/items/767dba44af81d1825248
      // https://gray-code.com/php/delete-specified-value-from-array/
      // https://qiita.com/Quantum/items/767dba44af81d1825248

      // compDate内にレコードが無い場合、
      // keyごと削除する。
      if(empty($rst['browsingHistory'])){
        unset($rst['browsingHistory']);
      };
      return $rst;
    }else{
      return false;
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
}





  //===============setter関数関係=================

  // 会社名情報挿入用セッター
  public function setCompany_name(string $str):void{
    //未入力チェック
    $this->validRequired($str,'err_msCompany_name');
    //最大文字数チェック
    $this->validMaxLen($str,'err_msCompany_name');
    //最小文字数チェック
    $this->validMinLen($str,'err_msCompany_name');
    //上のバリテーション処理を行い,エラーメッセージが無い場合
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    if(empty($this->err_msCompany_name)){
      $this->company_name = etc::sanitize($str);
    }
  }

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
  public function setListed_year(int $str):void{
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
  public function setNumberOfEmployees(int $str):void{
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
  public function setAverageAge(int $str):void{
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

  // レビュー数情報挿入用セッター
  public function setNumber_of_reviews(int $str):void{
    //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
    $this->number_of_reviews = etc::sanitize($str);
  }

  // 共通エラーメッセージ挿入用セッター
  public function setCommonErr_ms(string $str):void{
    //エラーメッセージの挿入
    $this->err_msCommon = $str;
  }

  //===============getter関数関係=================

  public function getCompanySearchResult():?array{
    return [$this->company_name,$this->representative,$this->location,
    $this->industry,$this->year_of_establishment,$this->listed_year,
    $this->number_of_employees,$this->average_annual_income
    ,$this->average_age,$this->number_of_reviews];
  }

  public function getCompany_name():?string{
    return $this->company_name;
  }

  public function getRepresentative():?string{
    return $this->representative;
  }

  public function getLocation():?string{
    return $this->location;
  }

  public function getIndustry():?string{
    return $this->industry;
  }

  public function getYearOfEstablishment(){
    return $this->year_of_establishment;
  }

  public function getListed_year(){
    return $this->listed_year;
  }

  public function getNumber_of_employees(){
    return $this->number_of_employees;
  }

  public function getAverage_annual_income(){
    return $this->average_annual_income;
  }

  public function getAverage_age(){
    return $this->average_age;
  }

  public function getNumber_of_reviews(){
    return $this->number_of_reviews;
  }

  public function getErr_msRepresentative():?string{
    return $this->err_msRepresentative;
  }

  public function getErr_msLocation():?string{
    return $this->err_msLocation;
  }

  public function getErr_msIndustry():?string{
    return $this->err_msIndustry;
  }

  public function getErr_msYear_of_establishment():?string{
    return $this->err_msYear_of_establishment;
  }

  public function getErr_msListed_year():?int{
    return $this->err_msListed_year;
  }

  public function getErr_msNumber_of_employees():?int{
    return $this->err_msNumber_of_employees;
  }

  public function getErr_msAverage_age():?int{
    return $this->err_msAverage_age;
  }

  public function getErr_msCommon():?string{
    return $this->err_msCommon;
  }

  public function getErr_msAll():?array{
    return [$this->err_msCompany_name,$this->err_msRepresentative,$this->err_msLocation,$this->err_msIndustry,
    $this->err_msYear_of_establishment,$this->err_msListed_year,$this->err_msNumber_of_employees,$this->err_msAverage_age,$this->err_msCommon];
  }
}

?>
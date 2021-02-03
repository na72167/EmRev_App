<?php

  namespace classes\userProp;

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\validate\validation;
  use classes\debug\debugFunction;
  use classes\etc\etc;

class companyReviewContributorProp extends validation{

  //会社情報関係
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

  //ユーザー関係
  protected $id;
  protected $user_id;
  protected $username;
  protected $age;
  protected $tel;
  protected $zip;
  protected $addr;
  protected $affiliation_company;
  protected $incumbent;
  protected $currently_department;
  protected $currently_position;
  protected $dm_state;
  protected $delete_flg;
  protected $create_date;
  protected $update_date;

  //レビュー情報関係
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

  public function __construct($company_name,$representative,$location,$industry,$year_of_establishment,$listed_year,$number_of_employees,$average_annual_income,
  $average_age,$number_of_reviews,$id,$user_id,$username,$age,$tel,$zip,$addr,$affiliation_company,$incumbent,$currently_department,$currently_position,
  $dm_state,$delete_flg,$create_date,$update_date,$joining_route,$enrollment_status,$occupation,$position,$enrollment_period,$employment_status,$company_id){

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

    $this->id = $id;
    $this->user_id = $user_id;
    $this->username = $username;
    $this->age = $age;
    $this->tel = $tel;
    $this->zip = $zip;
    $this->addr = $addr;
    $this->affiliation_company = $affiliation_company;
    $this->incumbent = $incumbent;
    $this->currently_department = $currently_department;
    $this->currently_position = $currently_position;
    $this->dm_state = $dm_state;
    $this->delete_flg = $delete_flg;
    $this->create_date = $create_date;
    $this->update_date = $update_date;

    $this->joining_route = $joining_route;
    $this->enrollment_status = $enrollment_status;
    $this->occupation = $occupation;
    $this->position = $position;
    $this->enrollment_period = $enrollment_period;
    $this->employment_status = $employment_status;
    $this->company_id = $company_id;
  }

  // 所持プロパティに関係するgetter関数と
  // revliReviewListで使う
  // 取得した$GET_['id'](レビューテーブル内の個別ID)を元に
  // 関連した会社情報と投稿者ユーザーの情報を取得する処理を書く。

  // レビューIDを元に投稿ユーザーの情報とレビュー元の会社情報を取得する。
  public static function companyReviewContributorProp(int $rev_id){
    debugFunction::debug('投稿者ユーザーの情報を取得します。');
    //例外処理
    try {

      // これを書いた時一つのクエリ文にjoin句を2回使える事を知らなかったので、そのうち書き直す。
      // https://qiita.com/KentFujii/items/f25bcb5f5ca7d7db1c9c

      //レビュー情報とそれを投稿したユーザー情報を取得している。(引っ張ってくるカラムの指定周りはそのうち削る。)
      //er.idは必ず指定する(お気に入り機能の都合上)
      $dbh = new dbConnectPDO();
      $sql = 'SELECT er.id,er.employee_id,er.review_company_id,er.joining_route,er.occupation,er.position,er.enrollment_period,
      er.enrollment_status,er.employment_status,er.welfare_office_environment,er.working_hours,er.holiday,er.in_company_system,
      er.corporate_culture,er.organizational_structure,er.ease_of_work_for_women,er.rewarding_work,er.image_gap,er.business_outlook,
      er.strengths_and_weaknesses,er.annual_income_salary,er.general_estimation_title,er.general_estimation,er.like_count,
      er.delete_flg,er.create_date,er.update_date,cp.user_id,cp.username,cp.age,cp.tel,cp.zip,cp.addr,cp.affiliation_company,
      cp.incumbent,cp.currently_department,cp.currently_position,cp.dm_state,cp.delete_flg,cp.create_date,cp.update_date
      FROM employee_reviews AS er LEFT JOIN contributor_profs AS cp ON er.employee_id = cp.user_id WHERE er.id = :rev_id';
      $data = array(':rev_id' => $rev_id);
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // =======================

      //レビュー情報とそれに関連した会社情報を取得している。
      $sql2 = 'SELECT * FROM employee_reviews AS er LEFT JOIN company_informations AS ci ON er.review_company_id = ci.id WHERE er.id = :rev_id';
      $data2 = array(':rev_id' => $rev_id);
      // クエリ実行
      $stmt2 = dbConnectFunction::queryPost($dbh->getPDO(), $sql2, $data2);

      // クエリ成功の場合
      if(!empty($stmt&&$stmt2)){
        $rst['reviews'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納
        $rst['company'] = $stmt2->fetchAll();//クエリ結果のデータを全レコードを格納

        // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
        // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
        // https://qiita.com/inaling/items/349e40bf8e4334225d92
        // https://qiita.com/Quantum/items/767dba44af81d1825248
        // https://gray-code.com/php/delete-specified-value-from-array/
        // https://qiita.com/Quantum/items/767dba44af81d1825248

        return $rst;
      }else{
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

  //対象レコードのupdateカラムの更新
  public static function updateUserAndHistoryLink(int $user_id,string $review_id){
    debugFunction::debug('対象レコードの閲覧記録を更新します。');
    //例外処理
    try {

      //レビュー情報とそれを投稿したユーザー情報を取得している。
      $dbh = new dbConnectPDO();
      // SQL文作成
      $sql = 'UPDATE browsing_historys_recodes SET browsing_history_date = CURRENT_TIME() WHERE (review_id = :review_id && user_id =:user_id)';
      $data = array(':review_id' => $review_id,':user_id' => $user_id);
      debugFunction::debug('取得したdata：'.print_r($data,true));
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if($stmt){
        debugFunction::debug('対象レコードの更新時刻を変更しました。レビュー詳細画面へ続きます。');
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
    }
  }

  //閲覧履歴テーブルにログインユーザー情報と閲覧したレビューの個別IDを登録する処理。
  public static function searchUserAndHistoryLink(int $user_id,string $review_id){
      debugFunction::debug('履歴テーブルに現在ログイン中のユーザーが過去に閲覧中のレビューを見たことがあるか確認します。');
      //例外処理
      try {

        //レビュー情報とそれを投稿したユーザー情報を取得している。
        $dbh = new dbConnectPDO();
        // SQL文作成
        $sql = 'SELECT * FROM browsing_historys_recodes WHERE (review_id = :review_id && user_id =:user_id)';
        $data = array(':review_id' => $review_id,':user_id' => $user_id);
        debugFunction::debug('取得したdata：'.print_r($data,true));
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if(!empty($stmt)){
        $rst['searchResult'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納

        // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
        // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
        // https://qiita.com/inaling/items/349e40bf8e4334225d92
        // https://qiita.com/Quantum/items/767dba44af81d1825248
        // https://gray-code.com/php/delete-specified-value-from-array/
        // https://qiita.com/Quantum/items/767dba44af81d1825248

        return $rst;
      }else{
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

  //閲覧履歴テーブルにログインユーザー情報と閲覧したレビューの個別IDを登録する処理。
  public static function userAndHistoryLink(int $user_id,string $review_id){
    debugFunction::debug('履歴テーブルにログイン中ユーザーに関するレコードを追加します。');
    //例外処理
    try {

      //レビュー情報とそれを投稿したユーザー情報を取得している。
      $dbh = new dbConnectPDO();
      // SQL文作成
      $sql = 'INSERT INTO browsing_historys_recodes (`review_id`,`user_id`) VALUES(:review_id,:user_id)';
      $data = array(':review_id' => $review_id,':user_id' => $user_id);
      debugFunction::debug('取得したdata：'.print_r($data,true));
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if($stmt){
        debugFunction::debug('レビュー詳細画面へ続きます。');
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
    }
  }


  // (初期画面版)閲覧レコードとログインユーザーの個別IDを元にレビュー情報と会社情報を取得する処理。
  public static function browsingHistoryLinkcompanyReviewContributorProp(int $u_id,int $span = 10){
    debugFunction::debug('閲覧レコードとログインユーザーの個別IDを元にレビュー情報と会社情報を取得します。');
    //例外処理

    // このあとログインユーザーの個別IDとbrowsing_historys_recodesテーブルのuser_idカラムに一致した
    // employee_reviewsと会社情報を一括取得する。(並びはORDER BY update_date DESC)。

    try {
      //レビュー情報とそれを投稿したユーザー情報。レビュー対象の会社情報を取得している。
      $dbh = new dbConnectPDO();
      $sql = 'SELECT er.id,er.id,er.employee_id,er.review_company_id,er.joining_route,er.occupation,er.position,er.enrollment_period,
      er.enrollment_status,er.employment_status,er.welfare_office_environment,er.working_hours,er.holiday,er.in_company_system,
      er.corporate_culture,er.organizational_structure,er.ease_of_work_for_women,er.rewarding_work,er.image_gap,er.business_outlook,
      er.strengths_and_weaknesses,er.annual_income_salary,er.general_estimation_title,er.general_estimation,er.like_count,
      er.delete_flg,er.create_date,er.update_date,bh.review_id,bh.user_id,bh.delete_flg, bh.browsing_history_date,bh.create_date,bh.update_date,
      ci.company_name,ci.industry,ci.company_url,ci.zip1,ci.zip2,ci.zip3,
      ci.location,ci.number_of_employees,ci.year_of_establishment,ci.representative,
      ci.listed_year,ci.average_annual_income,ci.average_age,ci.number_of_reviews,ci.delete_flg,ci.create_date,ci.update_date,
      cp.user_id,cp.username,cp.age,cp.tel,cp.zip,cp.addr,cp.affiliation_company,cp.incumbent,
      cp.currently_department,cp.currently_position,cp.dm_state,cp.delete_flg,cp.create_date,cp.update_date
      FROM employee_reviews AS er LEFT JOIN browsing_historys_recodes AS bh ON er.id = bh.review_id LEFT JOIN company_informations AS ci ON er.review_company_id = ci.id LEFT JOIN contributor_profs AS cp ON er.employee_id = cp.user_id WHERE bh.user_id = :u_id ORDER BY bh.browsing_history_date DESC';
      $data = array(':u_id' => $u_id);
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

      // クエリ成功の場合
      if($stmt){

        $rst['browsingHistory'] = $stmt->fetchAll();//クエリ結果のデータを全レコードを格納
        debugFunction::debug('閲覧履歴情報：'.print_r($rst['browsingHistory'],true));

        $rst['total'] = $stmt->rowCount(); //総レコード数
        $rst['total_page'] = ceil($rst['total']/$span); //総ページ数

        // そのまま$rstに対してarray_filter()を使うと検索結果が0件の場合
        // $rst['total']内に入る0も削除されてしまうので削除するキーワードを指定する。
        // https://qiita.com/inaling/items/349e40bf8e4334225d92
        // https://qiita.com/Quantum/items/767dba44af81d1825248
        // https://gray-code.com/php/delete-specified-value-from-array/
        // https://qiita.com/Quantum/items/767dba44af81d1825248

        return $rst;
      }else{
        return false;
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
    }
  }

  // ====================getter関数=====================

  //会社情報関係
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

  //投稿者ユーザー関係
  public function getId():self{
    return $this->id;
  }

  public function getUser_id():string{
    return $this->user_id;
  }

  public function getUsername(): ?self{
    return $this->username;
  }

  public function getAge(): ?self{
    return $this->age;
  }

  public function getTel(): ?self{
    return $this->tel;
  }

  public function getZip(): ?self{
    return $this->zip;
  }

  public function getAddr(): ?self{
    return $this->addr;
  }

  public function getAffiliation_company(): ?self{
    return $this->affiliation_company;
  }

  public function getIncumbent(): ?self{
    return $this->incumbent;
  }
  public function getCurrently_department(): ?self{
    return $this->currently_department;
  }
  public function getCurrently_position(): ?self{
    return $this->currently_position;
  }
  public function getDm_state(): self{
    return $this->dm_state;
  }
  public function getDelete_flg(): self{
    return $this->delete_flg;
  }

  public function getCreate_date():self{
    return $this->create_date;
  }

  public function getUpdate_date():self{
    return $this->update_date;
  }

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
}
?>
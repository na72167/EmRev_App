<?php
  namespace classes\userProp;
  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;


  //usersテーブル内情報を取得・管理するクラス
  class generalUserProp{

    protected $id;
    protected $email;
    protected $password;
    protected $roll;
    protected $report_flg;
    protected $delete_flg;
    protected $user_id;
    protected $username;
    protected $age;
    protected $tel;
    protected $profImg;
    protected $zip;
    protected $addr;
    protected $create_date;
    protected $update_date;
    protected $err_msUsername;
    protected $err_msAge;
    protected $err_msTel;
    protected $err_msZip;
    protected $err_msAddr;
    protected $err_msCommon;

    public function __construct($id,$email,$password,$roll,$report_flg,$delete_flg,$user_id,$username,$age,$tel,$profImg,$zip,$addr,$create_date,$update_date,$err_msUsername,$err_msAge,$err_msTel,$err_msZip,$err_msAddr,$err_msCommon){
      $this->id = $id;
      $this->email = $email;
      $this->password = $password;
      $this->roll = $roll;
      $this->report_flg = $report_flg;
      $this->delete_flg = $delete_flg;
      $this->user_id = $user_id;
      $this->username = $username;
      $this->age = $age;
      $this->tel = $tel;
      $this->profImg = $profImg;
      $this->zip = $zip;
      $this->addr = $addr;
      $this->create_date = $create_date;
      $this->update_date = $update_date;
      $this->err_msUsername = $err_msUsername;
      $this->err_msAge = $err_msAge;
      $this->err_msTel = $err_msTel;
      $this->err_msZip = $err_msZip;
      $this->err_msAddr = $err_msAddr;
      $this->err_msCommon = $err_msCommon;
    }

    // ユーザーのプロフィール情報の取得
    public static function getGeneralUserProp(int $u_id){
      debugFunction::debug('一般ユーザーの情報を取得します。');
      //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        //SQL文作成(user情報一覧取得)
        //ON句は結合条件を指定するもの。今回の場合だとuserテーブル内のidカラムとemployee_profsテーブルの
        //user_idテーブルのuser_idカラム内のレコードがWHERE句で当てはまった値(session['user_id']の数字)と一緒のものを取得する。
        $sql = 'SELECT * FROM users AS u LEFT JOIN general_profs AS gp ON u.id = gp.user_id WHERE u.id = :u_id';
        $data = array(':u_id' => $u_id);
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
      // クエリ結果のデータを返却
      return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ============setter関数============
    // 共通エラーメッセージ挿入用セッター
    public function setErr_msCommon(string $str):void{
      //エラーメッセージの挿入
      $this->err_msCommon = $str;
    }

    // ============getter関数============
    //戻り値の前の?をつけるとnullableな型宣言ができる
    //https://qiita.com/hirohero/items/9e01497fe70ddce3f1c2

    public function getId():self{
      return $this->id;
    }

    public function getEmail():?string{
      return $this->email;
    }

    public function getPassword():self{
      return $this->password;
    }

    public function getRoll():self{
      return $this->roll;
    }

    public function getReport_flg():self{
      return $this->report_flg;
    }

    public function getDelete_flg():self{
      return $this->delete_flg;
    }

    public function user_id():self{
      return $this->user_id;
    }

    public function getUsername(): ?string{
      return $this->username;
    }

    public function getAge(): ?int{
      return $this->age;
    }

    public function getProfImg(): ?string{
      return $this->ProfImg;
    }

    public function getTel(): ?int{
      return $this->tel;
    }
    public function getZip(): ?int{
      return $this->zip;
    }
    public function getAddr(): ?string{
      return $this->addr;
    }

    public function getCreate_date():self{
      return $this->create_date;
    }

    public function getUpdate_date():self{
      return $this->update_date;
    }

    public function getErr_msUsername(): ?string{
      return $this->err_msUsername;
    }

    public function getErr_msAge(): ?string{
      return $this->err_msAge;
    }

    public function getErr_msTel(): ?string{
      return $this->err_msTel;
    }

    public function getErr_msZip(): ?string{
      return $this->err_msZip;
    }

    public function getErr_msAddr(): ?string{
      return $this->err_msAddr;
    }

    public function getErr_msCommon(): ?string{
      return $this->err_msCommon;
    }

  }
?>
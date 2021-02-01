<?php
  namespace classes\userProp;
  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;

  class contributorUserProp{

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
    protected $err_msCommon;

    public function __construct($id,$user_id,$username,$age,$tel,$zip,$addr,$affiliation_company,$incumbent,$currently_department,$currently_position,$dm_state,$delete_flg,$create_date,$update_date,$err_msCommon){
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
      $this->err_msCommon = $err_msCommon;
    }

    // ユーザーのプロフィール情報の取得
    public static function getContributorUserProp($u_id){
      debugFunction::debug('投稿者ユーザーの情報を取得します。');
      //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        //SQL文作成(user情報一覧取得)
        //ON句は結合条件を指定するもの。今回の場合だとuserテーブル内のidカラムとemployee_profsテーブルの
        //user_idテーブルのuser_idカラム内のレコードがWHERE句で当てはまった値(session['user_id']の数字)と一緒のものを取得する。
        $sql = 'SELECT * FROM users AS u LEFT JOIN contributor_profs AS cp ON u.id = cp.user_id WHERE u.id = :u_id';
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

  }
?>
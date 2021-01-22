<?php
  namespace classes\userProp;
  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;


  //usersテーブル内情報を取得・管理するクラス
  class userProp{

    protected $id;
    protected $email;
    protected $password;
    protected $roll;
    protected $report_flg;
    protected $delete_flg;
    protected $create_date;
    protected $update_date;

    public function __construct($id,$email,$password,$roll,$report_flg,$delete_flg,$create_date,$update_date){
      $this->id = $id;
      $this->email = $email;
      $this->password = $password;
      $this->roll = $roll;
      $this->report_flg = $report_flg;
      $this->delete_flg = $delete_flg;
      $this->create_date = $create_date;
      $this->update_date = $update_date;
    }

    // ユーザーのプロフィール情報の取得
    public static function getUserProp($u_id){
      debugFunction::debug('ユーザー情報を取得します。');
      //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        //SQL文作成(user情報一覧取得)
        $sql = 'SELECT * FROM users WHERE id = :u_id';
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

    // ============getter関数============
    public function getId(){
      return $this->id;
    }

    public function getEmail():self{
      return $this->email;
    }

    public function getPassword():self{
      return $this->password;
    }

    public function getRoll():int{
      return $this->roll;
    }

    public function getReport_flg():self{
      return $this->report_flg;
    }

    public function getDelete_flg():self{
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
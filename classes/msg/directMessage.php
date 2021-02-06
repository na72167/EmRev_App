<?php

  namespace classes\msg;

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\debug\debugFunction;
  use classes\etc\etc;
  use classes\validate\validation;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;

  class directMessage extends validation{

    protected $toUser_id;
    protected $fromUser_id;
    protected $msg;
    protected $err_msMsg;

    //=========コンストラクタ=========
    public function __construct($toUser_id,$fromUser_id,$msg,$err_msMsg){
      $this->toUser_id = $toUser_id;
      $this->fromUser_id = $fromUser_id;
      $this->msg = $msg;
      $this->err_msMsg = $err_msMsg;
    }

    //=========過去にログインユーザーと連絡相手ユーザー間で連絡を取り合った事があるか確認する処理=========
    public function searchDmHistory($partnerUser_id,$loginUser_id){
      debugFunction::debug('過去のメッセージ履歴を検索します。');
      debugFunction::debug('連絡相手の個別ID：'.$partnerUser_id);
      debugFunction::debug('ログイン中ユーザーのID：'.$loginUser_id);
        //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        // SQL文作成
        // ログイン中ユーザーと連絡相手の間で過去にやり取りがあったかを確認。
        $sql = 'SELECT `id`,`send_date`,`to_user`,`from_user`,`msg`,`delete_flg`,`create_date`,`update_date`
        FROM `dm_messages` WHERE to_user = :to_user && from_user = :from_user OR to_user = :from_user && from_user = :to_user
        ORDER BY send_date ASC';
        $data = array(':to_user' => $partnerUser_id,':from_user' => $loginUser_id);
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
        if($stmt){
          // クエリ結果の全データを返却
          //クエリ文が定義されていない物にfetchAll()をするとエラーになる。
          return $stmt->fetchAll();
        }else{
          return false;
        }
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
      }
    }

    //=========ログインユーザーに対してメッセージを送ってきたユーザーを検索する処理=========
    public function toLoginUserMsgSearch($loginUser_id){
      debugFunction::debug('ログイン中ユーザーに対してメッセージを送ったユーザーを検索します。');
      debugFunction::debug('ログイン中ユーザーID：'.$loginUser_id);
        //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        // SQL文作成
        // ログイン中ユーザーに対してメッセージを送ったユーザー情報を検索します。
        $sql = 'SELECT d_mes.id,d_mes.send_date,d_mes.to_user,d_mes.from_user,d_mes.msg,d_mes.delete_flg,d_mes.create_date,d_mes.update_date,
        cp.user_id,cp.username,cp.age,cp.tel,cp.zip,cp.addr,cp.affiliation_company,cp.incumbent,cp.currently_department,
        cp.currently_position,cp.dm_state,cp.delete_flg,cp.create_date,cp.update_date
        FROM `dm_messages` AS d_mes LEFT JOIN contributor_profs AS cp ON d_mes.from_user = cp.user_id
        WHERE to_user = :to_user ORDER BY send_date ASC';
        $data = array(':to_user' => $loginUser_id);
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
        if($stmt){
          // クエリ結果の全データを返却
          //クエリ文が定義されていない物にfetchAll()をするとエラーになる。
          return $stmt->fetchAll();
          // debugFunction::debug('ログイン中ユーザーに対してメッセージを送ったユーザー情報など：'.print_r($stmt));
          // return $stmt;
        }else{
          return false;
        }
      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
      }
    }

    //=========DM機能の検索機能用クラス=========


    //=========setter=========
    public function setMsg($str){
      //未入力チェック
      $this->validRequired($str,'err_msMsg');
      //最大文字数チェック
      $this->validMaxLen($str,'err_msMsg');
      //上のバリテーション処理を行い,エラーメッセージが無い場合
      //サニタイズ処理(全ての要素をHTML化->文字列に変更。その後対象プロパティ内を置き換える。)を行う。
      if(empty($this->err_msMsg)){
        $this->msg = etc::sanitize($str);
      }
    }

    //=========getter=========
    public function getToUser_id(){
      return $this->toUser_id;
    }

    public function getFromUser_id(){
      return $this->fromUser_id;
    }

    public function getMsg(){
      return $this->msg;
    }

    public function err_msMsg(){
      return $this->err_msMsg;
    }

    public function getErr_msAll():?array{
      return [$this->err_msMsg];
    }
  }
?>
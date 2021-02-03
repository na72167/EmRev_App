<?php
  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\companyApply\companyApply;
  use classes\profEdit\profEdit;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('Ajax処理');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  // postがあり、ログイン済みの場合
  if(!empty($_POST['reviewId']) && !empty($_SESSION['user_id'])){
    debugFunction::debug('POST送信があります。');
    $r_id = $_POST['reviewId'];
    debugFunction::debug('個別レビューID：'.$r_id);

    //例外処理
  try {
    //接続情報をまとめたクラス
    $dbh = new dbConnectPDO();
    // ログインユーザーがお気に入り対象としたレビューが以前登録したかを確認。
    $sql = 'SELECT * FROM review_likes WHERE user_id = :u_id AND favorite_recode = :r_id';
    $data = array(':u_id' => $_SESSION['user_id'], ':r_id' => $r_id);
    // クエリ実行
    $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);

    //クエリ結果を代入
    $resultCount = $stmt->rowCount();
    debugFunction::debug($resultCount);
    // レコードが１件でもある場合
    if(!empty($resultCount)){
      // レコードを削除する(お気に入り登録の取り消し)
      $sql = 'DELETE FROM review_likes WHERE favorite_recode = :r_id AND user_id = :u_id';
      $data = array(':u_id' => $_SESSION['user_id'], ':r_id' => $r_id);
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
    }else{
      // レコードを挿入する(お気に入り登録処理)
      $sql = 'INSERT INTO review_likes (favorite_recode,user_id,create_date) VALUES (:r_id,:u_id,:date)';
      $data = array(':u_id' => $_SESSION['user_id'], ':r_id' => $r_id, ':date' => date('Y-m-d H:i:s'));
      // クエリ実行
      $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
    }

  } catch (Exception $e) {
    error_log('エラー発生:' . $e->getMessage());
  }
  }
  debugFunction::debug('Ajax処理終了 <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<');
?>
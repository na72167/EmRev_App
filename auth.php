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
  use classes\msg\directMessage;
  use classes\profEdit\profEdit;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

trait auth{
  function auth(){
    //デバック関係のメッセージも一通りまとめる。
    //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
    debugFunction::logSessionSetUp();
    debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
    debugFunction::debug('ログイン時刻の確認');
    debugFunction::debug('「「「「「「「「「「「「「');
    debugFunction::debugLogStart();
  //ログイン成功時
    if( !empty($_SESSION['login_date']) ){
      debugFunction::debug('ログイン済みユーザーです。');

      // 現在日時が最終ログイン日時+有効期限を超えているかの判定(time関数はunixタイムスタンプを使っている為,1970年1月1日からtime関数を使った時点の日時間を秒数に変えた数字を入る。例1970/1/1 00:01:28に使った場合88がlogin_dateのvalueとなる。)
      if( ($_SESSION['login_date'] + $_SESSION['login_limit']) < time()){
        debugFunction::debug('ログイン有効期限オーバーです。');

      //セッション削除(ログイン判定に引っかからせてログアウトさせる。)
        $_session = array();

      //ログインページへリダイレクト
        header("Location:index.php");
        }else{
          debugFunction::debug('ログイン有効期限以内です。');
          //time関数で現在時刻を引っ張ってきて入れ直す。(最終ログイン日時を現在日時に更新)
          $_SESSION['login_date'] = time();
      }
    }
  }
}
?>
<?php
  namespace classFolder\debug\debugFunction;

  class debugFunction{
      // 本番環境の場合はfalseに切り替える
      const debug_flg = true;

      private function logSessionSetUp(){
      //ログ出力関係の設定
      ini_set('log_errors','on');
      //ログの出力ファイルを指定
      ini_set('error_log','php.log');

      // セッション準備・セッション有効期限を延長する
      //セッションファイルの置き場を変更する（/var/tmp/以下に置くと30日は削除されない）
      session_save_path("/var/tmp/");

      //ガーベージコレクションが削除するセッションの有効期限を設定（第二引数の数字はセッションの有効期限を1ヶ月にする為の式。30日以上経っているものに対してだけ１００分の１の確率で削除）
      ini_set('session.gc_maxlifetime', 60*60*24*30);

      //ブラウザを閉じても削除されないようにクッキー自体の有効期限を延ばす
      ini_set('session.cookie_lifetime ', 60*60*24*30);

      //セッションを使う
      session_start();

      //現在のセッションIDを新しく生成したものと置き換える（なりすましのセキュリティ対策）
      session_regenerate_id();
    }

    function debug($string){
      self::debug_flg;
      if(!empty($debug_flg)){
        error_log('デバッグ：'.$string);
      }
    }

    function debugLogStart(){
      debug('>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> 画面表示処理開始');
      debug('セッションID：'.session_id());
      debug('セッション変数の中身：'.print_r($_SESSION,true));
      debug('現在日時タイムスタンプ：'.time());
      if(!empty($_SESSION['login_date']) && !empty($_SESSION['login_limit'])){
        debug( 'ログイン期限日時タイムスタンプ：'.( $_SESSION['login_date'] + $_SESSION['login_limit'] ) );
      }
    }
  }
?>
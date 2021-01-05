<?php
  namespace classes\etc;

  class etc{
  //sessionを１回だけ取得できる
  public static function getSessionFlash($key){
    global $_SESSION;
    if(!empty($_SESSION[$key])){
      $data = $_SESSION[$key];
      $_SESSION[$key] = '';
      return $data;
    }
  }

  // サニタイズ(対象の文字列をhtml化。その後文字列として返す。)
  public static function sanitize($str){
    return htmlspecialchars($str,ENT_QUOTES);
  }
}
?>
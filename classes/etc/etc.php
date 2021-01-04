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
}
?>
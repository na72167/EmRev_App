<?php

require('vendor/autoload.php');

use classes\debug\debugFunction;

debugFunction::logSessionSetUp();
debugFunction::debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugFunction::debug('「　ログアウトページ　');
debugFunction::debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugFunction::debugLogStart();

debugFunction::debug('ログアウトします。');

// セッションを削除（ログアウトする）
// session_destroy()を使うとセッションの再起動が必要になってエラーメッセージを入れる事ができなくなるので
// 配列を初期化する方にする。
$_SESSION = [];

// エラーメッセージの代入
$_SESSION['msg_success'] = 'エラーが発生しました。しばらく経ってからやり直してください。';

debugFunction::debug('ホーム画面へ遷移します。');

debugFunction::debug('セッション変数の中身：'.print_r($_SESSION['msg_success'],true));

// ホーム画面へ
header("Location:index.php");

?>
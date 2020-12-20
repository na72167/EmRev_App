<?php
//共通変数・関数ファイルを読込み
require('function.php');

debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debug('「　ログアウトページ　');
debug('「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「「');
debugLogStart();

debug('ログアウトします。');

// セッションを削除（ログアウトする）
// session_destroy()を使うとセッションの再起動が必要になってエラーメッセージを入れる事ができなくなるので
// 配列を初期化する方にする。
$_SESSION = [];

// エラーメッセージの代入
$_SESSION['msg_success'] = SUCCESS_MS_01;

debug('ホーム画面へ遷移します。');

debug('セッション変数の中身：'.print_r($_SESSION['msg_success'],true));
// ホーム画面へ
header("Location:index.php");
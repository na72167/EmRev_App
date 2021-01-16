<?php
  declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');
  //このファイルのみ名前空間を使うとPDOが上手く使えなくなる為
  //requireを使う。
  //継承元ファイル込で二回以上使うとFatal error: Cannot redeclareが出る。
  require('dbConnectPDO.php');
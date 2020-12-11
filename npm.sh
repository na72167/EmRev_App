#!/bin/sh

# npm はnode.jsの「パッケージ」を管理するツール
# 「パッケージ」は「ライブラリ」ともいい、プログラムの塊のこと。jQueryなど便利ツールのこと。
# node.js自体はJavaScriptで出来たWeb Server
# javaでいうところのmaven
# node.jsには開発で便利なtool（ライブラリ）がたくさんあるので、npmを使ってインストールして使う
# jqueryなどのライブラリもnpmでインストールして管理できる

# homebrewとはMac用のパッケージ管理ソフト
# https://brew.sh/index_ja.html
$ brew install node.js
# npm のバージョンを確認（バージョンが表示されればインストールされている証拠）
$ npm -v
$ mkdir npm_test
$ cd npm_test
$ npm init
# いろいろ聞かれるけど全部エンターで OK

# browserifyをインストールしてみる
# browserifyはモジュール間の依存関係を解決したり、ビルドするためのツール
# requireを使って別ファイルのjsを読み込めるので、htmlにscriptタグで読み込まなくていい。また、読み込み順序を気にしなくていい。
# -g は -global の略でnpmのオプション。PC全体で使えるようになる
# MACの場合は/usr/local/lib/node_modules/にインストールされる
# WindowsはC:¥Users¥%USERNAME%¥AppData¥Roaming¥npm¥node_modulesにインストールされる
# プロジェクトフォルダ内だけで使いたいなら-gは外す
# プロジェクト内にインストールした場合は、node_moduleディレクトリ配下にインストールされる
$ npm install browserify

# buildしてみる
$ browserify src/app.js -o dist/build.js

# package.jsonに記録したければ--saveを使う。アプリ内で使うものは--saveでインストールするといい
$ npm install --save jquery
# -Sは省略形。コマンドのオプションは一番後ろにつけても構わない
$ npm install jquery -S
# 開発時にしか使わないツールをインストールする際には--save-devをつけるとわかりやすい
$ npm install --save-dev gulp
# -Dは省略形。
$ npm install gulp -D

# バージョンを指定してインストールする場合
$ npm install --save-dev grunt@0.3.17


npm install --save gulp
npm install --save gulp-plumber
npm install --save gulp-rename
npm install --save gulp-sass
npm install --save gulp-autoprefixer
npm install --save gulp-csscomb
npm install --save gulp-merge-media-queries
npm install --save gulp-uglify
npm install --save gulp-concat

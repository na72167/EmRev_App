<?php

  namespace classes\validate;

  // 基本継承前提でこのファイルは使う。

  // urlの正規表現につかう予定のもの
  // https?://[\w!\?/\+\-_~=;\.,\*&@#\$%\(\)'\[\]]+
  // https://qiita.com/str32/items/a692073af32757618042

  class validation{

    //ユーザー登録関係のエラーやサクセスメッセージ関係
    //クラス内で完結させたい為,defineでは無くconstを使う。
    // =========エラーメッセージ関係=========
    const ERROR_MS_01 = '入力必須です';
    const ERROR_MS_02 = 'Emailの形式で入力してください';
    const ERROR_MS_03 = 'パスワード(再入力)が合っていません';
    const ERROR_MS_04 = '半角英数字のみご利用いただけます';
    const ERROR_MS_05 = '6文字以上で入力してください';
    const ERROR_MS_06 = '256文字以内で入力してください';
    const ERROR_MS_07 = 'エラーが発生しました。しばらく経ってからやり直してください。';
    const ERROR_MS_08 = 'そのEmailはすでに登録されています';
    const ERROR_MS_09 = '31文字以内で入力してください';
    const ERROR_MS_10 = '電話番号の形式が違います';
    const ERROR_MS_11 = '郵便番号の形式が違います';
    const ERROR_MS_14 = '文字で入力してください';

    // =========サクセスメッセージ関係=========
    const SUCCESS_MS_01 = '31文字以内で入力してください';
    const SUCCESS_MS_02 = '退会しました';

    //入力チェック
    public function validRequired($string,$prop){
      if(empty($string)){
        $this->$prop = self::ERROR_MS_01;
      }
    }

    //email確認(空文字も比較対象になるみたいなので,emailフォームを未入力にした場合
    //にも形式チェックも一緒に引っかかってERROR_MS_01の内容が上書きされてしまう。)
    //なのでEmailフォームが空の場合は形式チェックの処理が走らない様にif($string !== '')
    //を挟む様にした。
    public function validEmail($string,$prop){
      if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $string)){
        if($string !== ''){
          $this->$prop = self::ERROR_MS_02;
        }
      }
    }

      //確認用パスワードのチェック
    public function validMatch($string1,$prop,$string2){
      if($string1 !== $string2){
        $this->$prop = self::ERROR_MS_03;
      }
    }

    //半角チェック(半角のみしか打てないのにこの正規表現だと全角アルファベットが打てる。)
    //でも半角英数字の正規表現で調べるとこれが出てくるのでとりあえずこのまま。
    public function validHalf($string,$prop){
      if(!preg_match("/^[a-z0-9]+$/", $string)){
        $this->$prop = self::ERROR_MS_04;
      }
    }

    //最小文字数チェック(以下「<=」がうまく動かないのでorを使ってる。)
    public function validMinLen($string,$prop,$min = 5){
      if(mb_strlen($string) < $min or mb_strlen($string) == $min){
        $this->$prop = self::ERROR_MS_05;
      }
    }

    //最大文字数チェック
    public function validMaxLen($string,$prop,$max = 255){
      if(mb_strlen($string) > $max){
        $this->$prop = self::ERROR_MS_06;
      }
    }

    //電話番号形式チェック
    function validTel($string, $prop){
      if(!preg_match("/0\d{1,4}\d{1,4}\d{4}/", $string)){
        $this->$prop = self::ERROR_MS_10;
      }
    }

    //郵便番号形式チェック
    function validZip($string,$prop){
      if(!preg_match("/^\d{7}$/", $string)){
        $this->$prop = self::ERROR_MS_11;
      }
    }

    //半角数字チェック
    function validNumber($string, $prop){
      if(!preg_match("/^[0-9]+$/", $string)){
        $this->$prop = self::ERROR_MS_04;
      }
    }

    //最大文字数チェック(email専用)
    public function validMaxLenEmail($string,$prop,$max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        $this->$prop = self::ERROR_MS_09;
      }
    }

     //最大文字数チェック(password専用)
    public function validMaxLenPassword($string,$prop,$max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        $this->$prop = self::ERROR_MS_09;
      }
    }

    //固定長チェック
    function validLength($string,$prop, $len = 8){
      if( mb_strlen($string) !== $len ){
        $this->$prop = $len.self::ERROR_MS_14;
      }
    }

  // //email重複確認
  // function validEmailDup($email){
  //   try {
  //   //DB接続処理関数
  //     $dbh = dbConnect();
  //   //DBからemailデータを引っ張ってくる処理を詰める処理等
  //     $sql = 'SELECT count(*) FROM users WHERE email = :email';
  //     $data = array(':email' => $email);
  //   //クエリ実行
  //     $stmt = queryPost($dbh, $sql, $data);
  //   // クエリ結果を変数に代入
  //     $result = $stmt->fetch(PDO::FETCH_ASSOC);

  //   if(!empty(array_shift($result))){
  //       $err_ms['email'] = ERROR_MS_08;
  //     }
  //   } catch (Exception $e) {
  //     error_log('エラー発生:' . $e->getMessage());
  //     $err_ms['common'] = ERROR_MS_07;
  //   }
  // }

  }
?>
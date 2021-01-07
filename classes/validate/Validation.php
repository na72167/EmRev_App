<?php

  namespace classes\validate;


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

    // =========サクセスメッセージ関係=========
    const SUCCESS_MS_01 = '31文字以内で入力してください';
    const SUCCESS_MS_02 = '退会しました';

    //入力チェック
    public static function validRequired($string,$key){
      if(empty($string)){
        $err_ms = [];
        return $err_ms[$key] = self::ERROR_MS_01;
      }
    }

    //email確認
    public static function validEmail($string, $key){
      if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $string)){
        return $err_ms[$key] = self::ERROR_MS_02;
      }
    }

      //確認用パスワードのチェック
    public static function validMatch($string1, $string2, $key){
      if($string1 !== $string2){
        return $err_ms[$key] = self::ERROR_MS_03;
      }
    }

    //半角チェック(半角のみしか打てないのにこの正規表現だと全角アルファベットが打てる。)
    //でも半角英数字の正規表現で調べるとこれが出てくるのでとりあえずこのまま。
    public static function validHalf($string, $key){
      if(!preg_match("/^[a-zA-Z0-9]+$/", $string)){
        return $err_ms[$key] = self::ERROR_MS_04;
      }
    }

    //最小文字数チェック(以下「<=」がうまく動かないのでorを使ってる。)
    public static function validMinLen($string, $key, $min = 5){
      if(mb_strlen($string) < $min or mb_strlen($string) == $min){
        return $err_ms[$key] = self::ERROR_MS_05;
      }
    }

    //最大文字数チェック
    public static function validMaxLen($string, $key, $max = 255){
      if(mb_strlen($string) > $max){
        return $err_ms[$key] = self::ERROR_MS_06;
      }
    }

    //最大文字数チェック(email専用)
    public static function validMaxLenEmail($string, $key, $max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        return $err_ms[$key] = self::ERROR_MS_09;
      }
    }

     //最大文字数チェック(password専用)
    public static function validMaxLenPassword($string, $key, $max = 31){
      if(mb_strlen($string) > $max or mb_strlen($string) == $max){
        return $err_ms[$key] = self::ERROR_MS_09;
      }
    }


  // namespace classes\traits;

  // trait validation{

  //   //入力チェック
  //   public static function validRequired($string,$key){
  //     if(empty($string)){
  //       return $err_ms[$key] = ERROR_MS_01;
  //     }
  //   }

  //   //email確認
  //   public static function validEmail($string, $key){
  //     if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $string)){
  //       return $err_ms[$key] = self::ERROR_MS_02;
  //     }
  //   }

  //     //確認用パスワードのチェック
  //   public static function validMatch($string1, $string2, $key){
  //     if($string1 !== $string2){
  //       return $err_ms[$key] = self::ERROR_MS_03;
  //     }
  //   }

  //   //半角チェック(半角のみしか打てないのにこの正規表現だと全角アルファベットが打てる。)
  //   //でも半角英数字の正規表現で調べるとこれが出てくるのでとりあえずこのまま。
  //   public static function validHalf($string, $key){
  //     if(!preg_match("/^[a-zA-Z0-9]+$/", $string)){
  //       return $err_ms[$key] = self::ERROR_MS_04;
  //     }
  //   }

  //   //最小文字数チェック(以下「<=」がうまく動かないのでorを使ってる。)
  //   public static function validMinLen($string, $key, $min = 5){
  //     if(mb_strlen($string) < $min or mb_strlen($string) == $min){
  //       return $err_ms[$key] = self::ERROR_MS_05;
  //     }
  //   }

  //   //最大文字数チェック
  //   public static function validMaxLen($string, $key, $max = 255){
  //     if(mb_strlen($string) > $max){
  //       return $err_ms[$key] = self::ERROR_MS_06;
  //     }
  //   }

  //   //最大文字数チェック(email専用)
  //   public static function validMaxLenEmail($string, $key, $max = 31){
  //     if(mb_strlen($string) > $max or mb_strlen($string) == $max){
  //       return $err_ms[$key] = self::ERROR_MS_09;
  //     }
  //   }

  //    //最大文字数チェック(password専用)
  //   public static function validMaxLenPassword($string, $key, $max = 31){
  //     if(mb_strlen($string) > $max or mb_strlen($string) == $max){
  //       return $err_ms[$key] = self::ERROR_MS_09;
  //     }
  //   }

// ＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝


    // email重複確認
  //   function validEmailDup($email){
  //     if(empty($this->err_ms)){
  //       try {
  //       //DB接続処理関数
  //         $dbh = dbConnect();
  //       //DBからemailデータを引っ張ってくる処理を詰める処理等
  //         $sql = 'SELECT count(*) FROM users WHERE email = :email';
  //         $data = array(':email' => $email);
  //       //クエリ実行
  //         $stmt = queryPost($dbh, $sql, $data);
  //       // クエリ結果を変数に代入
  //         $result = $stmt->fetch(PDO::FETCH_ASSOC);

  //       if(!empty(array_shift($result))){
  //           $err_ms['email'] = ERROR_MS_08;
  //         }
  //       } catch (Exception $e) {
  //         error_log('エラー発生:' . $e->getMessage());
  //         $err_ms['common'] = ERROR_MS_07;
  //       }
  //   }
  // }
}
?>
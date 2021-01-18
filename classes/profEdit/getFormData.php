<?php

  namespace classes\profEdit;

  class getFormData{

    //プロフフォームにユーザーが以前登録した個人情報やバリにひっかかった入力情報を再表示させるための処理
    function getFormData($string){
      global $dbFormData;
      // ユーザーデータがある場合
      if(!empty($dbFormData)){

        //フォームのエラーがある場合
        if(!empty($err_ms[$string])){
          //POSTにデータがある場合
          if(isset($_POST[$string])){//金額や郵便番号などのフォームで数字や数値の0が入っている場合もあるので、issetを使うこと
            return $_POST[$string];
          }else{
            //ない場合（フォームにエラーがある＝POSTされてるハズなので、まずありえないが）はDBの情報を表示
            return $dbFormData[$string];
          }

        }else{
          //POSTにデータがあり、DBの情報と違う場合（このフォームも変更していてエラーはないが、他のフォームでひっかかっている状態）
          if(isset($_POST[$string]) && $_POST[$string] !== $dbFormData[$string]){
            return $_POST[$string];
          }else{//そもそも変更していない
            return $dbFormData[$string];
          }
        }

      }else{
        if(isset($_POST[$string])){
          return $_POST[$string];
        }
      }
    }



  }
?>
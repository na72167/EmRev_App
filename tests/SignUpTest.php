<?php

use classes\admin\signup;

//ファイル実行時にクラスのインスタンスは作られているっぽい。
class SignUpTest extends PHPUnit\Framework\TestCase {

  // ==============正常系（正しい数字や文字を入れた際に想定通りの動作をするかの確認）==============

  //Email関係
  public function testNormalValidEmail():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('test@exsample.com','','','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getEmail(),'err_msEmail');
    //正常なメールアドレスが入力された場合,err_msEmailプロパティに値が入らないかを確認。
    $this->assertSame($signUpTest->getEmailErr_ms(),'');

    //形式チェック
    $signUpTest->validEmail($signUpTest->getEmail(),'err_msEmail');
    $this->assertSame($signUpTest->getEmailErr_ms(),'');

    //最大文字数チェック
    $signUpTest->validMaxLenEmail($signUpTest->getEmail(),'err_msEmail');
    $this->assertSame($signUpTest->getEmailErr_ms(),'');

    //重複チェック
    // $signUpTest->validEmailDup($signUpTest->getEmail(),'err_msEmail');
    // $this->assertNull($signUpTest->getEmailErr_ms());

  }

  //パスワード関係
  public function testNormalValidPass():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('','test01','','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'');

    //半角確認テスト
    $signUpTest->validHalf($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'');

    //最大文字数確認テスト
    $signUpTest->validMaxLen($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'');

    //最小文字数確認テスト
    $signUpTest->validMinLen($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'');

  }

  //パスワード(再入力)関係
  public function testNormalValidPass_Re():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('','test01','test01','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'');

    //最大文字数確認テスト
    $signUpTest->validMaxLen($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'');

    //最小文字数確認テスト
    $signUpTest->validMinLen($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'');

    //再入力照合確認テスト
    $signUpTest->validMatch($signUpTest->getPass_re(),'err_msPassRe',$signUpTest->getPass());
    $this->assertSame($signUpTest->getPassReErr_ms(),'');

  }

  // ==============準正常系（想定内の異常な数字や文字を入れた際に想定通りの動作をするかの確認）==============


  //Email関係
  public function testSemi_NormalValidEmail():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('','','','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getEmail(),'err_msEmail');
    //正常なメールアドレスが入力された場合,err_msEmailプロパティに値が入らないかを確認。
    $this->assertSame($signUpTest->getEmailErr_ms(),'入力必須です');

    $signUpTest = new signup('test','','','','','','');
    //形式チェック
    $signUpTest->validEmail($signUpTest->getEmail(),'err_msEmail');
    $this->assertSame($signUpTest->getEmailErr_ms(),'Emailの形式で入力してください');

    $signUpTest = new signup('testtesttesttesttest@example.com','','','','','','');
    //最大文字数チェック
    $signUpTest->validMaxLenEmail($signUpTest->getEmail(),'err_msEmail');
    $this->assertSame($signUpTest->getEmailErr_ms(),'31文字以内で入力してください');

    //重複チェック
    // $signUpTest->validEmailDup($signUpTest->getEmail(),'err_msEmail');
    // $this->assertSame($signUpTest->getEmailErr_ms(),'そのEmailはすでに登録されています');

  }

  //パスワード関係
  public function testSemi_NormalValidPass():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('','','','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'入力必須です');

    $signUpTest = new signup('','TEST','','','','','');
    //半角確認テスト
    $signUpTest->validHalf($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'半角英数字のみご利用いただけます');

    $signUpTest = new signup('','testtesttesttestte
    sttesttesttesttesttesttesttesttesttesttesttestt
    esttesttesttesttesttesttesttesttesttesttesttest
    testtesttesttesttesttesttesttesttesttesttesttes
    ttesttesttesttesttesttesttesttesttesttesttestte
    sttesttesttesttesttestteststtesttesttesttesttes
    ttest','','','','','');
    //最大文字数確認テスト
    $signUpTest->validMaxLen($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'256文字以内で入力してください');

    $signUpTest = new signup('','tests','','','','','');
    //最小文字数確認テスト
    $signUpTest->validMinLen($signUpTest->getPass(),'err_msPass');
    $this->assertSame($signUpTest->getPassErr_ms(),'6文字以上で入力してください');

  }

  //パスワード(再入力)関係
  public function testSemi_NormalValidPass_Re():void {

    //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
    //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
    $signUpTest = new signup('','','','','','','');

    //未入力テスト
    $signUpTest->validRequired($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'入力必須です');

    $signUpTest = new signup('','','testtesttesttest
    testtesttesttesttesttesttesttesttesttesttesttest
    testtesttesttesttesttesttesttesttesttesttesttest
    testtesttesttesttesttesttesttesttesttesttesttes
    ttesttesttesttesttesttesttesttesttesttesttestte
    sttesttesttesttesttestteststtesttesttesttesttes
    ttest','','','','');
    //最大文字数確認テスト
    $signUpTest->validMaxLen($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'256文字以内で入力してください');

    $signUpTest = new signup('','','tests','','','','');
    //最小文字数確認テスト
    $signUpTest->validMinLen($signUpTest->getPass_re(),'err_msPassRe');
    $this->assertSame($signUpTest->getPassReErr_ms(),'6文字以上で入力してください');

    $signUpTest = new signup('','test','tests','','','','');
    //再入力照合確認テスト
    $signUpTest->validMatch($signUpTest->getPass_re(),'err_msPassRe',$signUpTest->getPass());
    $this->assertSame($signUpTest->getPassReErr_ms(),'パスワード(再入力)が合っていません');

  }


  // ==============異常系(想定外の異常な数字や動作が確認された際の処理が正しく行われるかの確認)==============
  //後回し

}

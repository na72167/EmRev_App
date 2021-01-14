
<?php

  use classes\admin\login;

  //ファイル実行時にクラスのインスタンスは作られているっぽい。
  class LoginTest extends PHPUnit\Framework\TestCase {

      // ==============正常系（正しい数字や文字を入れた際に想定通りの動作をするかの確認）==============
      //Email関係
    public function testNormalValidEmail():void {

      //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
      //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
      $loginTest = new login('test@exsample.com','','','','','');

      //未入力テスト
      $loginTest->validRequired($loginTest->getLoginEmail(),'err_msEmail');
      //正常なメールアドレスが入力された場合,err_msEmailプロパティに値が入らないかを確認。
      $this->assertSame($loginTest->getEmailErr_ms(),'');

      //形式チェック
      $loginTest->validEmail($loginTest->getLoginEmail(),'err_msEmail');
      $this->assertSame($loginTest->getEmailErr_ms(),'');

      //最大文字数チェック
      $loginTest->validMaxLenEmail($loginTest->getLoginEmail(),'err_msEmail');
      $this->assertSame($loginTest->getEmailErr_ms(),'');

      //重複チェック
      // $loginTest->validEmailDup($loginTest->getLoginEmail(),'err_msEmail');
      // $this->assertNull($loginTest->getEmailErr_ms());

    }

    //パスワード関係
    public function testNormalValidPass():void {

      //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
      //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
      $loginTest = new login('','test01','','','','');

      //未入力テスト
      $loginTest->validRequired($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'');

      //半角確認テスト
      $loginTest->validHalf($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'');

      //最大文字数確認テスト
      $loginTest->validMaxLen($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'');

      //最小文字数確認テスト
      $loginTest->validMinLen($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'');

    }

    // ==============準正常系（想定内の異常な数字や文字を入れた際に想定通りの動作をするかの確認）==============


    //Email関係
    public function testSemi_NormalValidEmail():void {

      //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
      //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
      $loginTest = new login('','','','','','');

      //未入力テスト
      $loginTest->validRequired($loginTest->getLoginEmail(),'err_msEmail');
      //正常なメールアドレスが入力された場合,err_msEmailプロパティに値が入らないかを確認。
      $this->assertSame($loginTest->getEmailErr_ms(),'入力必須です');

      $loginTest = new login('test','','','','','');
      //形式チェック
      $loginTest->validEmail($loginTest->getLoginEmail(),'err_msEmail');
      $this->assertSame($loginTest->getEmailErr_ms(),'Emailの形式で入力してください');

      $loginTest = new login('testtesttesttesttest@example.com','','','','','');
      //最大文字数チェック
      $loginTest->validMaxLenEmail($loginTest->getLoginEmail(),'err_msEmail');
      $this->assertSame($loginTest->getEmailErr_ms(),'31文字以内で入力してください');

      //重複チェック
      // $loginTest->validEmailDup($loginTest->getLoginEmail(),'err_msEmail');
      // $this->assertSame($loginTest->getEmailErr_ms(),'そのEmailはすでに登録されています');

    }

    //パスワード関係
    public function testSemi_NormalValidPass():void {

      //プロパティは左から「メアド,パスワード,パスワード(再),メアド用エラーメッセージ,
      //パスワード用エラーメッセージ,パスワード(再)用エラーメッセージ,共通エラーメッセージ」
      $loginTest = new login('','','','','','');

      //未入力テスト
      $loginTest->validRequired($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'入力必須です');

      $loginTest = new login('','TEST','','','','');
      //半角確認テスト
      $loginTest->validHalf($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'半角英数字のみご利用いただけます');

      $loginTest = new login('','testtesttesttestte
      sttesttesttesttesttesttesttesttesttesttesttestt
      esttesttesttesttesttesttesttesttesttesttesttest
      testtesttesttesttesttesttesttesttesttesttesttes
      ttesttesttesttesttesttesttesttesttesttesttestte
      sttesttesttesttesttestteststtesttesttesttesttes
      ttest','','','','','');
      //最大文字数確認テスト
      $loginTest->validMaxLen($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'256文字以内で入力してください');

      $loginTest = new login('','tests','','','','');
      //最小文字数確認テスト
      $loginTest->validMinLen($loginTest->getLoginPass(),'err_msPass');
      $this->assertSame($loginTest->getPassErr_ms(),'6文字以上で入力してください');

    }

    // ==============異常系(想定外の異常な数字や動作が確認された際の処理が正しく行われるかの確認)==============
    //後回し
}
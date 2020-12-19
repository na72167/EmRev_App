<?php

require_once(dirname(__FILE__) . '/../function.php');

class SignUpTest extends PHPUnit\Framework\TestCase {

  // ==============正常系==============

  public function testValidRequiredEmailTrue() {
    //email未入力のバリテーションがちゃんと走るかのテスト
    validRequired('test@exsample.com', 'email');
    $results = getErrMsg('email');
    $this->assertNull($results);
  }

  public function testValidRequiredPasswordTrue() {
    //password未入力のバリテーションがちゃんと走るかのテスト
    validRequired('123456', 'pass');
    $results = getErrMsg('pass');
    $this->assertNull($results);
  }

  public function testValidRequiredPasswordReTrue() {
    //password未入力のバリテーションがちゃんと走るかのテスト
    validRequired('123456', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertNull($results);
  }

  public function testValidFormatEmailTrue() {
    //emailの形式のバリテーションがちゃんと走るかのテスト
    validEmail('test@exsample.com', 'email');
    $results = getErrMsg('email');
    $this->assertNull($results);
  }

  public function testValidMaxLenEmailTrue() {
    //emailの最大文字数のバリテーションがちゃんと走るかのテスト
    validMaxLenEmail('test@exsample.com', 'email');
    $results = getErrMsg('email');
    $this->assertNull($results);
  }

  public function testValidDuplicateEmailTrue() {
    //emailの重複確認バリテーションがちゃんと走るかのテスト
    validEmailDup('test@exsample.com', 'email');
    $results = getErrMsg('email');
    $this->assertNull($results);
  }

  public function testValidHalfPasswordTrue() {
    //passwordが半角文字数かどうかのバリテーションがちゃんと走るかのテスト
    validHalf('123456', 'pass');
    $results = getErrMsg('pass');
    $this->assertNull($results);
  }

  public function testValidMaxLenPasswordTrue() {
    //passwordの最大文字数のバリテーションがちゃんと走るかのテスト
    validMaxLen('123456', 'pass');
    $results = getErrMsg('pass');
    $this->assertNull($results);
  }

  public function testValidMinLenPasswordTrue() {
    //passwordの最小文字数のバリテーションがちゃんと走るかのテスト
    validMinLen('123456', 'pass');
    $results = getErrMsg('pass');
    $this->assertNull($results);
  }

  public function testValidMaxLenPasswordReTrue() {
    //password(再入力)の最大文字数のバリテーションがちゃんと走るかのテスト
    validMaxLen('123456', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertNull($results);
  }

  public function testValidMinLenPasswordReTrue() {
    //password(再入力)の最小文字数のバリテーションがちゃんと走るかのテスト
    validMinLen('123456', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertNull($results);
  }

  public function testValidMatchPasswordTrue() {
    //passwordとpassword(再入力)の内容が合致しているかのテスト
    validMatch('123456','123456', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertNull($results);
  }

    // ==============準正常系==============

  public function testValidRequiredEmailFalse() {
    //email未入力時に「入力必須です」とエラーが出力されるかを確認。
    validRequired('', 'email');
    $results = getErrMsg('email');
    $this->assertEquals(ERROR_MS_01, $results);
  }

  public function testValidRequiredPasswordFalse() {
    //password未入力時に「入力必須です」とエラーが出力されるかのテスト
    validRequired('', 'pass');
    $results = getErrMsg('pass');
    $this->assertEquals(ERROR_MS_01, $results);
  }

  public function testValidRequiredPasswordReFalse() {
    //password未入力時に「入力必須です」とエラーが出力されるかのテスト
    validRequired('', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertEquals(ERROR_MS_01, $results);
  }

  public function testValidFormatEmailFalse() {
    //email欄に間違った形式文を入力時「Emailの形式で入力してください」と出力されるかのテスト
    error_log('Email形式チェック'.var_dump($err_ms[0]));
    validEmail('test', 'email');
    $results = getErrMsg('email');
    $this->assertEquals(ERROR_MS_02, $results);
  }

  public function testValidMaxLenEmailFalse() {
    //emailの最大文字数より多く入力した際、「31文字以内で入力してください」と出力されるかのテスト
    validMaxLenEmail('testtesttesttestte@exsample.com', 'email');
    $results = getErrMsg('email');
    $this->assertEquals(ERROR_MS_09, $results);

    global $err_ms;
    $key = array_search('Emailの形式で入力してください', $err_ms);
    error_log($key);

  }

  public function testValidHalfPasswordFalse() {
    //passwordが半角文字数以外のものを入力した際に「半角英数字のみご利用いただけます」
    //と出力されるかのテスト
    validHalf('&$%$#','pass');
    $results = getErrMsg('pass');
    $this->assertEquals(ERROR_MS_04, $results);
  }

  public function testValidMaxLenPasswordFalse() {
    //passwordの最大文字数を入力した際に「31文字以内で入力してください」と出力するかの確認。
    validMaxLenPassword('1234567891234567891234567891234', 'pass');
    $results = getErrMsg('pass');
    $this->assertEquals(ERROR_MS_09, $results);
  }

  public function testValidMinLenPasswordFalse() {
    //passwordの最小文字数を入力した際に「6文字以上で入力してください」と出力するかの確認。
    validMinLen('12345', 'pass');
    $results = getErrMsg('pass');
    $this->assertEquals(ERROR_MS_05, $results);
  }

  public function testValidMaxLenPasswordReFalse() {
    //password(再入力)の最大文字数を入力した際に「31文字以内で入力してください」と出力するかの確認。
    validMaxLenPassword('1234567891234567891234567891234', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertEquals(ERROR_MS_09, $results);
  }

  public function testValidMinLenPasswordReFalse() {
    //password(再入力)の最小文字数を入力した際に「6文字以上で入力してください」と出力するかの確認。
    validMinLen('12345', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertEquals(ERROR_MS_05, $results);
  }

  public function testValidMatchPasswordFalse() {
    //passwordとpassword(再入力)の内容が合致していない場合
    //「パスワード(再入力)が合っていません」と出力されるかのテスト。
    validMatch('123456','1234567', 'password_re');
    $results = getErrMsg('password_re');
    $this->assertEquals(ERROR_MS_03, $results);
  }

   // ==============異常系==============
   //例外処理が走るか確認
}

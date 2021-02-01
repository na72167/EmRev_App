<!--アカウント作成関係処理-->
<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\profEdit\profEdit;
  use classes\profEdit\getFormData;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\etc\etc;


  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('投稿者登録ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

  // このあと$_SESSION['user_id']を参照してuserｓテーブルに関した情報のみを管理するuserクラスを作成。
  // 中のrollプロパティにアクセス。その権限情報とuserクラスを元に一般・社員・管理者・退会済み用のSQLを発行・検索を行う。(退会済みは別)。
  // getUserPropクラスを切り分ける。

  //ログインデータ($_SESSION['user_id']の数字)に一致するUsers情報を取得する。
  $userProp = userProp::getUserProp($_SESSION['user_id']);

  //取得した情報をオブジェクト管理する。
  $userDate = new userProp($userProp['id'],$userProp['email'],$userProp['password'],$userProp['roll'],$userProp['report_flg'],$userProp['delete_flg'],$userProp['create_date'],$userProp['update_date']);

  //第二引数にtrueを指定した場合,string型で出力される様になる。
  debugFunction::debug('取得したユーザー情報：'.print_r($userDate,true));

  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('権限確認処理');
  debugFunction::debug('「「「「「「「「「「「「「');

  // ログインユーザーの権限チェック
  if($userDate->getRoll() === 100){
      //ログインidに対応したgeneral_profsテーブルのレコードを取得する。
      $generalUserProp = generalUserProp::getGeneralUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $generalUserDate = new generalUserProp($generalUserProp['id'],$generalUserProp['email'],$generalUserProp['password'],$generalUserProp['roll'],$generalUserProp['report_flg'],$generalUserProp['delete_flg'],$generalUserProp['user_id'],$generalUserProp['username'],(int)$generalUserProp['age'],(int)$generalUserProp['tel'],$generalUserProp['profImg'],(int)$generalUserProp['zip'],$generalUserProp['addr'],$generalUserProp['create_date'],$generalUserProp['update_date'],'','','','','','');
      debugFunction::debug('取得した一般ユーザー情報：'.print_r($generalUserDate,true));
    }elseif($userDate->getRoll() === 50){
      //すでに投稿者登録してるユーザー
      //フラッシュメッセージで「すでに投稿者登録済みです」と表示する。
      debugFunction::debug('投稿者登録済みアカウントです。');
      header("Location:mypage.php");
    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
      //フラッシュメッセージで「すでに投稿権限を持っています。」と表示する。
      debugFunction::debug('管理者権限持ちアカウントです。');
      header("Location:mypage.php");
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }


  // post送信されていてなおかつ一般ユーザーだった場合。
  if(!empty($_POST['empregEmployeeRegister'] === '登録する') && $userDate->getRoll() === 100){

    debugFunction::debug('POST送信があります。');
    debugFunction::debug('POST情報：'.print_r($_POST,true));
     //例外処理
    try {

      // ここのテーブル挿入から更新処理はもっとキレイに書けるはずなので、あとで書き換える。

      // ========================リレーション関係先のテーブル(contributor_profs)にレコードを挿入==============================
      // DBへ接続
      $dbh1 = new dbConnectPDO();
      // SQL文作成
      $sql1 = 'INSERT INTO contributor_profs (`user_id`) VALUES(:user_id)';
      $data1 = array(':user_id' => $userDate->getID());
      debugFunction::debug('取得したdata：'.print_r($data1,true));
      // クエリ実行
      $stmt1 = dbConnectFunction::queryPost($dbh1->getPDO(), $sql1, $data1);
      // ============================ここまで==========================

      // ========================リレーション関係先のテーブル(contributor_profs)を更新==============================
      // DBへ接続
      $dbh2 = new dbConnectPDO();
      // SQL文作成
      $sql2 = 'UPDATE users AS u LEFT JOIN contributor_profs AS cp ON u.id = cp.user_id SET u.roll = :u_roll WHERE u.id = :u_id';
      $data2 = array(':u_roll' => 50,':u_id' => $userDate->getID());
      debugFunction::debug('取得したdata：'.print_r($data2,true));
      // クエリ実行
      $stmt2 = dbConnectFunction::queryPost($dbh2->getPDO(), $sql2, $data2);
      // ============================ここまで==========================

      // クエリ成功の場合
      if($stmt1 && $stmt2){
        $_SESSION['msg_success'] = '投稿者登録しました！最初にプロフィール設定をしましょう！';
        debugFunction::debug('プロフィール設定画面へ遷移します。');
        header("Location:profileEdit.php"); //プロフィール設定画面へ
      }

    } catch (Exception $e) {
      error_log('エラー発生:' . $e->getMessage());
      $err_msg['common'] = 'エラーが発生しました。しばらく経ってからやり直してください。';
    }
  }
?>

<?php
  // タイトルの読み込み
  $Page_Title = '投稿者登録画面';
  $Intro__Text_Title ='Employee Registration';
  $Intro__Text_Sub ='投稿者登録画面';
  $Intro__Img = 'src="src/img/docs.png"';
  // ヘッドの読み込み
  require('./head.php');
?>
<body>

  <!--ヘッダー読み込み-->
  <?php
    require('./header.php');
  ?>

  <!-- ページ紹介要素ファイルの読み込み -->
  <?php
    require('./intro.php');
  ?>

  <?php
    require('./middleElement.php');
  ?>

  <section class="empregEmployeeRegister">
    <div class="empregEmployeeRegister__content">
      <h1 class="empregEmployeeRegister__title">Employee Registration</h1>

      <form action="" method="post">
        <h4>現在ログイン中のメールアドレス</h4>
        <div class="empregEmployeeRegister__outputStyle">
          <!-- ここは必ずメールアドレスが表示されないといけないので分岐処理はナシ。 -->
          <?php
            echo $generalUserDate->getEmail();
          ?>
        </div>
        <h4 class="empregEmployeeRegister__secondText">のメールアドレスで投稿者登録します。宜しいですか?</h4>
        <div class="empregEmployeeRegister__bottom-wrap">
            <!-- 時間がある時にinput・valueの形のボタンに変更する。 -->
            <bottom class="empregEmployeeRegister__bottom-return" onclick="location.href='mypage.php'">キャンセル</bottom>
            <input type="submit" name='empregEmployeeRegister' class="empregEmployeeRegister__bottom-next" value="登録する">
        </div>
      </form>

    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>

</body>
</html>
<?php
 // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\contributorUserProp;
  use classes\etc\etc;


  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー投稿ページ(投稿完了)');
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
      $_SESSION['msg_success'] = 'この機能を使うには投稿者登録する必要があります。';
      debugFunction::debug('取得した一般ユーザー情報：'.print_r($generalUserDate,true));
      debugFunction::debug('マイページへ遷移します。');
      header("Location:mypage.php"); //マイページへ
    }elseif($userDate->getRoll() === 50){
      //投稿者ユーザー
      $contributorUserProp = contributorUserProp::getContributorUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],$contributorUserProp['user_id'],$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],$contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'');
      debugFunction::debug('取得した投稿ユーザー情報：'.print_r($contributorUserDate,true));
    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }

  // post送信されていてなおかつ投稿者登録ユーザーだった場合。
  if(!empty($_POST['mypage'] === 'マイページへ') && $userDate->getRoll() === 50){
    //フラッシュメッセージ挟む。
    debugFunction::debug('マイページへ遷移します。');
    header("Location:mypage.php");
  }

?>

<!-- cmは「completeの略」 -->
<?php
  // タイトルの読み込み
  $Page_Title = '投稿完了';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='投稿完了';
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

  <section class="revRegistCm-content">

    <div class="revRegistCm-content__wrap">
      <?php
      require('./revProgress.php');
      ?>
      <div class="revRegistCm-content__form-element">
        <div class="revRegistCm-content__form-wrap">
          <h4 class="revRegistCm-content__title">投稿完了</h4>
          <h1 class="revRegistCm-content__sub">投稿ありがとうございました</h1>
          <form method="post">
            <div class="revRegistCm-content__bottom-wrap">
              <input type="submit" class="revRegistCm-content__bottom-next revRegistCm-content__bottom-link" name="mypage" value="マイページへ">
            </div>
          </form>
        </div>
      </div>

    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
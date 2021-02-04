<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\companyApply\companyApply;
  use classes\msg\directMessage;
  use classes\profEdit\profEdit;
  use classes\debug\debugFunction;
  use classes\userProp\userProp;
  use classes\userProp\generalUserProp;
  use classes\userProp\contributorUserProp;
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('DMページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();

    // このあと$_SESSION['user_id']を参照してuserｓテーブルに関した情報のみを管理するuserクラスを作成。
  // 中のrollプロパティにアクセス。その権限情報とuserクラスを元に一般・社員・管理者・退会済み用のSQLを発行・検索を行う。(退会済みは別)。
  // getUserPropクラスを切り分ける。

  //ログインデータ($_SESSION['user_id']の数字)に一致するUsers情報を取得する。
  $userProp = userProp::getUserProp($_SESSION['user_id']);

  //取得した情報をオブジェクト管理する。
  $userDate = new userProp($userProp['id'],$userProp['email'],$userProp['password'],$userProp['roll'],$userProp['report_flg'],$userProp['delete_flg'],$userProp['create_date'],$userProp['update_date']);

  //フォーム送信前にもprofEdit関係のメソッドを扱いたいので先にインスタンス生成する。
  $profEdit = new profEdit('','','','','','','','','','','','');

  //第二引数にtrueを指定した場合,string型で出力される様になる。
  debugFunction::debug('取得したユーザー情報：'.print_r($userDate,true));

  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('権限確認処理');
  debugFunction::debug('「「「「「「「「「「「「「');

  // ================ログインユーザーの権限チェック================
  if($userDate->getRoll() === 100){
      $_SESSION['msg_success'] = 'この機能を使うには投稿者登録する必要があります。';
      debugFunction::debug('マイページへ遷移します。');
      header("Location:mypage.php"); //マイページへ
    }elseif($userDate->getRoll() === 50){
      //投稿者ユーザー
      $contributorUserProp = contributorUserProp::getContributorUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $contributorUserDate = new contributorUserProp($contributorUserProp['id'],$contributorUserProp['user_id'],$contributorUserProp['username'],$contributorUserProp['age'],$contributorUserProp['tel'],$contributorUserProp['zip'],$contributorUserProp['addr'],$contributorUserProp['affiliation_company'],
      $contributorUserProp['incumbent'],$contributorUserProp['currently_department'],$contributorUserProp['currently_position'],$contributorUserProp['dm_state'],$contributorUserProp['delete_flg'],$contributorUserProp['create_date'],$contributorUserProp['update_date'],'','');
      debugFunction::debug('取得した投稿ユーザー情報：'.print_r($contributorUserDate,true));
    }elseif($userDate->getRoll() === 1){
      //管理者権限持ち
    }elseif($userDate->getRoll() === 150){
      //退会済み
    }else{
      //フラッシュメッセージで「権限が取得できません。ホームへ戻ります。」と表示
      //セッション情報破棄後index.phpへ飛ばす。
  }

  // ======================DM情報取得処理========================

  //ページに飛ぶ前に取得した連絡先相手の個別IDを$_GET['rev_id']から取得する。
  $toUser_id = (!empty($_GET['toUser_id'])) ? $_GET['toUser_id'] : '';

  //第一引数・・・連絡相手のID。第二引数・・・ログインユーザーのID。
  $dmInfo = new directMessage($toUser_id,$userDate->getID(),'','');

  //=========過去にログインユーザーと連絡相手ユーザー間で連絡を取り合った事があるか確認=========

  if($dmInfo->searchDmHistory($dmInfo->getToUser_id(),$dmInfo->getFromUser_id()) !== ''){

    // 連絡先相手のID情報が取得できたか確認
    if($dmInfo->getToUser_id() !== ''){
      // DBからメッセージデータを取得
      $viewData = $dmInfo->partnerMsg($dmInfo->getToUser_id());
      debugFunction::debug('取得した相手のDMメッセージ：'.print_r($viewData,true));
        // メッセージが取得できたかチェック
        if(!empty($viewData)){
          debugFunction::debug('相手ユーザーはログインユーザーに対して以前メッセージを送っています。');
        }elseif((empty($viewData))){
          debugFunction::debug('相手ユーザーはログインユーザーに対してまだメッセージを送っていません');
        }
    }elseif($dmInfo->getToUser_id() === null){
      // フラッシュ用セッション内に「連絡に必要な情報が取得できませんでした。」と表示する。
      $_SESSION['msg_success'] = '連絡に必要な情報が取得できませんでした。';
      header("Location:mypage.php"); //マイページへ
    }

  }elseif($dmInfo->searchDmHistory($dmInfo->getToUser_id(),$dmInfo->getFromUser_id()) === ''){
    debugFunction::debug('新規DMを開始します。');
  }


  // ======================DM送信処理========================

  // post送信されていた場合
  if(!empty($_POST)){
    debugFunction::debug('POST送信があります。');
    //バリデーションチェック
    $dmInfo->setMsg($dmInfo->getMsg($_POST['msg']));

    if(empty(array_filter($dmInfo->getErr_msAll()))){
      debugFunction::debug('バリデーションOKです。');
      //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        // SQL文作成
        $sql = 'INSERT INTO dm_messages (send_date,to_user,from_user,msg) VALUES (:send_date,:to_user,:from_user,:msg)';
        $data = array(':send_date' => date('Y-m-d H:i:s'), ':to_user' => $dmInfo->getToUser_id(), ':from_user' => $dmInfo->getFromUser_id(), ':msg' => $dmInfo->getMsg());
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh, $sql, $data);

        // クエリ成功の場合
        if($stmt){
          $_POST = array(); //postをクリア
          debugFunction::debug('DM画面へ遷移します。');
          // $_SERVER['PHP_SELF']現在実行されているスクリプトのファイル名
          // https://www.flatflag.nir87.com/server-358#_SERVER
          header("Location:DM.php?toUser_id=".$dmInfo->getToUser_id()); //同じ条件で再ジャンプ
        }

      } catch (Exception $e) {
        error_log('エラー発生:' . $e->getMessage());
        //フラッシュメッセージで接続できなかった事を表示させる。
      }
    }
  }

?>

<?php
  // タイトルの読み込み
  $Page_Title = 'DM画面';
  $Intro__Text_Title ='Direct Mail';
  $Intro__Text_Sub ='ダイレクトメッセージ画面';
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

  <section class="dmScreen">
    <!-- 左側のリスト部分 -->
    <div class="dmScreen__userList-wrap">

      <div class="dmScreen__userSearch-wrap">
        <label>
          <form action="#">
              <input class="dmScreen__userSearch-input" placeholder="Search">
              <bottom class="dmScreen__userSearch-button"></bottom>
          </form>
        </label>
      </div>

      <div class="dmScreen__timeZone-wrap">
          <div class="dmScreen__recent-wrap">
            <h1 class="dmScreen__recent-style">Recent</h1>

            <div>
              <div class="dmScreen__recent-element" tabIndex="0">
                <div class="dmScreen__recent-imgStyle">
                  <span class="dmScreen__recent-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__recent-name">
                  山田太郎
                </div>
                <div class="dmScreen__recent-time">
                  1m
                </div>

                <div class="dmScreen__recent-marker"></div>
              </div>
            </div>

            <div>
              <div class="dmScreen__recent-element" tabIndex="0">
                <div class="dmScreen__recent-imgStyle">
                  <span class="dmScreen__recent-activeSignal"></span>
                  <img href="#">
                </div>
                <div class="dmScreen__recent-name">
                  山田太郎
                </div>
                <div class="dmScreen__recent-time">
                  1m
                </div>
                <div class="dmScreen__recent-marker"></div>
              </div>
            </div>

          </div>

          <div class="dmScreen__thisWeek-wrap">
            <h1 class="dmScreen__thisWeek-style">This Week</h1>

            <div>
              <div class="dmScreen__thisWeek-element" tabIndex="0">
                <div class="dmScreen__thisWeek-imgStyle">
                  <span class="dmScreen__thisWeek-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__thisWeek-name">
                  山田太郎
                </div>
                <div class="dmScreen__thisWeek-time">
                  1m
                </div>

                <div class="dmScreen__thisWeek-marker"></div>
              </div>
            </div>

            <div>
              <div class="dmScreen__thisWeek-element" tabIndex="0">
                <div class="dmScreen__thisWeek-imgStyle">
                  <span class="dmScreen__thisWeek-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__thisWeek-name">
                  山田太郎
                </div>
                <div class="dmScreen__thisWeek-time">
                  1m
                </div>

                <div class="dmScreen__thisWeek-marker"></div>
              </div>
            </div>

            <div>
              <div class="dmScreen__thisWeek-element" tabIndex="0">
                <div class="dmScreen__thisWeek-imgStyle">
                  <span class="dmScreen__thisWeek-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__thisWeek-name">
                  山田太郎
                </div>
                <div class="dmScreen__thisWeek-time">
                  1m
                </div>

                <div class="dmScreen__thisWeek-marker"></div>
              </div>
            </div>

            <div>
              <div class="dmScreen__thisWeek-element" tabIndex="0">
                <div class="dmScreen__thisWeek-imgStyle">
                  <span class="dmScreen__thisWeek-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__thisWeek-name">
                  山田太郎
                </div>
                <div class="dmScreen__thisWeek-time">
                  1m
                </div>

                <div class="dmScreen__thisWeek-marker"></div>
              </div>
            </div>

            <div>
              <div class="dmScreen__thisWeek-element" tabIndex="0">
                <div class="dmScreen__thisWeek-imgStyle">
                  <span class="dmScreen__thisWeek-activeSignal"></span>
                  <img href="#">
                </div>

                <div class="dmScreen__thisWeek-name">
                  山田太郎
                </div>
                <div class="dmScreen__thisWeek-time">
                  1m
                </div>

                <div class="dmScreen__thisWeek-marker"></div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- DM相手の詳細表示要素 -->
      <div class="dmScreen__callPartner-element">
        <div>
          <div class="dmScreen__callPartner-imgStyle">
            <img href="#">
          </div>

          <div class="dmScreen__callPartner-name">
            山田太郎
            <div class="dmScreen__callPartner-time">
            active now
            </div>
          </div>

        </div>
      </div>

      <div class="dmScreen__contactBoard">

      <?php
        if(!empty($viewData)){
          foreach($viewData as $key => $val){
            // メッセージ送信者判定
            // to_user内のIDが連絡先ユーザーのIDと一致しているか確認。
            // 一致した場合は相手側のメッセージスタイルでメッセージを出力する。
            if($val['to_user'] === $dmInfo->getToUser_id()){
        ?>
        <!-- 相手側DM -->
        <div class="dmScreen__contactBoard-contactPerson">
          <div class="dmScreen__contactBoard-imgStylePerson">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-personText">
            <span><?php echo $val['msg'] ?>
          </div>
        </div>
        <?php
            // 一致しなかった場合はログインユーザー側のメッセージスタイルでメッセージを出力する。
            }else{
          ?>
        <!-- 自分側DM -->
        <div class="dmScreen__contactBoard-contactMyself">
          <div class="dmScreen__contactBoard-imgStyleMyself">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-TextMyself">
            <span><?php echo $val['msg'] ?>
          </div>
        </div>

        <?php
                }
              }
              //そもそも判定元レコードが無い場合
            }else{
          ?>
        <!-- メッセージ送信情報がない場合 -->
        <p>メッセージ投稿はまだありません</p>
        <?php
              }
          ?>


      </div>

      <div class="dmScreen__inputForm">

        <form  class="dmScreen__inputForm-clickSignal">
          <input class="dmScreen__inputForm-style" name="msg" placeholder="Type Something">
          <!-- 空でもvalueをつけないとtype="submit"を指定した要素はデフォルト文字「送信」が表示される。 -->
          <!-- https://www.tagindex.com/html_tag/form/input_submit.html -->
          <input type="submit" class="dmScreen__inputForm-button" name="send" value="">
        </form>


      </div>
    </div>
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
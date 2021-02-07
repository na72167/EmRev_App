<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use \DateTime;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\companyApply\companyApply;
  use classes\msg\directMessage;
  use classes\msg\directMessageSearch;
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

  // 連絡先相手のID情報が取得できたか確認
  if($dmInfo->getToUser_id() !== ''){
    // DBからメッセージデータを取得
    $viewData = $dmInfo->searchDmHistory($dmInfo->getToUser_id(),$dmInfo->getFromUser_id());
    debugFunction::debug('取得したDMメッセージ：'.print_r($viewData,true));
  }elseif($dmInfo->getToUser_id() === null){
    // フラッシュ用セッション内に「連絡に必要な情報が取得できませんでした。」と表示する。
    $_SESSION['msg_success'] = '連絡に必要な情報を取得できませんでした。';
    header("Location:mypage.php"); //マイページへ
  }

  // ======================連絡先相手の詳細情報取得========================

  // 連絡先相手のID情報が取得できたか確認
  if($dmInfo->getToUser_id() !== ''){
    // 連絡先相手の投稿者情報を取得する(DM機能は投稿者登録をしないと使えない想定なのでuserPropクラス経由でのID取得は✗)
    $contributorToUserProp = contributorUserProp::getContributorUserProp($dmInfo->getToUser_id());
    debugFunction::debug('取得した連絡先相手の投稿者情報：'.print_r($contributorToUserProp,true));
    if(empty($contributorToUserProp)){
      $_SESSION['msg_success'] = '連絡に必要な情報を取得できませんでした。';
      header("Location:mypage.php"); //マイページへ
    }
  }

  // ======================ログインユーザーに対してメッセージを送信した他ユーザーの一覧取得処理========================
  //DateTime クラスのまとめメモ
  //https://qiita.com/re-24/items/c3ed814f2e1ee0f8e811

  $DmSearchProp = new directMessage($toUser_id,$userDate->getID(),'','');
  $DmSendUser = $DmSearchProp->toLoginUserMsgSearch($_SESSION['user_id']);
  $SearchResult = null;

  // 検索機能を利用したか確認
  if($_POST['search'] === '検索'){
    debugFunction::debug('POST(検索)があります。');
    $SearchProp = new directMessageSearch($_POST['searchName'],'');
    $SearchProp->setSearchName($SearchProp->getSearchName());
    if($SearchProp->getSearchName()){
      debugFunction::debug('バリデーションOKです。');
       //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        //SQL文作成
        //ログイン中ユーザーに対してメッセージを送ったユーザー
        //ログインユーザーが検索したユーザーネームと同じ
        //ユーザー情報を取得します。
        $sql = 'SELECT d_mes.id,d_mes.send_date,d_mes.to_user,d_mes.from_user,d_mes.msg,d_mes.delete_flg,d_mes.create_date,d_mes.update_date,
        cp.user_id,cp.username,cp.age,cp.tel,cp.zip,cp.addr,cp.affiliation_company,cp.incumbent,cp.currently_department,
        cp.currently_position,cp.dm_state,cp.delete_flg,cp.create_date,cp.update_date
        FROM `dm_messages` AS d_mes LEFT JOIN contributor_profs AS cp ON d_mes.from_user = cp.user_id
        WHERE to_user = :to_user AND username = :username ORDER BY send_date ASC';
        $data = array(':to_user' => $userDate->getID(),':username' => $SearchProp->getSearchName());
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
        if($stmt){
          // クエリ結果の全データを返却
          $SearchResult = $stmt->fetchAll();
          $_POST = null;
          debugFunction::debug('検索結果：'.print_r($SearchResult,true));
          debugFunction::debug('POST内：'.print_r($_POST['search'],true));
        }else{
          $_POST = null;
          //フラッシュメッセージで「検索に当てはまるユーザーは存在しません」
          //と表示させる。
        }
      } catch (Exception $e) {
        // [PHP] まとめて例外をスローする小技
        // https://qiita.com/mpyw/items/6bd99ff62571c02feaa1
        error_log('エラー発生:' . $e->getMessage());
      }
    }
  }

  if(!empty($DmSendUser) && empty($SearchResult)){
    foreach($DmSendUser as $key => $val){
      //dm_messagesテーブルのsend_date関係のレコードを対象にする。
      //modify()関数を複数回使う場合はその数に合わせてインスタンスを用意しないといけない。
      //modify()を使った日付変更は一時的な物では無いので,一つのインスタンスに対して複数回modify()
      //を使うと判定処理に支障が出やすくなる。
      $RecentDesignated = new DateTime($val['send_date']);
      $ThisWeekDmListDesignated1 = new DateTime($val['send_date']);
      $ThisWeekDmListDesignated2 = new DateTime($val['send_date']);

      //メッセージの送信先がログインユーザーで尚且つ送信時間+3日以内の場合
      if($val['to_user'] === $dmInfo->getFromUser_id() && $RecentDesignated->modify('+3 days')->format('Y-m-d H:i:s') > date("Y-m-d H:i:s")){
        // もう一度配列管理に戻す
        $RecentDm =
          array(
          'id' => $val['id'],
          'send_date' => $val['send_date'],
          'to_user' => $val['to_user'],
          'from_user' => $val['from_user'],
          'msg' => $val['msg'],
          'delete_flg' => $val['delete_flg'],
          'create_date' => $val['create_date'],
          'update_date' => $val['update_date'],
          'user_id' => $val['user_id'],
          'username' => $val['username'],
          'age' => $val['age'],
          'tel' => $val['tel'],
          'zip' => $val['zip'],
          'addr' => $val['addr'],
          'affiliation_company' => $val['affiliation_company'],
          'incumbent' => $val['incumbent'],
          'currently_department' => $val['currently_department'],
          'currently_position' => $val['currently_position'],
          'dm_state' => $val['dm_state']
          );
        debugFunction::debug('ログイン中ユーザーに対して送信時間+3日以内にメッセージを送ったユーザー情報など：'.print_r($RecentDm,true));
      }

      //メッセージの送信先がログインユーザーで尚且つ送信時間+3日以上・7日以内の場合
      if($val['to_user'] === $dmInfo->getFromUser_id() && $ThisWeekDmListDesignated1->modify('+3 days')->format('Y-m-d H:i:s') < date("Y-m-d H:i:s") &&
      $ThisWeekDmListDesignated2->modify('+7 days')->format('Y-m-d H:i:s') > date("Y-m-d H:i:s")){
        // もう一度配列管理に戻す
        $ThisWeekDm =
        array(
          'id' => $val['id'],
          'send_date' => $val['send_date'],
          'to_user' => $val['to_user'],
          'from_user' => $val['from_user'],
          'msg' => $val['msg'],
          'delete_flg' => $val['delete_flg'],
          'create_date' => $val['create_date'],
          'update_date' => $val['update_date'],
          'user_id' => $val['user_id'],
          'username' => $val['username'],
          'age' => $val['age'],
          'tel' => $val['tel'],
          'zip' => $val['zip'],
          'addr' => $val['addr'],
          'affiliation_company' => $val['affiliation_company'],
          'incumbent' => $val['incumbent'],
          'currently_department' => $val['currently_department'],
          'currently_position' => $val['currently_position'],
          'dm_state' => $val['dm_state']
          );
        debugFunction::debug('ログイン中ユーザーに対して送信時間+3日以上、送信時間+7日以内にメッセージを送ったユーザー情報など：'.print_r($ThisWeekDm,true));
      }

      // 該当したDMを管理する
      if(!empty($RecentDm)){
        $RecentDmList[] = $RecentDm;
        debugFunction::debug('最近のDM一覧：'.print_r($RecentDmList,true));
      }
      if(!empty($ThisWeekDm)){
        $ThisWeekDmList[] = $ThisWeekDm;
        debugFunction::debug('今週のDM一覧：'.print_r($ThisWeekDmList,true));
      }
    }
  }

  // ======================DM送信処理========================

  // post送信されていた場合
  if($_POST['send'] === "送信"){
    debugFunction::debug('POST(送信)があります。');
    //バリデーションチェック
    $dmInfo->setMsg($_POST['msg']);
    if(empty($dmInfo->err_msMsg())){
      debugFunction::debug('バリデーションOKです。');
      //例外処理
      try {
        //接続情報をまとめたクラス
        $dbh = new dbConnectPDO();
        // SQL文作成
        $sql = 'INSERT INTO dm_messages (send_date,to_user,from_user,msg) VALUES (:send_date,:to_user,:from_user,:msg)';
        $data = array(':send_date' => date('Y-m-d H:i:s'), ':to_user' => $dmInfo->getToUser_id(), ':from_user' => $dmInfo->getFromUser_id(), ':msg' => $dmInfo->getMsg());
        // クエリ実行
        $stmt = dbConnectFunction::queryPost($dbh->getPDO(), $sql, $data);
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
  // タイトルの読み込み検索
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
        <form method="post">
          <input class="dmScreen__userSearch-input"  name="searchName" placeholder="Search">
          <!-- 空でもvalueをつけないとtype="submit"を指定した要素はデフォルト文字「送信」が表示される。 -->
          <!-- https://www.tagindex.com/html_tag/form/input_submit.html -->
          <input type="submit" class="dmScreen__userSearch-button" name="search" value="検索">
        </form>
      </div>

      <div class="dmScreen__timeZone-wrap">
          <div class="dmScreen__recent-wrap">
            <h1 class="dmScreen__recent-style">Recent</h1>

            <?php
              if(!empty($RecentDmList)){
                foreach($RecentDmList as $key => $val){
            ?>
              <div>
                <div class="dmScreen__recent-element" tabIndex="0">
                  <div class="dmScreen__recent-imgStyle">
                    <span class="dmScreen__recent-activeSignal"></span>
                    <img href="#">
                  </div>

                  <div class="dmScreen__recent-name">
                    <?php echo $RecentDmList['username'] ?>
                  </div>
                  <div class="dmScreen__recent-time">
                    <!-- ここには現在時刻から$RecentDmList['send_date']を比較したのち、その時間差を出力させる。-->
                    1m
                  </div>

                  <div class="dmScreen__recent-marker"></div>
                </div>
              </div>
            <?php
                }
              }
            ?>
          </div>

          <div class="dmScreen__thisWeek-wrap">
            <h1 class="dmScreen__thisWeek-style">This Week</h1>
            <div>
              <?php
                if(!empty($ThisWeekDmList)){
                  foreach($ThisWeekDmList as $key => $val){
              ?>
                <div>
                  <div class="dmScreen__thisWeek-element" tabIndex="0">
                    <div class="dmScreen__thisWeek-imgStyle">
                      <span class="dmScreen__thisWeek-activeSignal"></span>
                      <img href="#">
                    </div>

                    <div class="dmScreen__thisWeek-name">
                      <?php echo $val['username'] ?>
                    </div>
                    <div class="dmScreen__thisWeek-time">
                      <!-- ここには現在時刻から$RecentDmList['send_date']を比較したのち、その時間差を出力させる。-->
                      1m
                    </div>

                    <div class="dmScreen__thisWeek-marker"></div>
                  </div>
                </div>
              <?php
                  }
                }
              ?>
        </div>
      </div>


      <!-- DM相手の詳細表示要素 -->
      <div class="dmScreen__callPartner-element">
        <div>
          <div class="dmScreen__callPartner-imgStyle">
            <img href="#">
          </div>

          <div class="dmScreen__callPartner-name">
          <?php echo $contributorToUserProp['username'] ?>
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
            // from_user内のIDがログインユーザーのIDと一致しているか確認。
            // 一致した場合はログインユーザー側でメッセージを出力する。
            if($val['from_user'] === $dmInfo->getFromUser_id()){
        ?>
        <!-- ログインユーザー側DM -->
        <div class="dmScreen__contactBoard-contactMyself">
          <div class="dmScreen__contactBoard-imgStyleMyself">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-TextMyself">
            <span><?php echo $val['msg'] ?></span>
            <span><?php echo $val['send_date'] ?></span>
          </div>
        </div>

        <?php
            // 一致しなかった場合は相手側のメッセージスタイルのメッセージスタイルでメッセージを出力する。
            }else{
          ?>
        <!-- 相手側DM -->
        <div class="dmScreen__contactBoard-contactPerson">
          <div class="dmScreen__contactBoard-imgStylePerson">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-personText">
            <span><?php echo $val['msg'] ?></span>
            <span><?php echo $val['send_date'] ?></span>
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

        <form method="post" class="dmScreen__inputForm-clickSignal">
          <input class="dmScreen__inputForm-style" name="msg" placeholder="Type Something">
          <!-- 空でもvalueをつけないとtype="submit"を指定した要素はデフォルト文字「送信」が表示される。 -->
          <!-- https://www.tagindex.com/html_tag/form/input_submit.html -->
          <input type="submit" class="dmScreen__inputForm-button" name="send" value="送信">
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
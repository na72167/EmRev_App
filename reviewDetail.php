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
  use classes\userProp\companyReviewContributorProp;
  use classes\etc\etc;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー詳細ページ');
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
      //ログインidに対応したgeneral_profsテーブルのレコードを取得する。
      $generalUserProp = generalUserProp::getGeneralUserProp($userDate->getId());
      //取得したレコードをオブジェクト単位で管理する。
      $generalUserDate = new generalUserProp($generalUserProp['id'],$generalUserProp['email'],$generalUserProp['password'],$generalUserProp['roll'],$generalUserProp['report_flg'],$generalUserProp['delete_flg'],$generalUserProp['user_id'],$generalUserProp['username'],(int)$generalUserProp['age'],(int)$generalUserProp['tel'],$generalUserProp['profImg'],(int)$generalUserProp['zip'],$generalUserProp['addr'],$generalUserProp['create_date'],$generalUserProp['update_date'],'','','','','','');
      debugFunction::debug('取得した一般ユーザー情報：'.print_r($generalUserDate,true));
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

  // ================個別レビュー取得処理================

  $listProp = companyReviewContributorProp::companyReviewContributorProp($_GET['rev_id']);
  debugFunction::debug('取得した関連会社・レビュー・ユーザー情報：'.print_r($listProp,true));

  // ================閲覧履歴記録処理================

  $searchResult = companyReviewContributorProp::searchUserAndHistoryLink($userDate->getID(),$_GET['rev_id']);
    debugFunction::debug('閲覧履歴の出力：'.print_r($searchResult,true));
  //過去に同レビューを見ていた場合
  if(!empty(array_filter(($searchResult)))){
    // 対象レビューのupdateカラムを更新する
    companyReviewContributorProp::updateUserAndHistoryLink($userDate->getID(),$_GET['rev_id']);
  }elseif(empty(array_filter(($searchResult)))){
    //ログインユーザー情報と現在閲覧中のレビュー情報を登録する。
    companyReviewContributorProp::userAndHistoryLink($userDate->getID(),$_GET['rev_id']);
  }

?>

<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー詳細画面';
  $Intro__Text_Title ='Review Detail';
  $Intro__Text_Sub ='レビュー詳細画面';
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
      require('./designspace.php');
    ?>



    <section class="reviewerProf">

      <!-- 一般ユーザーの場合 -->
      <!-- enctype属性・・・送信する情報のエンコードタイプを指定する。form-dataはフォームにファイルを送信する機能がある場合に指定する。 -->
      <form action="" method="post" enctype="multipart/form-data">

        <!-- 共通エラーの出力 -->
        <div class="area-msg">

        </div>

        <!-- ユーザープロフ画像の登録 -->
        <div class="reviewerProf__img-wrap">
          <img class="reviewerProf__img">

          <!-- ここが写真の入力フォームになる予定 -->
          <!-- <input type="file" name="pic" class="reviewerProf__img" style="height:370px;"> -->

        </div>

        <!-- ========================== -->

        <div class="reviewerProf__detail">

          <label class="">
            <div class="reviewerProf__name">
              <div class="reviewerProf__name-areaMsg">
              </div>
              <!-- 多次元配列内に要素を挿入する際にできるkey[0]を削除か変更する方法を調べる。 -->
              <h1 class="reviewerProf__name-element">name <?php echo etc::sanitize($listProp['reviews'][0]['username']);?></h1>
            </div>
          </label>

          <div class="reviewerProf__ageTel-Wrap">

          <label class="">
            <div class="reviewerProf__age">
                <div class="reviewerProf__age-areaMsg">
                </div>
                <div class="reviewerProf__age-element">age<?php echo etc::sanitize($listProp['reviews'][0]['age']);?></div>
            </div>
          </label>

          <label class="">
            <div class="reviewerProf__tel">
            <div class="reviewerProf__tel-areaMsg">

                </div>
                <div class="reviewerProf__tel-element">tel<?php echo etc::sanitize($listProp['reviews'][0]['tel']);?></div>
            </div>
          </label>

          </div>

          <label class="">
            <div class="reviewerProf__address">
                <div class="reviewerProf__address-areaMsg">

                </div>
                <div class="reviewerProf__address-element">address<?php echo etc::sanitize($listProp['reviews'][0]['addr']);?></div>
            </div>
          </label>

          <label class="">
            <div class="reviewerProf__dmState">
                <div class="reviewerProf__dmState-areaMsg">

                </div>
                <div class="reviewerProf__dmState-element">DM可否<?php if($listProp['reviews'][0]['dm_state'] === '0'){
                    echo 'DM不可';
                  }elseif($listProp['reviews'][0]['dm_state'] === '1'){
                    echo 'DM可';
                  }
                ?>
                </div>
                </div>
            </div>
          </label>

          <div class="reviewerProf__employeeInfoWrap">
            <label class="">
              <div class="reviewerProf__affiliationCompany">
                <div class="reviewerProf__affiliationCompany-areaMsg">
                </div>
                <h1 class="reviewerProf__affiliationCompany-element">現所属会社<?php echo etc::sanitize($listProp['reviews'][0]['affiliation_company']);?></h1>
              </div>
            </label>

            <div class="reviewerProf__incumbentPositionWrap">
              <label class="">
                <div class="reviewerProf__incumbent">
                  <div class="reviewerProf__incumbent-areaMsg">

                  </div>
                  <div class="reviewerProf__incumbent-element">現職<?php echo etc::sanitize($listProp['reviews'][0]['incumbent']);?></div>
                </div>
              </label>

              <label class="">
                <div class="reviewerProf__Position">
                  <div class="reviewerProf__Position-areaMsg">

                  </div>
                  <div class="reviewerProf__Position-element">現役職
                    <?php echo etc::sanitize($listProp['reviews'][0]['position']);?>
                  </div>
                </div>
              </label>
            </div>

            <label class="">
              <div class="reviewerProf__currentDepartment">
                <div class="reviewerProf__currentDepartment-areaMsg">
                </div>
                <div class="reviewerProf__currentDepartment-element">現部署
                <?php echo etc::sanitize($listProp['reviews'][0]['currently_department']);?>
                </div>
              </div>
            </label>
          </div>

        </section>

        <div class="reviewerProf__bottom-wrap" style="margin-bottom:5px;">
          <!-- 今のままだとデベロッパーツールでstyle=display:none;を消されるとDM不可の人でもDMできてしまうので対策を考える。 -->
          <div class="reviewerProf__bottom-Impossible reviewerProf__bottom-link" <?php if($listProp['reviews'][0]['dm_state'] === '1') echo "style=display:none;"?>>DM不可</div>
          <div class="reviewerProf__bottom-return reviewerProf__bottom-link" <?php if($listProp['reviews'][0]['dm_state'] === '0') echo "style=display:none;"?> onclick="location.href='DM.php?toUser_id=<?php echo $listProp['reviews'][0]['employee_id'] ?>'">DMを開始する</div>
          <!-- 送信処理に沿って画面遷移 -->
          <input type="submit" name='update-button' class="reviewerProf__bottom-next reviewerProf__bottom-link" value="このユーザーを通報する">
        </div>

      </form>
    </section>

    <!-- ========================== -->

    <section class="revDeCompanyInfo">

      <div class="revDeCompanyInfo__header">
        <div class="revDeCompanyInfo__header-mainWrap">
          <div class="revDeCompanyInfo__header-title"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?></div>
          <div class="revDeCompanyInfo__header-subWrap">
          <div class="revDeCompanyInfo__header-compDetailLink" onclick="location.href='companyInformationDetails.php?comp_id=<?php echo $listProp['company'][0]['id'] ?>'">
          この会社の詳細ページへ
          </div>
        </div>
      </div>

      </div>

      <div class="revDeCompanyInfo__content">
        <div class="revDeCompanyInfo__content-enrollmentPeriodInformation">
          レビュー者の在籍期間情報
        </div>
        <div class="revDeCompanyInfo__content-enrollmentStatusJoiningRoute-wrap">
          <div class="revDeCompanyInfo__content-enrollmentStatus">
            在籍状況
            <?php echo etc::sanitize($listProp['reviews'][0]['enrollment_status']);?>
          </div>
          <div class="revDeCompanyInfo__content-joiningRoute">
            入社経路
            <?php echo etc::sanitize($listProp['reviews'][0]['joining_route']);?>
          </div>
        </div>
        <div class="revDeCompanyInfo__content-occupationAtTheTimeOfEnrollmentJobTitleAtTheTimeOfEnrollment-wrap">
          <div class="revDeCompanyInfo__content-occupationAtTheTimeOfEnrollment">
            在籍時の職種
            <?php echo etc::sanitize($listProp['reviews'][0]['occupation']);?>
          </div>
          <div class="revDeCompanyInfo__content-jobTitleAtTheTimeOfEnrollment">
            在籍時の役職
            <?php echo etc::sanitize($listProp['reviews'][0]['position']);?>
          </div>
        </div>
        <div class="revDeCompanyInfo__content-employmentStatusEnrollmentPeriod-wrap">
          <div class="revDeCompanyInfo__content-employmentStatus">
            雇用形態
            <?php echo etc::sanitize($listProp['reviews'][0]['employment_status']);?>
          </div>
          <div class="revDeCompanyInfo__content-enrollmentPeriod">
            在籍期間
            <?php echo etc::sanitize($listProp['reviews'][0]['enrollment_period']);?>
          </div>
        </div>
      </div>

    </section>

    <!-- ========================== -->

    <!-- お気に入り機能の為のクラス -->
    <section class="reviewFavoriteRegiste">
      <div class="reviewFavoriteRegiste__content-wrap">
        <!-- data-の後ろはスネークケースでは無いとデータの管理対象にならない -->
        <!-- js-click-likeの後ろの処理は、他から遷移してきた時点でお気に入り登録がされているかどうかを確認する物。 -->
        <div class="reviewFavoriteRegiste__content-main js-click-like <?php if(etc::isLike($_SESSION['user_id'],$listProp['reviews'][0]['id'])){ echo 'activeLike'; } ?>"
        data-reviewid="<?php echo etc::sanitize($listProp['reviews'][0]['id']); ?>">
          このユーザーのレビューをお気に入り登録する
        </div>
        <span class="reviewFavoriteRegiste__content-sub">(ここに星マークをいれる)</span>
      </div>
    </section>

    <!-- ========================== -->

    <section class="companyReviewDetail">
      <div class="companyReviewDetail-title">会社レビュー詳細</div>

      <div class="companyReviewDetail__content-mainWrap">

        <div class="companyReviewDetail__content-InHouseSystem">
          <div class="companyReviewDetail__content-InHouseSystem-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-InHouseSystem-subWrap">
            <span class="companyReviewDetail__content-InHouseSystem-icon"></span>
            <div class="companyReviewDetail__content-InHouseSystem-kind">社内制度</div>
            <span class="companyReviewDetail__content-InHouseSystem-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-InHouseSystem-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['in_company_system']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-corporateCulture">
          <div class="companyReviewDetail__content-corporateCulture-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-corporateCulture-subWrap">
            <span class="companyReviewDetail__content-corporateCulture-icon">アイコン</span>
            <div class="companyReviewDetail__content-corporateCulture-kind">企業文化</div>
            <span class="companyReviewDetail__content-corporateCulture-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-corporateCulture-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['corporate_culture']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-OrganizationalStructure">
          <div class="companyReviewDetail__content-OrganizationalStructure-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-OrganizationalStructure-subWrap">
            <span class="companyReviewDetail__content-OrganizationalStructure-icon">アイコン</span>
            <div class="companyReviewDetail__content-OrganizationalStructure-kind">組織体制</div>
            <span class="companyReviewDetail__content-OrganizationalStructure-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-OrganizationalStructure-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['organizational_structure']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-EaseOfWorkForWomen">
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-subWrap">
            <span class="companyReviewDetail__content-EaseOfWorkForWomen-icon">アイコン</span>
            <div class="companyReviewDetail__content-EaseOfWorkForWomen-kind">女性の働きやすさ</div>
            <span class="companyReviewDetail__content-EaseOfWorkForWomen-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['ease_of_work_for_women']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-RewardingWork">
          <div class="companyReviewDetail__content-RewardingWork-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-RewardingWork-subWrap">
            <span class="companyReviewDetail__content-RewardingWork-icon">アイコン</span>
            <div class="companyReviewDetail__content-RewardingWork-kind">働きがい</div>
            <span class="companyReviewDetail__content-RewardingWork-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-RewardingWork-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['rewarding_work']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany">
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-subWrap">
            <span class="companyReviewDetail__content-gapBeforeJoiningTheCompany-icon">アイコン</span>
            <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-kind">入社前のギャップ</div>
            <span class="companyReviewDetail__content-gapBeforeJoiningTheCompany-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['image_gap']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-BusinessOutlook">
          <div class="companyReviewDetail__content-BusinessOutlook-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-BusinessOutlook-subWrap">
            <span class="companyReviewDetail__content-BusinessOutlook-icon">アイコン</span>
            <div class="companyReviewDetail__content-BusinessOutlook-kind">事業展望</div>
            <span class="companyReviewDetail__content-BusinessOutlook-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-BusinessOutlook-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['business_outlook']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-StrengthsAndWeaknesses">
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-companyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-subWrap">
            <span class="companyReviewDetail__content-StrengthsAndWeaknesses-icon">アイコン</span>
            <div class="companyReviewDetail__content-StrengthsAndWeaknesses-kind">強み・弱み</div>
            <span class="companyReviewDetail__content-StrengthsAndWeaknesses-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['strengths_and_weaknesses']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-annualIncomeAndSalary">
          <div class="companyReviewDetail__content-annualIncomeAndSalary-CompanyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-annualIncomeAndSalary-subWrap">
            <span class="companyReviewDetail__content-annualIncomeAndSalary-icon"></span>
            <div class="companyReviewDetail__content-annualIncomeAndSalary-kind">年収・給与</div>
            <span class="companyReviewDetail__content-annualIncomeAndSalary-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-annualIncomeAndSalary-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['annual_income_salary']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-Welfare">
          <div class="companyReviewDetail__content-Welfare-CompanyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-Welfare-subWrap">
            <span class="companyReviewDetail__content-Welfare-icon">アイコン</span>
            <div class="companyReviewDetail__content-Welfare-kind">福利厚生</div>
            <span class="companyReviewDetail__content-Welfare-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-Welfare-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['welfare_office_environment']);?>
          </div>
        </div>

        <div class="companyReviewDetail__content-generalComment">
          <div class="companyReviewDetail__content-generalComment-CompanyName"><?php echo etc::sanitize($listProp['company'][0]['company_name']);?>のレビュー</div>
          <div class="companyReviewDetail__content-generalComment-subWrap">
            <span class="companyReviewDetail__content-generalComment-icon">アイコン</span>
            <div class="companyReviewDetail__content-generalComment-kind">総評</div>
            <span class="companyReviewDetail__content-generalComment-date">投稿日<span class="date"><?php echo etc::sanitize($listProp['reviews'][0]['create_date']);?></span></span>
          </div>
          <div class="companyReviewDetail__content-generalComment-about">
            <?php echo etc::sanitize($listProp['reviews'][0]['general_estimation']);?>
          </div>
        </div>

      </div>


      <div class="__pageTransition">
        <div class="__pageTransition-contentWrap">
          <span class="__pageTransition-leftArrow">◁</span>
            <div class="__pageTransition-guideNumber">12345</div>
          <span class="__pageTransition-rightArrow">▷</span>
        </div>
      </div>

  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>



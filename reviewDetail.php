<!--アカウント作成関係処理-->
<?php

  // declare(strict_types=1);
  //主にuseを扱う際のルートディレクトリ指定に使ってる。
  require('vendor/autoload.php');

  use \PDO;
  use \RuntimeException;
  use \Exception;
  use classes\admin\signup;
  use classes\admin\login;
  use classes\db\dbConnectFunction;
  use classes\db\dbConnectPDO;
  use classes\debug\debugFunction;

  //デバック関係のメッセージも一通りまとめる。
  //デバックログスタートなどの補助的用自作関数も一通りまとめてメッセージファイルに継承する。
  debugFunction::logSessionSetUp();
  debugFunction::debug('「「「「「「「「「「「「「「「「「「「');
  debugFunction::debug('レビュー詳細ページ');
  debugFunction::debug('「「「「「「「「「「「「「');
  debugFunction::debugLogStart();
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

    <!-- BEMに沿った命名の都合上ここのみ切り分ける -->
    <section class="middleElement">


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


        <div class="reviewerProf__detail">

          <label class="">
            <div class="reviewerProf__name">
                <div class="reviewerProf__name-areaMsg">

                </div>
                <h1 class="reviewerProf__name-element">name</h1>
                <input class="reviewerProf__name-output" type="text" name="username" value="">
            </div>
          </label>

          <div class="reviewerProf__ageTel-Wrap">

          <label class="">
            <div class="reviewerProf__age">
                <div class="reviewerProf__age-areaMsg">

                </div>
                <div class="reviewerProf__age-element">age</div>
                <input class="reviewerProf__age-output" type="text" name="age" value="">
            </div>
          </label>

          <label class="">
            <div class="reviewerProf__tel">
            <div class="reviewerProf__tel-areaMsg">

                </div>
                <div class="reviewerProf__tel-element">tel</div>
                <input class="reviewerProf__tel-output" type="text" name="tel" value="">
            </div>
          </label>

          </div>

          <label class="">
            <div class="reviewerProf__address">
                <div class="reviewerProf__address-areaMsg">

                </div>
                <div class="reviewerProf__address-element">address</div>
                <input class="reviewerProf__address-output" type="text" name="address" value="">
            </div>
          </label>

          <label class="">
            <div class="reviewerProf__dmState">
                <div class="reviewerProf__dmState-areaMsg">

                </div>
                <div class="reviewerProf__dmState-element">DM可否</div>
                  <!-- 許可か拒否の二択から選択できる様にする。 -->
                  <input class="reviewerProf__dmState-output" type="text" name="dmState" value="">
                </div>
            </div>
          </label>

          <div class="reviewerProf__employeeInfoWrap">
            <label class="">
              <div class="reviewerProf__affiliationCompany">
                <div class="reviewerProf__affiliationCompany-areaMsg">
                </div>
                <h1 class="reviewerProf__affiliationCompany-element">現所属会社</h1>
                <input class="reviewerProf__affiliationCompany-output" type="text" name="affiliationCompany" value="">
              </div>
            </label>

            <div class="reviewerProf__incumbentPositionWrap">
              <label class="">
                <div class="reviewerProf__incumbent">
                  <div class="reviewerProf__incumbent-areaMsg">

                  </div>
                  <div class="reviewerProf__incumbent-element">現職</div>
                  <input class="reviewerProf__incumbent-output" type="text" name="incumbent" value="">
                </div>
              </label>

              <label class="">
                <div class="reviewerProf__Position">
                  <div class="reviewerProf__Position-areaMsg">

                  </div>
                  <div class="reviewerProf__Position-element">現役職</div>
                  <input class="reviewerProf__Position-output" type="text" name="position" value="">
                </div>
              </label>
            </div>

            <label class="">
              <div class="reviewerProf__currentDepartment">
                <div class="reviewerProf__currentDepartment-areaMsg">

                </div>
                <div class="reviewerProf__currentDepartment-element">現部署</div>
                <input class="reviewerProf__currentDepartment-output" type="text" name="currentDepartment" value="">
              </div>
            </label>
          </div>

        </section>

        <div class="reviewerProf__bottom-wrap" style="margin-bottom:5px;">
          <!-- post内容を初期化したのち、マイページへ移動 -->
          <input type="submit" name='cancel-button' class="reviewerProf__bottom-return reviewerProf__bottom-link" value="DMを開始する">
          <!-- 送信処理に沿って画面遷移 -->
          <input type="submit" name='update-button' class="reviewerProf__bottom-next reviewerProf__bottom-link" value="このユーザーを通報する">
        </div>

      </form>
    </section>

    <section class="revDeCompanyInfo">
      <div class="revDeCompanyInfo__header">
        <div class="revDeCompanyInfo__mainWrap">
          <div class="revDeCompanyInfo__title">サンプル株式会社</div>
          <div class="revDeCompanyInfo__subWrap">
            <div class="revDeCompanyInfo__totalNumberOfPostedReviews">投稿レビュー総数:<span class="revDeCompanyInfo__countNum">○○</span>件</div>
            <div class="revDeCompanyInfo__compDetailLink">この会社の詳細ページへ</div>
          </div>
        </div>
      </div>

      <div class="revDeCompanyInfo__content">

        <div class="revDeCompanyInfo__content-enrollmentPeriodInformation">レビュー者の在籍期間情報</div>

        <div class="revDeCompanyInfo__content-enrollmentStatusJoiningRoute-wrap">
          <div class="revDeCompanyInfo__content-enrollmentStatus">在籍状況</div>
          <div class="revDeCompanyInfo__content-joiningRoute">入社経路</div>
        </div>

        <div class="revDeCompanyInfo__content-wrap">
          <div class="revDeCompanyInfo__content-occupationAtTheTimeOfEnrollmentJobTitleAtTheTimeOfEnrollment-wrap">
            <div class="revDeCompanyInfo__content-occupationAtTheTimeOfEnrollment">在籍時の職種</div>
            <div class="revDeCompanyInfo__content-jobTitleAtTheTimeOfEnrollment">在籍時の役職</div>
          </div>
          <div class="revDeCompanyInfo__content-employmentStatusEnrollmentPeriod-wrap">
            <div class="revDeCompanyInfo__content-employmentStatus">雇用形態</div>
            <div class="revDeCompanyInfo__content-enrollmentPeriod">在籍期間</div>
          </div>
        </div>
      </div>
    </section>

    <section class="reviewFavoriteRegiste">
      <div class="reviewFavoriteRegiste__content-wrap">
        <div class="reviewFavoriteRegiste__content-main">
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
          <div class="companyReviewDetail__content-InHouseSystem-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-InHouseSystem-subWrap">
            <span class="companyReviewDetail__content-InHouseSystem-icon"></span>
            <div class="companyReviewDetail__content-InHouseSystem-kind">社内制度</div>
            <span class="companyReviewDetail__content-InHouseSystem-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-InHouseSystem-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-corporateCulture">
          <div class="companyReviewDetail__content-corporateCulture-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-corporateCulture-subWrap">
            <span class="companyReviewDetail__content-corporateCulture-icon">アイコン</span>
            <div class="companyReviewDetail__content-corporateCulture-kind">企業文化</div>
            <span class="companyReviewDetail__content-corporateCulture-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-corporateCulture-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-OrganizationalStructure">
          <div class="companyReviewDetail__content-OrganizationalStructure-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-OrganizationalStructure-subWrap">
            <span class="companyReviewDetail__content-OrganizationalStructure-icon">アイコン</span>
            <div class="companyReviewDetail__content-OrganizationalStructure-kind">組織体制</div>
            <span class="companyReviewDetail__content-OrganizationalStructure-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-OrganizationalStructure-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-EaseOfWorkForWomen">
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-subWrap">
            <span class="companyReviewDetail__content-EaseOfWorkForWomen-icon">アイコン</span>
            <div class="companyReviewDetail__content-EaseOfWorkForWomen-kind">女性の働きやすさ</div>
            <span class="companyReviewDetail__content-EaseOfWorkForWomen-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-EaseOfWorkForWomen-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-RewardingWork">
          <div class="companyReviewDetail__content-RewardingWork-companyName">
          サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-RewardingWork-subWrap">
            <span class="companyReviewDetail__content-RewardingWork-icon">アイコン</span>
            <div class="companyReviewDetail__content-RewardingWork-kind">働きがい</div>
            <span class="companyReviewDetail__content-RewardingWork-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-RewardingWork-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany">
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-subWrap">
            <span class="companyReviewDetail__content-gapBeforeJoiningTheCompany-icon">アイコン</span>
            <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-kind">入社前のギャップ</div>
            <span class="companyReviewDetail__content-gapBeforeJoiningTheCompany-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-gapBeforeJoiningTheCompany-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-BusinessOutlook">
          <div class="companyReviewDetail__content-BusinessOutlook-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-BusinessOutlook-subWrap">
            <span class="companyReviewDetail__content-BusinessOutlook-icon">アイコン</span>
            <div class="companyReviewDetail__content-BusinessOutlook-kind">事業展望</div>
            <span class="companyReviewDetail__content-BusinessOutlook-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-BusinessOutlook-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-StrengthsAndWeaknesses">
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-companyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-subWrap">
            <span class="companyReviewDetail__content-StrengthsAndWeaknesses-icon">アイコン</span>
            <div class="companyReviewDetail__content-StrengthsAndWeaknesses-kind">強み・弱み</div>
            <span class="companyReviewDetail__content-StrengthsAndWeaknesses-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-StrengthsAndWeaknesses-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-annualIncomeAndSalary">
          <div class="companyReviewDetail__content-annualIncomeAndSalary-CompanyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-annualIncomeAndSalary-subWrap">
            <span class="companyReviewDetail__content-annualIncomeAndSalary-icon"></span>
            <div class="companyReviewDetail__content-annualIncomeAndSalary-kind">年収・給与</div>
            <span class="companyReviewDetail__content-annualIncomeAndSalary-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-annualIncomeAndSalary-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-Welfare">
          <div class="companyReviewDetail__content-Welfare-CompanyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-Welfare-subWrap">
            <span class="companyReviewDetail__content-Welfare-icon">アイコン</span>
            <div class="companyReviewDetail__content-Welfare-kind">福利厚生</div>
            <span class="companyReviewDetail__content-Welfare-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-Welfare-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
          </div>
        </div>

        <div class="companyReviewDetail__content-generalComment">
          <div class="companyReviewDetail__content-generalComment-CompanyName">サンプル株式会社のレビュー</div>
          <div class="companyReviewDetail__content-generalComment-subWrap">
            <span class="companyReviewDetail__content-generalComment-icon">アイコン</span>
            <div class="companyReviewDetail__content-generalComment-kind">総評</div>
            <span class="companyReviewDetail__content-generalComment-date">投稿日<span class="date">1111/11/11</span></span>
          </div>
          <div class="companyReviewDetail__content-generalComment-about">
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
            サンプルサンプルサンプルサンプルサンプルサンプルサンプルサンプル
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



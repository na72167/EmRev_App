<?php
  // タイトルの読み込み
  $Page_Title = ‘マイページ’;
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='マイページ画面';
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

  <?php
    require('./middleElement.php');
  ?>

    <section class="mypeUserProfile">
      <div class="mypeUserProfile__img-wrap">
        <img class="mypeUserProfile__img">
      </div>
      <div class="mypeUserProfile__detail">
        <div class="mypeUserProfile__name">
          <h1 class="mypeUserProfile__name-element">name</h1>
          <div class="mypeUserProfile__name-output">山田太郎</div>
        </div>
        <div class="mypeUserProfile__ageTel-Wrap">
          <div class="mypeUserProfile__age">
            <div class="mypeUserProfile__age-element">age</div>
            <div class="mypeUserProfile__age-output">00</div>
          </div>
          <div class="mypeUserProfile__tel">
            <div class="mypeUserProfile__tel-element">tel</div>
            <div class="mypeUserProfile__tel-output">000-0000-0000</div>
          </div>
        </div>
        <div class="mypeUserProfile__address">
          <div class="mypeUserProfile__address-element">adless</div>
          <div class="mypeUserProfile__address-output">東京都板橋区〇〇-0000-0</div>
        </div>
        <div class="mypeUserProfile__state">
          <div class="mypeUserProfile__state-element">state</div>
          <div class="mypeUserProfile__state-output">一般会員</div>
        </div>
      </div>
    </section>


    <!-- =================================== -->













    <section class="mypeMyReviewList">
      <h1 class="mypeMyReviewList__title">Latest Post Review List</h1>
      <div class="mypeMyReviewList__wrap">
        <div class="mypeMyReviewList__listWrap">
          <span class="mypeMyReviewList__scrollLeft">◁</span>
          <!-- =================================== -->

          <div class="mypeMyReviewList__detailElement">
            <div class="mypeMyReviewList__img-wrap">
              <img class="mypeMyReviewList__img">
            </div>
            <div class="mypeMyReviewList__detail">
              <div class="mypeMyReviewList__nameGood-Wrap">
                <div class="mypeMyReviewList__name">
                  <div class="mypeMyReviewList__name-element">投稿者名</div>
                  <div class="mypeMyReviewList__name-output">山田太郎</div>
                </div>
                <div class="mypeMyReviewList__good">
                  <div class="mypeMyReviewList__good-element">♡</div>
                  <div class="mypeMyReviewList__name-output">00</div>
                </div>
              </div>
              <div class="mypeMyReviewList__occupation">
                <div class="mypeMyReviewList__occupation-element">在籍時の職種</div>
                <div class="mypeMyReviewList__occupation-output">サンプルサンプル</div>
              </div>
              <div class="mypeMyReviewList__Posting-time">
                <div class="mypeMyReviewList__PostingTime-element">投稿時刻</div>
                <div class="mypeMyReviewList__Output">00:00</div>
              </div>
              <div class="mypeMyReviewList__ReviewDetail">
                <span class="mypeMyReviewList__ReviewDetail-link">このレビューを詳しく見る</span>
              </div>
            </div>
          </div>

          <!-- =================================== -->

          <div class="mypeMyReviewList__detailElement">
            <div class="mypeMyReviewList__img-wrap">
              <img class="mypeMyReviewList__img">
            </div>
            <div class="mypeMyReviewList__detail">
              <div class="mypeMyReviewList__nameGood-Wrap">
                <div class="mypeMyReviewList__name">
                  <div class="mypeMyReviewList__name-element">投稿者名</div>
                  <div class="mypeMyReviewList__name-output">山田太郎</div>
                </div>
                <div class="mypeMyReviewList__good">
                  <div class="mypeMyReviewList__good-element">♡</div>
                  <div class="mypeMyReviewList__name-output">00</div>
                </div>
              </div>
              <div class="mypeMyReviewList__occupation">
                <div class="mypeMyReviewList__occupation-element">在籍時の職種</div>
                <div class="mypeMyReviewList__occupation-output">サンプルサンプル</div>
              </div>
              <div class="mypeMyReviewList__Posting-time">
                <div class="mypeMyReviewList__PostingTime-element">投稿時刻</div>
                <div class="mypeMyReviewList__Output">00:00</div>
              </div>
              <div class="mypeMyReviewList__ReviewDetail">
                <span class="mypeMyReviewList__ReviewDetail-link">このレビューを詳しく見る</span>
              </div>
            </div>
          </div>

          <!-- =================================== -->
          <div class="mypeMyReviewList__detailElement">
            <div class="mypeMyReviewList__img-wrap">
              <img class="mypeMyReviewList__img">
            </div>
            <div class="mypeMyReviewList__detail">
              <div class="mypeMyReviewList__nameGood-Wrap">
                <div class="mypeMyReviewList__name">
                  <div class="mypeMyReviewList__name-element">投稿者名</div>
                  <div class="mypeMyReviewList__name-output">山田太郎</div>
                </div>
                <div class="mypeMyReviewList__good">
                  <div class="mypeMyReviewList__good-element">♡</div>
                  <div class="mypeMyReviewList__name-output">00</div>
                </div>
              </div>
              <div class="mypeMyReviewList__occupation">
                <div class="mypeMyReviewList__occupation-element">在籍時の職種</div>
                <div class="mypeMyReviewList__occupation-output">サンプルサンプル</div>
              </div>
              <div class="mypeMyReviewList__Posting-time">
                <div class="mypeMyReviewList__PostingTime-element">投稿時刻</div>
                <div class="mypeMyReviewList__Output">00:00</div>
              </div>
              <div class="mypeMyReviewList__ReviewDetail">
                <span class="mypeMyReviewList__ReviewDetail-link">このレビューを詳しく見る</span>
              </div>
            </div>
          </div>

            <!-- =================================== -->
          <div class="mypeMyReviewList__detailElement">
            <div class="mypeMyReviewList__img-wrap">
              <img class="mypeMyReviewList__img">
            </div>
            <div class="mypeMyReviewList__detail">
              <div class="mypeMyReviewList__nameGood-Wrap">
                <div class="mypeMyReviewList__name">
                  <div class="mypeMyReviewList__name-element">投稿者名</div>
                  <div class="mypeMyReviewList__name-output">山田太郎</div>
                </div>
                <div class="mypeMyReviewList__good">
                  <div class="mypeMyReviewList__good-element">♡</div>
                  <div class="mypeMyReviewList__name-output">00</div>
                </div>
              </div>
              <div class="mypeMyReviewList__occupation">
                <div class="mypeMyReviewList__occupation-element">在籍時の職種</div>
                <div class="mypeMyReviewList__occupation-output">サンプルサンプル</div>
              </div>
              <div class="mypeMyReviewList__Posting-time">
                <div class="mypeMyReviewList__PostingTime-element">投稿時刻</div>
                <div class="mypeMyReviewList__PostingTime-Output">00:00</div>
              </div>
              <div class="mypeMyReviewList__ReviewDetail">
                <span class="mypeMyReviewList__ReviewDetail-link">このレビューを詳しく見る</span>
              </div>
            </div>
          </div>
        <span class="mypeMyReviewList__scrollRight">▷</span>
        </div>
      <div class="mypeMyReviewList__ReviewListLink">投稿レビューをもっと見る</div>
    </section>





    <div class="myPostPreviewList-__dmNotification">
      <div class="myPostPreviewList-__dmNotification-title">DM通知一覧</div>
        <div class="myPostPreviewList-__dmNotification-list">

        <!-- ======================================================= -->
          <div class="myPostPreviewList-__dmNotification-detailNotification">
            <div class="myPostPreviewList-__dmNotification-postingTime">
              <div class="myPostPreviewList-__dmNotification-postingTimeElement">投稿日時</div>
              <div class="myPostPreviewList-__dmNotification-postingTimeOutput">2100/01/01</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postingDate">
              <div class="myPostPreviewList-__dmNotification-postingDateElement">投稿時刻</div>
              <div class="myPostPreviewList-__dmNotification-postingDateOutput">00:00:00</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postings">
              <div class="myPostPreviewList-__dmNotification-postingsElement">投稿内容</div>
              <div class="myPostPreviewList-__dmNotification-postingsOutput">サンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->

        <div class="myPostPreviewList-__dmNotification-detailNotification">
            <div class="myPostPreviewList-__dmNotification-postingTime">
              <div class="myPostPreviewList-__dmNotification-postingTimeElement">投稿日時</div>
              <div class="myPostPreviewList-__dmNotification-postingTimeOutput">2100/01/01</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postingDate">
              <div class="myPostPreviewList-__dmNotification-postingDateElement">投稿時刻</div>
              <div class="myPostPreviewList-__dmNotification-postingDateOutput">00:00:00</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postings">
              <div class="myPostPreviewList-__dmNotification-postingsElement">投稿内容</div>
              <div class="myPostPreviewList-__dmNotification-postingsOutput">サンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->

        <div class="myPostPreviewList-__dmNotification-detailNotification">
            <div class="myPostPreviewList-__dmNotification-postingTime">
              <div class="myPostPreviewList-__dmNotification-postingTimeElement">投稿日時</div>
              <div class="myPostPreviewList-__dmNotification-postingTimeOutput">2100/01/01</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postingDate">
              <div class="myPostPreviewList-__dmNotification-postingDateElement">投稿時刻</div>
              <div class="myPostPreviewList-__dmNotification-postingDateOutput">00:00:00</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postings">
              <div class="myPostPreviewList-__dmNotification-postingsElement">投稿内容</div>
              <div class="myPostPreviewList-__dmNotification-postingsOutput">サンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->

        <div class="myPostPreviewList-__dmNotification-detailNotification">
            <div class="myPostPreviewList-__dmNotification-postingTime">
              <div class="myPostPreviewList-__dmNotification-postingTimeElement">投稿日時</div>
              <div class="myPostPreviewList-__dmNotification-postingTimeOutput">2100/01/01</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postingDate">
              <div class="myPostPreviewList-__dmNotification-postingDateElement">投稿時刻</div>
              <div class="myPostPreviewList-__dmNotification-postingDateOutput">00:00:00</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postings">
              <div class="myPostPreviewList-__dmNotification-postingsElement">投稿内容</div>
              <div class="myPostPreviewList-__dmNotification-postingsOutput">サンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->

        <div class="myPostPreviewList-__dmNotification-detailNotification">
            <div class="myPostPreviewList-__dmNotification-postingTime">
              <div class="myPostPreviewList-__dmNotification-postingTimeElement">投稿日時</div>
              <div class="myPostPreviewList-__dmNotification-postingTimeOutput">2100/01/01</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postingDate">
              <div class="myPostPreviewList-__dmNotification-postingDateElement">投稿時刻</div>
              <div class="myPostPreviewList-__dmNotification-postingDateOutput">00:00:00</div>
            </div>
            <div class="myPostPreviewList-__dmNotification-postings">
              <div class="myPostPreviewList-__dmNotification-postingsElement">投稿内容</div>
              <div class="myPostPreviewList-__dmNotification-postingsOutput">サンプルサンプルサンプルサンプル...</div>
            </div>
          </div>
        <!-- ======================================================= -->
        </div>
      <span>もっと見る</span>
    </div>







    <!-- ======================================================= -->

    <div class="favoriteMyReviewList">
      <h1 class="favoriteMyReviewList-title">お気に入りレビュー一覧</h1>
      <div class="favoriteMyReviewList-wrap">
        <span class="favoriteMyReviewList-scrollLeft">◁</span>
          <div class="favoriteMyReviewList-listWrap">

          <!-- =================================== -->
            <div class="favoriteMyReviewList-detailElement">
              <img class="favoriteMyReviewList-img">
              <div class="favoriteMyReviewList-detail">
                <div class="favoriteMyReviewList-nameGoodWrap">
                  <div class="favoriteMyReviewList-name">
                    <div class="favoriteMyReviewList-nameElement">投稿者名</div>
                    <div class="favoriteMyReviewList-nameOutput">山田太郎</div>
                  </div>
                  <div class="favoriteMyReviewList-good">
                    <div class="favoriteMyReviewList-goodElement">♡</div>
                    <div class="favoriteMyReviewList-nameOutput">00</div>
                  </div>
                </div>
                <div class="favoriteMyReviewList-occupation">
                  <div class="favoriteMyReviewList-occupationElement">在籍時の職種</div>
                  <div class="favoriteMyReviewList-occupationOutput">サンプルサンプル</div>
                </div>
                <div class="favoriteMyReviewList-PostingTime">
                  <div class="favoriteMyReviewList-PostingTimeElement">投稿時刻</div>
                  <div class="favoriteMyReviewList-Output">00:00</div>
                </div>
                <div class="favoriteMyReviewList-ReviewDetail">
                  <span>このレビューを詳しく見る</span>
                </div>
              </div>
            </div>
            <!-- =================================== -->
            <div class="favoriteMyReviewList-detailElement">
              <img class="favoriteMyReviewList-img">
              <div class="favoriteMyReviewList-detail">
                <div class="favoriteMyReviewList-nameGoodWrap">
                  <div class="favoriteMyReviewList-name">
                    <div class="favoriteMyReviewList-nameElement">投稿者名</div>
                    <div class="favoriteMyReviewList-nameOutput">山田太郎</div>
                  </div>
                  <div class="favoriteMyReviewList-good">
                    <div class="favoriteMyReviewList-goodElement">♡</div>
                    <div class="favoriteMyReviewList-nameOutput">00</div>
                  </div>
                </div>
                <div class="favoriteMyReviewList-occupation">
                  <div class="favoriteMyReviewList-occupationElement">在籍時の職種</div>
                  <div class="favoriteMyReviewList-occupationOutput">サンプルサンプル</div>
                </div>
                <div class="favoriteMyReviewList-PostingTime">
                  <div class="favoriteMyReviewList-PostingTimeElement">投稿時刻</div>
                  <div class="favoriteMyReviewList-Output">00:00</div>
                </div>
                <div class="favoriteMyReviewList-ReviewDetail">
                  <span>このレビューを詳しく見る</span>
                </div>
              </div>
            </div>
            <!-- =================================== -->
            <div class="favoriteMyReviewList-detailElement">
              <img class="favoriteMyReviewList-img">
              <div class="favoriteMyReviewList-detail">
                <div class="favoriteMyReviewList-nameGoodWrap">
                  <div class="favoriteMyReviewList-name">
                    <div class="favoriteMyReviewList-nameElement">投稿者名</div>
                    <div class="favoriteMyReviewList-nameOutput">山田太郎</div>
                  </div>
                  <div class="favoriteMyReviewList-good">
                    <div class="favoriteMyReviewList-goodElement">♡</div>
                    <div class="favoriteMyReviewList-nameOutput">00</div>
                  </div>
                </div>
                <div class="favoriteMyReviewList-occupation">
                  <div class="favoriteMyReviewList-occupationElement">在籍時の職種</div>
                  <div class="favoriteMyReviewList-occupationOutput">サンプルサンプル</div>
                </div>
                <div class="favoriteMyReviewList-PostingTime">
                  <div class="favoriteMyReviewList-PostingTimeElement">投稿時刻</div>
                  <div class="favoriteMyReviewList-Output">00:00</div>
                </div>
                <div class="favoriteMyReviewList-ReviewDetail">
                  <span>このレビューを詳しく見る</span>
                </div>
              </div>
            </div>
            <!-- =================================== -->
            <div class="favoriteMyReviewList-detailElement">
              <img class="favoriteMyReviewList-img">
              <div class="favoriteMyReviewList-detail">
                <div class="favoriteMyReviewList-nameGoodWrap">
                  <div class="favoriteMyReviewList-name">
                    <div class="favoriteMyReviewList-nameElement">投稿者名</div>
                    <div class="favoriteMyReviewList-nameOutput">山田太郎</div>
                  </div>
                  <div class="favoriteMyReviewList-good">
                    <div class="favoriteMyReviewList-goodElement">♡</div>
                    <div class="favoriteMyReviewList-nameOutput">00</div>
                  </div>
                </div>
                <div class="favoriteMyReviewList-occupation">
                  <div class="favoriteMyReviewList-occupationElement">在籍時の職種</div>
                  <div class="favoriteMyReviewList-occupationOutput">サンプルサンプル</div>
                </div>
                <div class="favoriteMyReviewList-PostingTime">
                  <div class="favoriteMyReviewList-PostingTimeElement">投稿時刻</div>
                  <div class="favoriteMyReviewList-Output">00:00</div>
                </div>
                <div class="favoriteMyReviewList-ReviewDetail">
                  <span>このレビューを詳しく見る</span>
                </div>
              </div>
            </div>
            <!-- =================================== -->
          </div>
        <span class="favoriteMyPostPreviewList-__previewElement-scrollRight">▷</span>
      </div>
      <span>お気に入りレビューをもっと見る</span>
    </div>
    <!-- ======================================================= -->
  </section>

  <?php
  // フッター要素の読み込み
    require('./footer.php');
  ?>
</body>
</html>
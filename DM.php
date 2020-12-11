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
        <!-- 相手側DM -->
        <div class="dmScreen__contactBoard-contactPerson">
          <div class="dmScreen__contactBoard-imgStylePerson">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-personText"></div>
        </div>
        <!-- 自分側DM -->
        <div class="dmScreen__contactBoard-contactMyself">
          <div class="dmScreen__contactBoard-imgStyleMyself">
            <img href="#">
          </div>
          <div class="dmScreen__contactBoard-TextMyself"></div>
        </div>

      </div>

      <div class="dmScreen__inputForm">

        <form  class="dmScreen__inputForm-clickSignal">
          <input class="dmScreen__inputForm-style" placeholder="Type Something">
          <button class="dmScreen__inputForm-button"></button>
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
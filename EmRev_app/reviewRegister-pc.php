<?php
  // タイトルの読み込み
  $Page_Title = 'レビュー登録画面';
  $Intro__Text_Title ='Review Register';
  $Intro__Text_Sub ='投稿内容の確認';
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

<section class="revRegistPc-content">

<div class="revRegistPc-content__wrap">
  <?php
  require('./revProgress.php');
  ?>
<div class="revRegistPc-content__form-element">
  <div class="revRegistPc-content__form-wrap">
      <h4 class="revRegistPc-content__title">Post Company Review</h4>
      <h1 class="revRegistPc-content__sub">投稿内容の確認</h1>
      <from action="" class="revRegistPc-content__wrap">

        <input class="revRegistPc-content__input" placeholder="入社経路">
        <input class="revRegistPc-content__input" placeholder="在籍状況">
        <input class="revRegistPc-content__input" placeholder="在籍時の職種">
        <input class="revRegistPc-content__input" placeholder="在籍時の役職">
        <input class="revRegistPc-content__input" placeholder="在籍期間">
        <input class="revRegistPc-content__input" placeholder="在籍形態">
        <input class="revRegistPc-content__input" placeholder="福利厚生">
        <input class="revRegistPc-content__input" placeholder="勤務時間">

        <div class="revRegistPc-content__form-title">社内制度</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="社内制度について"></textarea>

        <div class="revRegistPc-content__form-title">企業文化</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="企業文化について"></textarea>

        <div class="revRegistPc-content__form-title">休暇</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="休暇について"></textarea>

        <div class="revRegistPc-content__form-title">組織体制</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="組織体制について"></textarea>

        <div class="revRegistPc-content__form-title">女性の働きやすさ</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="女性の働きやすさについて"></textarea>

        <div class="revRegistPc-content__form-title">福利厚生</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="福利厚生について"></textarea>

        <div class="revRegistPc-content__form-title">入社前とのギャップ</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="入社前とのギャップ"></textarea>

        <div class="revRegistPc-content__form-title">働きがい</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="働きがいについて"></textarea>

        <div class="revRegistPc-content__form-title">強み・弱み</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="強み・弱みについて"></textarea>

        <div class="revRegistPc-content__form-title">年収・給与</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="年収・給与について"></textarea>

        <div class="revRegistPc-content__form-title">事業展望</div>
        <textarea class="revRegistPc-content__form-areaForm" placeholder="事業展望について"></textarea>

        <div class="revRegistGc-content__form-conciseTitle">総合的なこの会社の印象や評価を20文字以内でお願いします。</div>
        <textarea class="revRegistGc-content__form-conciseAreaForm" placeholder="総評(簡潔にお願いします)"></textarea>

        <div class="revRegistGc-content__form-title">総評</div>
        <textarea class="revRegistGc-content__form-areaForm" placeholder="総評(詳しくお願いします)"></textarea>

        <div class="revRegistPc-content__bottom-wrap">
          <a href="reviewRegister-Pc.php" class="revRegistPc-content__bottom-link"><bottom class="revRegistPc-content__bottom-return">前の項目へ</bottom></a>
          <a href="reviewRegister-gc.php" class="revRegistPc-content__bottom-link"><bottom class="revRegistPc-content__bottom-next">投稿する</bottom></a>
        </div>
      </from>
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
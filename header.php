<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <?php tetote_meta_description(); ?>
  <?php /* <title>は add_theme_support('title-tag') とフィルターで自動生成 */ ?>
  <?php wp_head(); ?>
</head>

<body <?php body_class( 'exp-grid' ); ?> id='<?php echo get_custom_body_id(); ?>'>
  <header class="l-header p-header" id="js-header">
    <div class="p-header__inner">
      <h1 class="p-header__title">
        <a href="/">
          <img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_logo.svg" alt="TETOTE.co.ltd RECRUITING" width="250" height="61">
        </a>
      </h1>

      <div class="p-header__action">
        <a class="c-button--smallBW" href="/details/">募集要項</a>
        <a class="c-button--smallGG c-viga"href="/entry/">entry</a>
      </div>

      <button class="c-hamburger c-viga" id="js-hamburger"
              aria-controls="js-drawerBackground"
              aria-expanded="false"
              aria-label="メニューを開閉">
        <span class="c-hamburger__bar"></span>
        <span class="c-hamburger__bar"></span>
        <span class="c-hamburger__bar"></span>
        <span class="c-hamburger__text">menu</span>
      </button>
    </div><!-- .p-header__inner -->
  </header>

  <div class="p-drawer" id="js-drawerBackground" aria-hidden="true">
    <div class="p-drawer__inner">
      <div class="p-drawer__logo">
        <a href="/">
          <img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_logo.svg" alt="TETOTE.co.ltd RECRUITING" width="250" height="61">
        </a>
      </div>
      <div class="p-drawer__menu">
        <nav id="js-global-menu" aria-label="グローバルメニュー">
          <ul class="p-drawer__list">
            <li class="p-drawer__item"><a class="p-drawer__link" href="/about-us/"><span class="c-viga ">about us</span><span>TETOTEについて</span></a></li>
            <li class="p-drawer__item"><a class="p-drawer__link" href="/staff/"><span class="c-viga ">staff</span><span>社員について</span></a></li>
            <li class="p-drawer__item"><a class="p-drawer__link" href="/blog/"><span class="c-viga ">blog</span><span>採用ブログ</span></a></li>
            <li class="p-drawer__item"><a class="p-drawer__link" href="/benefits/"><span class="c-viga ">benefits</span><span>福利厚生について</span></a></li>
            <li class="p-drawer__item"><a class="p-drawer__link" href="/career/"><span class="c-viga ">carrer</span><span>研修制度とキャリアパス</span></a></li>
            <li class="p-drawer__item"><a class="p-drawer__link" href="/faq/"><span class="c-viga ">FAQ</span><span>よくある質問</span></a></li>
          </ul>
        </nav>

        <!-- ドロワー内のボタン群 -->
        <div class="p-drawer_button">
          <a class="c-button--smallBW" href="/details/">募集要項</a>
          <a class="c-button--smallGG c-viga"href="/entry/">entry</a>
        </div><!--.p-drawer_button" -->
      </div><!-- .p-drawer__menu -->
    </div><!-- .p-drawer__inner -->
  </div><!-- .p-drawer -->

  <?php if ( ! is_singular('staff') && is_singular('post') ) : ?>
  <main class="l-main" id="main">
    <div class="l-main__head p-main__head">
  <?php endif; ?>
      <?php
      // --- LowerHero: 表示対象ページ（ホワイトリスト）と固定文言 ---
      $lh = null;

      if ( is_page('about-us') ) {
        $lh = ['lead' => 'about us', 'title' => 'TETOTEについて', 'outline' => '私たちの理念を紹介をします。'];
      } elseif ( is_post_type_archive('staff') ) {
        $lh = ['lead' => 'staff', 'title' => '社員について', 'outline' => '弊社社員のリアルな声を紹介しています。'];
      } elseif ( is_home() ) {
        $lh = ['lead' => 'blog', 'title' => '採用ブログ', 'outline' => '採用情報やイベント情報などをご紹介します。'];
      } elseif ( is_page('benefits') ) {
        $lh = ['lead' => 'benefits', 'title' => '福利厚生について', 'outline' => '充実した福利厚生制度を設けています。'];
      } elseif ( is_page('career') ) {
        $lh = ['lead' => 'career', 'title' => '研修制度とキャリアパス', 'outline' => 'キャリアパスを支える充実した、研修制度'];
      } elseif ( is_page('details') ) {
        $lh = ['lead' => 'details', 'title' => '募集要項', 'outline' => 'TETOTEは幅広く仲間を募集しています。'];
      } elseif ( is_page('faq') ) {
        $lh = ['lead' => 'FAQ', 'title' => 'よくある質問', 'outline' => '皆様からよく頂くご質問にお答えします。'];
      }
      ?>

      <?php if ( $lh ) : ?>
        <div class="c-lowerHero">
          <div class="l-inner--lower c-lowerHero__inner">
            <p class="c-lowerHero__lead c-viga"><?php echo esc_html($lh['lead']); ?></p>
            <h1 class="c-lowerHero__title"><?php echo esc_html($lh['title']); ?></h1>
            <?php if (!empty($lh['outline'])): ?>
              <p class="c-lowerHero__outline"><?php echo esc_html($lh['outline']); ?></p>
            <?php endif; ?>
          </div>
        </div><!-- .p-lowerHero -->
      <?php endif; ?>

      <?php if ( ! is_front_page() && ! is_singular('staff') && ! is_singular('post') ) : ?>
        <!-- ▼ breadcrumb =============================== -->
        <?php breadcrumb(); ?>
        <!-- ▲ breadcrumb =============================== -->
      <?php endif; ?>
      <?php if ( ! is_singular('staff') ) : ?>
      </div><!-- .l-main__head .p-main__head-->
      <?php endif; ?>
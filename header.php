<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex">
  <?php tetote_meta_description(); ?>
  <?php /* <title>は add_theme_support('title-tag') とフィルターで自動生成 */ ?>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Poppins&family=Viga&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?php echo esc_url(get_theme_file_uri()); ?>/css/style.css">
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
            <li class="p-drawer__item"><a class="p-drawer__link" href="/toptopBenefits/"><span class="c-viga ">topBenefits</span><span>福利厚生について</span></a></li>
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
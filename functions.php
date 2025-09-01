<?php
// ==============================
// テーマサポート
// ==============================
function custom_theme_support() {
  add_theme_support( 'title-tag' );
  add_theme_support( 'post-thumbnails' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( "wp-block-styles" ) ;
  add_theme_support( 'responsive-embeds' );
  add_theme_support('html5',array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script'
  ));
  add_theme_support( 'custom-logo',array(
    //'width'       => 116,
    //'height'      => 57,
    //'flex-height' => true,
    //'flex-width'  => true,
    //'header-text' => array( 'site-title' ),
  ));
  add_theme_support( 'custom-background' );
  add_theme_support( 'align-wide' );
  add_theme_support( 'editor-styles' );
  add_editor_style( array( '/css/editor-style.css' ) );
  //add_theme_support( "custom-header", $array );
  register_nav_menus( array(
    'main_nav' => 'main-nav',
     ));
}
add_action('after_setup_theme', 'custom_theme_support');


// ==============================
// meta title の出し分け
// ==============================
add_filter('pre_get_document_title', function ($title) {
  $suffix = '株式会社TETOTE';

  if ( is_front_page() ) {
    return '採用特設サイト | ' . $suffix;

  } elseif ( is_home() ) {
    return '採用ブログ | ' . $suffix;

  } elseif ( function_exists('is_post_type_archive') && is_post_type_archive('staff') ) {
    return '社員について | ' . $suffix;

  } elseif ( is_singular() ) {
    return single_post_title('', false) . ' | ' . $suffix;

  } elseif ( is_archive() ) {
    return wp_strip_all_tags( get_the_archive_title() ) . ' | ' . $suffix;

  } elseif ( is_search() ) {
    return '検索結果 | ' . $suffix;

  } elseif ( is_404() ) {
    return 'ページが見つかりません | ' . $suffix;
  }

  return $title;
});


// ==============================
// meta description の出し分け
// ==============================

function tetote_meta_description() {
  $base = 'テクノロジーで社会課題を解決する。AIやビッグデータ分析などの技術を活用した社会課題解決サービスを提供するTETOTEの採用サイト。';

  // TOPページ（固定ページhome）
  if ( is_front_page() ) {
    $desc = $base;

  // 採用ブログ一覧ページ（投稿ページに設定した固定ページ /blog）
  } elseif ( is_home() ) {
    $desc = $base . 'このページでは、採用ブログについて解説しています。';

  // スタッフ一覧（CPTアーカイブ /staff）
  } elseif ( function_exists('is_post_type_archive') && is_post_type_archive('staff') ) {
    $desc = $base . 'このページでは、社員について解説しています。';

  // 採用ブログ詳細ページ
  } elseif ( is_singular('post') ) {
    $title = get_the_title();
    $desc  = $base . 'このページでは、' . $title . 'について解説しています。';

  // スタッフ詳細ページ
  } elseif ( is_singular('staff') ) {
    $title = get_the_title();
    $desc  = $base . 'このページでは、' . $title . 'について解説しています。';

  // 固定ページ（about-us、faqなど）
  } elseif ( is_page() ) {
    $title = get_the_title();
    $desc  = $base . 'このページでは、' . $title . 'について解説しています。';

  // その他（カテゴリ・タグ・検索など）
  } elseif ( is_archive() ) {
    $archive_title = wp_strip_all_tags( get_the_archive_title() );
    $desc = $base . $archive_title . 'について解説しています。';

  } else {
    $desc = $base;
  }

  echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
}


// ==============================
// 外部ファイルの読み込み
// ==============================
function tetote_add_files(){

  // Google Fontsのpreconnectを追加
  wp_enqueue_style(
    'google-fonts-preconnect-googleapis',
    'https://fonts.googleapis.com', 
    array(), 
    null
  );
  wp_enqueue_style(
    'google-fonts-preconnect-gstatic',
    'https://fonts.gstatic.com', 
    array(), 
    null
  );

  // Google Fontの読み込み
  wp_enqueue_style(
    'tetote-fonts',
    'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Poppins&family=Viga&display=swap',
    array(),
    null
  );

  //swiper min.cssの読み込み
  wp_enqueue_style(
    'tetote-swiper-css',
    'https://unpkg.com/swiper@8/swiper-bundle.min.css',
    array(),
    null
  );

  // メインスクリプトの読み込み
  wp_enqueue_style(
    'costom-style',
    get_theme_file_uri('/css/style.css'),
    array('tetote-swiper-css'),
    filemtime( get_theme_file_path('/css/style.css')),
    null
  );

  // swiper.min.jsの読み込み（スライダー）
  wp_enqueue_script(
    'tetote-swiper-bundle',
    'https://unpkg.com/swiper@8/swiper-bundle.min.js',
    array(),
    null,
    true
  );

  // swiper.jsの読み込み）
  wp_enqueue_script(
    'tetote-swiper',
    get_theme_file_uri('/js/swiper.js'),
    array(),
    null,
    true
  );

  // メインスクリプトの読み込み
  wp_enqueue_script(
    'tetote-main',
    get_theme_file_uri('/js/main.js'),
    array('tetote-swiper-bundle', 'tetote-swiper'),
    '1.0',
    true
  );

}
add_action('wp_enqueue_scripts','tetote_add_files');


// ==============================
// bodyのidにスラッグを入れる
// ==============================
function get_custom_body_id() {
    if (is_singular()) {
        global $post;
        if ($post && isset($post->post_name)) {
            return esc_attr($post->post_name);
        }
    } elseif (is_category() || is_tag() || is_tax()) {
        $term = get_queried_object();
        if ($term && isset($term->slug)) {
            return 'archive-' . esc_attr($term->slug);
        }
    } elseif (is_404()) {
        return 'error-404';
    } elseif (is_search()) {
        return 'search-results';
    }
    
    return '';
}

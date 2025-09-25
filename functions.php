<?php
/*-------------------------------
 テーマサポート
-------------------------------*/
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
  add_image_size('post_eyecath', 1440, 422, true);
  add_editor_style( array( '/css/editor-style.css' ) );
  //add_theme_support( "custom-header", $array );
  register_nav_menus( array(
    'footer_nav' => 'footer-menu',
     ));
}
add_action('after_setup_theme', 'custom_theme_support');


/*-------------------------------
 meta title の出し分け
-------------------------------*/
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


/*-------------------------------
 meta description の出し分け
-------------------------------*/

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
    if ( mb_strpos( $title, 'について' ) !== false ) {
      $desc = $base . 'このページでは、' . $title . '解説しています。';
    } else {
      $desc = $base . 'このページでは、' . $title . 'について解説しています。';
    }

  // その他（カテゴリ・タグ・検索など）
  } elseif ( is_archive() ) {
    $archive_title = wp_strip_all_tags( get_the_archive_title() );
    $desc = $base . $archive_title . 'について解説しています。';

  } else {
    $desc = $base;
  }

  echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
}


/*-------------------------------
 外部ファイルの読み込み
-------------------------------*/
function tetote_add_files(){

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

  // swiper.jsの読み込み
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


/*-------------------------------------
 外部ファイルの読み込み2（フロントページのみ）
-------------------------------------*/
function load_home_script_on_front_page() {
    if ( is_front_page() ) {
      wp_enqueue_script(
      'tetote-home',
      get_theme_file_uri('/js/home.js'),
      array(),
      null,
      true
    );
  }
}
add_action( 'wp_enqueue_scripts', 'load_home_script_on_front_page' );

/*-------------------------------------
 外部ファイルの読み込み3（staffのみ）
-------------------------------------*/
function load_staff_script_on_front_page() {
    if ( is_singular('staff') ) {
      wp_enqueue_script(
      'tetote-staff',
      get_theme_file_uri('/js/staff.js'),
      array(),
      null,
      true
    );
  }
}
add_action( 'wp_enqueue_scripts', 'load_staff_script_on_front_page' );


/*-------------------------------
 bodyのidにスラッグを入れる
-------------------------------*/
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


/*-------------------------------
 パンくずリスト
-------------------------------*/
if ( ! defined('ABSPATH') ) exit;

if ( ! function_exists('breadcrumb') ) {
  function breadcrumb() {

    // TOP では何も出力しない
    if ( is_front_page() ) {
      return;
    }

    // 共通：WPオブジェクト
    $wp_obj = get_queried_object();

    // JSON-LD 用配列
    $json = [];

    // ユーティリティ：投稿タイプのスラッグ（rewrite['slug'] 優先）
    $get_pt_slug = function($post_type) {
      $pto = get_post_type_object($post_type);
      if ( $pto && ! empty($pto->rewrite['slug']) ) return $pto->rewrite['slug'];
      return $post_type;
    };

    // ユーティリティ：ブログアーカイブのURLと表示ラベル
    $get_blog_info = function() {
      $page_for_posts = get_option('page_for_posts');
      if ( $page_for_posts ) {
        return [
          'url'   => get_permalink($page_for_posts),
          'label' => 'blog',                 // 表示はスラッグ固定
          'name'  => get_the_title($page_for_posts) // JSON-LDはタイトル
        ];
      }
      // posts page 未設定なら /?post_type=post 相当（スラッグは blog 固定表示）
      return [
        'url'   => get_post_type_archive_link('post'),
        'label' => 'blog',
        'name'  => __('Blog')
      ];
    };

    // パンくず開始
    echo '<nav id="breadcrumb" class="c-breadcrumbs" aria-label="Breadcrumbs">';
    echo '<div class="l-inner--lower p-breadcrumbs__inner">';
    echo '<ol class="c-breadcrumbs__list">';

    // ルート：top
    echo '<li><a href="' . esc_url(home_url('/')) . '">top</a></li>';
    // JSON-LD: ルートはサイト名を name に（可読性）
    $json[] = [
      'id'   => esc_url(home_url('/')),
      'name' => get_bloginfo('name')
    ];

    // ====== ルーティング別 ======

    // 1) 固定ページ（/about-us, /benefits, /career, /details, /faq, /entry, /entry-thanks など）
    if ( is_page() && ! is_home() ) {
      $page_id = $wp_obj->ID;

      // 親がいれば、親→子の順に slug 表示
      if ( $wp_obj->post_parent ) {
        $anc = array_reverse( get_post_ancestors($page_id) );
        foreach ( $anc as $pid ) {
          $url   = get_permalink($pid);
          $slug  = get_post_field('post_name', $pid);
          $title = get_the_title($pid);

          echo '<li><a href="' . esc_url($url) . '">' . esc_html($slug) . '</a></li>';
          $json[] = ['id' => esc_url($url), 'name' => wp_strip_all_tags($title)];
        }
      }

      // 自身（slug 表示）
      $self_slug  = get_post_field('post_name', $page_id);
      $self_title = get_the_title($page_id);
      echo '<li aria-current="page">' . esc_html($self_slug) . '</li>';
      $json[] = ['id' => esc_url(get_permalink($page_id)), 'name' => wp_strip_all_tags($self_title)];
    }

    // 2) ブログ一覧（/blog）: is_home()
    elseif ( is_home() ) {
      $blog = $get_blog_info();
      echo '<li aria-current="page">' . esc_html($blog['label']) . '</li>';
      $json[] = ['id' => esc_url($blog['url']), 'name' => wp_strip_all_tags($blog['name'])];
    }

    // 3) 投稿（ブログ詳細）: タイトル表示
    elseif ( is_single() && get_post_type() === 'post' ) {
      $blog = $get_blog_info();
      // blog
      echo '<li><a href="' . esc_url($blog['url']) . '">' . esc_html($blog['label']) . '</a></li>';
      $json[] = ['id' => esc_url($blog['url']), 'name' => wp_strip_all_tags($blog['name'])];

      // current: タイトル表示
      $title = get_the_title($wp_obj);
      echo '<li aria-current="page">' . esc_html( wp_strip_all_tags($title) ) . '</li>';
      $json[] = ['id' => esc_url(get_permalink($wp_obj)), 'name' => wp_strip_all_tags($title)];
    }

    // 4) カスタム投稿タイプ（例：社員 single /staff/nishimura → slug 表示）
    elseif ( is_single() ) {
      $pt = get_post_type($wp_obj);
      $pt_slug = $get_pt_slug($pt);                // 例：staff
      $pt_url  = get_post_type_archive_link($pt);
      $pt_name = get_post_type_object($pt)->label; // JSON-LD表示名

      // アーカイブ（表示はスラッグ）
      if ( $pt_url ) {
        echo '<li><a href="' . esc_url($pt_url) . '">' . esc_html($pt_slug) . '</a></li>';
        $json[] = ['id' => esc_url($pt_url), 'name' => wp_strip_all_tags($pt_name)];
      }

      // current: slug 表示（nishimura）
      $self_slug  = get_post_field('post_name', $wp_obj->ID);
      $self_title = get_the_title($wp_obj->ID);
      echo '<li aria-current="page">' . esc_html($self_slug) . '</li>';
      $json[] = ['id' => esc_url(get_permalink($wp_obj->ID)), 'name' => wp_strip_all_tags($self_title)];
    }

    // 5) 投稿タイプアーカイブ（例：/staff）
    elseif ( is_post_type_archive() ) {
      $pt      = get_post_type();
      $pt_slug = $get_pt_slug($pt);
      $pt_obj  = get_post_type_object($pt);
      $pt_name = $pt_obj ? $pt_obj->label : $pt_slug;

      echo '<li aria-current="page">' . esc_html($pt_slug) . '</li>';
      $json[] = ['id' => esc_url(get_post_type_archive_link($pt)), 'name' => wp_strip_all_tags($pt_name)];
    }

    // 6) タクソノミーアーカイブ（必要最低限：slug表示）
    elseif ( is_tax() ) {
      $term = $wp_obj; // WP_Term
      $tax  = $term->taxonomy;

      // 親タームがあれば slug で
      if ( $term->parent ) {
        $anc = array_reverse( get_ancestors($term->term_id, $tax) );
        foreach ( $anc as $tid ) {
          $p = get_term($tid, $tax);
          $url  = get_term_link($p);
          $slug = $p->slug;
          echo '<li><a href="' . esc_url($url) . '">' . esc_html($slug) . '</a></li>';
          $json[] = ['id' => esc_url($url), 'name' => wp_strip_all_tags($p->name)];
        }
      }

      // current: slug
      echo '<li aria-current="page">' . esc_html($term->slug) . '</li>';
      $json[] = ['id' => esc_url(get_term_link($term)), 'name' => wp_strip_all_tags($term->name)];
    }

    // 7) 404ページ
    elseif ( is_404() ) {
        // HTML 表示（見た目は "404" 固定）
        echo '<li aria-current="page">404</li>';

        // JSON-LD（検索エンジン用に分かりやすいタイトルを入れる）
        $json[] = [
            'id'   => esc_url(home_url($_SERVER['REQUEST_URI'])),
            'name' => 'ページが見つかりません'
        ];
    }

    // ) 検索・日付・著者など（今回は使用想定外なので簡易）
    elseif ( is_search() ) {
      echo '<li aria-current="page">' . sprintf('search: %s', esc_html(get_search_query())) . '</li>';
    } elseif ( is_date() ) {
      // 例: /2025/09/ のようなページ
      $y = get_query_var('year'); $m = get_query_var('monthnum'); $d = get_query_var('day');
      $parts = array_filter([$y, $m ? sprintf('%02d',$m) : null, $d ? sprintf('%02d',$d) : null]);
      echo '<li aria-current="page">' . esc_html(implode('/', $parts)) . '</li>';
    } elseif ( is_author() ) {
      echo '<li aria-current="page">' . esc_html( $wp_obj->user_nicename ) . '</li>';
    } else {
      // フォールバック
      echo '<li aria-current="page">' . esc_html( wp_strip_all_tags( get_the_title() ) ) . '</li>';
    }

    echo '</ol>';

    // JSON-LD 出力
    if ( ! empty($json) ) {
      $items = [];
      $pos = 1;
      foreach ( $json as $e ) {
        $items[] = [
          '@type'    => 'ListItem',
          'position' => $pos++,
          'item'     => [
            '@id'  => $e['id'],
            'name' => $e['name'],
          ],
        ];
      }
      echo '<script type="application/ld+json">' .
        wp_json_encode([
          '@context'       => 'https://schema.org',
          '@type'          => 'BreadcrumbList',
          'name'           => 'パンくずリスト',
          'itemListElement'=> $items,
        ], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) .
      '</script>';
    }

    echo '</div>';
    echo '</nav>';
  }
}


/*--------------------------------------------------------------
  階層スラッグ対応ページテンプレートローダー（tmp/page 用）
  - 固定ページの親/子/孫…のスラッグを連結して候補を生成
  - 日本語スラッグ（UTF-8）/ASCII化の両方に対応
  - tmp/page/◯◯.php を優先順に locate_template で探索

  提供関数：
    - ys_get_parent_slugs($post): 親スラッグ配列（祖父→親→…）
    - ys_page_template_candidates($post): 候補相対パス一覧
    - ys_locate_page_template($post): 最初に見つかったテンプレのフルパス
--------------------------------------------------------------*/

if (!function_exists('ys_get_parent_slugs')) {
  /**
   * 祖父→親→…の順で親スラッグ配列を返す（多階層対応）
   * @param WP_Post|int|null $post
   * @return array
   */
  function ys_get_parent_slugs($post) {
    $slugs = [];
    //$post が WP_Post オブジェクトかどうか判定し、字（投稿ID）が来た場合はWP_Postオブジェクトに変換
    $obj = is_object($post) ? $post : get_post($post);
    //$obj が取得できなかったら、空の配列を返して終了
    if (!$obj) return $slugs;

    //$obj->post_parent が 0じゃない限り（親ページがある限り）、このループを回す
    while (!empty($obj->post_parent)) {
      //現在のページオブジェクト $obj から、親ページの ID を取り出し、get_post() で親ページの WP_Postオブジェクトを取得。
      $obj = get_post($obj->post_parent);
      //親ページが取得できなかった場合はループを抜ける
      if (!$obj) break;
      // 親ページの スラッグを $slugs に追加。post_name は日本語スラッグ可
      $slugs[] = $obj->post_name;
    }
    return array_reverse($slugs);
  }
}

if (!function_exists('ys_page_template_candidates')) {
  /**
   * tmp/page/ 以下で探すテンプレ候補一覧を優先順で返す（日本語スラッグ対応）
   * @param WP_Post|int|null $post
   * @return array  相対パス（locate_template 用）
   */
  function ys_page_template_candidates($post) {

    //$post を WP_Postオブジェクトに変換。投稿がなければ空配列を返す。
    $obj = is_object($post) ? $post : get_post($post);
    if (!$obj) return [];

    //親スラッグ配列を取得（例：['company', 'office']）
    $parents = ys_get_parent_slugs($obj); // 祖父→親→…
    //$self に現在ページのスラッグを代入。
    $self    = $obj->post_name;

    // 連結名（親-子-孫...）
    $joined_raw   = implode('-', array_merge($parents, [$self])); // そのまま array_merge() で「親スラッグ配列＋現在ページのスラッグ」を一つの配列にまとめる。
    $joined_ud    = urldecode($joined_raw);                        // URLエンコードされている場合に備えてデコード
    $joined_ascii = sanitize_title($joined_ud);                    // ASCII化（手動で英数命名してる時の拾い用）sanitize_title() はWordPress標準関数で、日本語をローマ字にしたり、スペースをハイフンにしたりする安全なファイル名を生成。例）「会社-アクセス」 → kaisha-akusesu

    $self_ud      = urldecode($self);
    $self_ascii   = sanitize_title($self_ud);

    // 優先候補のベース名（重複排除・空除去）例：['company-office-access', 'kaisha-akusesu', 'access', 'akusesu']
    $names = array_values(array_unique(array_filter([
      $joined_raw,
      $joined_ud,
      $joined_ascii,
      $self,
      $self_ud,
      $self_ascii,
    ])));

    // 相対パスに変換
    $paths = [];
    foreach ($names as $name) {
      $paths[] = 'tmp/page/' . $name . '.php';
    }
    return $paths;
  }
}

if (!function_exists('ys_locate_page_template')) {
  /**
   * 候補のうち最初に見つかったテンプレのフルパスを返す（なければ空文字）
   * @param WP_Post|int|null $post
   * @return string
   */
  function ys_locate_page_template($post) {
    $candidates = ys_page_template_candidates($post);
    foreach ($candidates as $rel) {
      //locate_template($rel) はWordPressの標準関数で、テーマ内で相対パスを渡すと、フルパスを返す。
      $path = locate_template($rel); 
       //最初に見つかったものを即リターン
      if ($path) return $path;
    }
    //見つからなければ空文字を返す。
    return ''; 
  }
}


/*-----------------------------------------------
 * staff詳細ページのurlに/blog/が挟まらないようにする
-----------------------------------------------*/
add_filter( 'register_post_type_args', 'tetote_override_staff_rewrite_args', 10, 2 );
function tetote_override_staff_rewrite_args( $args, $post_type ) {
    if ( $post_type !== 'staff' ) {
        return $args;
    }

    // rewrite を上書き（/staff/slug/ にしたい場合）
    $args['rewrite']    = array(
        'slug'       => 'staff',
        'with_front' => false,
    );

    // アーカイブスラッグも明示（/staff/）
    $args['has_archive'] = 'staff';

    return $args;
}


/*-----------------------------------------------
 * ACF の staff_slug フィールドを post_name に反映する
 * - ACF の保存後フックで実行
 * - 再帰防止のため静的フラグを使用
-----------------------------------------------*/
add_action('acf/save_post', 'tetote_sync_staff_slug_to_post_name', 20);

function tetote_sync_staff_slug_to_post_name( $post_id ) {
  // リビジョンは無視
  if ( wp_is_post_revision( $post_id ) ) {
    return;
  }

  // 投稿タイプが staff でなければ無視
  $post_type = get_post_type( $post_id );
  if ( $post_type !== 'staff' ) {
    return;
  }

  static $running = false;
  if ( $running ) {
    return; // 再帰防止
  }

  $running = true;

  // ACF フィールド名 'staff_slug' の値を取得（安全のため get_post_meta を使用）
  $acf_slug = get_post_meta( $post_id, 'staff_slug', true );

  // 空なら終了（運用で未入力の場合は何もしない）
  if ( empty( $acf_slug ) ) {
    $running = false;
    return;
  }

  // サニタイズしてスラッグ化
  $slug = sanitize_title( $acf_slug );

  // 現在の投稿情報を取得
  $post = get_post( $post_id );
  if ( ! $post ) {
    $running = false;
    return;
  }

  // 既に同じスラッグなら何もしない
  if ( $slug === $post->post_name ) {
    $running = false;
    return;
  }

  // 重複回避：WP のユニーク化関数を使う
  $unique_slug = wp_unique_post_slug( $slug, $post_id, $post->post_status, $post->post_type, $post->post_parent );

  // 投稿スラッグを更新（これが save をトリガーするが、静的フラグで再帰を防いでいる）
  wp_update_post( array(
    'ID'        => $post_id,
    'post_name' => $unique_slug,
  ) );

  $running = false;
}
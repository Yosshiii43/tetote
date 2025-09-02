<?php get_header(); ?>

<!-- ▼ content =========================================== -->
<div class="content">

  <!--ループ開始 -->
  <?php if (have_posts()) : while (have_posts()) :
    the_post(); ?>

  <!-- ▼ tmp =========================================== -->

  <!-- ▼その他（tmp/page/{slug}.php があればインクルード、親ページならば子ページのリストを表示） -->

  <?php
    // 現在のページのスラッグと親ページのスラッグを組み合わせてテンプレートパスを生成
    $slug_name = $post->post_name;
    $parent_slugs = ys_get_parent_slugs($post); 
    $template_slug = 'tmp/page/' . (!empty($parent_slugs) ? implode('-', $parent_slugs) . '-' : '') . $slug_name . '.php';

    // テンプレートファイルをインクルード
      $template_path = ys_locate_page_template($post); 
      if ($template_path) {
        include $template_path; // 例: tmp/page/会社-アクセス.php や tmp/page/company-access.php など
      } else {
      // 子ページのタイトルを取得して目次として表示
      $child_pages = get_pages(['child_of' => get_the_ID(), 'sort_column' => 'menu_order']);
      if (!empty($child_pages)) : ?>
        <div class="c-childPageToc">
          <ul class="c-childPageToc__items">
            <?php foreach ($child_pages as $child_page) : ?>
              <li class="c-childPageToc__item">
                <a href="<?php echo esc_url(get_permalink($child_page->ID)); ?>"
                  class="c-childPageToc__link">
                  <?php echo esc_html($child_page->post_title); ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif;
    }
  ?>
  <!-- ▲その他 -->

  <!-- ▲ tmp =================================================== -->

  <?php if(!empty($post->post_content)): //投稿画面から入力した本文を出力 ?>
  <div class="wp-post">
    <!-- 各コンポーネントブロックのクラス名はJSで付与 -->
    <?php the_content();?>

  </div>
  <?php endif; ?>

  <?php endwhile; else: //ページがないとき ?>
  <?php if (is_404()): ?>
  <?php get_template_part('tmp/page/404'); ?>
  <?php else : ?>
  <p>準備中です。</p>
  <?php endif; ?>
  <?php endif; ?>
  <!--ループ終了 -->

</div>
<!-- ▲ content =========================================== -->

</main>
<!-- ▲ container =================================================== -->

<?php get_footer(); ?>
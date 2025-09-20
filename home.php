<?php
// home.php — ブログ一覧（/blog/）用テンプレート
get_header();
?>

    <div class="l-main__body">
      <div class="l-inner--lower p-archiveBlog__inner">
        <div class="p-archiveBlog__contents">
          <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
              <?php get_template_part('tmp/module/blog-card'); ?>
            <?php endwhile; ?>
          <?php else : ?>
            <p>記事が見つかりませんでした。</p>
          <?php endif; ?>
        </div><!-- .p-archiveBlog__contents -->

        <div class="p-archiveBlog__pagination" aria-label="Posts pagination">  
          <?php
            // ページネーション
            the_posts_pagination( array(
              'mid_size' => 1,
              'prev_next' => false,
              'type' => 'list',
            ) );
            ?>
        </div>
        
      </div><!-- .p-archiveBlog__inner -->
    </div><!-- l-main__body -->
  </main>

<?php get_footer(); ?>
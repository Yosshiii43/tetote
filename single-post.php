<?php 
/*
 * blog single template
 */
get_header(); ?>

  <main class="l-main p-singleBlog" id="main" role="main">

    <!-- ▼ breadcrumb =============================== -->
      <?php breadcrumb(); ?>
    <!-- ▲ breadcrumb =============================== -->
     
    <div class="l-main__body">
      <div class="l-inner--800 p-singleBlog__inner">
        <div class="p-singleBlog__contents">

          <?php if ( have_posts() ) : while ( have_posts() ) : the_post();

            // カテゴリ(最初のカテゴリ)
            $cats = get_the_category();
            $cat_name = '';
            if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
              $cat_name = esc_html( $cats[0]->name );
            }

            // 日付フォーマット
            $date = get_the_modified_time( 'Y.m.d' );

            // サムネイル
            if ( has_post_thumbnail() ) {
              $thumbID = get_post_thumbnail_id( $post->ID );
              $thumb = get_the_post_thumbnail_url( get_the_ID(), 'full' );
              $thumalt = get_post_meta( $thumbID, '_wp_attachment_image_alt', true );
            } else {
              $thumb = "https://placehold.jp/24/f0f0f1/666/720x411.png?text=No%20Image";
              $thumalt = "no image";
            }
            ?>

          <div class="p-singleBlog__head">
            <p class="p-singleBlog__category"><?php echo esc_html( $cat_name ); ?></p>
            <p class="p-singleBlog__date"><?php echo esc_html( $date ); ?></p>
          </div>
          <h1 class="p-singleBlog__title"><?php the_title(); ?></h1>
          <img class="p-singleBlog__img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo ( $thumalt ); ?>">
          <?php the_content() ?>
        </div><!-- p-singleBlog__contents -->
      </div><!-- l-inner--800 p-singleBlog__inner-->

      <div class="p-singleBlog__nav">
        <?php
        $prev = get_previous_post();
        $next = get_next_post();
        ?>
        <div class="l-inner--lower">
          <ul class="c-navLinks">
            <?php if ( $prev ): ?>
              <li class="c-navLinks__prev">
                <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" rel="prev">
                  <span class="c-navLinks__label">
                    <span><?php echo esc_html( get_the_title( $prev ) ); ?></span>
                    <span><?php echo esc_html( get_the_modified_time( 'Y.m.d', $prev ) ); ?></span>
                  </span>
                </a>
              </li>
            <?php else: ?>
              <li></li>
            <?php endif; ?>

            <?php if ( $next ): ?>
              <li class="c-navLinks__next">
                <a href="<?php echo esc_url( get_permalink( $next ) ); ?>">
                  <span class="c-navLinks__label">
                    <span><?php echo esc_html( get_the_title( $next ) ); ?></span>
                    <span><?php echo esc_html( get_the_modified_time( 'Y.m.d', $next ) ); ?></span>
                  </span>
                </a>
              </li>
            <?php else: ?>
              <li></li>
            <?php endif; ?>
          </ul>
          
          <?php
            endwhile;
              wp_reset_postdata();
            endif;
          ?>

        </div>
      </div>
    </div><!-- l-main__body -->
  </main>


<?php get_footer(); ?>
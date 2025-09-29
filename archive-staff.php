<?php get_header(); ?>

  <div class="p-archiveStaff">
    <div class="p-archiveStaff__inner l-inner--1024">
      <div class="p-archiveStaff__content">

        <?php
        $args = [
          'post_type'      => 'staff',
          'post_status'    => 'publish',
          'orderby'        => 'ID',
          'order'          => 'ASC',
          'posts_per_page' => 6,   // 1ページに表示する件数（固定6件）
        ];
        $staff_query = new WP_Query( $args );
        ?>

        <?php if ( $staff_query->have_posts() ) : ?>
          <?php while ( $staff_query->have_posts() ) : ?>
            <?php $staff_query->the_post(); ?>
              <?php get_template_part('tmp/module/member-card') ?>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php else : ?>
          <p>表示するスタッフがいません。</p>
        <?php endif; ?>

      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>
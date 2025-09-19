<?php get_header(); ?>

<main class="l-main" id="main" role="main">
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
          <?php while ( $staff_query->have_posts() ) : $staff_query->the_post(); ?>
            <!-- 1件分の出力（カード等） -->
            <?php
              // ACFフィールド取得
              $staff_photo   = get_field('staff_photo');
              $staff_messages = get_field('staff_messages');
              $message_1     = $staff_messages['message_1'] ?? '';
              $message_2     = $staff_messages['message_2'] ?? '';
              $staff_name    = get_field('staff_name');
              $last_name     = $staff_name['last_name'] ?? '';
              $first_name    = $staff_name['first_name'] ?? '';
              $join_year     = get_field('join_year');
              $job_type      = wp_get_post_terms(get_the_ID(), 'job_type', ['fields' => 'names']);
              $job_type_name = $job_type ? $job_type[0] : '';
              $staff_photo_field = get_field('staff_photo');
              $photo_id = null;
              $photo_url = '';
              $alt = '';

              // ACF の返り値が配列の場合
              if ( is_array($staff_photo_field) && ! empty($staff_photo_field['id']) ) {
                  $photo_id = intval( $staff_photo_field['id'] );
                  $alt = $staff_photo_field['alt'];
              } elseif ( is_numeric($staff_photo_field) ) {
                  // ACF が ID を返す設定の場合
                  $photo_id = intval($staff_photo_field);
              } elseif ( is_array($staff_photo_field) && ! empty($staff_photo_field['url']) ) {
                  // URL を返す設定の場合
                  $photo_url = $staff_photo_field['url'];
              }
            ?>
            <article class="c-memberCard">
              <a href="<?php the_permalink(); ?>">
                <div class="c-memberCard__head">
                  <?php if ( $photo_id ) {
                      // wp_get_attachment_image_src でURLとサイズを取得
                      $img_data = wp_get_attachment_image_src( $photo_id, 'medium' );
                      if ( $img_data ) {
                          echo '<img class="c-memberCard__media" src="' . esc_url($img_data[0]) . '" alt="' . esc_attr($alt) . '" width="' . esc_attr($img_data[1]) . '" height="' . esc_attr($img_data[2]) . '">';
                      }
                      } elseif ( ! empty($photo_url) ) {
                          // URLで返ってきた場合はサイズが不明 → 固定値
                          echo '<img class="c-memberCard__media" src="' . esc_url($photo_url) . '" alt="' . esc_attr($alt) . '" width="600" height="758">';
                      } elseif ( has_post_thumbnail() ) {
                          // サムネイルあり
                          $thumb_id = get_post_thumbnail_id();
                          $img_data = wp_get_attachment_image_src( $thumb_id, 'medium' );
                          echo '<img class="c-memberCard__media" src="' . esc_url($img_data[0]) . '" alt="' . esc_attr($alt) . '" width="' . esc_attr($img_data[1]) . '" height="' . esc_attr($img_data[2]) . '">';
                      } else {
                          // プレースホルダー
                          echo '<img class="c-memberCard__media" src="http://placehold.jp/600x758.png?text=No Image" alt="' . esc_attr($alt) . '" width="600" height="758">';
                      }
                      ?>
                  <div class="c-memberCard__text">
                    <?php if ($message_1): ?><p><?php echo esc_html($message_1); ?></p><?php endif; ?>
                    <?php if ($message_2): ?><p><?php echo esc_html($message_2); ?></p><?php endif; ?>
                  </div>
                </div>
                <div class="c-memberCard__body">
                  <div class="c-memberCard__info">
                    <p><?php echo esc_html($job_type_name); ?></p>
                    <p><?php echo esc_html($join_year); ?><span>年入社</span></p>
                  </div>
                  <h2><span><?php echo esc_html($last_name); ?></span><span><?php echo esc_html($first_name); ?></span></h2>
                </div>
              </a>
            </article>
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
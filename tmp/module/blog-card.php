<?php
  // 投稿リンク
  $permalink = esc_url( get_permalink() );

  // サムネイル
  if ( has_post_thumbnail() ) {
    $thumbID = get_post_thumbnail_id( $post->ID );
    $thumb = get_the_post_thumbnail_url( get_the_ID(), 'medium' );
    $thumalt = get_post_meta( $thumbID, '_wp_attachment_image_alt', true );
  } else {
    $thumb = "https://placehold.jp/24/f0f0f1/666/160x180.png?text=No%20Image";
    $thumalt = "no image";
  }

  // カテゴリ（最初のカテゴリ名を表示）
  $cats = get_the_category();
  $cat_name = '';
  if ( ! empty( $cats ) && ! is_wp_error( $cats ) ) {
    $cat_name = esc_html( $cats[0]->name );
  }

  //タイトル
  $title = get_the_title();

  // 日付フォーマット
  $date = get_the_modified_time( 'Y.m.d' );
?>

<div class="c-blogUnit">
  <a href="<?php echo $permalink; ?>">
    <img class="c-blogUnit__img" src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo ( $thumalt ); ?>" width="300" height="300">
    <div class="c-blogUnit__text">
      <?php if ( $cat_name ) : ?>
        <p class="c-blogUnit__category"><?php echo $cat_name; ?></p>
      <?php endif; ?>
      <p class="c-blogUnit__link"><?php echo esc_html( wp_strip_all_tags( $title ) ); ?></p>
      <p class="c-blogUnit__date"><?php echo esc_html( $date ); ?></p>
    </div>
  </a>
</div><!--c-blogUnit -->
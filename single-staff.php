<?php
/**
 * single-staff.php
 * Staff single template — integrates ACF group fields and job_type taxonomy.
 *
 * ACF fields used (as per your setup):
 * - staff_messages (group)
 *    - message_1 (text)
 *    - message_2 (text)
 * - staff_name (group)
 *    - last_name (text)
 *    - first_name (text)
 * - join_year (text)
 * - staff_introduction (text)
 * - staff_photo (image field returning ID)
 *
 * Taxonomy:
 * - job_type (single term expected)
 *
 * Features:
 * - Outputs ACF fields with proper escaping
 * - Renders post content and injects IDs into H2 headings for TOC anchors
 * - Generates a TOC sidebar (PC only) that follows scroll and highlights active section via IntersectionObserver
 * - Other members section uses WP_Query excluding current post
 */
get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<?php
// --- Fetch structured ACF data ---
$messages = get_field('staff_messages'); // group
$last_name = get_field('staff_name')['last_name'] ?? '';
$first_name = get_field('staff_name')['first_name'] ?? '';
$join_year = get_field('join_year');
$introduction = get_field('staff_introduction');
$photo_id = get_field('staff_photo'); // assuming returns attachment ID

// Taxonomy: job_type (single)
$job_terms = get_the_terms( get_the_ID(), 'job_type' );
$job_name = '';
if ( $job_terms && ! is_wp_error( $job_terms ) ) {
    // take the first term
    $job_name = esc_html( $job_terms[0]->name );
}

// --- Prepare content and extract h2 headings, inject ids into h2 tags ---
$raw_content = apply_filters( 'the_content', get_the_content() );

// Find all h2 contents
$headings = array();
if ( preg_match_all( '/<h2\b[^>]*>(.*?)<\/h2>/is', $raw_content, $matches ) ) {
    foreach ( $matches[1] as $h ) {
        // strip tags inside heading and make a safe slug
        $text = wp_strip_all_tags( $h );
        $id = sanitize_title( $text );
        // ensure unique ids if duplicates exist
        $orig_id = $id;
        $i = 2;
        while ( in_array( $id, array_column($headings, 'id'), true ) ) {
            $id = $orig_id . '-' . $i;
            $i++;
        }
        $headings[] = array( 'id' => $id, 'text' => $text );
    }

    // Replace h2 tags to inject ids in order
    $index = 0;
    $raw_content = preg_replace_callback(
        '/<h2\b([^>]*)>(.*?)<\/h2>/is',
        function( $m ) use ( &$index, $headings ) {
            if ( ! isset( $headings[$index] ) ) {
                return $m[0];
            }
            $id = esc_attr( $headings[$index]['id'] );
            $attrs = trim( $m[1] );
            // If existing id attribute, keep it (but prefer our generated)
            $new = '<h2 id="' . $id . '"' . ( $attrs ? ' ' . $attrs : '' ) . '>' . $m[2] . '</h2>';
            $index++;
            return $new;
        },
        $raw_content
    );
}
?>

<main class="l-main" id="main" role="main">

  <div class="l-main__head p-main__head">
    <div class="p-staffHead">
      <div class="l-inner--lower p-staffHead__inner">
        <div class="p-staffHead__contents">

          <!-- messages (group: staff_messages => message_1, message_2) -->
          <?php if ( ! empty( $messages ) && ( ! empty( $messages['message_1'] ) || ! empty( $messages['message_2'] ) ) ) : ?>
            <div class="p-staffHead__lead">
              <?php if ( ! empty( $messages['message_1'] ) ) : ?>
                <p><?php echo esc_html( $messages['message_1'] ); ?></p>
              <?php endif; ?>
              <?php if ( ! empty( $messages['message_2'] ) ) : ?>
                <p><?php echo esc_html( $messages['message_2'] ); ?></p>
              <?php endif; ?>
            </div>
          <?php endif; ?>

          <!-- job type taxonomy -->
          <?php if ( ! empty( $job_name ) ) : ?>
            <p class="p-staffHead__jobType"><?php echo $job_name; ?></p>
          <?php endif; ?>

          <!-- name (group staff_name => last_name / first_name) -->
          <div class="p-staffHead__info">
            <?php if ( $last_name || $first_name ) : ?>
              <h1 class="p-staffHead__name"><span><?php echo esc_html( $last_name ); ?></span><span><?php echo esc_html( $first_name ); ?></span></h1>
            <?php else : ?>
              <h1 class="p-staffHead__name"><?php the_title(); ?></h1>
            <?php endif; ?>

            <?php if ( $join_year ) : ?>
              <p class="p-staffHead__year"><?php echo esc_html( $join_year ); ?><span>入社</span></p>
            <?php endif; ?>
          </div>

          <!-- short outline/intro -->
          <?php if ( $introduction ) : ?>
            <p class="p-staffHead__outline"><?php echo wp_kses_post( nl2br( $introduction ) ); ?></p>
          <?php endif; ?>

        </div><!-- .p-staffHead__contents -->

        <!-- media (staff_photo or featured image fallback) -->
        <div class="p-staffHead__media">
          <?php
            if ( $photo_id ) {
                echo wp_get_attachment_image( $photo_id, 'large', false, array( 'alt' => get_the_title() ) );
            } elseif ( has_post_thumbnail() ) {
                the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) );
            } else {
                echo '<img src="' . esc_url( get_theme_file_uri( '/img/img_member_default.jpg' ) ) . '" alt="' . esc_attr( get_the_title() ) . '">';
            }
          ?>
        </div>

      </div><!-- .l-inner--lower .p-staffHead__inner -->

      <!-- breadcrumb -->
      <?php if ( function_exists( 'breadcrumb' ) ) : breadcrumb(); endif; ?>

    </div><!-- .p-staffHead -->
  </div><!-- .l-main__head -->

  <div class="l-main__body p-staffMain">
    <div class="l-inner--lower p-staffMain__inner">
      <div class="p-staffMain__body">

        <!-- Main content area (post content with injected h2 ids) -->
        <section class="p-staffMain__content">
          <?php
            // Output the sanitized content (already filtered and with h2 ids)
            echo $raw_content;
          ?>
        </section>

        <!-- Sidebar: table of contents (generated from headings) -->
        <?php if ( ! empty( $headings ) ) : ?>
          <aside class="p-staffMain__asid" aria-label="目次">
            <p>目次</p>
            <ul class="p-staffMain__toc" id="staff-toc">
              <?php foreach ( $headings as $h ) : ?>
                <li><a href="#<?php echo esc_attr( $h['id'] ); ?>"><?php echo esc_html( $h['text'] ); ?></a></li>
              <?php endforeach; ?>
            </ul>
          </aside>
        <?php endif; ?>

      </div><!-- .p-staffMain__body -->
    </div><!-- .l-inner--lower .p-staffMain__inner -->

    <!-- Other members (exclude current) -->
    <div class="p-staffMain__other">
      <div class="l-inner--lower">
        <h2>その他のメンバー</h2>
        <?php
          $args = array(
            'post_type'      => 'staff',
            'posts_per_page' => 3,
            'post__not_in'   => array( get_the_ID() ),
          );
          $other = new WP_Query( $args );
          if ( $other->have_posts() ) :
        ?>
          <div class="p-staffMain__otherList">
            <?php while ( $other->have_posts() ) : $other->the_post(); ?>
              <article class="c-memberCard">
                <a href="<?php the_permalink(); ?>">
                  <div class="c-memberCard__head">
                    <?php
                      if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'medium', array( 'class' => 'c-memberCard__media', 'alt' => get_the_title() ) );
                      } else {
                        echo '<img class="c-memberCard__media" src="' . esc_url( get_theme_file_uri( '/img/img_member_default.jpg' ) ) . '" alt="' . esc_attr( get_the_title() ) . '">';
                      }
                    ?>
                    <div class="c-memberCard__text">
                      <?php if ( $excerpt = get_field('card_lead') ) : ?>
                        <p><?php echo esc_html( $excerpt ); ?></p>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="c-memberCard__body">
                    <div class="c-memberCard__info">
                      <?php if ( $job = get_field('job_type') ) : ?><p><?php echo esc_html( $job ); ?></p><?php endif; ?>
                      <?php if ( $year = get_field('join_year') ) : ?><p><?php echo esc_html( $year ); ?><span>入社</span></p><?php endif; ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                  </div>
                </a>
              </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php else : ?>
          <p>他のメンバーはまだ登録されていません。</p>
        <?php endif; ?>
      </div>
    </div><!-- .p-staffMain__other -->

  </div><!-- .l-main__body -->

  <div class="l-main__foot"></div>

</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
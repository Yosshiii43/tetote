<?php get_header(); ?>

    <div class="l-main__head p-main__head">
      <div class="p-hero">
        <!-- Slider main container -->
        <div class="swiper">
          <!-- Additional required wrapper -->
          <div class="swiper-wrapper">
            <!-- Slides -->
            <div class="swiper-slide">
              <div class="slide-media" style="--hero-x:64%;">
                <img  class="p-hero__img" src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_hero_top1.jpg" alt="街路樹が美しい街をスーツ姿で歩く20代男性" loading="eager" decoding="async">
              </div>
            </div>
            <div class="swiper-slide">
              <div class="slide-media" style="--hero-x:50%;">
                <img class="p-hero__img" src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_hero_top2.jpg" alt="オフィス内で笑顔で打ち合わせをする一人の男性と二人の女性">
              </div>
            </div>
          </div>
        </div><!-- .swiper -->

        <p class="p-hero__catchcopy p-heroCatchcopy c-viga">BECOME A <br>CHALLENGER.</p>

        <div class="p-hero__text p-heroText"><p>君の挑戦が、意思が、未来を変える</p></div>

        <div class="p-hero__news p-heroNews">
          <div class="p-heroNews__head">
            <h2 class="c-viga">news</h2>
          </div>
          <?php $news_query = new WP_Query(
              array(
                'post_type' => 'post',
                'posts_per_page' => 1, //記事数
              )
            ); ?>
          <?php if ($news_query->have_posts()) : ?>
          <?php $news_query->the_post(); ?>
          <div class="p-heroNews__body">
            <?php $redirect_url = get_field('contents_redirect_url'); ?>
              <a href="<?php echo esc_url($redirect_url ? $redirect_url : get_permalink()); ?>">
                <span class="js-lineHeight"><?php echo esc_html(get_the_title()); ?></span>
                <span><span class="c-viga">view more</span><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/icon_arrow1.svg" alt="" width="20" height="20"></span>
              </a>
            <?php else: ?>
            <p>記事がありません</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
          </div><!-- p-heroNews__body -->
        </div><!-- p-hero__news p-heroNews -->
      </div><!-- .p-hero -->
    </div><!-- .l-main__head .p-main__head-->

    <div class="l-main__body">

      <div class="p-mission" id="topMission">
        <div class="p-mission__head">
          <div class="swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><div class="slide-media"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide1.jpg" alt="オフィスで電話をかけながらキーボードを操作するスーツ姿の30代男性" width="1012" height="786"></div></div>
              <div class="swiper-slide"><div class="slide-media slide-media-down"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide2.jpg" alt="カフェでノートパソコンを操作している20代女性" width="1012" height="786"></div></div>
              <div class="swiper-slide"><div class="slide-media"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide3.jpg" alt="お客様と向かい合って説明をしているスーツ姿の20代女性" width="1012" height="786"></div></div>
              <div class="swiper-slide"><div class="slide-media slide-media-down"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide1.jpg" alt="" width="1012" height="786"></div></div>
              <div class="swiper-slide"><div class="slide-media"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide2.jpg" alt="" width="1012" height="786"></div></div>
              <div class="swiper-slide"><div class="slide-media slide-media-down"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_slide3.jpg" alt="" width="1012" height="786"></div></div>
            </div>
          </div>
          <div class="p-mission__text">
            <p>後悔しないキャリアを作る、</p>
            <p>それこそが、我々の使命だ</p>
          </div>
        </div><!-- .p-mission__head-->
        <div class="p-mission__body">
          <div>
            <p>「人手不足」<br>
              <span><span>今の日本が抱える</span><span>この社会課題に挑み、</span></span>
              <span><span>企業と個人の可能性を</span><span>最大限に引き出す。</span></span>
              それが私達の役目。
            </p>
            <p>単につなぐだけじゃない。
              <span><span>「手と手」を取り合って</span><span>いけるような、</span></span>
              <span><span>持続可能な社会を、</span><span>一緒に作りませんか？</span></span>
            </p>
          </div>
          <a class="c-button--wb c-viga" href="/about-us/">view more</a>
        </div>
      </div><!-- .p-mission -->

      <section class="p-member" id="topMember">
        <div class="l-inner--1024">
          <h2 class="c-topSectionTitle p-member__title">
            <span class="c-topSectionTitle__upper"><span>人</span>を知る</span>
            <span class="c-topSectionTitle__lower c-poppins">member</span>
          </h2>
          <div class="p-member__description">
            <p>TETOTEの社員がどういった信念を持って働いているのか、<br>
                一日のスケジュールや仕事内容などを紹介します。</p>
          </div>
          <div class="p-member__swiper">
            <div class="p-member__swiperInner">
              <div class="swiper">
                <div class="swiper-wrapper">
                  <?php $member_query = new WP_Query(
                    array(
                      'post_type' => 'staff',
                      'posts_per_page' => 8, //記事数
                    )
                  ); ?>
                  <?php if ($member_query->have_posts()) : ?>
                    <?php while ($member_query->have_posts()) : ?>
                      <?php $member_query->the_post(); ?>
                  
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
                  <div class="swiper-slide">
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
                                  // URLで返ってきた場合はサイズが不明 → width/heightなし
                                  echo '<img class="c-memberCard__media" src="' . esc_url($photo_url) . '" alt="' . esc_attr($alt) . '">';
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
                  </div><!-- .swiper-slide --> 
                  <?php endwhile; ?>
                  <?php else: ?>
                    <p>記事がありません</p>
                  <?php endif; ?>
                  <?php wp_reset_postdata(); ?>

                </div><!-- .swiper-wrapper -->
              </div><!-- .swiper -->
            </div>
          </div><!-- .p-member__swiper -->
          <a class="c-button--wb c-viga" href="/staff/">view more</a>
          <div class="swiper-controller">
            <button class="swiper-button-prev c-button--arrowW"></button>
            <button class="swiper-button-next c-button--arrowW"></button>
          </div>
        </div><!-- .l-inner--1024 -->
      </section><!-- .p-member-->

      <section class="p-topBenefits" id="toptopBenefits">
        <div class="l-inner--1024">
          <h2 class="c-topSectionTitle p-topBenefits__title">
            <span class="c-topSectionTitle__upper"><span>制度・環境</span>を知る</span>
            <span class="c-topSectionTitle__lower c-poppins">topBenefits</span>
          </h2>
          <div class="p-topBenefits__description">
            <p>当社では働く従業員とそのご家族が健やかに過ごせるよう、多様な研修、福利厚生を提供しています。</p>
          </div>
          <div class="p-topBenefits__contents">
            <div class="p-topBenefits__content">
              <a href="/career/">
                <img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_career1.png" alt="Training And Career">
                <div class="c-button--arrowB"></div>
                <h3>研修制度とキャリアパス</h3>
                <p>個々の目標に合わせたキャリアパスを支える、豊富な研修メニューで、あなた自身の成長を強力にサポートします。</p>
              </a>
            </div>
            <div class="p-topBenefits__content">
              <a href="/topBenefits/">
                <img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_benefits1.png" alt="employee topBenefits">
                <div class="c-button--arrowB"></div>
                <h3>福利厚生</h3>
                <p>TETOTEの福利厚生制度は、従業員の健康と幸福を重視し、働きやすい環境を提供することを目的としています。</p>
              </a>
            </div>
          </div><!-- .p-topBenefits__contents -->
        </div>
      </section><!-- .p-topBenefits -->

      <section class="p-blog" id="topBlog">
        <div class="l-inner--1024">
          <h2 class="c-topSectionTitle p-blog__title">
            <span class="c-topSectionTitle__upper">採用ブログ</span>
            <span class="c-topSectionTitle__lower c-poppins">blog</span>
          </h2>
          <div class="p-blog__description">
            <p>採用情報やイベント情報、社員の紹介など、<br>
              日々の現場の様子をご紹介します。</p>
          </div>
          <div class="p-blog__contents">
            <?php $blog_query = new WP_Query(
              array(
                'post_type' => 'post',
                'posts_per_page' => 4, //記事数
              )
            ); ?>
          <?php if ($blog_query->have_posts()) : ?>
            <?php while ($blog_query->have_posts()) : ?>
              <?php $blog_query->the_post(); ?>
              <?php get_template_part('tmp/module/blog-card'); ?>
            <?php endwhile; ?>
            <?php else: ?>
              <p>記事がありません</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
          </div><!-- .p-blog__contents -->
          <a class="p-blog__viewMore c-viga" href="/blog/"><span class="c-button--arrowW"></span>view more</a>
        </div><!-- .l-inner--1024 -->
      </section><!-- .p-blog -->

      <section class="p-recruitment" id="topRecruitment">
         <div class="l-inner--1024">
          <h2 class="c-topSectionTitle p-recruitment__title">
            <span class="c-topSectionTitle__upper">採用情報</span>
            <span class="c-topSectionTitle__lower c-poppins">recruitment</span>
          </h2>
          <div class="p-recruitment__description">
            <p>募集要項（職種、業務内容、応募条件、選考フロー）とよくある質問・会社概要などをまとめています。</p>
          </div>
          <div class="p-recruitment__contents">
            <a class="p-recruitment__link c-button--wb" href="/details/">募集要項</a>
            <a class="p-recruitment__link c-button--wb" href="/faq/">よくある質問</a>
            <a class="p-recruitment__link c-button--wb" href="/about-us/#profile">会社概要</a>
          </div>
        </div>
      </section>
    </div><!-- l-main__body -->
  </main>

<?php get_footer(); ?>
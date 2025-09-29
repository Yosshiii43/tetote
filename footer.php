  <footer class="l-footer p-footer">
    <div class="p-footer__head">
    </div>
    <div class="l-inner--1380 p-footer__inner">
      <div class="p-footer__cta">
        <p class="p-footer__ctaText">わたしたちと一緒に働く仲間を募集中です。<br>
          少数精鋭のチームで、<br>
          あなたも会社も一緒に成長していきましょう。</p>
        <a class="p-footer__ctaButton c-button--gb c-viga" href="/entry/">entry</a>
      </div>
      <div class="p-footer__foot">
        <div>
          <nav class="p-footer__nav">
            <?php wp_nav_menu( array( 
              'theme_location' => 'footer_nav' ,
              'menu_class' => 'p-footer__navList'
              ) ); ?>
          </nav>
          <ul class="p-footer__sns">
            <li class="p-footer_snsItem"><a class="p-footer_snsLink" href="@@facebook-link@@"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/icon_facebook.svg" alt="facebook"></a></li>
            <li class="p-footer_snsItem"><a class="p-footer_snsLink" href="@@twitter-link@@"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/icon_twitter.svg" alt="twitter"></a></li>
            <li class="p-footer_snsItem"><a class="p-footer_snsLink" href="@@youtube-link@@"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/icon_youtube.svg" alt="youtube"></a></li>
          </ul>
          <a class="p-footer__logo" href="/"><img src="<?php echo esc_url(get_theme_file_uri()); ?>/img/img_logo.svg" alt=""></a>
        </div>
        <p class="p-footer__copyright c-viga">&copy; <?php echo esc_html(date('Y')); ?> TETOTE All Right Reserved.</p>
      </div>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>
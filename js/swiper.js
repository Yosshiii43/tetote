/*************************************************************************
 * swiper
 *************************************************************************/


//-------------------------------------------------------------------------
// トップページ ヒーロー部分
//-------------------------------------------------------------------------

// Swiper CDN(bundle) 前提
let heroSwiper = null;

function applyZoom(swiper) {
  // いったん全てのズームを外す
  const imgs = swiper.el.querySelectorAll('.p-hero__img');
  imgs.forEach(img => img.classList.remove('is-zoom'));

  // アクティブの画像にだけズームをかけ直す（再発火用にreflow）
  const active = swiper.slides[swiper.activeIndex]?.querySelector('.p-hero__img');
  if (!active) return;
  void active.offsetWidth; // reflow
  active.classList.add('is-zoom');
}

function initHeroSwiper() {
  const el = document.querySelector('.p-hero .swiper');
  if (!el) return;

  if (heroSwiper) {
    try { heroSwiper.destroy(true, true); } catch (e) {}
    heroSwiper = null;
  }

  heroSwiper = new Swiper(el, {
    slidesPerView: 1,
    allowTouchMove: false,

    // フェードで滑らかに（白フラッシュ対策で crossFade: true）
    //effect: 'fade',
    //fadeEffect: { crossFade: true },

    // 2枚でも安定させるため rewind を採用
    loop: false,
    rewind: true,

    // テンポ（好みに合わせて調整）
    speed: 1200,
    autoplay: {
      delay: 4500,                 // 初回が長く止まって見えない程度に短め
      disableOnInteraction: false,
      waitForTransition: true,
      stopOnLastSlide: false,
    },

    // 画像は先読み、リサイズ時は内部で再計算
    preloadImages: true,
    updateOnWindowResize: true,
    observer: true,
    observeParents: true,

    on: {
      init(swiper) {
        // 初回ズームを確実に見せる
        applyZoom(swiper);
      },
      slideChangeTransitionStart(swiper) {
        // 切替のたびにズームを再発火
        applyZoom(swiper);
      },
    },
  });

  window.heroSwiper = heroSwiper; // デバッグ用（不要なら削除）
}

window.addEventListener('load', initHeroSwiper);
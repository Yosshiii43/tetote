/*************************************************************************
 * swiper
 *************************************************************************/


//-------------------------------------------------------------------------
// トップページ ヒーロー部分
//-------------------------------------------------------------------------

let heroSwiper = null;

function applyZoom(swiper) {
  // いったん全部オフ
  swiper.el.querySelectorAll('.p-hero__img').forEach(img => {
    img.classList.remove('is-zoom');
  });
  // アクティブ画像にだけズームを付け直す（再発火のためにreflow）
  const activeImg = swiper.slides[swiper.activeIndex]?.querySelector('.p-hero__img');
  if (!activeImg) return;
  void activeImg.offsetWidth;
  activeImg.classList.add('is-zoom');
}

function initHeroSwiper() {
  const el = document.querySelector('.p-hero .swiper');
  if (!el) return;

  if (heroSwiper) {
    heroSwiper.destroy(true, true);
    heroSwiper = null;
  }

  heroSwiper = new Swiper(el, {
    slidesPerView: 1,
    allowTouchMove: false,

    // ★ Swiperのfadeに戻す（横スライドはしない）
    effect: 'fade',
    fadeEffect: { crossFade: true }, // 前後を重ねて“ふわっ”を強調

    // リピートはrewindで
    loop: false,
    rewind: true,

    // テンポ
    speed: 1100, // フェードの“ふわっ”感（1.0〜1.2sが目安）
    autoplay: {
      delay: 4600, // ズームとバランス
      disableOnInteraction: false,
      waitForTransition: true,
      stopOnLastSlide: false,
    },

    preloadImages: true,
    observer: true,
    observeParents: true,

    on: {
      init(swiper) {
        document.querySelector('.p-hero')?.classList.add('is-inited');
        applyZoom(swiper);
      },
      slideChangeTransitionStart(swiper) {
        applyZoom(swiper);
      },
    },
  });

  window.heroSwiper = heroSwiper; // 任意
}

window.addEventListener('load', initHeroSwiper);
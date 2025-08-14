/*************************************************************************
 * swiper
 *************************************************************************/


//-------------------------------------------------------------------------
// トップページ ヒーロー部分
//-------------------------------------------------------------------------

let heroSwiper = null;

const initHeroSwiper = () => {

  // すでにSwiperが存在していたら破棄
  if (heroSwiper) {
    heroSwiper.destroy(true, true);
    heroSwiper = null;
  }

  heroSwiper = new Swiper('.p-hero .swiper', {
    // 必須・安定化
    slidesPerView: 1,
    allowTouchMove: false,

    // フェード
    effect: 'fade',
    fadeEffect: { crossFade: true },

    // ループは使わず「巻き戻し」（fadeと相性がいい）
    loop: false,
    rewind: true,

    // 自動再生
    speed: 2000,
    autoplay: {
      delay: 7000,
      disableOnInteraction: false,
      waitForTransition: false,
    },

    //切り替えのアニメーションはドラッグ操作が終了してから開始
    followFinger: false,
  });
};

//初期化
window.addEventListener('load', () =>{
  initHeroSwiper();
});

// 例：tab以上を (min-width:744px) と仮定
  const mql = window.matchMedia('(min-width: 744px)');
  let currentIsTabUp = mql.matches;

  mql.addEventListener('change', (e) => {
    // ブレークポイントを跨いだときだけ
    if (e.matches !== currentIsTabUp) {
      currentIsTabUp = e.matches;

      // ついでに一時的にトランジション無効（横ズレ見せない）
      document.body.classList.add('is-resizing');
      if (window.heroSwiper?.autoplay) heroSwiper.autoplay.stop();

      // Swiper 再初期化
      initHeroSwiper();

      // 解除
      requestAnimationFrame(() => {
        document.body.classList.remove('is-resizing');
        if (window.heroSwiper?.autoplay) heroSwiper.autoplay.start();
      });
    }
  });
/*************************************************************************
 * swiper
 *************************************************************************/

let currentBreakpoint = window.innerWidth >= 768 ? 'tab' : 'sp';

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
    speed: 2000, // フェードの“ふわっ”感（1.0〜1.2sが目安）
    autoplay: {
      delay: 5000, // ズームとバランス
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


//-------------------------------------------------------------------------
// トップページ mission
//-------------------------------------------------------------------------

let missionSwiper = null;

const initMissionSwiper = () => {

  if (missionSwiper !== null) {
    missionSwiper.destroy(true, true);
  }

  missionSwiper = new Swiper('.p-mission .swiper', {
    slidesPerView: 'auto',
    spaceBetween: 16,
    loop: true,
    //loopAdditionalSlides: 3,
    speed: 8000,
    autoplay: {
      delay: 0,
      disableOnInteraction: false,
    },
    freeMode: {
      enabled: true,
      momentum: false,
    },
    breakpoints: {
      1024: {
        spaceBetween: 34,
      }
    },
  });
};

//初期化
window.addEventListener('load', () =>{
  initMissionSwiper();
});

// ブレークポイントを跨いだときだけ再初期化
window.addEventListener('resize', () => {
  const newBreakpoint = window.innerWidth >= 768 ? 'tab' : 'sp';
  if (newBreakpoint !== currentBreakpoint) {
    currentBreakpoint = newBreakpoint;
    initMissionSwiper();
  }
});

//-------------------------------------------------------------------------
// トップページ member
//-------------------------------------------------------------------------

let memberSwiper = null;

const initMemberSwiper = () => {

  if (memberSwiper !== null) {
    memberSwiper.destroy(true, true);
  }

  memberSwiper = new Swiper('.p-member .swiper', {
    slidesPerView: 'auto',
    spaceBetween: 23,
    loop: true,
    //loopAdditionalSlides: 1,
    speed: 8000,
    autoplay: {
      delay: 0,
      reverseDirection: true, // 逆方向の動きを有効にする
      //disableOnInteraction: false,
    },
    freeMode: {
      enabled: true,
      momentum: false,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      1024: {
        spaceBetween: 43,
      }
    },
  });
};

//初期化
window.addEventListener('load', () =>{
  initMemberSwiper();
});

// ブレークポイントを跨いだときだけ再初期化
window.addEventListener('resize', () => {
  const newBreakpoint = window.innerWidth >= 768 ? 'tab' : 'sp';
  if (newBreakpoint !== currentBreakpoint) {
    currentBreakpoint = newBreakpoint;
    initMemberSwiper();
  }
});
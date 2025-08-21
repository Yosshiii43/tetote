/********************************************************************************
 * swiper
 ********************************************************************************/

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
// ===== member（Swiper v8 / CDN）: クリック即反応・競合ゼロ版 =====
let memberSwiper = null;

const initMemberSwiper = () => {
  const root = document.querySelector('.p-member');
  if (!root) return;

  const container = root.querySelector('.swiper');
  const nextBtn   = root.querySelector('.swiper-button-next');
  const prevBtn   = root.querySelector('.swiper-button-prev');
  if (!container || !nextBtn || !prevBtn) return;

  if (memberSwiper) {
    try { memberSwiper.destroy(true, true); } catch (_) {}
    memberSwiper = null;
  }

  // あなたの調整値を維持
  const FLOW_SPEED  = 1600;  // 自動
  const FLOW_DELAY  = 1800;  // speed より少し長く
  const CLICK_SPEED = 400;   // クリック時だけ速く

  memberSwiper = new Swiper(container, {
    slidesPerView: 'auto',
    spaceBetween: 23,
    loop: true,
    speed: FLOW_SPEED,
    autoplay: {
      delay: FLOW_DELAY,
      disableOnInteraction: true, // ユーザー操作で必ず停止
      waitForTransition: false    // ← 手動で止め/再開するため待たない
    },
    // navigation は使わない（競合を断つ）
    allowTouchMove: false,
    resistanceRatio: 0,
    breakpoints: { 1024: { spaceBetween: 43 } },
  });

  let busy = false;

  // --- 入力系：pointerdownで先取りしつつ、clickも保険で拾う ---
  const triggerMove = (dir) => {
    if (busy || !memberSwiper) return;
    busy = true;

    // 1) autoplay即停止
    try { memberSwiper.autoplay.stop(); } catch (_) {}

    // 2) 進行中トランジションを0msで終了して位置確定
    const wrap = memberSwiper.wrapperEl;
    const prevTd = wrap.style.transitionDuration;
    wrap.style.transitionDuration = '0ms';
    // reflow
    // eslint-disable-next-line no-unused-expressions
    wrap.offsetHeight;
    wrap.style.transitionDuration = prevTd || '';

    memberSwiper.setTransition(0);
    memberSwiper.slideTo(memberSwiper.activeIndex, 0, false);
    if (memberSwiper.params.loop && typeof memberSwiper.loopFix === 'function') {
      memberSwiper.loopFix();
    }
    // Swiper内部のアニメーション中フラグを明示的に解除（取りこぼし防止）
    memberSwiper.animating = false;
    memberSwiper.updateSlidesProgress();
    memberSwiper.updateSlidesClasses();

    // 3) コマンドは次のフレームで実行（キャンセル直後の競合回避）
    const old = memberSwiper.params.speed;
    let started = false;

    const onStart = () => { started = true; memberSwiper.off('transitionStart', onStart); };
    memberSwiper.on('transitionStart', onStart);

    requestAnimationFrame(() => {
      if (!memberSwiper) return;
      memberSwiper.params.speed = CLICK_SPEED;
       const targetReal = dir === 'next'
      ? memberSwiper.realIndex + 1
      : memberSwiper.realIndex - 1;

    memberSwiper.slideToLoop(targetReal, CLICK_SPEED, true);

    setTimeout(() => {
      if (!started && memberSwiper) {
        memberSwiper.slideToLoop(targetReal, CLICK_SPEED, true); // フォールバック一回だけ
      }
    }, 120);
  });

    // 4) 終了後に復帰
    memberSwiper.once('transitionEnd', () => {
      memberSwiper.params.speed = old;
      if (memberSwiper.params.loop && typeof memberSwiper.loopFix === 'function') {
        memberSwiper.loopFix();
      }
      try { memberSwiper.autoplay.start(); } catch (_) {}
      busy = false;
    });
  };

  const onPDNext = (e) => { e.preventDefault(); triggerMove('next'); };
  const onPDPrev = (e) => { e.preventDefault(); triggerMove('prev'); };
  const onClickNext = (e) => { e.preventDefault(); triggerMove('next'); };
  const onClickPrev = (e) => { e.preventDefault(); triggerMove('prev'); };

  // pointerdown を優先しつつ、click も保険で拾う（capture で最優先）
  nextBtn.addEventListener('pointerdown', onPDNext, { capture: true, passive: false });
  prevBtn.addEventListener('pointerdown', onPDPrev, { capture: true, passive: false });
  nextBtn.addEventListener('click', onClickNext, { capture: true, passive: false });
  prevBtn.addEventListener('click', onClickPrev, { capture: true, passive: false });
};

window.addEventListener('load', initMemberSwiper);

window.addEventListener('resize', () => {
  const newBp = window.innerWidth >= 768 ? 'tab' : 'sp';
  if (newBp !== currentBreakpoint) {
    currentBreakpoint = newBp;
    initMemberSwiper();
  }
});
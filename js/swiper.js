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
// ====== member（Swiper v8 / CDN）安定版 ======
let memberSwiper = null;

const initMemberSwiper = () => {
  const root = document.querySelector('.p-member');
  if (!root) return;

  const container = root.querySelector('.swiper');
  const nextBtn   = root.querySelector('.swiper-button-next');
  const prevBtn   = root.querySelector('.swiper-button-prev');
  if (!container || !nextBtn || !prevBtn) return;

  // 既存破棄
  if (memberSwiper) {
    try { memberSwiper.destroy(true, true); } catch (_) {}
    memberSwiper = null;
  }

  // “ほぼ連続”に見えるが、クリックは食われない設定
  const FLOW_SPEED = 1800;   // 自動スクロールの1ステップ時間
  const FLOW_DELAY = 1950;   // speed より少し長く（息継ぎ）

  memberSwiper = new Swiper(container, {
    slidesPerView: 'auto',
    spaceBetween: 23,
    loop: true,
    speed: FLOW_SPEED,
    autoplay: {
      delay: FLOW_DELAY,
      // ← ユーザー操作時は必ず autoplay を止める（競合をゼロに）
      disableOnInteraction: true,
      waitForTransition: true
    },
    navigation: {
      // 純正ナビを使う（方向・枚数の安定性が高い）
      nextEl: nextBtn,
      prevEl: prevBtn
    },
    allowTouchMove: false, // 誤ドラッグの“途中位置”を残さない
    resistanceRatio: 0,
    breakpoints: { 1024: { spaceBetween: 43 } }
  });

  // --- クリック中だけ高速にして“必ず1枚だけ”動かす ---
  const NORMAL_SPEED = FLOW_SPEED;
  const CLICK_SPEED  = 400;
  let resumeAfterTransition = false;

  // クリック直前で autoplay を確実に止め、速度を一時的に速くする
  const onPointerDown = () => {
    if (!memberSwiper) return;
    // autoplay.stop() は disableOnInteraction:true で自動停止するが、
    // 念のため明示して“重ね遷移”を防ぐ
    try { memberSwiper.autoplay.stop(); } catch (_) {}

    memberSwiper.params.speed = CLICK_SPEED;

    // 途中位置のズレを消しておく（現在スライドへ0ms吸着）
    memberSwiper.setTransition(0);
    memberSwiper.slideTo(memberSwiper.activeIndex, 0, false);

    // 遷移が終わったら speed を戻して autoplay を再開する予約
    resumeAfterTransition = true;
  };

  // 遷移完了で復帰処理
  memberSwiper.on('transitionEnd', () => {
    if (!memberSwiper) return;
    memberSwiper.params.speed = NORMAL_SPEED;
    if (resumeAfterTransition) {
      resumeAfterTransition = false;
      // ユーザー操作で止まっている autoplay を再開
      try { memberSwiper.autoplay.start(); } catch (_) {}
    }
  });

  // 純正ナビのクリックより“前”に速さ変更＆停止を差し込む
  nextBtn.addEventListener('pointerdown', onPointerDown);
  prevBtn.addEventListener('pointerdown', onPointerDown);

  // デバッグしたい時だけ公開
  // window.memberSwiper = memberSwiper;
};

// 初期化
window.addEventListener('load', initMemberSwiper);

// ブレークポイント跨ぎでのみ再初期化
window.addEventListener('resize', () => {
  const newBp = window.innerWidth >= 768 ? 'tab' : 'sp';
  if (newBp !== currentBreakpoint) {
    currentBreakpoint = newBp;
    initMemberSwiper();
  }
});
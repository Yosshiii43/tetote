/*************************************************************************
 * main.js  –  ver.1.0
 *************************************************************************/

//--------------------------------------------------------------------------
// ハンバーガーメニューとドロワー
//--------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('#js-header');
  const hamburger = document.querySelector('#js-hamburger');
  const drawer = document.querySelector('#js-drawerBackground');
  const main = document.querySelector('#main'); // 本文だけ inert にする
  if (!drawer || !hamburger) return;

  const FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
  const getFocusable = (root) => Array.from(root.querySelectorAll(FOCUSABLE));

  let lastFocused = null;

  const setToggleA11y = (isOpen) => {
    hamburger.setAttribute('aria-expanded', String(isOpen));
    hamburger.setAttribute('aria-label', isOpen ? 'メニューを閉じる' : 'メニューを開く');
  };

  const openMenu = () => {
    lastFocused = document.activeElement;
    drawer.classList.add('is-open');
    body.classList.add('is-scrollLock');
    header.classList.add('is-open');

    drawer.setAttribute('aria-hidden', 'false');
    setToggleA11y(true);

    // 本文だけ操作不可に（ヘッダーは操作可能のまま）
    main?.setAttribute('inert', '');

    // 初期フォーカスをドロワー内の先頭へ
    const focusables = getFocusable(drawer);
    (focusables[0] || drawer).focus();
  };

  const closeMenu = () => {
    drawer.classList.remove('is-open');
    body.classList.remove('is-scrollLock');
    header.classList.remove('is-open');

    drawer.setAttribute('aria-hidden', 'true');
    setToggleA11y(false);

    // 本文の inert を解除（ヘッダーはもともと触れる）
    main?.removeAttribute('inert');

    // フォーカスをトグルへ戻す
    (lastFocused instanceof HTMLElement ? lastFocused : hamburger).focus();
  };

  // トグル
  hamburger.addEventListener('click', () => {
    drawer.classList.contains('is-open') ? closeMenu() : openMenu();
  });

  // Esc で閉じる（非モーダルでも利便性のため入れておく）
  drawer.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      e.preventDefault();
      closeMenu();
    }
  });
});

//--------------------------------------------------------------------------
// スムーススクロール
//--------------------------------------------------------------------------
// ヘッダー情報
/*
const header = document.querySelector(".p-header");
const headerHeight = header ? header.offsetHeight + 0 : 0;

// イージング関数（easeOutExpo）
function scrollToPos(position) {
  const startPos = window.scrollY;
  const distance = Math.min(
    position - startPos,
    document.documentElement.scrollHeight - window.innerHeight - startPos
  );
  const duration = 800; // スクロールにかかる時間（ミリ秒）

  let startTime;

  function easeOutExpo(t, b, c, d) {
    return (c * (-Math.pow(2, (-10 * t) / d) + 1) * 1024) / 1023 + b;
  }

  function animation(currentTime) {
    if (startTime === undefined) {
      startTime = currentTime;
    }
    const timeElapsed = currentTime - startTime;
    const scrollPos = easeOutExpo(timeElapsed, startPos, distance, duration);
    window.scrollTo(0, scrollPos);
    if (timeElapsed < duration) {
      requestAnimationFrame(animation);
    } else {
      window.scrollTo(0, position);
    }
  }

  requestAnimationFrame(animation);
}

// 画像の強制読み込み
function loadImages() {
  const targets = document.querySelectorAll("[data-src]");
  for (const target of targets) {
    const dataSrc = target.getAttribute("data-src");
    const currentSrc = target.getAttribute("src");

    // data-src と src が異なる場合のみコピーする
    if (dataSrc !== currentSrc) {
      target.setAttribute("src", dataSrc);
    }
  }
}

// ページ内のスムーススクロール
for (const link of document.querySelectorAll('a[href*="#"]')) {
  link.addEventListener("click", (e) => {
    const hash = e.currentTarget.hash;
    const target = document.getElementById(hash.slice(1));

    // ページトップへ("#"と"#top"）
    if (!hash || hash === "#top") {
      e.preventDefault();
      scrollToPos(0);

      // アンカーへ
    } else if (target) {
      e.preventDefault();
      loadImages();
      const position =
        target.getBoundingClientRect().top + window.scrollY - headerHeight;
      scrollToPos(position);

      // URLにハッシュを含める
      history.pushState(null, "", hash);
    }
  });
}

// 別ページ遷移後のスムーススクロール
const urlHash = window.location.hash;
if (urlHash) {
  const target = document.getElementById(urlHash.slice(1));
  if (target) {
    // ページトップから開始（ブラウザ差異を考慮して併用）
    history.replaceState(null, "", window.location.pathname);
    window.scrollTo(0, 0);

    loadImages();
    window.addEventListener("load", () => {
      const position =
        target.getBoundingClientRect().top + window.scrollY - headerHeight;
      scrollToPos(position);

      // ハッシュを再設定
      history.replaceState(null, "", window.location.pathname + urlHash);
    });
  }
}
*/

//--------------------------------------------------------------------------
// スクロールするとアニメーション付きで追従ヘッダーを出すコード
//--------------------------------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('scroll', function() {
    const header = document.querySelector('.p-header');
    const headerHeight = header.offsetHeight; // ヘッダーの高さを取得
    const scrollY = window.pageYOffset;
    const hero = document.querySelector('.p-hero');
    const heroHeight = hero.offsetHeight; // ヒーローの高さを取得
    
    
    if (scrollY >= heroHeight) {
      header.classList.add('p-header--sticky');
      document.body.style.marginTop = headerHeight + 'px'; // コンテンツにヘッダーの高さ分の余白を設定
    } else {
      header.classList.remove('p-header--sticky');
      document.body.style.marginTop = '0'; // コンテンツの余白をリセット
    }
  });
});


/*************************************************************************
 * 1行と複数行の判定(Top Hero内News)
 *************************************************************************/
const updateLineHeight = () => {
  const elems = document.querySelectorAll('.js-lineHeight');

  elems.forEach(elem => {
    // 一旦クラスをリセット
    elem.classList.remove('lineHeight--single', 'lineHeight--multi');

    // getComputedStyleでline-heightを取得
    const computed = window.getComputedStyle(elem);
    const lineHeight = parseFloat(computed.lineHeight);
    const height = elem.offsetHeight;
    const lines = Math.round(height / lineHeight);

    if (lines > 1) {
      elem.classList.add('lineHeight--multi');
    } else {
      elem.classList.add('lineHeight--single');
    }
  });
};

// 初回実行
window.addEventListener('DOMContentLoaded', updateLineHeight);

// リサイズ時にも再実行（デバウンス付き）
let resizeTimer;
window.addEventListener('resize', () => {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(updateLineHeight, 200);
});
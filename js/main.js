/*************************************************************************
 * main.js  –  ver.1.0
 *************************************************************************/

//--------------------------------------------------------------------------
// ハンバーガーメニューとドロワー
//--------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
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
// スクロールするとアニメーション付きで追従ヘッダーを出すコード
//--------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  window.addEventListener('scroll', function() {
    const header = document.querySelector('.p-header');
    const headerHeight = header.offsetHeight; // ヘッダーの高さを取得
    const scrollY = window.pageYOffset;
    const hero = document.querySelector('.p-main__head');
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
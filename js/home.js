/*************************************************************************
 * home.js  –  ver.1.0
 *************************************************************************/
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

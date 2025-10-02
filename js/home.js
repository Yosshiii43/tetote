/*************************************************************************
 * home.js  –  ver.1.0
 *************************************************************************/
//--------------------------------------------------------------------------
// スクロールするとアニメーション付きで追従ヘッダーを出すコード
//--------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
  const header = document.querySelector('.p-header');
  const hero = document.querySelector('.p-hero');
  window.addEventListener('scroll', function() {
    const scrollY = window.pageYOffset;
    const heroHeight = hero.offsetHeight; // ヒーローの高さを取得
    if (scrollY >= heroHeight) {
      header.classList.add('p-header--sticky');
    } else {
      header.classList.remove('p-header--sticky');
    }
  });
});
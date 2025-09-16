/*************************************************************************
 * staff.js  –  ver.1.0
 *************************************************************************/

//--------------------------------------------------------------------------
// Inline JS for TOC behavior: sticky on desktop, smooth scroll, active highlight
//--------------------------------------------------------------------------

(function(){
  // Only run in browsers that support IntersectionObserver
  if (!('IntersectionObserver' in window)) return;

  document.addEventListener('DOMContentLoaded', function(){
    var toc = document.getElementById('staff-toc');
    if (!toc) return;

    var links = Array.prototype.slice.call(toc.querySelectorAll('a'));
    var targets = links.map(function(a){
      var id = a.getAttribute('href').slice(1);
      return document.getElementById(id);
    }).filter(Boolean);

    // Smooth scroll on click
    links.forEach(function(link){
      link.addEventListener('click', function(e){
        e.preventDefault();
        var id = this.getAttribute('href').slice(1);
        var el = document.getElementById(id);
        if (!el) return;
        // Use scrollIntoView for simplicity
        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        // Update hash without jump
        history.replaceState(null, null, '#' + id);
      });
    });

    // IntersectionObserver to toggle active class
    var options = {
      root: null,
      rootMargin: '0px 0px -60% 0px', // consider a heading active when it's near top
      threshold: 0
    };

    var observer = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        var id = entry.target.getAttribute('id');
        var link = toc.querySelector('a[href="#' + id + '"]');
        if (!link) return;
        if (entry.isIntersecting) {
          // remove active on others
          toc.querySelectorAll('a').forEach(function(a){ a.classList.remove('is-active'); });
          link.classList.add('is-active');
        }
      });
    }, options);

    targets.forEach(function(t){ observer.observe(t); });

    // Optional: make the sidebar sticky on desktop via CSS; nothing required here
  });
})();
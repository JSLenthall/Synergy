//576

let docqs = _query => document.querySelector(_query),
    docqsa = _query => document.querySelectorAll(_query),
    deck = docqsa('#catalogue .card-deck')[0],
    navBtn = docqsa('#catalogue .catalogue-nav');

navBtn.forEach(_el => _el.addEventListener("click", _e => {
  let scrollPos = deck.scrollLeft,
      fullLeft = deck.scrollWidth - deck.clientWidth;

  if(_el.classList.contains('prev')){
    scrollPos -= 150;
    if(scrollPos < 0) {
      scrollPos = 0;
    }
  } else {
    scrollPos += 150;
    if(scrollPos > fullLeft) {
      scrollPos = fullLeft;
    }
  }
  deck.scrollLeft = scrollPos;
}));

function onResize(_e){
  navBtn.forEach(_el => _el.classList.remove('active'));
  if(deck.scrollWidth > deck.offsetWidth){
    navBtn.forEach(_el => _el.classList.add('active'));
  }
}

window.addEventListener("resize", onResize);
onResize();

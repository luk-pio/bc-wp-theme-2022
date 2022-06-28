// When the user scrolls the page, execute myFunction
window.onscroll = function () {
  myFunction();
};

// Get the header
var header = document.getElementById("bc-header");
var hero = document.getElementById("homepage-hero");
var body = document.getElementById("bc-body");
var cart;

// Get the offset position of the navbar
var sticky = (hero && hero.offSetTop) || 0;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  var cart = cart || document.getElementById("bc-header-cart");
  if (window.scrollY > sticky) {
    header.classList.remove("accent");
    cart.classList.remove("accent");
    body.classList.add("sticky-header-offset");
  } else {
    header.classList.add("accent");
    cart.classList.add("accent");
    body.classList.remove("sticky-header-offset");
  }
}

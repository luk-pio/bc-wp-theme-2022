// When the user scrolls the page, execute myFunction
window.onscroll = function () {
  myFunction();
};

// Get the header
var header = document.getElementById("bc-header");
var hero = document.getElementById("homepage-hero");
var body = document.getElementById("bc-body");

// Get the offset position of the navbar
var sticky = (hero && hero.offSetTop) || 0;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.scrollY > sticky) {
    header.classList.add("sticky");
    body.classList.add("sticky-header-offset");
  } else {
    header.classList.remove("sticky");
    body.classList.remove("sticky-header-offset");
  }
}

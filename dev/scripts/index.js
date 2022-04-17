function placeholderActive(el) {
  if (el.attr("placeholder") && el.val() === "") {
    return true;
  }
  return false;
}
jQuery("span:has(input:not(:placeholder-shown)) ~ span").addClass(
  "input-selected"
);
// make Form labels stay above inputs
jQuery("span > input").focusout(function () {
  if (!placeholderActive(jQuery(this))) {
    jQuery(this)
      .parent()
      .parent()
      .children(".bc-form-label")
      .addClass("input-selected");
  } else {
    if (!placeholderActive(jQuery(this))) {
      jQuery(this)
        .parent()
        .parent()
        .children(".bc-form-label")
        .removeClass("input-selected");
    }
  }
});
// When the user scrolls the page, execute myFunction
window.onscroll = function () {
  myFunction();
};

// Get the header
var header = document.getElementById("bc-header");
var body = document.getElementById("bc-body");

// Get the offset position of the navbar
var sticky = header.offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
  if (window.pageYOffset > sticky) {
    header.classList.add("sticky");
    body.classList.add("sticky-header-offset");
  } else {
    header.classList.remove("sticky");
    body.classList.remove("sticky-header-offset");
  }
}

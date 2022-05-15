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

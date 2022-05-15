// Use radio buttons for variation select
jQuery(document).on("change", ".variation-radios input", function () {
  jQuery(".variation-radios input:checked").each(function (index, element) {
    var $el = jQuery(element);
    var thisName = $el.attr("name");
    var thisVal = $el.attr("value");
    jQuery('select[name="' + thisName + '"]')
      .val(thisVal)
      .trigger("change");
  });
});
jQuery(document).on("woocommerce_update_variation_values", function () {
  setTimeout(showWaitingListAnimation, 0);
  jQuery(".variation-radios input").each(function (index, element) {
    var $el = jQuery(element);
    var thisName = $el.attr("name");
    var thisVal = $el.attr("value");
    $el.removeAttr("disabled");
    if (
      jQuery(
        'select[name="' + thisName + '"] option[value="' + thisVal + '"]'
      ).is(":disabled")
    ) {
      $el.prop("disabled", true);
    }
  });
});

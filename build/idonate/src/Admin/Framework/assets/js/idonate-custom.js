(function ($, window) {
  "use strict";

  /*  Keep the accordion field's first item opened */
  $(window).load(function () {
    $(".idonate-opened-accordion").each(function () {
      if (!$(this).hasClass("hidden")) {
        $(this).addClass("idonate_saved_filter");
      }
    });
  });
  $(".idonate-field-checkbox.idonate_advanced_filter").change(function (event) {
    $(".idonate-opened-accordion").each(function () {
      if ($(this).hasClass("hidden")) {
        $(this).removeClass("idonate_saved_filter");
      } else {
        $(this).addClass("idonate_saved_filter");
      }
      if (!$(this).hasClass("idonate_saved_filter")) {
        if (
          $(this)
            .find(".idonate-accordion-title")
            .siblings(".idonate-accordion-content")
            .hasClass("idonate-accordion-open")
        ) {
          $(this).find(".idonate-accordion-title");
        } else {
          $(this).find(".idonate-accordion-title").trigger("click");
          $(this)
            .find(".idonate-accordion-content")
            .find(".idonate-cloneable-add")
            .trigger("click");
        }
      }
    });
  });

  // Disable Fields //
  $("select option:contains((Pro))").attr('disabled', true).css('opacity', '1')
  // Disable and style the switcher element
  $(".switcher_pro_only .idonate--switcher")
    .attr("disabled", "disabled")
    .addClass("only_pro_switcher")
    .css({ background: "#B0BCC4" });

  // Apply common styling to elements with the 'only_pro_switcher' class
  $(".only_pro_switcher").css({
    "pointer-events": "none",
    color: "#8796A1",
    position: "relative",
  });
})(jQuery, window, document);

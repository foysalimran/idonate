/**
 * Table of contents
 * -----------------------------------
 * 01. INITIALIZE ADMIN DATA TABLE
 * 02. INITIALIZE ADMIN FORM VALIDATE
 * 03. DONOR ADMIN VIEW
 * 04. COUNTRY SELECT BOX
 * 05. FILE UPLOAD
 * 06. FUNCTION TO DISPLAY POPUP
 * 07. FUNCTION TO HIDE POPUP
 * 08. VIEW DONOR DISPLAY POPUP
 * 09. VIEW DONOR HIDE POPUP
 * 10. VALIDATING EMPTY FIELD
 * 11. RESPONSE MESSAGE
 * 12. BLOOD REQUEST
 * 13. DONOR PENDING
 * 14. COPY SHORTCODE
 */

(function ($) {
  "use strict";
  var PATH = {};

  /******************** 01. INITIALIZE ADMIN DATA TABLE ********************/
  PATH.AdminDataTable = function () {
    if ($("#table_id").length) {
      $("#table_id").DataTable();
    }
  };
  /******************** 02. INITIALIZE ADMIN FORM VALIDATE ********************/
  PATH.Validate = function () {
    if ($("#form").length) {
      $("#form").validate();
    }
  };
  /******************** 03. DONOR ADMIN VIEW ********************/
  PATH.DonorAdminView = function () {
    var $selector = $(".dedit");

    $selector.on("click", function () {
      $(".loaderadd").html(
        '<div class="loaderwrapper"><div class="loader"></div></div>'
      );
      var $this = this,
        $id = $($this).data("donor-id"),
        $targetEdit = $($this).data("donor-edit"),
        $targetView = $($this).data("donor-view"),
        $targetDelete = $($this).data("donor-delete");

      $.ajax({
        url: localData.statesurl,
        data: {
          action: "admin_donor_profile_view",
          id: $id,
        },
        dataType: "json",
        success: function (response) {
          var post_template;
          if ($targetEdit === 1) {
            post_template = wp.template("donot-edit-template")(response);
          }
          if ($targetView === 1) {
            post_template = wp.template("donor-view-template")(response);
          }
          if ($targetDelete === 1) {
            post_template = wp.template("donor-delete-template")(response);
          }
          $(".contentapp").html(post_template);
          $(".loaderwrapper").remove();
          $("#datebirthedit").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "1800:2030",
          });
          // Select box selected value
          $("[data-select]").each(function () {
            var $this = $(this),
              selected;
            selected = $this.data("select");
            if (selected !== "") {
              $this.find("select").val(selected);
            }
          });

          // Selected country and state for donor edit
          $.ajax({
            type: "POST",
            url: localData.statesurl,
            data: {
              country: response.contycode,
              action: "country_to_states_ajax",
            },
            success: function (rss) {
              $(".state").empty();
              var $opt = "";
              $.each(JSON.parse(rss), function (key, value) {
                var selected = "";
                if (response.state === value) {
                  selected = "selected";
                }
                $opt +=
                  '<option value="' +
                  key +
                  '" ' +
                  selected +
                  ">" +
                  value +
                  "</option>";
              });
              $(".state").append($opt);
            },
          });
        },
      });
    });
  };

  /******************** 04. COUNTRY SELECT BOX ********************/
  PATH.CountrySelectBox = function () {
    $("body").on("change", ".country", function () {
      $.ajax({
        type: "POST",
        url: localData.statesurl,
        data: {
          country: $(this).val(),
          action: "country_to_states_ajax",
        },
        success: function (rss) {
          $(".state").empty();
          var $opt = "";
          $.each(JSON.parse(rss), function (key, value) {
            $opt += '<option value="' + key + '">' + value + "</option>";
          });

          $(".state").append($opt);
        },
      });
    });
  };

  /******************** 04. COUNTRY SELECT BOX ********************/
  PATH.AdminCountrySelectBox = function () {
    $("body").on("change", ".br_country_meta  select", function () {
      $.ajax({
        type: "POST",
        url: localData.statesurl,
        data: {
          country: $(this).val(),
          action: "idonate_country_to_states_ajax",
        },
        success: function (rss) {
          $(".br_state_meta  select").empty();
          var $opt = "";
          $.each(JSON.parse(rss), function (key, value) {
            $opt += '<option value="' + key + '">' + value + "</option>";
          });

          $(".br_state_meta select").append($opt);
        },
      });
    });
  };

  /******************** 05. FILE UPLOAD ********************/
  PATH.FileUpload = function () {
    $(document).on("change", ".profilepic", function () {
      var $this = $(this);

      if ($this[0]["files"]) {
        var reader = new FileReader(),
          $target = $($this.data("target"));

        reader.onload = function (e) {
          $target.attr("src", e.target.result);
        };

        reader.readAsDataURL($this[0]["files"][0]);
      }
    });
  };

  /******************** 10. VALIDATING EMPTY FIELD ********************/
  PATH.check_empty = function () {
    if (
      document.getElementById("name").value == "" ||
      document.getElementById("email").value == "" ||
      document.getElementById("msg").value == ""
    ) {
      alert("Fill All Fields !");
    } else {
      document.getElementById("form").submit();
      alert("Form Submitted Successfully...");
    }
  };
  /******************** 11. RESPONSE MESSAGE ********************/
  PATH.ResponseMessage = function () {
    setTimeout(function () {
      var element = document.getElementById("idonate-response-msg");
      if (element) {
        element.parentNode.removeChild(element);
      }
    }, 3000); // 3000 milliseconds = 3 seconds
  };

  /******************** 12. BLOOD REQUEST ********************/
  PATH.BloodRequest = function () {
    if ($(".request_pending_lists").length > 0) {
      $(".request_pending_lists").each(function () {
        var ajaxurl = idonate.ajaxurl,
          nonce = idonate.nonce;

        var pendingAction = null;
        var pendingActionData = null;

        $(".request_pending_lists").on(
          "click",
          ".idonate_popup_modal",
          function (event) {
            event.preventDefault();
            event.stopPropagation();
            var that = $(this);
            var user_id = that.parents(".blood_request_info").data("id");

            $.ajax({
              type: "POST",
              url: ajaxurl,
              data: {
                user_id: user_id,
                action: "idonate_blood_request_popup",
                nonce: nonce,
              },
              success: function (response) {
                var $data = $(response);
                var $newElements = $data.css({ opacity: 0 });

                $.magnificPopup.open({
                  type: "inline",
                  showCloseBtn: false,
                  closeBtnInside: false,
                  enableEscapeKey: true,
                  closeOnBgClick: true,
                  items: { src: $newElements },
                  callbacks: {
                    open: function () {
                      $(document)
                        .off("click", "[data-reqaction]")
                        .on("click", "[data-reqaction]", function () {
                          var $this = $(this),
                            $uid = $this.data("uid"),
                            dataAction = $this.data("reqaction");

                          if (
                            dataAction === "delete" &&
                            !confirm(
                              "Are you sure you want to delete this donor?"
                            )
                          ) {
                            return;
                          }

                          pendingAction = "panding_blood_request_action";
                          pendingActionData = {
                            target:
                              dataAction === "delete" ? "delete" : "approve",
                            userid: $uid,
                          };

                          $.magnificPopup.close();
                        });
                    },
                    close: function () {
                      if (pendingAction && pendingActionData) {
                        $.ajax({
                          type: "post",
                          url: ajaxurl,
                          data: {
                            action: pendingAction,
                            ...pendingActionData,
                          },
                          success: function (response) {
                            var listdismis = $(
                              "[data-uid='" + pendingActionData.userid + "']"
                            ).parents("[data-listid]");

                            $(listdismis).fadeOut();

                            var res = JSON.parse(response);
                            var listID = $("#list" + pendingActionData.userid);
                            if (listID.length) {
                              listID.hide();
                            }
                            $("body").append(
                              '<div class="ido-pop" style="position: fixed; width: 300px; text-align: center; background-color: #d4edda; border-color: #c3e6cb; color: #18692b;padding: 12px; bottom: 30px; left: 50%; transform: translateX(-50%);">' +
                                res.msg +
                                "</div>"
                            );
                            $(".ido-pop").delay("800").fadeOut("slow");
                            pendingAction = null;
                            pendingActionData = null;
                          },
                        });
                      }
                    },
                  },
                });
                $newElements.animate({ opacity: 1 });
              },
            });
          }
        );
      });
    }
  };

  /******************** 13. DONOR PENDING ********************/
  PATH.DonorPending = function () {
    if ($(".donor_pending_lists").length > 0) {
      $(".donor_pending_lists").each(function () {
        var ajaxurl = idonate.ajaxurl,
          nonce = idonate.nonce;

        var pendingAction = null;
        var pendingActionData = null;

        $(".donor_pending_lists").on(
          "click",
          ".idonate_popup_modal",
          function (event) {
            event.preventDefault();
            event.stopPropagation();
            var that = $(this);
            var user_id = that.parents(".donor_info").data("id");

            $.ajax({
              type: "POST",
              url: ajaxurl,
              data: {
                user_id: user_id,
                action: "idonate_donor_popup",
                nonce: nonce,
              },
              success: function (response) {
                var $data = $(response);
                var $newElements = $data.css({ opacity: 0 });

                $.magnificPopup.open({
                  type: "inline",
                  showCloseBtn: false,
                  closeBtnInside: false,
                  enableEscapeKey: true,
                  closeOnBgClick: true,
                  items: { src: $newElements },
                  callbacks: {
                    open: function () {
                      // Attach event handler to dynamically loaded content
                      $(document).on(
                        "click",
                        "[data-donoraction]",
                        function () {
                          var $this = $(this),
                            $uid = $this.data("uid"),
                            dataAction = $this.data("donoraction");

                          // Confirm delete action
                          if (dataAction === "delete") {
                            if (
                              !confirm(
                                "Are you sure you want to delete this donor?"
                              )
                            ) {
                              return;
                            }
                          }

                          pendingAction = "panding_donor_action";
                          pendingActionData = {
                            target:
                              dataAction === "delete" ? "delete" : "approve",
                            userid: $uid,
                          };

                          $.magnificPopup.close();
                        }
                      );
                    },
                    close: function () {
                      if (pendingAction && pendingActionData) {
                        $.ajax({
                          type: "post",
                          url: idonate.ajaxurl,
                          data: {
                            action: pendingAction,
                            ...pendingActionData,
                          },
                          success: function (response) {
                            var listdismis = $(
                              "[data-uid='" + pendingActionData.userid + "']"
                            ).parents("[data-listid]");

                            $(listdismis).fadeOut();

                            var res = JSON.parse(response);
                            var listID = $("#list" + pendingActionData.userid);
                            if (listID.length) {
                              listID.hide();
                            }

                            $("body").append(
                              '<div class="ido-pop" style="position: fixed; width: 300px; text-align: center; background-color: #d4edda; border-color: #c3e6cb; color: #18692b;padding: 12px; bottom: 30px; left: 50%; transform: translateX(-50%);">' +
                                res.msg +
                                "</div>"
                            );

                            $(".ido-pop").delay("800").fadeOut("slow");

                            pendingAction = null;
                            pendingActionData = null;
                          },
                        });
                      }
                    },
                  },
                });
                $newElements.animate({ opacity: 1 });
              },
            });
          }
        );
      });
    }
  };

  /******************** 14. COPY SHORTCODE ********************/
  PATH.CopyShortcode = function () {
    $(".idonate_shortcode").on("click", function (e) {
      e.preventDefault();
      idonate_copyToShortcode($(this));
      idonate_SelectText($(this));
      $(this).trigger("focus").select();
      $(".idonate-after-copy-shortcode").animate(
        {
          opacity: 1,
          bottom: 25,
        },
        300
      );
      setTimeout(function () {
        jQuery(".idonate-after-copy-shortcode").animate(
          {
            opacity: 0,
          },
          200
        );
        jQuery(".idonate-after-copy-shortcode").animate(
          {
            bottom: 0,
          },
          0
        );
      }, 2000);
    });
    function idonate_copyToShortcode(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
    }
    function idonate_SelectText(element) {
      var r = document.createRange();
      var w = element.get(0);
      r.selectNodeContents(w);
      var sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(r);
    }
  };

  /******************** DOCUMENT READY FUNCTION ********************/
  $(function () {
    PATH.AdminDataTable();
    PATH.Validate();
    PATH.DonorAdminView();
    PATH.CountrySelectBox();
    PATH.AdminCountrySelectBox();
    PATH.FileUpload();
    PATH.DonorPending();
    PATH.BloodRequest();
    PATH.CopyShortcode();
  });

  /******************** IDONATE ON SCROLL FUNCTION ********************/
  $(window).on("scroll", function () {});

  /******************** IDONATE ON LOAD FUNCTION ********************/
  $(window).on("load", function () {
    PATH.ResponseMessage();
  });
})(jQuery);

/******************** 06. FUNCTION TO DISPLAY POPUP ********************/
function div_show() {
  document.getElementById("donor_form_popup").style.display = "block";
}

/******************** 07. FUNCTION TO HIDE POPUP ********************/
function div_hide() {
  document.getElementById("donor_form_popup").style.display = "none";
}

/******************** 08. VIEW DONOR DISPLAY POPUP ********************/
function div_donor_show() {
  document.getElementById("donorProfile").style.display = "block";
}

/******************** 09. VIEW DONOR HIDE POPUP ********************/
function div_donor_hide() {
  document.getElementById("donorProfile").style.display = "none";
}

/**
 * Set get pro link
 * @since 2.2.5
 */
const getProMenu = document.querySelector("span.idonate-get-pro-text");
if (getProMenu) {
  const el = getProMenu.parentElement;
  const link = "https://1.envato.market/idonate";

  el.setAttribute("href", link);
  el.setAttribute("target", "_blank");
}

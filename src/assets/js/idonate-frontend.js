(function ($) {
  /******************** 01. DONOR FORM VALIDATE ********************/
  if ($("#form").length) {
    $("#form").validate();
  }
  /******************** 02. REQUEST FORM VALIDATE ********************/
  if ($("#blood-request").length) {
    $("#blood-request").validate();
  }

  /******************** 03. INITIALIZE ADMIN DATA TABLE ********************/
  if ($("#table_id").length) {
    $("#table_id").DataTable();
  }

  /******************** 04. DONOR POPUP ********************/
  if ($(".donor_wrapper").length > 0) {
    $(".donors").each(function () {
      var ajaxurl = idonate.ajaxurl,
        nonce = idonate.nonce;

      function idonate_post_id_list() {
        var list = [];
        $(".donors")
          .find(".donor_info")
          .each(function () {
            list.push($(this).data("id"));
          });
        return list;
      }

      function idonate_val2key(val, array) {
        for (var all_key in array) {
          if (array[all_key] == val) {
            return all_key;
          }
        }
        return false;
      }

      function idonate_array_key_prev(all_key, idonate_id_length) {
        all_key--;
        if (all_key < 0) {
          all_key = idonate_id_length - 1;
        }
        return all_key;
      }

      function idonate_array_key_next(all_key, idonate_id_length) {
        all_key++;
        if (all_key >= idonate_id_length) {
          all_key = 0;
        }
        return all_key;
      }

      function ajax_popup_next_prev(idonate_array_key, url) {
        $("#preloader").show(); // Show preloader
        $.ajax({
          type: "POST",
          url: url,
          data: {
            user_id: idonate_array_key,
            nonce: nonce,
            action: "idonate_post_admin_popup_next_prev",
          },
          success: function (response) {
            var $data = $(response);
            var $newElements = $data.css({ opacity: 0 });
            $(".idonate_popup_ajax_content").html($newElements);
            $newElements.animate({ opacity: 1 });
            $("#preloader").hide(); // Hide preloader
          },
        });
      }

      var idonate_array_key;
      var idonate_id_list;
      var idonate_id_length;

      $(".donors").on("click", ".idonate_popup_modal", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var that = $(this);
        var user_id = that.parents(".donor_info").data("id");
        idonate_id_list = idonate_post_id_list();
        idonate_array_key = idonate_val2key(user_id, idonate_id_list);
        idonate_id_length = idonate_id_list.length;
        $.ajax({
          type: "POST",
          url: ajaxurl,
          data: {
            user_id: user_id,
            action: "idonate_post_popup",
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
            });
            $newElements.animate({ opacity: 1 });
          },
        });

        $(document)
          .off("click", ".idonate-popup-button-next")
          .on("click", ".idonate-popup-button-next", function (event) {
            event.preventDefault();
            event.stopPropagation();
            idonate_array_key = idonate_array_key_next(
              idonate_array_key,
              idonate_id_length
            );
            ajax_popup_next_prev(idonate_id_list[idonate_array_key], ajaxurl);
          });

        $(document)
          .off("click", ".idonate-popup-button-prev")
          .on("click", ".idonate-popup-button-prev", function (event) {
            event.preventDefault();
            event.stopPropagation();
            idonate_array_key = idonate_array_key_prev(
              idonate_array_key,
              idonate_id_length
            );
            ajax_popup_next_prev(idonate_id_list[idonate_array_key], ajaxurl);
          });
      });
    });
  }
  /******************** 05. REQUEST POPUP ********************/
  if ($(".request_wrapper").length > 0) {
    $(".request").each(function () {
      var ajaxurl = idonate.ajaxurl,
        nonce = idonate.nonce;

      function idonate_post_id_list() {
        var list = [];
        $(".request")
          .find(".single-request")
          .each(function () {
            list.push($(this).data("id"));
          });
        return list;
      }

      function idonate_val2key(val, array) {
        for (var all_key in array) {
          if (array[all_key] == val) {
            return all_key;
          }
        }
        return false;
      }

      function idonate_array_key_prev(all_key, idonate_id_length) {
        all_key--;
        if (all_key < 0) {
          all_key = idonate_id_length - 1;
        }
        return all_key;
      }

      function idonate_array_key_next(all_key, idonate_id_length) {
        all_key++;
        if (all_key >= idonate_id_length) {
          all_key = 0;
        }
        return all_key;
      }

      function ajax_popup_next_prev(idonate_array_key, url) {
        $("#preloader").show(); // Show preloader
        $.ajax({
          type: "POST",
          url: url,
          data: {
            post_id: idonate_array_key,
            nonce: nonce,
            action: "idonate_request_popup_next_prev",
          },
          success: function (response) {
            var $data = $(response);
            var $newElements = $data.css({ opacity: 0 });
            $(".idonate_popup_ajax_content").html($newElements);
            $newElements.animate({ opacity: 1 });
            $("#preloader").hide(); // Hide preloader
          },
        });
      }

      var idonate_array_key;
      var idonate_id_list;
      var idonate_id_length;

      $(".request").on(
        "click",
        ".idonate_request_popup_modal",
        function (event) {
          event.preventDefault();
          event.stopPropagation();
          var that = $(this);
          var post_id = that.parents(".single-request").data("id");
          idonate_id_list = idonate_post_id_list();
          idonate_array_key = idonate_val2key(post_id, idonate_id_list);
          idonate_id_length = idonate_id_list.length;
          $.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
              post_id: post_id,
              action: "idonate_request_popup_modal",
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
              });
              $newElements.animate({ opacity: 1 });
            },
          });

          $(document)
            .off("click", ".idonate-popup-button-next")
            .on("click", ".idonate-popup-button-next", function (event) {
              event.preventDefault();
              event.stopPropagation();
              idonate_array_key = idonate_array_key_next(
                idonate_array_key,
                idonate_id_length
              );
              ajax_popup_next_prev(idonate_id_list[idonate_array_key], ajaxurl);
            });

          $(document)
            .off("click", ".idonate-popup-button-prev")
            .on("click", ".idonate-popup-button-prev", function (event) {
              event.preventDefault();
              event.stopPropagation();
              idonate_array_key = idonate_array_key_prev(
                idonate_array_key,
                idonate_id_length
              );
              ajax_popup_next_prev(idonate_id_list[idonate_array_key], ajaxurl);
            });
        }
      );
    });
  }
  /******************** 06. UPDATE PROFILE PICTURE ********************/
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

  /******************** 07. COUNTRY SELECT BOX ********************/
  $("body").on("change", ".country", function () {
    var state_id = document.getElementById("state");

    $.ajax({
      type: "POST",
      url: idonate.ajaxurl,
      data: {
        country: $(this).val(),
        action: "country_to_states_ajax",
      },

      success: function (rss) {
        all_state = JSON.parse(rss);
        if (state_id) {
          let current_state = JSON.parse(state_id.getAttribute("data-state"));
          const matchedItems = {};
          for (const key in all_state) {
            if (current_state.hasOwnProperty(key)) {
              matchedItems[key] = all_state[key];
            }
          }
          function isEmpty(matchedItems) {
            for (let key in matchedItems) {
              if (matchedItems.hasOwnProperty(key)) {
                return true;
              }
            }
            return false;
          }

          if (isEmpty(matchedItems)) {
            $(".state").empty();
            var $opt = ""; // Default option
            $.each(matchedItems, function (key, value) {
              $opt += '<option value="' + key + '">' + value + "</option>";
            });
            $(".state").append($opt);
          }
        } else {
          $(".state").empty();
          var $opt = ""; // Default option
          $.each(all_state, function (key, value) {
            $opt += '<option value="' + key + '">' + value + "</option>";
          });
          $(".state").append($opt);
        }
      },
    });
  });

  /******************** 08. DONOR FILTER ********************/
  if ($(".donor_wrapper").length > 0) {
    $(".donor_wrapper").each(function () {
      var $wrapper = $(this);
      var pagenumLink = $wrapper.data("pagenum_link");

      $wrapper
        .find("#bloodgroup, #availability, #country, #state")
        .change(function () {
          updateDonors($wrapper, pagenumLink);
        });

      $wrapper.find("#city, #name").on("keyup", function () {
        updateDonors($wrapper, pagenumLink);
      });

      $wrapper.find("#reset-button").click(function () {
        $wrapper.find("#bloodgroup").val("");
        $wrapper.find("#availability").val("");
        $wrapper.find("#country").val("");
        $wrapper.find("#state").val("");
        $wrapper.find("#city").val("");
        $wrapper.find("#name").val("");
        updateDonors($wrapper, pagenumLink);
      });

      function updateDonors($wrapper, pagenumLink) {
        var bloodgroup = $wrapper.find("#bloodgroup").val();
        var availability = $wrapper.find("#availability").val();
        var country = $wrapper.find("#country").val();
        var state = $wrapper.find("#state").val();
        var city = $wrapper.find("#city").val();
        var name = $wrapper.find("#name").val();

        $.ajax({
          url: idonate.ajaxurl,
          type: "POST",
          data: {
            action: "idonate_search_donors",
            nonce: idonate.nonce,
            bloodgroup: bloodgroup,
            availability: availability,
            country: country,
            state: state,
            city: city,
            name: name,
            pagenumLink: pagenumLink,
          },
          success: function (response) {
            if (response.success) {
              $wrapper.find(".donors").html(response.data.html);
            } else {
              $wrapper
                .find(".donors")
                .html(
                  '<h3 class="alert text-center alert-danger">' +
                    response.data.message +
                    "</h3>"
                );
            }
          },
        });
      }
    });
  }

  /******************** 09. Request FILTER ********************/
  if ($(".request_wrapper").length > 0) {
    $(".request_wrapper").each(function () {
      var $wrapper = $(this);
      var pagenumLink = $wrapper.data("pagenum_link");

      $wrapper.find("#bloodgroup, #country, #state").change(function () {
        updateRequests($wrapper, pagenumLink);
      });

      $wrapper
        .find("#city, #name, #start_date, #end_date")
        .on("keyup change", function () {
          updateRequests($wrapper, pagenumLink);
        });

      $wrapper.find("#reset-button").click(function () {
        $wrapper.find("#bloodgroup").val("");
        $wrapper.find("#country").val("");
        $wrapper.find("#state").val("");
        $wrapper.find("#city").val("");
        $wrapper.find("#name").val("");
        $wrapper.find("#start_date").val("");
        $wrapper.find("#end_date").val("");
        updateRequests($wrapper, pagenumLink);
      });

      function updateRequests($wrapper, pagenumLink) {
        var bloodgroup = $wrapper.find("#bloodgroup").val();
        var country = $wrapper.find("#country").val();
        var state = $wrapper.find("#state").val();
        var city = $wrapper.find("#city").val();
        var name = $wrapper.find("#name").val();
        var start_date = $wrapper.find("#start_date").val();
        var end_date = $wrapper.find("#end_date").val();

        $.ajax({
          url: idonate.ajaxurl,
          type: "POST",
          data: {
            action: "idonate_search_request",
            nonce: idonate.nonce,
            bloodgroup: bloodgroup,
            country: country,
            state: state,
            city: city,
            name: name,
            start_date: start_date,
            end_date: end_date,
            pagenumLink: pagenumLink,
          },
          success: function (response) {
            if (response.success) {
              $wrapper.find(".request").html(response.data.html);
            } else {
              $wrapper
                .find(".request")
                .html(
                  '<h3 class="alert text-center alert-danger">' +
                    response.data.message +
                    "</h3>"
                );
            }
          },
        });
      }
    });
  }
  setTimeout(function () {
    var element = document.getElementById("idonate-response-msg");
    if (element) {
      element.parentNode.removeChild(element);
    }
  }, 3000); // 3000 milliseconds = 3 seconds

  const dashboardNavigation = document.querySelector(".dashboard-navigation");
  const dashboardMenu = document.querySelector(".dashboard_menu");
  dashboardNavigation.addEventListener("click", () => {
    dashboardMenu.classList.toggle("active");
  });
})(jQuery);

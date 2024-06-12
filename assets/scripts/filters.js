jQuery(document).ready(function ($) {
  // Initialize Select2
  $("#categoryFilter").select2();
  $("#formatFilter").select2();
  $("#date_dropdown").select2();

  function fetchFilteredPhotos(page = 1) {
    let category = $("#categoryFilter").val();
    let format = $("#formatFilter").val();
    let date = $("#date_dropdown").val();

    $.ajax({
      url: ajaxurl, // `ajaxurl` is a global variable in WordPress
      type: "POST",
      data: {
        action: "filter_photos",
        category: category,
        format: format,
        date: date,
        page: page,
      },
      success: function (response) {
        if (page === 1) {
          $(".photos_container").html(response);
        } else {
          $(".photos_container").append(response);
        }
      },
    });
  }

  $("#categoryFilter, #formatFilter, #date_dropdown").on("change", function () {
    fetchFilteredPhotos();
  });

  $("#load_more_button").on("click", function () {
    let page = $(this).data("page");
    $(this).data("page", page + 1);
    fetchFilteredPhotos(page + 1);
  });
});

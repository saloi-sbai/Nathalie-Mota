jQuery(document).ready(function ($) {
  $("#load_more_button").click(function (event) {
    event.preventDefault();

    var button = $(this);
    var currentPage = parseInt(button.data("page"));
    var nextPage = currentPage + 1;

    $.ajax({
      type: "POST",
      url: my_ajax_obj.ajax_url,
      dataType: "json",
      data: {
        action: "loadMore",
        paged: nextPage,
      },
      success: function (response) {
        if (response.html) {
          $(".photos_container").append(response.html);
          button.data("page", nextPage);

          if (!response.has_more_posts) {
            button.hide();
          }
        }
      },
    });
  });
});

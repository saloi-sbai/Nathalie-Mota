// modal
document.addEventListener("DOMContentLoaded", function () {
  console.log("Le DOM est chargé.");
  var overlay = document.getElementById("overlay");
  var contactLink = document.getElementById("menu-item-18");
  var closeButton = document.getElementsByClassName("close-modal")[0];

  contactLink.onclick = function (event) {
    event.preventDefault(); // Empêche le comportement par défaut du lien
    overlay.classList.remove("hidden");
  };

  closeButton.onclick = function () {
    overlay.classList.add("hidden");
  };

  window.onclick = function (event) {
    if (event.target == overlay) {
      overlay.classList.add("hidden");
    }
  };
});

// bouton charger plus
const loadMore = jQuery("#load_more_button");
function initializeLoadMore() {
  let currentPage = 1;
  loadMore.on("click", function (event) {
    event.preventDefault();
    currentPage++;
    jQuery.ajax({
      type: "POST",
      url: "http://localhost/nathalie-mota/wp-admin/admin-ajax.php",
      dataType: "json",
      data: {
        action: "loadMore",
        paged: currentPage,
      },
      success: function (response) {
        jQuery(".photos_container").append(response.html);
        checkIfMorePosts(response);
      },
    });
  });
}
function checkIfMorePosts(res) {
  if (!res.has_more_posts) {
    loadMore.hide();
    console.log("Response : Has no more posts");
  } else {
    loadMore.show();
    console.log("Response : Has more posts");
  }
}

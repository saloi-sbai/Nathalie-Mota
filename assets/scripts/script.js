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



// categorie et filter

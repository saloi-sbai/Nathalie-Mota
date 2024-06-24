// JS DES FILTRES

console.log("Le JS des filtres est bien chargé");

jQuery(document).ready(function ($) {
  // Fonction appelée lorsque les filtres changent
  $("#categorie, #format, #annees").on("change", function () {
    // Je récupère les valeurs des filtres
    const category = $("#categorie").val();
    const format = $("#format").val();
    const years = $("#annees").val();
    console.log(category);
    // Je vérifie si les valeurs sont les valeurs par défaut (vides)
    const isDefaultValues = category === "" && format === "" && years === "";

    // envoie une requête AJAX pour filtrer les photos
    $.ajax({
      url: ajax_params.ajax_url,
      type: "post",
      data: {
        action: "filter_photos", // action a realiser coté serveur
        filter: {
          category: category,
          format: format,
          years: years,
        },
      },
      
      // Gestion de la Réponse AJAX en Cas de Succès
      success: function (response) {
        $("#photo__container").html(""); // Vide le conteneur de photos
        $("#photo__container").append(response); // Ajoute les nouvelles photos
        attachEventsToImages();

        // Je masque le bouton "#viewMore" si des filtres sont appliqués
        if (category.length || format.length || years.length) {
          $("#viewMore").hide();
        } else {
          $("#viewMore").show();
        }
      },
      // Fonction appelée en cas d'erreur de la requête
      error: function (xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
        console.log(ajaxOptions);
        console.log(xhr.responseText);
      },
      // Fonction appelée à la fin de la requête, succès ou échec
      complete: function () {
        // Si les valeurs sont les valeurs par défaut, je relance le conteneur photo
        if (isDefaultValues) {
          // Je met à jour la section des photos avec le contenu par défaut
          $("#photo__container").load(
            window.location.href + " #photo__container"
          );
        }
      },
    });
  });
});

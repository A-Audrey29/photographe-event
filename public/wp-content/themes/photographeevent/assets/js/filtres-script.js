// pagination

jQuery(document).ready(function($) {
  let currentPage = 1;
  // Add event listener to the click of links with class "ajax"
  $('#load-more').on('click', function(event) {
      currentPage++;
      // Send an AJAX request to the server
      $.ajax({
          url: 'wp-admin/admin-ajax.php', // Use the global ajaxurl variable provided by WordPress
          method: 'POST', // HTTP method to use
          data: {
              action: 'weichie_load_more',
              paged: currentPage,
          },
          success: function(res) {
              console.log(res);
              $('.galerie-container').append(res);
          },
          error: function(res) {
              console.log('Error');

          }
      });
  });
})

  // Filtre Catégories


//   jQuery(document).ready(function($) {
//     // Écouteur d'événement pour le changement de filtres
//     $('#categories-select, #format-select, #date-select').change(function() {
//         // Obtenez les valeurs des filtres sélectionnés
//         let cat = $('#categories-select').val();
//         let photoFormat = $('#format-select').val();
//         let date = $('#date-select').val();

//         // Faites la requête Ajax
//         $.ajax({
//             url: 'wp-admin/admin-ajax.php', // L'URL de l'action Ajax
//             method: 'POST',
//             data: {
//                 action: 'galerie_filtres', // L'action à appeler dans functions.php
//                 cat_id: cat, // Valeur du filtre de catégorie
//                 format: photoFormat, // Valeur du filtre de format
//                 tri: date // Valeur du
//             }
//         });
//     })
// })


// => reponse du serveur 0 mais 200


// let pageActuelle = 1;

// $('#btn-charger-plus').on('click', function() {
//     pageActuelle ++;
//     ajaxRequest(true);
// });
// $(document).on('change', '.js-filter', function(e) {
//     e.preventDefault();
//     pageActuelle = 1;
//     ajaxRequest(false);
// });


  jQuery(document).ready(function($) {
    // Écouteur d'événement pour le changement de filtres
    $('#categories-select, #format-select, #date-select').change(function() {
        // Obtenez les valeurs des filtres sélectionnés
        let cat = $('#categories-select')
        let categorieTaxonomie = cat.attr('id');
        let categorieSelection = cat.find('option:selected').val();

        let format = $('#format-select')
        let formatTaxonomie = format.attr('id');
        let formatSelection = format.find('option:selected').val();

        let date = $('#date-select').find('option:selected').val();

        // Faites la requête Ajax
        $.ajax({
            url: 'wp-admin/admin-ajax.php', // L'URL de l'action Ajax
            method: 'POST',
            dataType: 'html',
            data: {
                action: 'galerie_filtres', // L'action à appeler dans functions.php
                categorieTaxonomie: categorieTaxonomie,
                categorieSelection: categorieSelection,
                formatTaxonomie: formatTaxonomie,
                formatSelection: formatSelection,
                orderDirection: date,
            },
            success: function(resultat) {
                if ($) {
                    $('.galerie-container').append(resultat);
                }
                else {
                    $('.galerie-container').html(resultat);
                }
            },
            error: function(result) {
                console.warn(result);
            }
           
        });
    });
});





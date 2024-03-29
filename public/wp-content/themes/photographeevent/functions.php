<?php

require_once('assets/inc/supports.php');
require_once('assets/inc/assets.php');
require_once('assets/inc/apparence.php');


function register_my_menus()
{
    register_nav_menus(
        array(
            'main' => __('Menu principal'),
            'footer' => __('Bas de page'),
        )
    );
}
add_action('after_setup_theme', 'register_my_menus');

// wp_nav_menu(array(
//     'theme_location' => 'main',
// ));



//déclaration des 2 emplacements des menu cf supports
// register_nav_menus(array(
//     'main' => 'Menu principal',
//     'footer' => 'Bas de page'
// ));

// intégration de l'item CONTACT dans le menu

// function add_last_nav_item($items)
// {
//     return $items .= '<li class="menu-item nav-item"><a href="#" id="myBtn" role="button" data-toggle="modal">CONTACT</a></li>';
// }
// add_filter('wp_nav_menu_items', 'add_last_nav_item');




//intégration mention tx " tous droits réservé "

function add_last_nav_item($items, $args)
{
    // Vérifiez si le menu correspond au menu principal
    if ($args->theme_location == 'footer') {
        $items .= '<li class="menu-item">TOUS DROITS RÉSERVÉS</li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'add_last_nav_item', 10, 2);



// gestion des class : rajout de nav-item
function photographeevent_menu_class($classes)
{
    $classes[] = 'nav-item';
    return $classes;
}
add_filter('nav_menu_css_class', 'photographeevent_menu_class');


// gestion de la class des liens des items
function photographeevent_menu_link_class($attrs)
{
    $attrs['class'] = 'nav-link';
    return $attrs;
}
add_filter('nav_menu_link_attributes', 'photographeevent_menu_link_class');


// ajout des taxonomies

$terms = get_terms(array(
    'taxonomy'   => 'post_tag',
    'hide_empty' => false,
));


// fonction pour afficher les photos page d'accueil et "vous aimeriez aussi" de la single

function galeriePhotos($ajaxposts)
{
    while ($ajaxposts->have_posts()) :
        $ajaxposts->the_post();

        // Récupérer l'image mise en avant de l'article
        add_image_size('custom-size', 500, 500, true);

        get_template_part('template-parts/content', 'image');

    endwhile;
}

function afficherTaxonomies($nomTaxonomie)
{
    if ($terms = get_terms(array(
        'taxonomy' => $nomTaxonomie,
        'orderby' => 'name'
    ))) {
        foreach ($terms as $term) {
            echo '<option class="js-filter-item" value="' . $term->slug . '">' . $term->name . '</option>';
        }
    }
}


function galerie_filtres($cat = 9, $format = 'paysage', $date = 'DESC')
{
    $categorieSelection = $_POST['categorieSelection'];
    $formatSelection = $_POST['formatSelection'];
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => $_POST['orderDirection'],
        'tax_query' => array(
            array(
                'relation' => 'AND',
                $_POST['categorieSelection'] != "all" ?
                    array(
                        'taxonomy' => 'categories',
                        'field' => 'slug',
                        'terms' => $_POST['categorieSelection'],
                    )
                    : '',
                $_POST['formatSelection'] != "all" ?
                    array(
                        'taxonomy' => 'formats',
                        'field' => 'slug',
                        'terms' => $_POST['formatSelection'],
                    )
                    : '',
            ),
        ),
    );

    $query = new WP_Query($args);
    galeriePhotos($query, true);

    wp_die();
}
add_action('wp_ajax_nopriv_galerie_filtres', 'galerie_filtres');
add_action('wp_ajax_galerie_filtres', 'galerie_filtres');




// requête pagination

function weichie_load_more()
{
    $paged = $_POST['paged']; // Récupère la valeur de 'paged' depuis la requête Ajax

    $ajaxposts = new WP_Query([
        'post_type' => 'photo',
        'posts_per_page' => 12, //12 / 14 = 2 pages
        'paged' => $paged,
        'order' => 'DESC',
        'orderby' => ['date' => 'DESC', 'ID' => 'ASC']
    ]);

    $response = '';

    if ($ajaxposts->have_posts()) {
        while ($ajaxposts->have_posts()) : $ajaxposts->the_post();
            $response .=  get_template_part('template-parts/content', 'image');
        endwhile;
    } else {
        $response = '';
    }

    echo $response;
    exit;
}
add_action('wp_ajax_weichie_load_more', 'weichie_load_more');
add_action('wp_ajax_nopriv_weichie_load_more', 'weichie_load_more');


function weichie_disable_ajax_cache()
{
    if (defined('DOING_AJAX') && DOING_AJAX) {
        // Désactiver la mise en cache des requêtes Ajax
        define('DONOTCACHEPAGE', true);
    }
}
add_action('init', 'weichie_disable_ajax_cache');

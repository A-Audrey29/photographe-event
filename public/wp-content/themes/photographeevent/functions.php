<?php

require_once('assets/inc/supports.php');
require_once('assets/inc/assets.php');
require_once('assets/inc/apparence.php');

//déclaration des 2 emplacements des menu
register_nav_menus(array(
    'main' => 'Menu principal',
    'footer' => 'Bas de page'
));


// gestion des class : rajout de nav-item
function photographeevent_menu_class($classes)
{
    $classes[] = 'nav-item';
    return $classes;
}
add_filter('nav_menu_css_class', 'photographeevent_menu_class');


// gestion de la class des liens
function photographeevent_menu_link_class($attrs)
{
    $attrs['class'] = 'nav-link';
    return $attrs;
}
add_filter('nav_menu_link_attributes', 'photographeevent_menu_link_class');


// ajout du prtefolio sans ACF
// function photographeevent_register_post_types()
// {

//     // CPT Portfolio
//     $labels = array(
//         'name' => 'Portfolio',
//         'all_items' => 'Toutes les photos',  // affiché dans le sous menu
//         'singular_name' => 'Photo',
//         'add_new_item' => 'Ajouter une photo',
//         'edit_item' => 'Modifier la photo',
//         'menu_name' => 'Portfolio'
//     );

//     $args = array(
//         'labels' => $labels,
//         'public' => true,
//         'show_in_rest' => true,
//         'has_archive' => true,
//         'supports' => array('title', 'editor', 'thumbnail'),
//         'menu_position' => 5,
//         'menu_icon' => 'dashicons-admin-customizer',
//     );

//     register_post_type('portfolio', $args);
// }
// add_action('init', 'photographeevent_register_post_types'); // Le hook init lance la fonction


// ajout des taxonomies

$terms = get_terms( array(
    'taxonomy'   => 'post_tag',
    'hide_empty' => false,
) );
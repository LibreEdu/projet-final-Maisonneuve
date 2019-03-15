<?php

/** Typde de post personnalisé. */


/**
 * Crochet d’action 'init'
 *
 */
add_action('init', 'e1795854_TP2_custom_post_types_and_private_taxonomy');

/**
 * Traitement à l’installation du TPP
 *
 * @param void
 * @return void
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function e1795854_TP2_custom_post_types_and_private_taxonomy()
{
    e1795854_TP2_custom_post_types();            // Création du type de post personnalisé
    e1795854_TP2_register_private_taxonomy();    // Création de la taxonomie
}

function e1795854_TP2_custom_post_types() {
    $labels = array(
        'name'                  =>  __('Exhibitions', 'e1795854-tp2'), // Attention ne pas mettre de _ pour la dernier paramètres, sinon pb avec la traduction (POEdit).
        'singular_name'         =>  __('Exhibition', 'e1795854-tp2'),
        'add_new'               =>  __('Add New', 'e1795854-tp2'),
        'add_new_item'          =>  __('Add New Exhibition', 'e1795854-tp2'),
        'edit_item'             =>  __('Edit Exhibition', 'e1795854-tp2'),
        'new_item'              =>  __('New Exhibition', 'e1795854-tp2'),
        'view_item'             =>  __('View Exhibition', 'e1795854-tp2'),
        'view_items'            =>  __('View Exhibitions', 'e1795854-tp2'),
        'search_items'          =>  __('Search Exhibitions', 'e1795854-tp2'),
        'not_found'             =>  __('No exhibitions found.', 'e1795854-tp2'),
        'not_found_in_trash'    =>  __('No exhibitions found in Trash.', 'e1795854-tp2'),
        'parent_item_colon'     =>  __('Exhibition Book:', 'e1795854-tp2'),
        'all_items'             =>  __('All Exhibitions', 'e1795854-tp2'),
        'archives'              =>  __('Exhibition Archives', 'e1795854-tp2' ),
        'attributes'            =>  __('Exhibition Attributes', 'e1795854-tp2'),
        'insert_into_item'      =>  __('Insert into exhibition', 'e1795854-tp2'),
        'uploaded_to_this_item' =>  __('Uploaded to this exhibition', 'e1795854-tp2'),
        'featured_image'        =>  __('Exhibition Poster', 'e1795854-tp2'),
        'set_featured_image'    =>  __('Set poster', 'e1795854-tp2'),
        'remove_featured_image' =>  __('Remove poster', 'e1795854-tp2'),
        'use_featured_image'    =>  __('Use as poster', 'e1795854-tp2'),
        'menu_name'             =>  __('Exhibitions', 'e1795854-tp2'),
        'filter_items_list'     =>  __('Filter exhibitions list', 'e1795854-tp2'),
        'items_list_navigation' =>  __('Exhibitions list navigation', 'e1795854-tp2'),
        'items_list'            =>  __('Exhibitions list', 'e1795854-tp2'),
        'name_admin_bar'        =>  __('Exhibition', 'e1795854-tp2')
    );

    // $args = array(
    //     'labels'                => $labels, // tableau des libellés pour la gestion du TPP
    //     'description'           => __('Exhibition catalog', 'e1795854-tp2'),
    //     'public'                => true,
    //     'exclude_from_search'   => false,
    //     'publicly_queryable'    => true,
    //     'show_ui'               => true,
    //     'show_in_nav_menus'     => true,
    //     'show_in_menu'          => true,
    //     'show_in_admin_bar'     => true,
    //     'menu_position'         => null,
    //     'menu_icon'             => null,
    //     'capability_type'       => 'post',
    //     'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'post-formats' ),
    //     // 'capabilities'          => array('edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts', 'publish_posts', 'read_private_posts'),
    //     'map_meta_cap'          => null,
    //     'hierarchical'          => false,
    //     // 'register_meta_box_cb'  => None ,
    //     'taxonomies'            => array('theme', 'artist', 'place'),
    //     'has_archive'           => true,
    //     'rewrite'               => array('slug' => 'exhibition'),
    //     'permalink_epmask'      => EP_PERMALINK,
    //     'query_var'             => true,
    //     'can_export'            => true,
    //     'delete_with_user'      => null,
    //     'show_in_rest'          => false,
    //     'rest_base'             => $post_type,
    //     // 'rest_controller_class' => WP_REST_Posts_Controller,
    //     '_builtin'              => false
    // );

    $args = array(
        'labels'             => $labels, // tableau des libellés pour la gestion du TPP
        'description'        => __('All Exhibitions', 'e1795854-tp2'),
        'public'             => true,
        'hierarchical'       => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'menu_position'      => null,
        'capability_type'    => 'post',
        'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields'),
        'taxonomies'         => array('theme', 'artist', 'place'),
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'exhibition'),
        'query_var'          => true
    );

    register_post_type( 'e1795854_exhibition', $args ); // Ne pas mettre de -, ni un nom trop long (max 20 caractères)
    // https://wordpress.stackexchange.com/questions/82227/register-post-type-name-character-limit
}


/**
 * Création de la taxonomie
 *
 * @param void
 * @return void
 */
function e1795854_TP2_register_private_taxonomy()
{

    $labels = array(
        'name'              =>  __('Themes', 'e1795854-tp2'),
        'singular_name'     =>  __('Theme', 'e1795854-tp2')
    );

    $args = array(
            'hierarchical'  => true,
            'labels'        => $labels,
            'public'        => true,
            'rewrite'       => true
    );

    register_taxonomy( 'e1795854_theme', 'e1795854_exhibition', $args);



    $labels = array(
        'name'              =>  __('Artists', 'e1795854-tp2'),
        'singular_name'     =>  __('Artist', 'e1795854-tp2')
    );

    $args = array(
            'hierarchical'  => true,
            'labels'        => $labels,
            'public'        => true,
            'rewrite'       => true
    );

    register_taxonomy( 'e1795854_artist', 'e1795854_exhibition', $args);



    $labels = array(
        'name'              =>  __( 'Places', 'e1795854-tp2' ),
        'singular_name'     =>  __( 'Place', 'e1795854-tp2' )
    );

    $args = array(
            'hierarchical'  => true,
            'labels'        => $labels,
            'public'        => true,
            'rewrite'       => true
    );

    register_taxonomy( 'e1795854_place', 'e1795854_exhibition', $args );
}

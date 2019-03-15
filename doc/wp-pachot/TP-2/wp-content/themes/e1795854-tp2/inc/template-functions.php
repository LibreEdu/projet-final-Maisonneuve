<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package e1795854_TP2
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function e1795854_tp2_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'e1795854_tp2_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function e1795854_tp2_pingback_header() {
    if ( is_singular() && pings_open() ) {
        echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
    }
}
add_action( 'wp_head', 'e1795854_tp2_pingback_header' );

/**
 * e1795854 Modifie la requête principale pour les pages de liste du TPP e1795854_exhibition
 * en fixant la pagination à 8 items par page
 * et en triant sur la métadonnée 'date publication'
 */
function e1795854_tp2_pre_get_posts($wp_query) {

    if (!is_admin() && $wp_query->is_main_query()) {

        $query = $wp_query->query;
        // echo "<pre> ".print_r($query, true)."</pre>";

        if (!empty($query['e1795854_theme']) || !empty($query['e1795854_artist'])
            || (!empty($query['post_type']) && $query['post_type'] === 'e1795854_exhibition')) {

            $wp_query->set('posts_per_page', '9');
            $wp_query->set('orderby', 'post_date');
            $wp_query->set('order','DESC');
        }
    }
    return $wp_query;
}
add_filter('pre_get_posts', 'e1795854_tp2_pre_get_posts' );

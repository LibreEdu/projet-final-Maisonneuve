<?php
/**
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
/**************** COCKTAIL REGISTER WIDGETS ***************************************/
add_action('widgets_init', 'cocktail_widgets_init');
function cocktail_widgets_init() {

	register_sidebar(array(
			'name' => __('Main Sidebar', 'cocktail'),
			'id' => 'cocktail_main_sidebar',
			'description' => __('Shows widgets at Main Sidebar.', 'cocktail'),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('Top Header Info', 'cocktail'),
			'id' => 'cocktail_header_info',
			'description' => __('Shows widgets on all page.', 'cocktail'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Side Menu', 'cocktail'),
			'id' => 'cocktail_side_menu',
			'description' => __('Shows widgets on all page.', 'cocktail'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Slider Section', 'cocktail'),
			'id' => 'slider_section',
			'description' => __('Use any Slider Plugins and drag that slider widgets to this Slider Section', 'cocktail'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Contact Page Sidebar', 'cocktail'),
			'id' => 'cocktail_contact_page_sidebar',
			'description' => __('Shows widgets on Contact Page Template.', 'cocktail'),
			'before_widget' => '<aside id="%1$s" class="widget widget_contact">',
			'after_widget' => '</aside>',
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		));
	register_sidebar(array(
			'name' => __('Iframe Code For Google Maps', 'cocktail'),
			'id' => 'cocktail_form_for_contact_page',
			'description' => __('Add Iframe Code using text widgets', 'cocktail'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_sidebar(array(
			'name' => __('WooCommerce Sidebar', 'cocktail'),
			'id' => 'cocktail_woocommerce_sidebar',
			'description' => __('Add WooCommerce Widgets Only', 'cocktail'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		));
	register_widget( 'Cocktail_popular_Widgets' );
}
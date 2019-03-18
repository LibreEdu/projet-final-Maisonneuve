<?php
/**
 * The template for displaying navigation.
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
$cocktail_settings = cocktail_get_theme_options();
	if ( function_exists('wp_pagenavi' ) ) :
		wp_pagenavi();
	else: 
	// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => '<i class="fa fa-angle-double-left"></i><span class="screen-reader-text">' . __( 'Previous page', 'cocktail' ).'</span>',
			'next_text'          => '<i class="fa fa-angle-double-right"></i><span class="screen-reader-text">' . __( 'Next page', 'cocktail' ).'</span>',
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'cocktail' ) . ' </span>',
		) );
	endif;
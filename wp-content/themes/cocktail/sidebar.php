<?php
/**
 * The sidebar containing the main Sidebar area.
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
	$cocktail_settings = cocktail_get_theme_options();
	if( $post ) {
		$layout = get_post_meta( get_queried_object_id(), 'cocktail_sidebarlayout', true );
	}
	if( empty( $layout ) || is_archive() || is_search() || is_home() ) {
		$layout = 'default';
	}

if( 'default' == $layout ) { //Settings from customizer
	if(($cocktail_settings['cocktail_sidebar_layout_options'] != 'nosidebar') && ($cocktail_settings['cocktail_sidebar_layout_options'] != 'fullwidth')){ ?>

<aside id="secondary" class="widget-area">
<?php }
}else{ // for page/ post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){ ?>
<aside id="secondary" class="widget-area">
  <?php }
	}?>
  <?php 
	if( 'default' == $layout ) { //Settings from customizer
		if(($cocktail_settings['cocktail_sidebar_layout_options'] != 'nosidebar') && ($cocktail_settings['cocktail_sidebar_layout_options'] != 'fullwidth')): ?>
  <?php dynamic_sidebar( 'cocktail_main_sidebar' ); ?>
</aside><!-- end #secondary -->
<?php endif;
	}else{ // for page/post
		if(($layout != 'no-sidebar') && ($layout != 'full-width')){
			dynamic_sidebar( 'cocktail_main_sidebar' );
			echo '</aside><!-- end #secondary -->';
		}
	}
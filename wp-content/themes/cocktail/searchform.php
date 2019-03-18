<?php
/**
 * Displays the searchform
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
?>
<form class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
	<?php
		$cocktail_settings = cocktail_get_theme_options();
		$cocktail_search_form = $cocktail_settings['cocktail_search_text'];?>
		<input type="search" name="s" class="search-field" placeholder="<?php echo esc_attr($cocktail_search_form); ?>" autocomplete="off" />
		<button type="submit" class="search-submit"><i class="fa fa-search"></i></button>
</form> <!-- end .search-form -->
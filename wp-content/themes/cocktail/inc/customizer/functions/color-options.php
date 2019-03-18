<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
/********************* Color Option **********************************************/

	$wp_customize->add_section( 'colors', array(
		'title' 						=> __('Background Color Options','cocktail'),
		'priority'					=> 100,
		'panel'					=>'colors'
	));
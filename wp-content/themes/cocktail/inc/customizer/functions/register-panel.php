<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */

	/******************** COCKTAIL CUSTOMIZE REGISTER *********************************************/
	add_action( 'customize_register', 'cocktail_customize_register_wordpress_default' );
	function cocktail_customize_register_wordpress_default( $wp_customize ) {
		$wp_customize->add_panel( 'cocktail_wordpress_default_panel', array(
			'priority' => 5,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'WordPress Settings', 'cocktail' ),
		) );
	}

	add_action( 'customize_register', 'cocktail_customize_register_options');
	function cocktail_customize_register_options( $wp_customize ) {
		$wp_customize->add_panel( 'cocktail_options_panel', array(
			'priority' => 6,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Theme Options', 'cocktail' ),
		) );
	}

	add_action( 'customize_register', 'cocktail_customize_register_colors' );
	function cocktail_customize_register_colors( $wp_customize ) {
		$wp_customize->add_panel( 'colors', array(
			'priority' => 9,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Colors Section', 'cocktail' ),
		) );
	}

	add_action( 'customize_register', 'cocktail_customize_register_frontpage_features' );
	function cocktail_customize_register_frontpage_features( $wp_customize ) {
		$wp_customize->add_panel( 'cocktail_frontpage_features_panel', array(
			'priority' => 8,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Frontpage Features', 'cocktail' ),
		) );
	}

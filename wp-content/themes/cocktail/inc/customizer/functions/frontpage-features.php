<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
$cocktail_settings = cocktail_get_theme_options();
$cocktail_categories_lists = cocktail_categories_lists();
$wp_customize->add_section( 'cocktail_frontpage_features', array(
	'title' => __('Frontpage Features','cocktail'),
	'priority' => 10,
	'panel' =>'cocktail_frontpage_features_panel'
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_disable_frontpage_features]', array(
	'default' => $cocktail_settings['cocktail_disable_frontpage_features'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_disable_frontpage_features]', array(
	'priority'=>10,
	'label' => __('Disable Frontpage Features', 'cocktail'),
	'section' => 'cocktail_frontpage_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting(
	'cocktail_theme_options[cocktail_frontpage_features]', array(
		'default'				=>$cocktail_settings['cocktail_frontpage_features'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'cocktail_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_frontpage_features]',
		array(
			'priority' => 50,
			'label'       => __( 'Front Page Features', 'cocktail' ),
			'section'     => 'cocktail_frontpage_features',
			'settings'	  => 'cocktail_theme_options[cocktail_frontpage_features]',
			'type'        => 'select',
			'choices'	=>  $cocktail_categories_lists 
		)
);


/*************** Footer Frontpage Posts ************************/

$wp_customize->add_section( 'cocktail_footer_frontpage_features', array(
	'title' => __('Frontpage Footer Posts','cocktail'),
	'priority' => 30,
	'panel' =>'cocktail_frontpage_features_panel'
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_disable_frontpage_footer_posts]', array(
	'default' => $cocktail_settings['cocktail_disable_frontpage_footer_posts'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_disable_frontpage_footer_posts]', array(
	'priority'=>10,
	'label' => __('Disable Frontpage Footer Posts', 'cocktail'),
	'section' => 'cocktail_footer_frontpage_features',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_footer_posts_title]', array(
	'default'           => $cocktail_settings['cocktail_footer_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_footer_posts_title]', array(
	'label' => __('Title','cocktail'),
	'section' => 'cocktail_footer_frontpage_features',
	'type'     => 'text',
	'priority'	=> 20,
	)
);

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_footer_posts_description]', array(
	'default'           => $cocktail_settings['cocktail_footer_posts_description'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_footer_posts_description]', array(
	'label' => __('Description','cocktail'),
	'section' => 'cocktail_footer_frontpage_features',
	'type'     => 'text',
	'priority'	=> 30,
	)
);

$wp_customize->add_setting(
	'cocktail_theme_options[cocktail_frontpage_footer_posts]', array(
		'default'				=>$cocktail_settings['cocktail_frontpage_footer_posts'],
		'capability'			=> 'manage_options',
		'sanitize_callback'	=> 'cocktail_sanitize_category_select',
		'type'				=> 'option'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_frontpage_footer_posts]',
		array(
			'priority' => 50,
			'label'       => __( 'Front Page Footer Posts', 'cocktail' ),
			'section'     => 'cocktail_footer_frontpage_features',
			'settings'	  => 'cocktail_theme_options[cocktail_frontpage_footer_posts]',
			'type'        => 'select',
			'choices'	=>  $cocktail_categories_lists 
		)
);
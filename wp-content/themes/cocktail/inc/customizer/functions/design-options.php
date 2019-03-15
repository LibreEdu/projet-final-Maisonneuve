<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
$cocktail_settings = cocktail_get_theme_options();

$wp_customize->add_section('cocktail_layout_options', array(
	'title' => __('Layout Options', 'cocktail'),
	'priority' => 102,
	'panel' => 'cocktail_options_panel'
));

$wp_customize->add_setting('cocktail_theme_options[cocktail_responsive]', array(
	'default' => $cocktail_settings['cocktail_responsive'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_responsive]', array(
	'priority' =>20,
	'label' => __('Responsive Layout', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'select',
	'checked' => 'checked',
	'choices' => array(
		'on' => __('ON ','cocktail'),
		'off' => __('OFF','cocktail'),
	),
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_entry_meta_single]', array(
	'default' => $cocktail_settings['cocktail_entry_meta_single'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_entry_meta_single]', array(
	'priority'=>40,
	'label' => __('Disable Entry Meta from Single Page', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'select',
	'choices' => array(
		'show' => __('Display Entry Format','cocktail'),
		'hide' => __('Hide Entry Format','cocktail'),
	),
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_entry_meta_blog]', array(
	'default' => $cocktail_settings['cocktail_entry_meta_blog'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_entry_meta_blog]', array(
	'priority'=>50,
	'label' => __('Disable Entry Meta from Blog', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type'	=> 'select',
	'choices' => array(
		'show-meta' => __('Display Entry Meta','cocktail'),
		'hide-meta' => __('Hide Entry Meta','cocktail'),
	),
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_post_category]', array(
	'default' => $cocktail_settings['cocktail_post_category'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_post_category]', array(
	'priority'=>55,
	'label' => __('Disable Category', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_post_author]', array(
	'default' => $cocktail_settings['cocktail_post_author'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_post_author]', array(
	'priority'=>60,
	'label' => __('Disable Author', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_post_date]', array(
	'default' => $cocktail_settings['cocktail_post_date'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_post_date]', array(
	'priority'=>65,
	'label' => __('Disable Date', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_post_comments]', array(
	'default' => $cocktail_settings['cocktail_post_comments'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_post_comments]', array(
	'priority'=>68,
	'label' => __('Disable Comments', 'cocktail'),
	'section' => 'cocktail_layout_options',
	'type' => 'checkbox',
));

$wp_customize->add_setting('cocktail_theme_options[cocktail_blog_content_layout]', array(
   'default'        => $cocktail_settings['cocktail_blog_content_layout'],
   'sanitize_callback' => 'cocktail_sanitize_select',
   'type'                  => 'option',
   'capability'            => 'manage_options'
));
$wp_customize->add_control('cocktail_theme_options[cocktail_blog_content_layout]', array(
   'priority'  =>75,
   'label'      => __('Blog Content Display', 'cocktail'),
   'section'    => 'cocktail_layout_options',
   'type'       => 'select',
   'checked'   => 'checked',
   'choices'    => array(
       'fullcontent_display' => __('Blog Full Content Display','cocktail'),
       'excerptblog_display' => __(' Excerpt  Display','cocktail'),
   ),
));

$wp_customize->add_setting('cocktail_theme_options[cocktail_design_layout]', array(
	'default'        => $cocktail_settings['cocktail_design_layout'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type'                  => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_design_layout]', array(
	'priority'  =>80,
	'label'      => __('Design Layout', 'cocktail'),
	'section'    => 'cocktail_layout_options',
	'type'       => 'select',
	'checked'   => 'checked',
	'choices'    => array(
		'full-width-layout' => __('Full Width Layout','cocktail'),
		'boxed-layout' => __('Boxed Layout','cocktail'),
		'small-boxed-layout' => __('Small Boxed Layout','cocktail'),
	),
));
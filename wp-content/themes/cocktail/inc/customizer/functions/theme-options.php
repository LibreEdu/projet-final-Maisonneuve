<?php
/**
 * Theme Customizer Functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
$cocktail_settings = cocktail_get_theme_options();
/********************** COCKTAIL WORDPRESS DEFAULT PANEL ***********************************/
$wp_customize->add_section('header_image', array(
'title' => __('Header Media', 'cocktail'),
'priority' => 20,
'panel' => 'cocktail_wordpress_default_panel'
));
$wp_customize->add_section('colors', array(
'title' => __('Colors', 'cocktail'),
'priority' => 30,
'panel' => 'cocktail_wordpress_default_panel'
));
$wp_customize->add_section('background_image', array(
'title' => __('Background Image', 'cocktail'),
'priority' => 40,
'panel' => 'cocktail_wordpress_default_panel'
));
$wp_customize->add_section('nav', array(
'title' => __('Navigation', 'cocktail'),
'priority' => 50,
'panel' => 'cocktail_wordpress_default_panel'
));
$wp_customize->add_section('static_front_page', array(
'title' => __('Static Front Page', 'cocktail'),
'priority' => 60,
'panel' => 'cocktail_wordpress_default_panel'
));
$wp_customize->add_section('title_tagline', array(
	'title' => __('Site Title & Logo Options', 'cocktail'),
	'priority' => 10,
	'panel' => 'cocktail_wordpress_default_panel'
));

$wp_customize->add_section('cocktail_custom_header', array(
	'title' => __('Options', 'cocktail'),
	'priority' => 503,
	'panel' => 'cocktail_options_panel'
));

$wp_customize->add_section('cocktail_footer_image', array(
	'title' => __('Footer Background Image', 'cocktail'),
	'priority' => 510,
	'panel' => 'cocktail_options_panel'
));

/********************  COCKTAIL THEME OPTIONS ******************************************/

$wp_customize->add_setting('cocktail_theme_options[cocktail_header_display]', array(
	'capability' => 'edit_theme_options',
	'default' => $cocktail_settings['cocktail_header_display'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_header_display]', array(
	'label' => __('Site Logo/ Text Options', 'cocktail'),
	'priority' => 105,
	'section' => 'title_tagline',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'header_text' => __('Display Site Title Only','cocktail'),
		'header_logo' => __('Display Site Logo Only','cocktail'),
		'show_both' => __('Show Both','cocktail'),
		'disable_both' => __('Disable Both','cocktail'),
	),
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_logo_high_resolution]', array(
	'default' => $cocktail_settings['cocktail_logo_high_resolution'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_logo_high_resolution]', array(
	'priority'=>110,
	'label' => __('Center Logo for high resolution screen(Use 2X size image)', 'cocktail'),
	'section' => 'title_tagline',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_search_custom_header]', array(
	'default' => $cocktail_settings['cocktail_search_custom_header'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_search_custom_header]', array(
	'priority'=>20,
	'label' => __('Disable Search Form', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_side_menu]', array(
	'default' => $cocktail_settings['cocktail_side_menu'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_side_menu]', array(
	'priority'=>25,
	'label' => __('Disable Side Menu', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_stick_menu]', array(
	'default' => $cocktail_settings['cocktail_stick_menu'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_stick_menu]', array(
	'priority'=>30,
	'label' => __('Disable Stick Menu', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_scroll]', array(
	'default' => $cocktail_settings['cocktail_scroll'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_scroll]', array(
	'priority'=>40,
	'label' => __('Disable Goto Top', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_top_social_icons]', array(
	'default' => $cocktail_settings['cocktail_top_social_icons'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_top_social_icons]', array(
	'priority'=>50,
	'label' => __('Disable Header Social Icons', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_side_menu_social_icons]', array(
	'default' => $cocktail_settings['cocktail_side_menu_social_icons'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_side_menu_social_icons]', array(
	'priority'=>60,
	'label' => __('Disable Side Menu Social Icons', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_buttom_social_icons]', array(
	'default' => $cocktail_settings['cocktail_buttom_social_icons'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_buttom_social_icons]', array(
	'priority'=>70,
	'label' => __('Disable Bottom Social Icons', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_display_page_single_featured_image]', array(
	'default' => $cocktail_settings['cocktail_display_page_single_featured_image'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_display_page_single_featured_image]', array(
	'priority'=>100,
	'label' => __('Disable Page/Single Featured Image', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_disable_main_menu]', array(
	'default' => $cocktail_settings['cocktail_disable_main_menu'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_disable_main_menu]', array(
	'priority'=>120,
	'label' => __('Disable Main Menu', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_instagram_feed_display]', array(
	'default' => $cocktail_settings['cocktail_instagram_feed_display'],
	'sanitize_callback' => 'cocktail_checkbox_integer',
	'type' => 'option',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_instagram_feed_display]', array(
	'priority'=>49,
	'label' => __('Disable Instagram', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_reset_all]', array(
	'default' => $cocktail_settings['cocktail_reset_all'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'cocktail_reset_alls',
	'transport' => 'postMessage',
));
$wp_customize->add_control( 'cocktail_theme_options[cocktail_reset_all]', array(
	'priority'=>150,
	'label' => __('Reset all default settings. (Refresh it to view the effect)', 'cocktail'),
	'section' => 'cocktail_custom_header',
	'type' => 'checkbox',
));

/********************** Footer Background Image ***********************************/
$wp_customize->add_setting( 'cocktail_theme_options[cocktail_img-upload-footer-image]',array(
	'default'	=> $cocktail_settings['cocktail_img-upload-footer-image'],
	'capability' => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	'type' => 'option',
));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cocktail_theme_options[cocktail_img-upload-footer-image]', array(
	'label' => __('Footer Background Image','cocktail'),
	'description' => __('Image will be displayed on footer','cocktail'),
	'priority'	=> 50,
	'section' => 'cocktail_footer_image',
	)
));

/********************** Header Image ***********************************/

$wp_customize->add_setting('cocktail_theme_options[cocktail_enable_header_image]', array(
	'capability' => 'edit_theme_options',
	'default' => $cocktail_settings['cocktail_enable_header_image'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_enable_header_image]', array(
	'label' => __('Display Header Image/ Slider Sidebar Widget Section', 'cocktail'),
	'priority' => 40,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'frontpage' => __('Front Page','cocktail'),
		'enitresite' => __('Entire Site','cocktail'),
		'off' => __('Disable','cocktail'),
	),
));

$wp_customize->add_setting( 'cocktail_theme_options[cocktail_header_image_title]', array(
	'default'           => $cocktail_settings['cocktail_header_image_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_header_image_title]', array(
	'label' => __('Title','cocktail'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 50,
	)
);
$wp_customize->add_setting( 'cocktail_theme_options[cocktail_header_image_link]', array(
	'default'           => $cocktail_settings['cocktail_header_image_link'],
	'sanitize_callback' => 'esc_url_raw',
	'type'                  => 'option',
	'capability'            => 'manage_options'
	)
);
$wp_customize->add_control( 'cocktail_theme_options[cocktail_header_image_link]', array(
	'label' => __('Link','cocktail'),
	'section' => 'header_image',
	'type'     => 'text',
	'priority'	=> 60,
	)
);

$wp_customize->add_setting('cocktail_theme_options[cocktail_header_image_layout]', array(
	'capability' => 'edit_theme_options',
	'default' => $cocktail_settings['cocktail_header_image_layout'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_header_image_layout]', array(
	'label' => __('Display Header Image Layout', 'cocktail'),
	'priority' => 70,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'default' => __('Default/ Fullwidth','cocktail'),
		'header-image-small' => __(' Header Image Small','cocktail'),
	),
));

$wp_customize->add_setting('cocktail_theme_options[cocktail_header_image_bg_text_color]', array(
	'capability' => 'edit_theme_options',
	'default' => $cocktail_settings['cocktail_header_image_bg_text_color'],
	'sanitize_callback' => 'cocktail_sanitize_select',
	'type' => 'option',
));
$wp_customize->add_control('cocktail_theme_options[cocktail_header_image_bg_text_color]', array(
	'label' => __('Header Image With background Text color', 'cocktail'),
	'priority' => 80,
	'section' => 'header_image',
	'type' => 'select',
	'checked' => 'checked',
		'choices' => array(
		'default' => __('Off','cocktail'),
		'bg-text-color' => __('On','cocktail'),
	),
));
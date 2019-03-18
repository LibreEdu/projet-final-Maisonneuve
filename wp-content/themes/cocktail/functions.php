<?php
/**
 * Display all cocktail functions and definitions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */

/************************************************************************************************/
if ( ! function_exists( 'cocktail_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cocktail_setup() {
	/**
	 * Set the content width based on the theme's design and stylesheet.
	 */
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width=1170;
	}

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support('post-thumbnails');

	/*
	 * Let WordPress manage the document title.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => __( 'Main Menu', 'cocktail' ),
		'side-nav-menu' => __( 'Side Menu', 'cocktail' ),
		'social-link'  => __( 'Add Social Icons Only', 'cocktail' ),
	) );

	/* 
	* Enable support for custom logo. 
	*
	*/ 
	add_theme_support( 'custom-logo', array(
		'flex-width' => true, 
		'flex-height' => true,
	) );

	add_theme_support( 'gutenberg', array(
			'colors' => array(
				'#617958',
			),
		) );
	add_theme_support( 'align-wide' );

	//Indicate widget sidebars can use selective refresh in the Customizer. 
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	add_image_size( 'cocktail-popular-post', 75, 75, true );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cocktail_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	add_editor_style( array( 'css/editor-style.css') );

/**
 * Load WooCommerce compatibility files.
 */
	
require get_template_directory() . '/woocommerce/functions.php';


}
endif; // cocktail_setup
add_action( 'after_setup_theme', 'cocktail_setup' );

/***************************************************************************************/
function cocktail_content_width() {
	if ( is_page_template( 'page-templates/gallery-template.php' ) || is_attachment() ) {
		global $content_width;
		$content_width = 1920;
	}
}
add_action( 'template_redirect', 'cocktail_content_width' );

/***************************************************************************************/
if(!function_exists('cocktail_get_theme_options')):
	function cocktail_get_theme_options() {
	    return wp_parse_args(  get_option( 'cocktail_theme_options', array() ), cocktail_get_option_defaults_values() );
	}
endif;

/***************************************************************************************/
require get_template_directory() . '/inc/customizer/cocktail-default-values.php';
require get_template_directory() . '/inc/settings/cocktail-functions.php';
require get_template_directory() . '/inc/settings/cocktail-common-functions.php';
require get_template_directory() . '/page-templates/frontpage-features.php';

/************************ Cocktail Sidebar/ Widgets  *****************************/
require get_template_directory() . '/inc/widgets/widgets-functions/register-widgets.php';
require get_template_directory() . '/inc/widgets/widgets-functions/popular-posts.php';

/************************ Cocktail Customizer  *****************************/
require get_template_directory() . '/inc/customizer/functions/sanitize-functions.php';
require get_template_directory() . '/inc/customizer/functions/register-panel.php';

function cocktail_customize_register( $wp_customize ) {
		if(!class_exists('Cocktail_Plus_Features')  && !class_exists('Mocktail_Customize_upgrade') && !class_exists('Cappuccino_Customize_upgrade') )  {
		class Cocktail_Customize_upgrade extends WP_Customize_Control {
			public function render_content() { ?>
				<a title="<?php esc_attr_e( 'Review Us', 'cocktail' ); ?>" href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/cocktail/' ); ?>" target="_blank" id="about_cocktail">
				<?php esc_html_e( 'Review Us', 'cocktail' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://themefreesia.com/theme-instruction/cocktail/' ); ?>" title="<?php esc_attr_e( 'Theme Instructions', 'cocktail' ); ?>" target="_blank" id="about_cocktail">
				<?php esc_html_e( 'Theme Instructions', 'cocktail' ); ?>
				</a><br/>
				<a href="<?php echo esc_url( 'https://tickets.themefreesia.com/' ); ?>" title="<?php esc_attr_e( 'Support Tickets', 'cocktail' ); ?>" target="_blank" id="about_cocktail">
				<?php esc_html_e( 'Forum', 'cocktail' ); ?>
				</a><br/>
			<?php
			}
		}
		$wp_customize->add_section('cocktail_upgrade_links', array(
			'title'					=> __('Important Links', 'cocktail'),
			'priority'				=> 1000,
		));
		$wp_customize->add_setting( 'cocktail_upgrade_links', array(
			'default'				=> false,
			'capability'			=> 'edit_theme_options',
			'sanitize_callback'	=> 'wp_filter_nohtml_kses',
		));
		$wp_customize->add_control(
			new Cocktail_Customize_upgrade(
			$wp_customize,
			'cocktail_upgrade_links',
				array(
					'section'				=> 'cocktail_upgrade_links',
					'settings'				=> 'cocktail_upgrade_links',
				)
			)
		);
	}	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'cocktail_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'cocktail_customize_partial_blogdescription',
		) );
	}
	
	require get_template_directory() . '/inc/customizer/functions/design-options.php';
	require get_template_directory() . '/inc/customizer/functions/theme-options.php';
	require get_template_directory() . '/inc/customizer/functions/color-options.php' ;
	require get_template_directory() . '/inc/customizer/functions/frontpage-features.php' ;
}
if(!class_exists('Cocktail_Plus_Features')){

	if(!function_exists('mocktail_customize_register') && !function_exists('cappuccino_customize_register') ){

		// Add Upgrade to Plus Button.
		require_once( trailingslashit( get_template_directory() ) . 'inc/upgrade-plus/class-customize.php' );

		/**
		 * TGM plugin Activation
		 */
		require_once( trailingslashit( get_template_directory() ) . '/inc/tgm/tgm.php' );
	}

}

/** 
* Render the site title for the selective refresh partial. 
* @see cocktail_customize_register() 
* @return void 
*/ 
function cocktail_customize_partial_blogname() { 
bloginfo( 'name' ); 
} 

/** 
* Render the site tagline for the selective refresh partial. 
* @see cocktail_customize_register() 
* @return void 
*/ 
function cocktail_customize_partial_blogdescription() { 
bloginfo( 'description' ); 
}
add_action( 'customize_register', 'cocktail_customize_register' );
/******************* Cocktail Header Display *************************/
function cocktail_header_display(){
	$cocktail_settings = cocktail_get_theme_options();
	$header_display = $cocktail_settings['cocktail_header_display'];
$cocktail_header_display = $cocktail_settings['cocktail_header_display'];
if ($cocktail_header_display == 'header_logo' || $cocktail_header_display == 'header_text' || $cocktail_header_display == 'show_both' || is_active_sidebar( 'cocktail_header_banner' )) {

		if ($header_display == 'header_logo' || $header_display == 'header_text' || $header_display == 'show_both')	{
			echo '<div id="site-branding" class="site-branding">';
			if($header_display != 'header_text'){
				cocktail_the_custom_logo();
			}
			echo '<div id="site-detail">';
				if (is_home() || is_front_page()){ ?>
				<h1 id="site-title"> <?php }else{?> <h2 id="site-title"> <?php } ?>
				<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_html(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				<?php if(is_home() || is_front_page()){ ?>
				</h1>  <!-- end .site-title -->
				<?php } else { ?> </h2> <!-- end .site-title --> <?php }

				$site_description = get_bloginfo( 'description', 'display' );
				if ($site_description){?>
					<div id="site-description"> <?php bloginfo('description');?> </div> <!-- end #site-description -->
			
		<?php }
		echo '</div></div>'; // end #site-branding
		}
			if( is_active_sidebar( 'cocktail_header_banner' )){ ?>
				<div class="advertisement-box">
					<?php dynamic_sidebar( 'cocktail_header_banner' ); ?>
				</div> <!-- end .advertisement-box -->
			<?php } 
		}
}
/************** Site Branding *************************************/
add_action('cocktail_site_branding','cocktail_header_display');

if ( ! function_exists( 'cocktail_the_custom_logo' ) ) : 
 	/** 
 	 * Displays the optional custom logo. 
 	 * Does nothing if the custom logo is not available. 
 	 */ 
 	function cocktail_the_custom_logo() { 
		if ( function_exists( 'the_custom_logo' ) ) { 
			the_custom_logo(); 
		}
 	} 
endif;

/************** Site Branding for sticky header and side menu sidebar *************************************/
add_action('cocktail_new_site_branding','cocktail_stite_branding_for_stickyheader_sidesidebar');

	function cocktail_stite_branding_for_stickyheader_sidesidebar(){ 
		$cocktail_settings = cocktail_get_theme_options(); ?>
		<div id="site-branding" class="site-branding">
			<?php	
			$cocktail_header_display = $cocktail_settings['cocktail_header_display'];
			if ($cocktail_header_display == 'header_logo' || $cocktail_header_display == 'show_both') {
				cocktail_the_custom_logo(); 
			}

			if ($cocktail_header_display == 'header_text' || $cocktail_header_display == 'show_both') { ?>
			<div id="site-detail">
				<div id="site-title">
					<a href="<?php echo esc_url(home_url('/'));?>" title="<?php echo esc_attr(get_bloginfo('name', 'display'));?>" rel="home"> <?php bloginfo('name');?> </a>
				</div>
				<!-- end #site-title -->
				<div id="site-description"><?php bloginfo('description');?></div> <!-- end #site-description -->
			</div><!-- end #site-detail -->
			<?php } ?>
		</div> <!-- end #site-branding -->
	<?php }
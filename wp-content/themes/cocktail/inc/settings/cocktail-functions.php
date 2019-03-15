<?php
/**
 * Custom functions
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
/********************* Set Default Value if not set ***********************************/
	if ( !get_theme_mod('cocktail_theme_options') ) {
		set_theme_mod( 'cocktail_theme_options', cocktail_get_option_defaults_values() );
	}
/********************* COCKTAIL RESPONSIVE AND CUSTOM CSS OPTIONS ***********************************/
function cocktail_responsiveness() {
	$cocktail_settings = cocktail_get_theme_options();
	if( $cocktail_settings['cocktail_responsive'] == 'on' ) { ?>
	<meta name="viewport" content="width=device-width" />
	<?php } else { ?>
	<meta name="viewport" content="width=1170" />
	<?php  }
}
add_filter( 'wp_head', 'cocktail_responsiveness');

/******************************** EXCERPT LENGTH *********************************/
function cocktail_excerpt_length($cocktail_excerpt_length) {
	$cocktail_settings = cocktail_get_theme_options();
	if( is_admin() ){
		return absint($cocktail_excerpt_length);
	}

	$cocktail_excerpt_length = $cocktail_settings['cocktail_excerpt_length'];
	return absint($cocktail_excerpt_length);
}
add_filter('excerpt_length', 'cocktail_excerpt_length');

/********************* CONTINUE READING LINKS FOR EXCERPT *********************************/
function cocktail_continue_reading($more) {
	$link = sprintf(
			'<a href="%1$s" class="more-link">%2$s</a>',
			esc_url( get_permalink( get_the_ID() ) ),
			/* translators: %s: Name of current post */
			sprintf( __( '<span class="screen-reader-text"> "%s"</span>', 'cocktail' ), get_the_title( get_the_ID() ) )
		);
	if( is_admin() ){
		return $more;
	}

	return $link;
}
add_filter('excerpt_more', 'cocktail_continue_reading');

/***************** USED CLASS FOR BODY TAGS ******************************/
function cocktail_body_class($cocktail_class) {
	$cocktail_settings = cocktail_get_theme_options();
	$cocktail_site_layout = $cocktail_settings['cocktail_design_layout'];
	if ($cocktail_site_layout =='boxed-layout') {
		$cocktail_class[] = 'boxed-layout';
	}elseif ($cocktail_site_layout =='small-boxed-layout') {
		$cocktail_class[] = 'boxed-layout-small';
	}else{
		$cocktail_class[] = '';
	}

	if ( is_singular() && false !== strpos( get_queried_object()->post_content, '<!-- wp:' ) ) {
		$cocktail_class[] = 'gutenberg';
	}

	if(is_page_template('page-templates/contact-template.php')) {
		$cocktail_class[] = 'contact-template';
	}
	return $cocktail_class;
}
add_filter('body_class', 'cocktail_body_class');

/********************** SCRIPTS FOR DONATE/ UPGRADE BUTTON ******************************/
function cocktail_customize_scripts() {
	wp_enqueue_style( 'cocktail_customizer_custom', get_template_directory_uri() . '/inc/css/cocktail-customizer.css');
}
add_action( 'customize_controls_print_scripts', 'cocktail_customize_scripts');

/**************************** SOCIAL MENU *********************************************/
function cocktail_social_links_display() {
		if ( has_nav_menu( 'social-link' ) ) : ?>
	<div class="social-links clearfix">
	<?php
		wp_nav_menu( array(
			'container' 	=> '',
			'theme_location' => 'social-link',
			'depth'          => 1,
			'items_wrap'      => '<ul>%3$s</ul>',
			'link_before'    => '<span class="screen-reader-text">',
			'link_after'     => '</span>',
		) );
	?>
	</div><!-- end .social-links -->
	<?php endif; ?>
<?php }
add_action ('cocktail_social_links', 'cocktail_social_links_display');

/******************* DISPLAY BREADCRUMBS ******************************/
function cocktail_breadcrumb() {
	if (function_exists('bcn_display')) { ?>
		<div class="breadcrumb home">
			<?php bcn_display(); ?>
		</div> <!-- .breadcrumb -->
	<?php }
}
/*************************** ENQUEING STYLES AND SCRIPTS ****************************************/
function cocktail_scripts() {
	$cocktail_settings = cocktail_get_theme_options();
	$cocktail_stick_menu = $cocktail_settings['cocktail_stick_menu'];
	wp_enqueue_script('cocktail-main', get_template_directory_uri().'/js/cocktail-main.js', array('jquery'), false, true);
	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_style( 'cocktail-style', get_stylesheet_uri() );
	wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/font-awesome/css/font-awesome.min.css');

	if( $cocktail_stick_menu != 1 ):

		wp_enqueue_script('jquery-sticky', get_template_directory_uri().'/assets/sticky/jquery.sticky.min.js', array('jquery'), false, true);
		wp_enqueue_script('cocktail-sticky-settings', get_template_directory_uri().'/assets/sticky/sticky-settings.js', array('jquery'), false, true);

	endif;

	wp_enqueue_script('cocktail-navigation', get_template_directory_uri().'/js/navigation.js', array('jquery'), false, true);

	if( $cocktail_settings['cocktail_responsive'] == 'on' ) {
		wp_enqueue_style('cocktail-responsive', get_template_directory_uri().'/css/responsive.css');
	}
	/********* Adding Multiple Fonts ********************/
	$cocktail_googlefont = array();
	array_push( $cocktail_googlefont, 'Noto+Sans');
	array_push( $cocktail_googlefont, 'Lora');
	$cocktail_googlefonts = implode("|", $cocktail_googlefont);

	wp_register_style( 'cocktail-google-fonts', '//fonts.googleapis.com/css?family='.$cocktail_googlefonts .':400,400i,700');
	wp_enqueue_style( 'cocktail-google-fonts' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	/* Custom Css */
	$cocktail_internal_css='';

	if ($cocktail_settings['cocktail_logo_high_resolution'] !=0){
		$cocktail_internal_css .= '/* Center Logo for high resolution screen(Use 2X size image) */
		.custom-logo-link .custom-logo {
			height: 120px;
			width: auto;
		}

		@media only screen and (max-width: 767px) { 
			.custom-logo-link .custom-logo {
				height: auto;
				width: 60%;
			}
		}

		@media only screen and (max-width: 480px) { 
			.custom-logo-link .custom-logo {
				height: auto;
				width: 80%;
			}
		}';
	}

	if($cocktail_settings['cocktail_header_display']=='header_logo'){
		$cocktail_internal_css .= '
		#site-branding #site-title, #site-branding #site-description{
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
		#site-detail {
			padding: 0;
		}';
	}

	if($cocktail_settings['cocktail_header_image_bg_text_color']=='bg-text-color'){
		$cocktail_internal_css .= '/* Header Image With background Text color */
		.header-image-title {
			background-color: rgba(0,0,0,0.3);
			padding: 8px 26px;
			width: auto;
		}';
	}

	wp_add_inline_style( 'cocktail-style', wp_strip_all_tags($cocktail_internal_css) );
}
add_action( 'wp_enqueue_scripts', 'cocktail_scripts' );

/**************** Categoy Lists ***********************/

if( !function_exists( 'cocktail_categories_lists' ) ):
    function cocktail_categories_lists() {
        $cocktail_cat_args = array(
            'type'       => 'post',
            'taxonomy'   => 'category',
        );
        $cocktail_categories = get_categories( $cocktail_cat_args );
        $cocktail_categories_lists = array('' => esc_html__('--Select--','cocktail'));
        foreach( $cocktail_categories as $category ) {
            $cocktail_categories_lists[esc_attr( $category->slug )] = esc_html( $category->name );
        }
        return $cocktail_categories_lists;
    }
endif;

/**************** Tag list Lists ***********************/
if( !function_exists( 'cocktail_tag_lists' ) ):
	function cocktail_tag_lists() {
		$tags = get_tags();
		$cocktail_tag_list = array('' => esc_html__('--Select--','cocktail'));
		foreach ( (array) $tags as $tag ) {
			$cocktail_tag_list[esc_attr( $tag->slug )] = esc_html($tag->name);
		}

		return $cocktail_tag_list;
	}
endif;

/**************** Header banner display/ Widget slider ***********************/
function cocktail_header_image_widget_slider(){
	$cocktail_settings = cocktail_get_theme_options();
	$cocktail_header_image_layout = $cocktail_settings['cocktail_header_image_layout'];
	if ( get_header_image() ) : ?>
		<div class="custom-header <?php if($cocktail_header_image_layout=='header-image-small'){ echo 'header-image-small'; } ?>">
			<div class="custom-header-wrap">
				<img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr(get_custom_header()->width);?>" height="<?php echo esc_attr(get_custom_header()->height);?>" alt="<?php echo esc_attr(get_bloginfo('name', 'display'));?>">
					<?php if($cocktail_settings['cocktail_header_image_title'] !=''){ ?>
						<h2 class="header-image-title"><a title="<?php echo esc_attr($cocktail_settings['cocktail_header_image_title']);?>" href="<?php echo esc_url($cocktail_settings['cocktail_header_image_link']);?>"><?php echo esc_attr($cocktail_settings['cocktail_header_image_title']);?></a></h2>
						<?php } ?>
			</div>
		</div> <!-- end .custom-header -->
		<?php endif;
		if(is_active_sidebar( 'slider_section' )):
			dynamic_sidebar( 'slider_section' );
		endif;
}

add_action('cocktail_display_header_image_widget_slider','cocktail_header_image_widget_slider');

/**************** Categoy Lists ***********************/

if( !function_exists( 'cocktail_categories_lists' ) ):
	function cocktail_categories_lists() {
	$cocktail_cat_args = array(
		'type'       => 'post',
		'taxonomy'   => 'category',
	);
		$cocktail_categories = get_categories( $cocktail_cat_args );
		$cocktail_categories_lists = array();
		$cocktail_categories_lists = array('' => esc_html__('--Select--','cocktail'));
	foreach( $cocktail_categories as $category ) {
		$cocktail_categories_lists[esc_attr( $category->slug )] = esc_html( $category->name );
	}
		return $cocktail_categories_lists;
	}
endif;
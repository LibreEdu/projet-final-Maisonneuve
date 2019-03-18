<?php
if(!function_exists('cocktail_get_option_defaults_values')):
	/******************** COCKTAIL DEFAULT OPTION VALUES ******************************************/
	function cocktail_get_option_defaults_values() {
		global $cocktail_default_values;
		$cocktail_default_values = array(
			'cocktail_responsive'	=> 'on',
			'cocktail_design_layout' => 'full-width-layout',
			'cocktail_sidebar_layout_options' => 'right',
			'cocktail_search_custom_header' => 0,
			'cocktail_side_menu'	=> 0,
			'cocktail_img-upload-footer-image' => '',
			'cocktail_header_display'=> 'header_text',
			'cocktail_scroll'	=> 0,
			'cocktail_excerpt_length'	=> '25',
			'cocktail_reset_all' => 0,
			'cocktail_stick_menu'	=>0,
			'cocktail_logo_high_resolution'	=> 0,
			'cocktail_blog_post_image' => 'on',
			'cocktail_search_text' => esc_html__('Search &hellip;','cocktail'),
			'cocktail_entry_meta_single' => 'show',
			'cocktail_entry_meta_blog' => 'show-meta',
			'cocktail_blog_content_layout'	=> 'excerptblog_display',
			'cocktail_post_category' => 0,
			'cocktail_post_author' => 0,
			'cocktail_post_date' => 0,
			'cocktail_post_comments' => 0,
			'cocktail_footer_column_section'	=>'4',
			'cocktail_disable_main_menu' => 0,
			'cocktail_current_date'=>0,
			'cocktail_instagram_feed_display'=>0,
			'cocktail_display_page_single_featured_image'=>0,
			'cocktail_header_image_title'=>'',
			'cocktail_header_image_link'=>'',
			'cocktail_enable_header_image'=>'frontpage',
			'cocktail_frontpage_features' =>'',
			'cocktail_disable_frontpage_features'=>0,
			'cocktail_no_of_frontpage'=>'4',
			'cocktail_header_image_layout'=>'default',
			/*Frontpage footer posts */
			'cocktail_disable_frontpage_footer_posts'=>0,
			'cocktail_frontpage_footer_posts'=>'',
			'cocktail_no_of_frontpage_footer_posts'=>'2',
			'cocktail_footer_posts_title'=>'',
			'cocktail_footer_posts_description'=>'',
			'cocktail_header_image_bg_text_color'=>'default',

			/*Social Icons */
			'cocktail_top_social_icons' =>0,
			'cocktail_side_menu_social_icons' =>0,
			'cocktail_buttom_social_icons'	=>0,
			);
		return apply_filters( 'cocktail_get_option_defaults_values', $cocktail_default_values );
	}
endif;
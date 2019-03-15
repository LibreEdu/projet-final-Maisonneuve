<?php
/**
 * Template Name: Gallery Template
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */

function cocktail_frontpage_features(){ 
$cocktail_settings = cocktail_get_theme_options();
$cocktail_disable_frontpage_features = $cocktail_settings['cocktail_disable_frontpage_features'];
$cocktail_no_of_frontpage = $cocktail_settings['cocktail_no_of_frontpage'];
$query = new WP_Query(array(
			'posts_per_page' =>  intval($cocktail_settings['cocktail_no_of_frontpage']),
			'post_type'					=> 'post',
			'category_name' => esc_attr($cocktail_settings['cocktail_frontpage_features']),
	));
	if(($cocktail_disable_frontpage_features !=1) && ($cocktail_settings['cocktail_frontpage_features'] !='')){ ?>
	<div class="our-feature-box">
		<div class="wrap">
			<div class="inner-wrap">
				<div class="column clearfix">
					<?php while ($query->have_posts()):$query->the_post(); ?>
					<div class="four-column">
						<div class="feature-content-wrap clearfix">
							<?php if(has_post_thumbnail() ){ ?>
								<a class="feature-icon" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
							<?php } ?>
							<div class="feature-content">
								<h2 class="feature-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>	
							</div> <!-- end .feature-content -->
						</div> <!-- end .feature-content-wrap -->
					</div> <!-- end .four-column -->
					<?php endwhile;
					wp_reset_postdata(); ?>
				</div> <!-- end .column -->
			</div> <!-- end .inner-wrap -->
		</div> <!-- end .wrap -->
	</div> <!-- end .our-feature-box -->
	<?php } ?>

<?php }
add_action('cocktail_display_frontpage_features','cocktail_frontpage_features');

/*************** Footer Frontpage Posts ************************/

function cocktail_frontpage_footer_posts(){ 
$cocktail_settings = cocktail_get_theme_options();
$cocktail_disable_frontpage_footer_posts = $cocktail_settings['cocktail_disable_frontpage_footer_posts'];
$cocktail_no_of_frontpage_footer_posts = $cocktail_settings['cocktail_no_of_frontpage_footer_posts'];
$cocktail_footer_posts_title = $cocktail_settings['cocktail_footer_posts_title'];
$cocktail_footer_posts_description = $cocktail_settings['cocktail_footer_posts_description'];
$cocktail_post_author = $cocktail_settings['cocktail_post_author'];
$cocktail_post_date = $cocktail_settings['cocktail_post_date'];
$cocktail_post_comments = $cocktail_settings['cocktail_post_comments'];
$content_display = $cocktail_settings['cocktail_blog_content_layout'];

$query = new WP_Query(array(
			'posts_per_page' =>  intval($cocktail_settings['cocktail_no_of_frontpage_footer_posts']),
			'post_type'					=> 'post',
			'category_name' => esc_attr($cocktail_settings['cocktail_frontpage_footer_posts']),
	));
if(($cocktail_disable_frontpage_footer_posts !=1) && ($cocktail_settings['cocktail_frontpage_footer_posts'] !='')){ ?>
<div class="feature-post-box">
	<div class="wrap">
		<div class="inner-wrap">
			<div class="feature-post-header">
				<?php if($cocktail_footer_posts_title!=''){ ?>
				<h2 class="feature-post-box-title"><?php echo esc_html($cocktail_footer_posts_title); ?></h2>
				<?php }
				if($cocktail_footer_posts_description!=''){ ?>
				<span class="feature-post-box-sub-title"><?php echo esc_attr($cocktail_footer_posts_description); ?></span>
				<?php } ?>
			</div>
			<div class="column clearfix">
				<?php while ($query->have_posts()):$query->the_post(); ?>
				<div class="two-column">
					<div class="feature-post-wrap clearfix">
						<?php if(has_post_thumbnail() ){ ?>
							<a class="feature-post-img" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a>
						<?php } ?>
						<div class="feature-post-content">
							<header class="feature-post-entry-header">
								<h2 class="feature-post-title"><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
								<div class="entry-meta">
									<?php 
									if($cocktail_post_author !=1){
										echo '<span class="author vcard"><a href="'.esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )).'" title="'.the_title_attribute('echo=0').'"><i class="fa fa-user-o"></i> ' .esc_html(get_the_author()).'</a></span>';
									}
									if($cocktail_post_date !=1){
										printf( '<span class="posted-on"><a href="%1$s" title="%2$s"><i class="fa fa-calendar-o"></i> %3$s </a></span>',
														esc_url(get_the_permalink()),
														esc_attr( get_the_time(get_option( 'date_format' )) ),
														esc_attr( get_the_time(get_option( 'date_format' )) )
													);
									}
									if ( comments_open() && $cocktail_post_comments !=1) { ?>
											<span class="comments">
											<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'cocktail' ), __( '<i class="fa fa-comments-o"></i> 1 Comment', 'cocktail' ), __( '<i class="fa fa-comments-o"></i> % Comments', 'cocktail' ), '', __( 'Comments Off', 'cocktail' ) ); ?> </span>
									<?php } ?>
								</div> <!-- end .entry-meta -->
							</header> <!-- end .feature-post-entry-header -->
							<div class="feature-post-entry-content">
								<?php if($content_display == 'excerptblog_display'):
									the_excerpt();
								else:
									the_content();
								endif; ?>
							</div> <!-- end .feature-post-entry-content -->
						</div> <!-- end .feature-post-content -->
					</div> <!-- end .feature-post-wrap -->
				</div> <!-- end .two-column -->
				<?php endwhile;
				wp_reset_postdata(); ?>
			</div> <!-- end .column -->
		</div> <!-- end .inner-wrap -->
	</div> <!-- end .wrap -->
</div> <!-- end .feature-post-box -->
<?php }
}
add_action('cocktail_display_footer_frontpage_posts','cocktail_frontpage_footer_posts');
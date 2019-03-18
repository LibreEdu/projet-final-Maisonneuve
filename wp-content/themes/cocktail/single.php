<?php
/**
 * The template for displaying all single posts.
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
get_header();
$cocktail_settings = cocktail_get_theme_options();
$cocktail_display_page_single_featured_image = $cocktail_settings['cocktail_display_page_single_featured_image'];
$format = get_post_format();
$cocktail_entry_meta_single = $cocktail_settings['cocktail_entry_meta_single'];
$tag_list = get_the_tag_list();
$cocktail_post_category = $cocktail_settings['cocktail_post_category'];
$cocktail_post_author = $cocktail_settings['cocktail_post_author'];
$cocktail_post_date = $cocktail_settings['cocktail_post_date'];
$cocktail_post_comments = $cocktail_settings['cocktail_post_comments'];
while( have_posts() ) {
	the_post(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
				<?php if(has_post_thumbnail() && $cocktail_display_page_single_featured_image == 0 ){ ?>
					<div class="entry-thumb">
						<figure class="entry-thumb-content">
							<?php the_post_thumbnail(); ?>
						</figure>
					</div> <!-- end .entry-thumb -->
				<?php }
				 ?>
				 <header class="entry-header">
					<?php if($cocktail_entry_meta_single != 'hide' ){ ?>
						<div class="entry-meta">
							<?php if ( current_theme_supports( 'post-formats', $format ) ) { 
								printf( '<span class="entry-format"><a href="%1$s">%2$s</a></span>', esc_url( get_post_format_link( $format ) ), esc_attr(get_post_format_string( $format )) );
							}

							if($cocktail_post_category !=1){ ?>
								<span class="cat-links">
									<?php the_category(); ?>
								</span> <!-- end .cat-links -->
							<?php }

							if(!empty($tag_list)){ ?>
								<span class="tag-links">
									<?php echo get_the_tag_list(); ?>
								</span> <!-- end .tag-links -->
							<?php } ?>
						</div> <!-- end .entry-meta -->
					<?php } ?>
					<h2 class="entry-title"> <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> <?php the_title();?> </a> </h2> <!-- end.entry-title -->
					<?php if($cocktail_entry_meta_single != 'hide' ){ ?>
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
									<?php comments_popup_link( __( '<i class="fa fa-comment-o"></i> No Comments', 'cocktail' ), __( '<i class="fa fa-comment-o"></i> 1 Comment', 'cocktail' ), __( '<i class="fa fa-comment-o"></i> % Comments', 'cocktail' ), '', __( 'Comments Off', 'cocktail' ) ); ?> </span>
							<?php } ?>
						</div> <!-- end .entry-meta -->
					<?php } ?>
				</header><!-- end .entry-header -->
				<div class="entry-content">
					<?php the_content(); ?>			
				</div><!-- end .entry-content -->
				<?php wp_link_pages( array( 
					'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'cocktail' ),
					'after'             => '</div>',
					'link_before'       => '<span>',
					'link_after'        => '</span>',
					'pagelink'          => '%',
					'echo'              => 1
				) );

				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			 ?>
			</article><!-- end .post -->
			<?php
			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
							'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'cocktail' ),
						) );
			} elseif ( is_singular( 'post' ) ) {
			the_post_navigation( array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'cocktail' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'cocktail' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'cocktail' ) . '</span> ' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'cocktail' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
				} ?>
		</main><!-- end #main -->
	</div> <!-- end #primary -->
	<?php
	get_sidebar();
	?>
</div><!-- end .wrap -->
<?php }
get_footer();
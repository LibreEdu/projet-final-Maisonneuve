<?php
/**
 * The template for displaying content.
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */
$cocktail_settings = cocktail_get_theme_options(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class();?>>
		<?php
		$entry_format_meta_blog = $cocktail_settings['cocktail_entry_meta_blog'];
		$content_display = $cocktail_settings['cocktail_blog_content_layout'];
		$cocktail_blog_post_image = $cocktail_settings['cocktail_blog_post_image'];
		$tag_list = get_the_tag_list();
		$format = get_post_format();
		$cocktail_post_category = $cocktail_settings['cocktail_post_category'];
		$cocktail_post_author = $cocktail_settings['cocktail_post_author'];
		$cocktail_post_date = $cocktail_settings['cocktail_post_date'];
		$cocktail_post_comments = $cocktail_settings['cocktail_post_comments'];
		 ?>
		<?php if( has_post_thumbnail() && $cocktail_blog_post_image == 'on') { ?>
			<div class="post-image-content">
				<figure class="post-featured-image">
						<a title="<?php the_title_attribute(); ?>" href="<?php echo esc_url(get_permalink()); ?>" >
							<?php the_post_thumbnail(); ?>
						</a>
				</figure><!-- end.post-featured-image -->	
			</div><!-- end.post-image-content -->
		<?php } ?>
		<header class="entry-header">
			<?php if($entry_format_meta_blog != 'hide-meta' ){ ?>
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
			<?php if($entry_format_meta_blog != 'hide-meta' ){ ?>
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
			<?php if($content_display == 'excerptblog_display'):
					the_excerpt();
				else:
					the_content();
				endif; ?>
		</div> <!-- end .entry-content -->

	<?php wp_link_pages( array( 
			'before'            => '<div style="clear: both;"></div><div class="pagination clearfix">'.esc_html__( 'Pages:', 'cocktail' ),
			'after'             => '</div>',
			'link_before'       => '<span>',
			'link_after'        => '</span>',
			'pagelink'          => '%',
			'echo'              => 1
		) ); ?>
</article><!-- end .post -->
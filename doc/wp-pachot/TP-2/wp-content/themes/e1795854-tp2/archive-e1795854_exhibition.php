<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package e1795854_TP2
 */

get_header();
?>

    <div id="primary" class="content-area">
        <main id="main-catalog" class="site-main">
            <header>
                <h1 class="entry-title"><?php _e('All exhibitions', 'e1795854-tp2'); ?></h1>
            </header>
            <div id="catalog-list-e1795854-exhibition">
                <?php
                /* Start the Loop */
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content-archive', get_post_type() );

                endwhile;
                ?>
            </div>
            <p class="e1795854-paginate"><?php echo paginate_links(); ?></p>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
// get_sidebar();
get_footer();

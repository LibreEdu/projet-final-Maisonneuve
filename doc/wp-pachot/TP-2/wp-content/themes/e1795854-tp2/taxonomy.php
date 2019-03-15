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
        <main id="main-taxonomy" class="site-main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                ?>
            </header><!-- .page-header -->

            <div id="archive-list-e1795854-exhibition">
                <?php
                while ( have_posts() ) :
                    the_post();

                    /*
                     * Include the Post-Type-specific template for the content.
                     * If you want to override this in a child theme, then include a file
                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/content-taxonomy', get_post_type() );

                endwhile;
                ?>
            </div>
            <p class="e1795854-paginate"><?php echo paginate_links(); ?></p>
            <?php


        else :

            get_template_part( 'template-parts/content', 'none' );

        endif;
        ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
// get_sidebar();
get_footer();

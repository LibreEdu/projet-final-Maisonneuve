<?php
/**
 * Template name: Accueil
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package e1795854_TP2
 */

get_header();

$args = array(
    'post_type'      => 'e1795854_exhibition',
    'orderby'        => 'post_date',
    'posts_per_page' => '3'
);

$exhibitions = new WP_Query($args);

?>

    <div id="primary" class="content-area">
        <main id="main-accueil" class="site-main">
            <header>
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

            </header>
            <?php
            while ( $exhibitions->have_posts() ) :
                $exhibitions->the_post();

                get_template_part( 'template-parts/content', 'page-accueil' );

            endwhile;
            ?>

        </main>
    </div>

<?php
// get_sidebar();
get_footer();

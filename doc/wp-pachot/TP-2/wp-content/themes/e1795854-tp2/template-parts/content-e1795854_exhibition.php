<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package e1795854_TP2
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    
    </header><!-- .entry-header -->

    <div class="e1795854-entry-content">
        <?php e1795854_tp2_post_thumbnail(); ?>

        <div class="e1795854-entry-content-text">
            <p><span><?php
                        $date =  get_post_meta(get_the_id(), 'Date_debut', true);
                        echo date("d/m/Y", strtotime($date));
                    ?></span> - <span><?php
                        $date =  get_post_meta(get_the_id(), 'Date_fin', true);
                        echo date("d/m/Y", strtotime($date));
                    ?></span></p>
            <p><?php echo the_terms(get_the_id(), 'e1795854_place')?></p>
            <p><?php echo the_terms(get_the_id(), 'e1795854_artist'); ?></p>
            <p><?php echo the_terms(get_the_id(), 'e1795854_theme'); ?></p>
            <?php the_content(); ?>
            <?php echo do_shortcode('[e1795854_tp2_preview]'); ?>
            <?php echo do_shortcode('[e1795854_tp2_registered]'); ?>
        </div>
    </div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->

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
    <?php $multiple = true; e1795854_tp2_post_thumbnail($multiple); ?>

    <div class="e1795854-tp2-entry-content">
        <header class="entry-header">
            <h2 class="entry-title"><a href="<?php echo get_permalink(get_the_id()); ?>"><?php the_title(); ?></a></h2>
            <p>
                <span><?php
                        $date =  get_post_meta(get_the_id(), 'Date_debut', true);
                        echo date("d/m/Y", strtotime($date));
                    ?></span>
                - <span><?php
                        $date =  get_post_meta(get_the_id(), 'Date_fin', true);
                        echo date("d/m/Y", strtotime($date));
                    ?></span>
            </p>
            <p><?php 
                    $lieu = get_the_terms(get_the_id(), 'e1795854_place');
                    echo $lieu[0]->name;
                ?></p>
        </header>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->

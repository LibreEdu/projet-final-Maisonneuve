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
    <p><a href="<?php echo get_permalink(get_the_id()); ?>"><?php the_title(); ?></a></p>
</article><!-- #post-<?php the_ID(); ?> -->

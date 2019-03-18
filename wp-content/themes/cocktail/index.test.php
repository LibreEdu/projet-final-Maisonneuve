<?php
/**
 * The main template file.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Freesia
 * @subpackage Cocktail
 * @since Cocktail 1.0
 */

if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		echo "<b>Permalien : </b>";the_permalink();
		echo "<br><b>Titre : </b>"; the_title() ;
		echo "<br />";
		get_template_part( 'template‐parts/post/content', get_post_format() );
		echo "<p class=\"postmetadata\">";
		the_time('j F Y') ;
		echo " par "; the_author();
		echo " | Cat&eacute;gorie : ";
		the_category(', ');
		echo " | ";
		comments_popup_link('Pas de commentaires', '1 Commentaire', '% Commentaires');
		edit_post_link('Editer', ' &#124; ', '');
		echo "</p>";
	endwhile;
endif;

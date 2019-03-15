<?php
/**
 * Widget API: classe N41_Recipes_Widget_News
 *
 * @package N41 Recipes
 */

/**
 * Classe qui implémente le widget N41_Recipes_Widget_News
 * ce widget affiche un lien vers la dernière recette enregistrée dans la table recipes
 *
 * @see WP_Widget
 */
class N41_Recipes_Widget_News extends WP_Widget {

    /**
     * Constructeur d'une nouvelle instance de cette classe
     *
     */
    public function __construct() {
        $widget_ops = array(
            'classname'   => 'n41_recipes_widget_news',
            'description' => 'Affiche le nom de la dernière recette enregistrée.'
        );
        parent::__construct( 'n41_recipes_widget_news', 'N41 Recipes - Dernière recette', $widget_ops );
    }

    /**
     * Affiche le contenu de l'instance courante du widget
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'
     * @param array $instance Settings for the current widget instance
     */
    public function widget( $args, $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : $instance['nbRecipesToDisplay'] > 1 ? __('Dernières recettes') : __('Dernière recette') ;

        /** Ce crochet de filtres est documenté dans wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

        // le tableau args contient les codes html de mise en forme
        // enregistrés par la fonction WP register_sidebar dans le thème courant
        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        // Affichage du lien vers la page de la dernière recette
        $this->get_last_recipe($instance);

        echo $args['after_widget'];
    }

    /**
     * Affichage du lien vers la page de la dernière recette
     *
     * @param none
     */
    public function get_last_recipe($instance) {
        global $wpdb;

        if($instance['nbRecipesToDisplay'] > 0) :
          // récupération des dernières recettes dans la table recipes
          $sql = "SELECT * FROM $wpdb->prefix"."recipes ORDER BY id DESC LIMIT " . $instance['nbRecipesToDisplay'];

          $recipes = $wpdb->get_results($sql);
          if (count($recipes)) :

              foreach ($recipes as $recipe) :

                  // récupération du lien vers la page générique d'affichage d'une recette
                  $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'n41_recipes' AND meta_value = 'single'");
                  $single_permalink = get_permalink($postmeta->post_id);
    ?>

        <ul>
          <li>
            <a href="<?php echo $single_permalink.'?page='.stripslashes($recipe->title).'&id='.$recipe->id?>"><?php echo stripslashes($recipe->title) ?></a>
          </li>
        </ul>
    <?php
              endforeach;
    ?>

        <br />

    <?php
          else :
    ?>

        <p>Aucune recette enregistrée.</p>
    <?php
          endif;
        endif;
        if ($instance['displayNbRecipes']) :
            $resultat = $wpdb->get_row("SELECT count(*) nbRecipes FROM $wpdb->prefix"."recipes");
    ?>

        <p>Il y a <?php echo $resultat->nbRecipes ?> recette<?php echo ($resultat->nbRecipes>1)?"s":""; ?> en tout.</p>

    <?php
        endif;
    }

    /**
     * Affichage du formulaire de configuration du widget
     *
     * @param array $instance Current settings
     */
    public function form( $instance ) {
        // ici un seul paramètre de configuration: le titre du widget
        // qui est affiché dans la zone du widget sur les pages du site
        $title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $nbRecipesToDisplay = esc_attr($instance['nbRecipesToDisplay'] ?? 3);
        $displayNbRecipes = esc_attr($instance['displayNbRecipes'] ?? 1);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
                <input    class="widefat"
                        id="<?php echo $this->get_field_id('title'); ?>"
                        name="<?php echo $this->get_field_name('title'); ?>"
                        type="text"
                        value="<?php echo $title; ?>" />
            </label>
            <label>Nombre de recettes à afficher :
                <input class="widefat" name="<?php echo $this->get_field_name('nbRecipesToDisplay'); ?>" type="number" value="<?= $nbRecipesToDisplay; ?>" />
            </label>
            <label>Afficher le nombre total de recette :
                <input class="widefat" name="<?php echo $this->get_field_name('displayNbRecipes'); ?>" type="checkbox" value="1" <?php checked($displayNbRecipes, "1"); ?> />
            </label>
        </p>
        <?php
    }

    /**
     * Modification de la configuration en retour du formulaire
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form()
     * @param array $old_instance Old settings for this instance
     * @return array Updated settings
     */
    public function update( $new_instance, $old_instance ) {

        // // DEBUG N41
        // $nfile = fopen(ABSPATH."n41-debug.log", "a");
        // $value =date("Y-m-d H:i:s ")."class-n41-recipes-widget-news - update : old_instance ".print_r($old_instance, true). "\n";
        // fwrite($nfile, $value);
        // $value =date("Y-m-d H:i:s ")."class-n41-recipes-widget-news - update : new_instance ".print_r($new_instance, true). "\n";
        // fwrite($nfile, $value);
        // fclose($nfile);
        // // FIN DEBUG N41

        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['nbRecipesToDisplay'] = sanitize_text_field($new_instance['nbRecipesToDisplay']);
        $instance['displayNbRecipes'] = sanitize_text_field($new_instance['displayNbRecipes']);
        return $instance;
    }

}

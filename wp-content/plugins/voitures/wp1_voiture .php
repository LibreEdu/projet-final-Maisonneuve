<?php
    /*
    Plugin Name: wp1_voiture
    Plugin URI: https://wp1.plugins.com
    Description: Liste des voitures
    Version: 1.0
    Author: Fatemeh
    Author URI: https://Fatemeh.com
    */

    include ("wp1_voiture_setting.php");

    register_activation_hook( __FILE__, 'wp1_voitures_activate' );
    /**
     *==========================Activation de l'extension============================
     *
     * @param none
     * @return none
     */
    function wp1_voitures_activate() {
        wp1_voitures_check_version();
        wp1_voitures_create_table();
        wp1_voitures_create_pages();
        wp1_voitures_default_settings();
    }

    /**
     * ========================Verification de version WP =================================
     *
     * @param none
     * @return none
     */
    function wp1_voitures_check_version() {
        global $wp_version;
        if ( version_compare( $wp_version, '4.9', '<' ) ) {
            wp_die( 'Cette extension requiert WordPress version 4.9 ou plus.' );
        }
    }

    /**
     * ================= Creation de la table ====================================
     *
     * @param none
     * @return none
     */
    function wp1_voitures_create_table() {
    global $wpdb;
    $sql = "CREATE TABLE $wpdb->prefix"."voitures(
        id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        marque varchar(100) NOT NULL,
        modele varchar(150) NOT NULL,
        couleur varchar(100) NOT NULL,
        annee int(11)UNSIGNED NOT NULL,
        kilometrage int(11) UNSIGNED NOT NULL,
        prix int(11) UNSIGNED NOT NULL,
        users bigint(20) UNSIGNED NOT NULL,
        date date,
        FOREIGN KEY (users) REFERENCES $wpdb->prefix"."users(ID),
        PRIMARY KEY(id)
        ) ".$wpdb->get_charset_collate();
     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    }

    /**
     *==============Creation automatique des pages======================
     *
     * @param none 
     * @return none
     */
    function wp1_voitures_create_pages(){
        $wp1_voitures_page = array(
            'post_title'     => "Saisie d'un vehicule",
            'post_content'   => "[saisie_voiture]",
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
            'meta_input' => array('wp1_voitures' => 'form')
        );
        wp_insert_post($wp1_voitures_page);

        $wp1_voitures_page = array(
          'post_title' => "Liste des voitures",
          'post_content' => "[wp1_voitures_list]",
          'post_type' => 'page',
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'meta_input' => array('wp1_voitures' => 'list')
        );
        wp_insert_post($wp1_voitures_page);

        $wp1_voitures_page = array(
          'post_title' =>  "Liste de voiture",
          'post_content' => "[wp1_voitures_single]",
          'post_type' => 'page',
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'meta_input' => array('wp1_voitures' => 'single')
        );
        wp_insert_post($wp1_voitures_page);

        $wp1_voitures_page = array(
          'post_title' => "Modifier",
          'post_content' => "[wp1_voitures_modifier]",
          'post_type' => 'page',
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'meta_input' => array('wp1_voitures' => 'modifier')
        );
        wp_insert_post($wp1_voitures_page);

        $wp1_voitures_page = array(
          'post_title' => "Supprimer",
          'post_content' => "[wp1_voitures_supprimer]",
          'post_type' => 'page',
          'post_status' => 'publish',
          'comment_status' => 'closed',
          'ping_status' => 'closed',
          'meta_input' => array('wp1_voitures' => 'supprimer')
        );
        wp_insert_post($wp1_voitures_page);
    }

    //================Desactivation de l'extension=======================
      register_deactivation_hook( __FILE__, 'wp1_voitures_deactivate' );

    /**
     *Desactivation de l'extension
     *
     * @param none
     * @return none
     */
    function wp1_voitures_deactivate() {
        wp1_voitures_delete_pages();
    }  

    /**
     * ====================Suppression des pages de l'extension=======================
     *
     * @param none
     * @return none
     */
    function wp1_voitures_delete_pages(){
        global $wpdb;
        $postmetas = $wpdb->get_results(
                       "SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures'");
        $force_delete = true;
          foreach ($postmetas as $postmeta) {
            // suppression lorsque la metadonnees si ce n'est pas une image
            if ($postmeta->meta_value !== 'img') {
                wp_delete_post( $postmeta->post_id, $force_delete );
            }
        }
    }

    register_uninstall_hook(__FILE__, 'wp1_voitures_uninstall');
    /**
     * ===================Traitements de  la desinstalation de l'extension==============
     *
     * @param none
     * @return none
     */
    function wp1_voitures_uninstall() {
        wp1_voitures_drop_table();
        wp1_voitures_delete_settings();
    }

    /**
     * =======================Suppression de la table voitures=========================
     *
     * @param none
     * @return none
     */
    function wp1_voitures_drop_table() {
        global $wpdb;
        $sql = "DROP TABLE $wpdb->prefix"."voitures";
        $wpdb->query($sql);
    }
    /**
     * =====================Suppression de l'option wp1_voitures_settings================
     *
     * @param none 
     * @return none
     */
    function wp1_voitures_delete_settings() {
        delete_option('wp1_voitures_settings');
    }

    //======================Section pour l'utilisation de hook ==========================

    /**
     * Ajoute le nom de le voiture dans le marque via le crochet de filtres the_marque
     * pour la page "voiture" uniquement, identifier par la metadonnes wp1_voitures = single
     * @param bool  $marque    The current marque
     * @param int   $post_id  The current post ID
     * @return bool false
     */
    function wp1_voitures_hook_the_marque($marque, $post_id) {
        $single = true;
        $wp1_voitures = get_post_meta($post_id, 'wp1_voitures', $single);
        if ($wp1_voitures === 'single' && isset($_GET['id'])) {
            global $wpdb;
            $sql = "SELECT marque FROM $wpdb->prefix"."voitures WHERE id =%d";
            $voiture = $wpdb->get_row($wpdb->prepare($sql, $_GET['id']));
            $marque= ':<br>'.stripslashes($voiture->marque);
        }
        return $marque;
    }

    // ==============Ajout de la fonction wp1_voitures_hook_the_marque au hook the_marque==========	
    add_filter( 'the_marque', 'wp1_voitures_hook_the_marque', 10, 2 );

    /**
     *
     * @param bool  $open    Whether the current post is open for comments
     * @param int   $post_id The current post ID
     * @return bool false
     */
    function wp1_voitures_close_hook_comments_open($open, $post_id) {
        $single = true;
        $wp1_voitures = get_post_meta($post_id, 'wp1_voitures', $single);
        if ($wp1_voitures !== '') {
            $open = false;
        }
        return $open;
    }

    /**
    * =======================Tableau de reglage ============================
    *
    * @param none
    * @return none
    */
    function wp1_voitures_default_settings() {
        add_option(
            'wp1_voitures_settings',
            array(
                'view_marque'  => 'yes',
                'view_modele'  => 'yes',
                'view_annee'  => 'yes',
                'view_couleur' => 'yes',
                'view_kilometrage'    => 'yes',
                'view_prix'    => 'yes',
                'view_edit'  => 'yes',
                'view_aut'  => 'yes',
                'view_abon'  => 'yes',
                'view_visible' => 'yes',
                'view_date'    => 'yes')    
        );
    }

    /**
     * ===========Creation du formulaire de saisie d'une voiture=======================
     *
     * @param none
     * @return echo html form voiture code
     */
    function html_form_voiture_code() {
       
        ?>
        <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <label>Marque</label>
            <input type="text" name="marque" placeholder="marque de la voiture" required>
            <label>Modele</label>
            <input type="text" name="modele" placeholder="modele de la voiture" required>
            <label>Couleur</label>
            <input type="text" name="couleur" placeholder="couleur de la voiture" required><br>
            <label>Annee</label>
            <input type="text" name="annee" placeholder="annee" required pattern="[1-2][0-9][0-9][0-9]*">
            <label>Kilometrage</label>
            <input type="text" name="kilometrage" placeholder="kilometrage" required>
            <label>Prix</label>
            <input type="text" name="prix" placeholder="prix" required>
            <input type="submit" name="submitted" value="Envoyez">
        </form>
    <?php
    }

    /**
     * ===================Insertion d'une voiture dans la table==========================
     *
     * @param none
     * @return none
     */
    function insert_voiture() {
        // si le bouton submit est clique

        if ( isset( $_POST['submitted'] ) ) {
            // assainir les valeurs du formulaire  
            $marque = sanitize_text_field( $_POST["marque"] );
            $modele = sanitize_text_field( $_POST["modele"] );
            $couleur = sanitize_text_field( $_POST["couleur"] );
            $annee = sanitize_text_field( $_POST["annee"] );
            $kilometrage = sanitize_text_field( $_POST["kilometrage"] );
            $prix = sanitize_text_field( $_POST["prix"] );
            $current_user = wp_get_current_user();
            $users=$current_user->ID; 
            $date=current_time('mysql'); 

            // insertion dans la table
            global $wpdb;
            $wpdb->insert( $wpdb->prefix.'voitures',
            array( 'marque' => $marque, 'modele' => $modele,
            'couleur' => $couleur,'annee' => $annee,
            'kilometrage' => $kilometrage,      
            'prix' => $prix, 'users' => $users, 'date' => $date),
            array( '%s','%s','%s','%d','%d','%d', '%d', '%s'));
            }
        }

        /**
         * ===================Execution de hook de saisie d'une voiture====================
         *
         * @param none
         * @return the content of the output buffer (end output buffering)
         */
        function shortcode_input_form_voiture() {
            ob_start(); // temporisation de sortie
            insert_voiture();
            html_form_voiture_code();
            return ob_get_clean(); // fin de la temporisation de sortie pour l'envoi au navigateur
        }

        // =======Creation de shortcode pour afficher et traiter le formulaire=================
        add_shortcode( 'saisie_voiture', 'shortcode_input_form_voiture' );
        /**
         * ==============Creation de la page de liste des voitures =========================
         *
         * @param none
         * @return echo html list voitures code
         */
        function wp1_voitures_html_list_code() {
        //===============Affichage d'un lien vers le formulaire de saisie d'un voiture============
        global $wpdb;
        $user1=0;
        $user2=0;
        $user3=0;
        $current_user = wp_get_current_user();
        $users=$current_user->ID; 
        $usersRol=wp_get_current_user()->roles;
        $settings = get_option('wp1_voitures_settings'); 
        if (isset($settings['view_aut']) && $settings['view_aut'] === 'yes') :
        $user1=1;
        endif;

        if (isset($settings['view_abon']) && $settings['view_abon'] === 'yes') :
        $user2=1;
        endif;

        if (isset($settings['view_edit']) && $settings['view_edit'] === 'yes') :
        $user3=1;        
        endif;
                     
        if ($user1=1 AND $usersRol==='author') :
        $affiche='yes';
        else:
        $affiche='non';
        endif;
        
        if($user2=1 AND $usersRol==='subscriber') :
        $affiche='yes';   
        else:
        $affiche='non';   
        endif;

        if($user3=1 AND $usersRol==='editor') :
        $affiche='yes';   
        else:
        $affiche='non';   
        endif;
        
        if (current_user_can('administrator') OR current_user_can('editor') OR current_user_can('author') OR $affiche==='yes') :  
            $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures' AND meta_value = 'form'");
        ?>
            <a href="<?php echo get_permalink($postmeta->post_id)?>">Saisie d'une voiture</a>
        <?php
        endif;
        ?>
         <!-- ==============Affichage du formulaire trier voiture ===========================-->
        <form action="<?php echo esc_url($_SERVER['REQUEST_URI'])?>" method="post"> 
                <h3>Trier par:</h3>
                 <select name="tirer"><br><br>
                 	<option value= "annee" selected>ANNEE</option>
			        <option value= "marque" >MARQUE</option>
                 	<option value= "modele">MODELE</option>
                 	<option value= "couleur">COULEUR</option>
                 </select>
                  <input type="submit" name="trier" value="trier"><br>
                </form><br>
        <!-- ============Affichage du formulaire de recherche d'un type de voiture ================-->
		<form action="<?php echo esc_url($_SERVER['REQUEST_URI'])?>" method="post">
               	<input type="text" name="ads-marque"  placeholder="marque de la voiture"><br>
                <input type="text" name="ads-modele" placeholder="modele de la voiture"><br>
                <input type="text" name="ads-couleur" placeholder="couleur de la voiture"><br>  
                <input type="text" name="ads-prix" placeholder="prix maximum"><br>  
                <input type="submit" name="cherche" value="Rechercher">
            </form>
               <?php
              global $wpdb; 
             $voitures = $wpdb->get_results("SELECT * FROM $wpdb->prefix"."voitures ORDER BY date ASC
            ");
            
         //==============================Affichage la liste des voiture ============================
        if(isset($_POST['trier'])&&!isset( $_POST['cherche'] ))
        {
            $order= $_POST['tirer'];
            global $wpdb;
            $voitures = $wpdb->get_results("SELECT * FROM $wpdb->prefix"."voitures
            ORDER BY $order ASC");
        } 

        else if (isset($_POST['cherche'])&&!isset($_POST['trier']))
        {
            $ads_make  = isset($_POST['ads-marque'])  && trim($_POST['ads-marque'])  !== '' ? trim($_POST['ads-marque'])  : '';
            $ads_model = isset($_POST['ads-modele']) && trim($_POST['ads-modele']) !== '' ? trim($_POST['ads-modele']) : '';
            $ads_couleur = isset($_POST['ads-couleur']) && trim($_POST['ads-couleur']) !== '' ? trim($_POST['ads-couleur']) : '';
            $ads_prix = isset($_POST['ads-prix']) && trim($_POST['ads-prix']) !== '' ? trim($_POST['ads-prix']) : '';

            global $wpdb; 
            $sql  = "SELECT * FROM $wpdb->prefix"."voitures
            WHERE marque LIKE '%s' AND modele LIKE '%s' AND couleur LIKE '%s' AND prix LIKE %s 
            ORDER BY annee ASC";

            $voitures = $wpdb->get_results($wpdb->prepare($sql, '%'.$ads_make.'%', '%'.$ads_model.'%', '%'.$ads_couleur.'%', '%'.$ads_prix.'%')); 
        }

        else if  (!isset($_POST['cherche'])&& !isset($_POST['trier'])) 
        {
           global $wpdb; 
            $voitures = $wpdb->get_results("SELECT * FROM $wpdb->prefix"."voitures ORDER BY date ASC");
        }

        if (count($voitures)>0)
            global $wpdb; 
            $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures' AND meta_value = 'single'");
                $single_permalink = get_permalink($postmeta->post_id);
                $settings = get_option('wp1_voitures_settings');
                $date1=current_time('mysql'); 

            if (isset($settings['view_visible']) && $settings['view_visible'] === 'yes') :  
            ?>
            <br>
            <table>
                <tr>
                    <th><b>Marque</b></th>
                    <th><b>Modele</b></th>
                    <th><b>Annee</b></th>
                    <th><b>Couleur</b></th>
                    <th><b>Kilometrage</b></th>
                    <th><b>Prix</b></th>
                    <th><b>Date</b></th>
                </tr>
            <?php
                foreach ($voitures as $voiture) :
            ?>	
                <tr>
                    <td><a href="<?php echo $single_permalink.'?id='.$voiture->id?>"><?php echo stripslashes($voiture->marque) ?></a></td>
                    <td><?php echo $voiture->modele?></td>
                    <td><?php echo $voiture->annee ?></td>
                    <td><?php echo $voiture->couleur ?></td>
                    <td><?php echo $voiture->kilometrage?></td>
                    <td><?php echo $voiture->prix ?></td>
                    <td><?php echo $voiture->date ?></td>
                </tr>
            <?php
                endforeach;
        endif;
        ?>
        </table>
        <?php
    }
    /**
     * ============Execution du code court  d'affichage de la liste des voitures====================
     *
     * @param none
     * @return the content of the output buffer (end output buffering)
     */
    function wp1_voitures_shortcode_list() {
        ob_start(); // temporisation de sortie
        wp1_voitures_html_list_code();
        return ob_get_clean(); // fin de la temporisation de sortie pour l'envoi au navigateur
    }

    // =========Creation shortcode pour afficher la liste des voitures==============================
    add_shortcode( 'wp1_voitures_list', 'wp1_voitures_shortcode_list' );

    /**
     * Creation de la page d'affichage d'un voiture
     *
     * @param none
     * @return echo html single voiture code
     */
    function wp1_voitures_html_single_code() {
        //Affichage d'un lien vers la page de liste des voitures
        //global $wpdb;
        //$current_user= wp_get_current_user();

        //$users=$current_user->ID; 
        //$creer=$voiture->users;
        //var_dump($voitures);
        //if ($users== $creer OR current_user_can('administrator')):
        global $wpdb;
        $postmeta = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures' AND meta_value = 'list'");
    ?>
        <a href="<?php echo get_permalink($postmeta->post_id)?>"><b>Retour sur la lise des voitures</b></a>
    <?php	
        //endif;				
        //=============================Affichage de le voiture ===============================
        $voiture_id = isset($_GET['id']) ? $_GET['id'] : null;
        $sql = "SELECT * FROM $wpdb->prefix"."voitures WHERE id =%d";
        $voiture = $wpdb->get_row($wpdb->prepare($sql, $voiture_id));
        $postmeta1 = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures' AND meta_value = 'modifier'");
        $modifier_permalink = get_permalink($postmeta1->post_id);
        $postmeta2 = $wpdb->get_row("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'wp1_voitures' AND meta_value = 'supprimer'");
        $supprimer_permalink = get_permalink($postmeta2->post_id);
        if ($voiture !== null) :
            // récupération du post de l'image associée au voiture, dans la table posts,à partir du post_name qui contient l'id du voiture 
            $voiture_image_post = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_name = 'voiture-".$voiture_id."' AND post_type='attachment'");
        ?>
        <table>
            <tr><td>MARQUE</td><td><?php echo stripslashes($voiture->marque) ?></td></tr>
            <tr><td>MODELE</td><td><?php echo stripslashes($voiture->modele) ?></td></tr>
            <tr><td>COULEUR</td><td><?php echo $voiture->couleur ?></td></tr>
            <tr><td>ANNEE</td><td><?php echo stripslashes($voiture->annee) ?></td></tr>
            <tr><td>KILOMETRAGE</td><td><?php echo $voiture->kilometrage ?></td></tr>
            <tr><td>PRIX</td><td><?php echo $voiture->prix ?></td></tr>
            <tr><td>DATE</td><td><?php echo $voiture->date ?></td></tr>
            <?php 
            $user1=0;
            $user2=0;
            $user3=0;
            $current_user = wp_get_current_user();
            $users=$current_user->ID; 
            $creer=$voiture->users;
            $usersRol=wp_get_current_user()->roles;
            $settings = get_option('wp1_voitures_settings'); 
            if (isset($settings['view_aut']) && $settings['view_aut'] === 'yes') :
            $user1=1;
            endif;

            if (isset($settings['view_abon']) && $settings['view_abon'] === 'yes') :
            $user2=1;
            endif;

            if (isset($settings['view_edit']) && $settings['view_edit'] === 'yes') :
            $user3=1;        
            endif;
                     
            if ($user1=1 AND $usersRol==='author') :
            $affiche='yes';
            else:
            $affiche='non';
            endif;
            
            if($user2=1 AND $usersRol==='subscriber') :
            $affiche='yes';   
            else:
            $affiche='non';
            endif;

            if($user3=1 AND $usersRol==='editor') :
            $affiche='yes';   
            else:
            $affiche='non';
            endif;
        //=================Assurer l'utilisateur est administrateur ========================
        global $wpdb;
        $users = get_current_user_id();
        $creer=$voiture->users;
        if ($users== $creer OR current_user_can('administrator')  OR $affiche=='yes'):
         ?>
          <tr><td><a href='<?php echo $modifier_permalink.'?id='.$voiture->id ?>'><b>Modifier</b></td></tr>
           <tr><td><a href='<?php echo $supprimer_permalink.'?id='.$voiture->id ?>'><b>Supprimer</b></td></tr>
         <?php 
        endif;
        ?>
        </table>
    <?php
endif;
    }

    /**
     * =============Execution du code court (shortcode) d'affichage d'une voitures======================
     *
     * @param none
     * @return the content of the output buffer (end output buffering)
     */
    function wp1_voitures_shortcode_single() {
        ob_start(); // temporisation de sortie
        wp1_voitures_html_single_code();
        return ob_get_clean(); 
    }

    // ========================Creer un shortcode pour afficher une voiture=============================
    add_shortcode( 'wp1_voitures_single', 'wp1_voitures_shortcode_single' );

    /**
     * ======================creation  de la  formulaire de modification voiture=====================
     *
     * @param none
     * @return echo html modifier voiture code
     */
    function  wp1_voitures_html_modifier_code() {
        //Affichage lae formulaire de modification de la voiture
        global $wpdb;
        $voiture_id = isset($_GET['id']) ? $_GET['id'] : null;
        $sql = "SELECT * FROM $wpdb->prefix"."voitures WHERE id ='%d'";
        $voiture = $wpdb->get_row($wpdb->prepare($sql, $voiture_id));
        ?>
        <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">
            <label>Marque de la voiture</label>
            <input type="text" name="marque" value="<?php echo stripslashes($voiture->marque) ?>" >
            <label>Modele de la voiture</label>
            <input type="text" name="modele" value="<?php echo stripslashes($voiture->modele) ?>">    
            <label>Couleur</label>
            <input type="text" name="couleur" value="<?php echo $voiture->couleur ?>">
            <label>Annee</label>
            <input type="text" name="annee" value="<?php echo stripslashes($voiture->annee) ?>">  
            <label>Kilometrage</label>
            <input type="text" name="kilometres" value="<?php echo $voiture->kilometrage ?>">
            <label>Prix</label>
            <input type="text" name="prix" value="<?php echo $voiture->prix ?>">
            <input type="submit" name="modifiez" value="modifiez"> 
        </form>
    <?php
    }

    /**
     * ================modification d'un voiture dans la table voitures
     *
     * @param none
     * @return none
     */
    function modifier_voiture() {
        // si le bouton submit est cliquÃ©
        $voiture_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ( isset( $_POST['modifiez'] ) ) {
            // assainir les valeurs du formulaire
            $marque        = sanitize_text_field( $_POST["marque"] );
            $modele  = sanitize_text_field( $_POST["modele"] );
            $annee = sanitize_text_field( $_POST["annee"] );
            $couleur = sanitize_text_field( $_POST["couleur"] );
            $kilometres    = sanitize_text_field( $_POST["kilometres"] );
            $prix    = sanitize_text_field( $_POST["prix"] );
            $date=current_time('mysql'); 
            // insertion dans la table
             global $wpdb;
            $wpdb->UPDATE( $wpdb->prefix.'voitures',
            array( 'marque' => $marque, 'modele' => $modele,
            'couleur' => $couleur,'annee' => $annee,
            'kilometrage' => $kilometres,      
            'prix' => $prix,
              'date' => $date 
            ),
            array( 'id' => $voiture_id
                 ),               
            array( '%s','%s','%s','%d','%d','%d','%s'),
                           array( '%d' ) 
            );         
        }
    }

    /**
     * ===========Execution du code courtde saisie d'un voiture =================
     *
     * @param none
     * @return the content of the output buffer (end output buffering)
     */
    function wp1_voitures_shortcode_modifier() {
        ob_start(); // temporisation de sortie
        wp1_voitures_html_modifier_code(); 
        modifier_voiture();  
        return ob_get_clean(); 
    }

    // ==========Creation du shortcode pour afficher et traiter le formulaire==========
    add_shortcode( 'wp1_voitures_modifier', 'wp1_voitures_shortcode_modifier' );
  
    /**
     * ===============creation  de le  page de suppression voiture==================
     *
     * @param none
     * @return echo html supprimer voiture code
     */
   function  wp1_voitures_html_supprimer_code() {
        //Affichage le message de confirmation pour supprimer voiture
        global $wpdb;
        $voiture_id = isset($_GET['id']) ? $_GET['id'] : null;
        $sql = "SELECT * FROM $wpdb->prefix"."voitures WHERE id ='%d'";
        ?>
        <form action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>" method="post">   
            <h2>Etes-vous sur de vouloir supprimer cette annonce?</h2>
            <input type="submit" name="supprimer" value="supprimer"> 
        </form>
    <?php
    }

    /**
     * =================modification d'un voiture dans la table voitures================
     *
     * @param none
     * @return none
     */
    function supprimer_voiture() {
        // si le bouton submit est cliqué
        $voiture_id = isset($_GET['id']) ? $_GET['id'] : null;
        if ( isset( $_POST['supprimer'] ) ) {
            // suuprimer cette annonce dela table
             global $wpdb;
            $wpdb->DELETE( $wpdb->prefix.'voitures',
            array( 'ID' => $voiture_id) 
            );
            // chargement des fichiers nécessaires à l'exécution de la fonction media_handle_upload
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
         }
    }

    /**
     * ================Exécution du code court de saisie d'un voiture ======================
     *
     * @param none
     * @return the content of the output buffer (end output buffering)
     */
    function wp1_voitures_shortcode_supprimer() {
        ob_start(); // temporisation de sortie
        supprimer_voiture();
        wp1_voitures_html_supprimer_code();
        return ob_get_clean(); // fin de la temporisation de sortie pour l'envoi au navigateur
    }

    // créer un shortcode pour afficher et traiter le formulaire
    add_shortcode( 'wp1_voitures_supprimer', 'wp1_voitures_shortcode_supprimer' );


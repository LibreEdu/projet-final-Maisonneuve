<?php

// l'exécution du hook 'admin_menu' sert à compléter le panneau d'administration,
// pour les extensions et les thèmes
add_action( 'admin_menu', 'wp1_voitures_add_menu_page' );

/**
 * Formulaire des reglage
 *
 * @param none
 * @return none
 */
function wp1_voitures_add_menu_page() {
	add_menu_page(
		'reglage de l\'extension wp1 voitures',	// balise title de la page des réglages 
 		'wp1 voitures',								// texte de menu de la page des réglages dans le menu latéral gauche
		'administrator',							// capacité pour afficher cette page
 		'wp1-voitures-settings-page',				// slug dans l'url de la page
		'wp1_voitures_settings_page');				// fonction d'affichage de la page
		
	// l'exécution du hook 'admin_init' sert à initialiser le traitement de la page des réglages,avant l'affichage du panneau d'administration
	add_action( 'admin_init', 'wp1_voitures_register_setting' );
}

/**
 * Traitement de la page formulaire de reglage
 *
 * @param none
 * @return none
 */
function wp1_voitures_register_setting() {
	register_setting(
			'wp1_voitures_option_group',		// nom de la zone des réglages, associée à la saisie des valeurs de l'option
			'wp1_voitures_settings',			// nom de l'option des réglages
			'wp1_voitures_sanitize_option');	// fonction pour assainir les valeurs de l'option des réglages
}

/**
 * ================Assainissement des valeurs de l'option renvoyées par le formulaire des réglages==================
 *
 * @param none
 * @return none
 */
function wp1_voitures_sanitize_option( $input ) {
	$input['view_visible']= sanitize_text_field($input['view_visible']);
	//$input['view_modele'] = sanitize_text_field($input['view_modele']);
	//$input['view_annee']    = sanitize_text_field($input['view_annee']);
	//$input['view_couleur']    = sanitize_text_field($input['view_couleur']);
 	//$input['view_kilometrage']    = sanitize_text_field($input['view_kilometrage'] );
    //$input['view_prix']    = sanitize_text_field($input['view_prix']);
    $input['view_aut'] = sanitize_text_field($input['view_aut']);
	$input['view_edit'] = sanitize_text_field($input['view_edit']);
	$input['view_abon'] = sanitize_text_field($input['view_abon']);
    //$input['view_date'] = sanitize_text_field($input['view_date']);
	return $input;
}

/**
 * ==================Affichage du formulaire des réglages=======================
 *
 * @param none
 * @return none
 */
function wp1_voitures_settings_page() {
?>
	<div>
		<h2>Réglages de wp1 voitures</h2>
		<form method="post" action="options.php">
		<?php settings_fields( 'wp1_voitures_option_group' );?>
		<?php $wp1_voitures_settings = get_option( 'wp1_voitures_settings' ); ?>
		<h3>Interface de reglage de l'extension</h3>
			<table class="form-table">	
				<tr>
					<th scope="row">Visibilite de l'article</th>
					<td>
						<p>
							<input type="radio" name="wp1_voitures_settings[view_visible]" value="yes"
								<?php checked(!isset( $wp1_voitures_settings['view_visible']) || $wp1_voitures_settings['view_visible'] === 'yes' ) ?>>
							OUI
							<br>	   
							<input type="radio" name="wp1_voitures_settings[view_visible]" value="non"
								<?php checked( isset( $wp1_voitures_settings['view_visible']) && $wp1_voitures_settings['view_visible'] === 'non' ) ?>>
							NON
						</p>
					</td>
				</tr>			
				<tr>
					<th scope="row">Editeur</th>
					<td>
						<p>
							<input type="radio" name="wp1_voitures_settings[view_edit]" value="yes"
								<?php checked( !isset( $wp1_voitures_settings['view_edit']) || $wp1_voitures_settings['view_edit'] === 'yes' ) ?>>
							OUI
							<br>	   
							<input type="radio" name="wp1_voitures_settings[view_edit]" value="non"
								<?php checked( isset( $wp1_voitures_settings['view_edit']) && $wp1_voitures_settings['view_edit'] === 'non' ) ?>>
							NON
						</p>
					</td>
				</tr>
				
				<tr>
					<th scope="row">Auteur</th>
					<td>
						<p>
							<input type="radio" name="wp1_voitures_settings[view_aut]" value="yes"
								<?php checked( !isset( $wp1_voitures_settings['view_aut']) || $wp1_voitures_settings['view_aut'] === 'yes' ) ?>>
							OUI
							<br>	   
							<input type="radio" name="wp1_voitures_settings[view_aut]" value="non"
								<?php checked( isset( $wp1_voitures_settings['view_aut']) && $wp1_voitures_settings['view_aut'] === 'non' ) ?>>
							NON
						</p>
					</td>
				</tr>
				
				<tr>
					<th scope="row">Abonne</th>
					<td>
						<p>
							<input type="radio" name="wp1_voitures_settings[view_abon]" value="yes"
								<?php checked( !isset( $wp1_voitures_settings['view_abon']) || $wp1_voitures_settings['view_abon'] === 'yes' ) ?>>
							OUI
							<br>	   
							<input type="radio" name="wp1_voitures_settings[view_abon]" value="non"
								<?php checked( isset( $wp1_voitures_settings['view_abon']) && $wp1_voitures_settings['view_abon'] === 'non' ) ?>>
							NON
						</p>
					</td>
				</tr>
			</table>
			<p>
				<input type="submit" class="button-primary" value="Enregistrer les modifications">
			</p>
		</form>
	</div>	
 <?php
 }
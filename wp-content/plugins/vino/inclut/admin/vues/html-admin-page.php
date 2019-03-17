<?php
/**
 * Vue admin: page principale
 * 
 * @package Vino\Admin\Vue
 */
defined( 'ABSPATH' ) || exit;

?>
<div class="wrap">
	<h2>Importer les bouteilles de la SAQ</h2>
	<form method="post" action="options.php">
		<?php settings_fields("e1795854_TP1_settings_group");   // Génération de balises input cachées pour faire le lien avec la fonction register_setting par le paramètre option_group ?>

		<p>Nombre de bouteilles à importer : <input type="number" name="e1795854_TP1_settings[days]" min="0" required /></p>
		<p class="submit">
			<input type="submit" class="button-primary" value="Importer les bouteilles" />
		</p>
	</form>
</div>
<?php

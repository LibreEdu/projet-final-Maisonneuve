<?php
/**
 * Vue admin: page principale
 * 
 * @package Vino\Admin\Vue
 */
defined( 'ABSPATH' ) || exit;

?>
<div class="wrap">
	<h2>Importer des bouteilles de la SAQ</h2>
	<form method="post" action="options.php">
		<?php settings_fields("vino_import_nb_bouteilles"); // Génération de balises input cachées pour faire le lien avec la fonction register_setting par le paramètre option_group ?>

		<p>Nombre de bouteilles à importer : <input type="number" name="vino_import[nb_bouteilles]" min="0" required /></p>
		<p class="submit">
			<input type="submit" class="button-primary" value="Importer" />
		</p>
	</form>
	Nb bouteilles = <?php echo $nb_bouteilles; ?>
</div>
<?php

var vino = (function(){

	/**
	 * Module Vino.
	 */
	var obj = {};

	/**
	 * Redirige l’utilisateur vers le formulaire d’ajout de cellier.
	 *
	 * @example document.getElementById("btnAjouterCellier").addEventListener("click", ()=>
	 * {
	 *     vino.ajouterCellier();
	 * }, false);
	 */
	obj.ajouterCellier = function() {
		window.location = 'index.php?cellier&action=ajouter-form';
	}

	return obj;

})();

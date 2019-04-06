/**
 * @file Module VinoAdmin
 * @author Alexandre Pachot
 * @version 0.1
 */
var vinoAdmin = (function(){

	'use strict';


	/**
	 * Le module vinoAdmin gère les fonctions de la page d’administration.
	 * @exports vinoAdmin
	 */
	var obj = {};


	/**
	 * Démarre l’importation des bouteilles de vin de la SAQ.
	 */
	obj.importer = function() {
		// alert('Lorsque vous allez cliquer sur le bouton « OK » cela va lancer l’importation. C’est une opération qui dure longtemps. Un message vous préviendra de la fin de l’importation.');

		// Bouton Importer
		let btnImporter = document.getElementById('btnImporter');
		btnImporter.innerHTML = 'Importation en cours';
		btnImporter.className = '';

		// Barre de progression
		let barreProgression = document.getElementById('barre-progression');
		barreProgression.style.display = 'block';

		// Console de log (non fonctionnel)
		// let log = document.getElementById('log-importation');
		// log.style.visibility = 'visible';

		// Requête pour le serveur
		let parametres = {
			'mettreAJour':document.getElementById('mettreAJour').checked,
			'indice':document.getElementById('btnIndice').value
		};
		let requete = new Request('index.php?importation&action=importer-js', {method: 'POST', body: JSON.stringify(parametres)});
		fetch(requete)
		.then(response => {
			if (response.status === 200) {
				return response.text();
			} else {
				throw new Error('Erreur');
			}
		})
		.then(response => {
			// En cas d’erreur, déconnexion
			if (response == 'deconnexion') {
				window.location = 'index.php?login&action=logout';
			}

			btnImporter.innerHTML = 'Importation finie';
			barreProgression.style.display = 'none';

			// Console de log
			// log.innerHTML = response;
		}).catch(error => {
			console.error(error);
		});
	}


	/**
	 * Change la valeur de l’indice affichée en fonction de la position du bouton du variateur.
	 */
	obj.changerIndice = function() {
		document.getElementById('valeurIndice').innerHTML = document.getElementById('btnIndice').value;
	}

	return obj;

})();

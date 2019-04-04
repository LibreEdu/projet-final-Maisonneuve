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
		alert("Lorsque vous allez cliquer sur le bouton « OK » cela va lancer l’importation. C’est une opération qui dure longtemps. Un message vous préviendra de la fin de l’importation.");
		let parametres = {
			'mettreAJour':document.getElementById('mettreAJour').checked,
			'indice':document.getElementById('btnIndice').value
		};
		let requete = new Request('index.php?importation&action=importer', {method: 'POST', body: JSON.stringify(parametres)});
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
			if (response == "deconnexion") {
				window.location = 'index.php?login&action=logout';
			}

			// Division qui va recevoir les informations de la requête
			let log = document.getElementById('log-importation');
			log.style.visibility = 'visible';
			log.innerHTML = response;
		}).catch(error => {
			console.error(error);
		});
	}


	/**
	 * Change la valeur de l’indice affichée en fonction de la position du bouton du variateur.
	 */
	obj.changerIndice = function() {
		document.getElementById("valeurIndice").innerHTML = document.getElementById("btnIndice").value;
	}

	return obj;

})();

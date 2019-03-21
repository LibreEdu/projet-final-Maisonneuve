/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

window.addEventListener('load', function() {
	document.querySelectorAll('.formAjouterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			window.location = 'index.php?uCellier&action=ajouter-form';
		});
	});

	let cellier = {
		id_usager : document.querySelector('[name="id_usager"]'),
		nom : document.querySelector('[name="nom"]'),
	};

	/*let btnAjouterCellier = document.querySelector('[name="ajouterCellier"]');
	if(btnAjouterCellier){
		btnAjouterCellier.addEventListener('click', function(evt){
			var param = {
				'id_usager':cellier.id_usager.value,
				'nom':cellier.nom.value,
			};
			let requete = new Request('index.php?uCcellier&action=ajouterCellier', {method: 'POST', body: JSON.stringify(param)});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					console.log(response);
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
				window.location = 'index.php?uCellier&action=ajouterCellier';
			}).catch(error => {
				console.error(error);
			});
		});
	}*/	

	document.querySelectorAll('.ajouterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			var param = {
				'id_usager':cellier.id_usager.value,
				'nom':cellier.nom.value,
			};
			let requete = new Request('index.php?uCellier&action=ajouterCellier', {method: 'POST', body: JSON.stringify(param)});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					console.log(response);
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
				alert('safdadfe');
				window.location = 'index.php?uCellier&action=ajouterCellier';
			}).catch(error => {
				console.error(error);
			});
		});
	});

	document.querySelectorAll('.btnVisiterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			/*let requete = new Request('index.php?uCellier&action=visiterCellier', {method: 'POST', body: '{'id': '+id+'}'});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			});*/
			window.location = 'index.php?uBouteille&action=visiterCellier&id='+id;
		});
	});

	document.querySelectorAll('.btnSupprimerCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			let requete = new Request('index.php?uCellier&action=supprimerCellier', {method: 'POST', body: '{"id": ' + id+ '}'});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			});
		});
	});

	document.querySelectorAll('.btnBoire').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;

			let requete = new Request('index.php?uBouteille&action=boire-js', {method: 'POST', body: '{"id": ' + id + '}'});
			// récuperer la quantité avec l'id de la bouteille concerné 
			let quantite = document.getElementById(id);
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
				//affichage de la quantité
				quantite.innerHTML = 'Quantité : '+ response.quantite;
			}).catch(error => {
				console.error(error);
			});
		})

	});


	document.querySelectorAll('.btnAjouter').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			let requete = new Request('index.php?uBouteille&action=ajouter-js', {method: 'POST', body: '{"id": ' + id + '}'});
			// récuperer la quantité avec l'id de la bouteille concerné 
			let quantite = document.getElementById(id);
			
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
				//affichage de la quantité
				quantite.innerHTML = 'Quantité : '+ response.quantite;
			}).catch(error => {
				console.error(error);
			});
		})

	});
	
	document.querySelectorAll('.btnModifier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			window.location = 'index.php?uBouteille&action=modifier-form&id='+id;
		});
	});

	let inputNomBouteille = document.querySelector('[name="nom_bouteille"]');
	let liste = document.querySelector('.listeAutoComplete');
	if(inputNomBouteille){
	  	inputNomBouteille.addEventListener('keyup', function(evt){
		let nom = inputNomBouteille.value;
		liste.innerHTML = '';
		if(nom){
			let requete = new Request('index.php?uBouteille&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + nom + '"}'});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.text();
				} else {
				throw new Error('Erreur');
				}
			})
			.then(response => {
				console.log(response);
				// response.forEach(function(element){
				// 	liste.innerHTML += '<li data-id=" + element.id_bouteille_saq +'">'+element.nom+'</li>';
				// })
			}).catch(error => {
				console.error(error);
			});
		}
	});

	let bouteille = {
		nom : document.querySelector('.nom_bouteille'),
		millesime : document.querySelector('[name="millesime"]'),
		quantite : document.querySelector('[name="quantite"]'),
		date_achat : document.querySelector('[name="date_achat"]'),
		prix : document.querySelector('[name="prix"]'),
		garde_jusqua : document.querySelector('[name="garde_jusqua"]'),
		notes : document.querySelector('[name="notes"]'),
	};

	liste.addEventListener('click', function(evt){
		console.dir(evt.target)
		if(evt.target.tagName == 'LI'){
			bouteille.nom.dataset.id = evt.target.dataset.id;
			bouteille.nom.innerHTML = evt.target.innerHTML;
			
			liste.innerHTML = '';
			inputNomBouteille.value = '';

		}
	});

	// let btnAjouter = document.querySelector('[name="ajouterBouteilleCellier"]');
	// if(btnAjouter){
	// 	btnAjouter.addEventListener('click', function(evt){
	// 	var param = {
	// 		'id_bouteille':bouteille.nom.dataset.id,
	// 		'date_achat':bouteille.date_achat.value,
	// 		'garde_jusqua':bouteille.garde_jusqua.value,
	// 		'notes':bouteille.date_achat.value,
	// 		'prix':bouteille.prix.value,
	// 		'quantite':bouteille.quantite.value,
	// 		'millesime':bouteille.millesime.value,
	// 	};
	// 	let requete = new Request('index.php?requete=ajouter-form', {method: 'POST', body: JSON.stringify(param)});
	// 		fetch(requete)
	// 		.then(response => {
	// 			if (response.status === 200) {
	// 				return response.json();
	// 			} else {
	// 				throw new Error('Erreur');
	// 			}
	// 		})
	// 		.then(response => {
	// 		}).catch(error => {
	// 			console.error(error);
	// 		});		
	// 	});
	// }

	// let bouteille2 = {
	// 	id : document.querySelector('[name="id"]'),
	// 	nom : document.querySelector('[name="nom"]'),
	// 	millesime : document.querySelector('[name="millesime"]'),
	// 	quantite : document.querySelector('[name="quantite"]'),
	// 	date_achat : document.querySelector('[name="date_achat"]'),
	// 	prix : document.querySelector('[name="prix"]'),
	// 	garde_jusqua : document.querySelector('[name="garde_jusqua"]'),
	// 	notes : document.querySelector('[name="notes"]'),
	// 	code_saq : document.querySelector('[name="code_saq"]'),
	// 	prix_saq : document.querySelector('[name="prix_saq"]'),
	// 	format : document.querySelector('[name="format"]'),
	// 	description : document.querySelector('[name="description"]'),
	// 	pays : document.querySelector('[name="pays"]'),
	// 	id_type : document.querySelector('[name="id_type"]'),
	// };
	
	// let btnModifier = document.querySelector('[name="modifierBouteilleCellier"]');
	// if(btnModifier){
	// 	btnModifier.addEventListener('click', function(evt){
	// 	  var params = {
	// 		'id':bouteille2.id.value,
	// 		'nom':bouteille2.nom.value,
	// 		'date_achat':bouteille2.date_achat.value,
	// 		'garde_jusqua':bouteille2.garde_jusqua.value,
	// 		'notes':bouteille2.date_achat.value,
	// 		'prix':bouteille2.prix.value,
	// 		'quantite':bouteille2.quantite.value,
	// 		'millesime':bouteille2.millesime.value,
	// 		'code_saq':bouteille2.code_saq.value,
	// 		'prix_saq':bouteille2.prix_saq.value,
	// 		'format':bouteille2.format.value,
	// 		'description':bouteille2.description.value,
	// 		'pays':bouteille2.pays.value,
	// 		'id_type':bouteille2.type.value,
	// 	};
	// 	let requete = new Request('index.php?requete=modifier', {method: 'POST', body: JSON.stringify(params)});
	// 		fetch(requete)
	// 			.then(response => {
	// 				if (response.status === 200) {
	// 					return response.json();
	// 				} else {
	// 					throw new Error('Erreur');
	// 				}
	// 			})
	// 			.then(response => {
	// 			}).catch(error => {
	// 				console.error(error);
	// 			});
		
	// 	});
	// }
}


});


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
	//En cliquant sur le bouton ajouter cellier il le redirige vers le controleur cellier
	let btnAjouterCellier = document.getElementById('btnAjouterCellier');
	if(btnAjouterCellier){
		btnAjouterCellier.addEventListener('click', function(){
			window.location = 'index.php?cellier&action=ajouter-form';
		});
	};

	//En cliquant sur le bouton visiter, il recupere le id du cellier et le redirige vers le controlleur bouteille
	document.querySelectorAll('.btnVisiterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			window.location = 'index.php?bouteille&action=visiterCellier&id='+id;
		});
	});

	//En cliquant sur le boutton supprimer cellier il le supprime et redirige vers le controleur cellier
	document.querySelectorAll('.btnSupprimerCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			let requete = new Request('index.php?cellier&action=supprimer', {method: 'POST', body: '{"id": ' + id+ '}'});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
				window.location = 'index.php?cellier';
			}).catch(error => {
				console.error(error);
			});
		});
	});

	//Recuperer le bouton ajouter et diriger vers le controleur bouteille
	let btnAjouterBouteille = document.getElementById('btnAjouterBouteille');
	if(btnAjouterBouteille){
		btnAjouterBouteille.addEventListener('click', function(){
			window.location = 'index.php?bouteille&action=ajouter-form';
		});
	};

	document.querySelectorAll('.btnBoire').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;

			let requete = new Request('index.php?bouteille&action=boire-js', {method: 'POST', body: '{"id": ' + id + '}'});
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
				quantite.innerHTML = 'Quantité : '+ response[0].quantite;
			}).catch(error => {
				console.error(error);
			});
		})

	});

	document.querySelectorAll('.btnAjouter').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			let requete = new Request('index.php?bouteille&action=ajouter-js', {method: 'POST', body: '{"id": ' + id + '}'});
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
				quantite.innerHTML = 'Quantité : '+ response[0].quantite;
			}).catch(error => {
				console.error(error);
			});
		})

	});
	
	document.querySelectorAll('.btnModifier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			window.location = 'index.php?bouteille&action=modifier-form&id='+id;
		});
	});

	let inputNomBouteille = document.querySelector('[name="nom_bouteille"]');
	let liste = document.querySelector('.listeAutoComplete');

	if(document.getElementById('recherche')){
		document.getElementById('recherche').style.display = "none";
	};

	var element = document.getElementById('afficher');
	if(element){
		element.onclick = function() {
			if(document.getElementById('afficher').checked == true){
				document.getElementById('recherche').style.display = "initial";
				console.log('visible');
			}
			else{
				document.getElementById('recherche').style.display = "none";
				console.log('non visible');
			};
		};
	};

	
	if(inputNomBouteille){
		inputNomBouteille.addEventListener('keyup', function(evt){
			let nom = inputNomBouteille.value;
			liste.innerHTML = '';
			if(nom){
				let requete = new Request('index.php?bouteille&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + nom + '"}'});
				fetch(requete)
				.then(response => {
					if (response.status === 200) {
						return response.json();
					} else {
					throw new Error('Erreur');
					}
				})
				.then(response => {
					response.forEach(function(element){
						liste.innerHTML += '<li '
						+ 'data-id="' + element.id_bouteille_saq + '" '
						+ 'data-prix="' + element.prix + '"'
						+ 'data-millesime="' + element.millesime + '"'
						+ 'data-pays="' + element.pays + '"'
						+ 'data-format="' + element.format + '"'
						+ '>'
						+ element.nom + '</li>';
					} )
				}).catch(error => {
					console.error(error);
				});
			}
		} );
	}

	let bouteille = {
		nom : document.getElementById('nom_bouteille'),
		millesime : document.getElementById('millesime'),
		prix : document.getElementById('prix'),
		pays : document.getElementById('pays'),
		format : document.getElementById('format'),
		id_type : document.querySelector('[name="type"]')
	};

	liste.addEventListener('click', function(evt){
		if(evt.target.tagName == 'LI'){			
			bouteille.nom.value = evt.target.innerHTML;
			bouteille.prix.value = evt.target.dataset.prix;
			bouteille.millesime.value = evt.target.dataset.millesime;
			bouteille.pays.value = evt.target.dataset.pays;
			bouteille.format.value = evt.target.dataset.format;
			
			liste.innerHTML = '';
			inputNomBouteille.value = '';

		}
	});
	
	let btnAjouter = document.querySelector('[name="ajouterBouteilleCellier"]');
	if(btnAjouter){
		btnAjouter.addEventListener('click', function(evt){
		var param = {
			'id_bouteille':bouteille.nom.dataset.id,
			'date_achat':bouteille.date_achat.value,
			'garde_jusqua':bouteille.garde_jusqua.value,
			'note':bouteille.note.value,
			'prix':bouteille.prix.value,
			'quantite':bouteille.quantite.value,
			'millesime':bouteille.millesime.value,
		};
		let requete = new Request('index.php?requete=ajouter-form', {method: 'POST', body: JSON.stringify(param)});
			fetch(requete)
			.then(response => {
				if (response.status === 200) {
					return response.json();
				} else {
					throw new Error('Erreur');
				}
			})
			.then(response => {
			}).catch(error => {
				console.error(error);
			});		
		});
	}

} );


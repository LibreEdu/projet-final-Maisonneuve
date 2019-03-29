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
	// let btnAjouterCellier = document.getElementById('btnAjouterCellier');
	// if(btnAjouterCellier){
	// 	btnAjouterCellier.addEventListener('click', function(){
	// 		window.location = 'index.php?cellier&action=ajouter-form';
	// 	});
	// };

	//En cliquant sur le bouton visiter, il recupere le id du cellier et le redirige vers le controlleur bouteille
	document.querySelectorAll('.btnVisiterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id_cellier = evt.target.parentElement.dataset.id_cellier;
			console.log(id_cellier);
			window.location = 'index.php?cellier&action=voir&id_cellier='+id_cellier;
		});
	});

	//En cliquant sur le boutton supprimer cellier il le supprime et redirige vers le controleur cellier
	document.querySelectorAll('.btnSupprimerCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id_cellier = evt.target.parentElement.dataset.id_cellier;
			let requete = new Request('index.php?cellier&action=supprimer', {method: 'POST', body: '{"id": ' + id_cellier + '}'});
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

	//Recuperer le bouton ajouter bouteille et diriger vers le controleur bouteille
	let btnAjouterBouteille = document.getElementById('btnAjouterBouteille');
	if(btnAjouterBouteille){
		btnAjouterBouteille.addEventListener('click', function(){
			window.location = 'index.php?bouteille&action=ajouter-form';
		});
	};

	//Recuperer le bouton recherche bouteille et le type choisit puis diriger vers le controleur bouteille SAQ
	/*let iconRecherche = document.getElementById('iconRecherche');
	iconRecherche.addEventListener('click', function(element){
		alert('ssss');
		let recherchePar = document.querySelector('.recherchePar');
		recherchePar.innerHTML = 'Par <select>'
						+'<option value="nom">nom</option>'
						+'<option value="type">type</option>'
						+'</select>';
	});*/
	let btnRechercheBouteille = document.getElementById('btnRecherche');
	if(btnRechercheBouteille){
		btnRechercheBouteille.addEventListener('keyup', function(){	
			let recherchePar = document.querySelector('[name="recherchePar"]');
			alert(recherchePar.value);		
			let inputNomBouteille = document.querySelector('[name="nom_bouteille"]');
			let nom = inputNomBouteille.value;			
			let liste = document.querySelector('.autoComplete');
			if(liste){
				liste.innerHTML = '';				
				var params = {
					'valeur':recherchePar.value,
					'nom':inputNomBouteille.value						
				};
				let requete = new Request('index.php?bouteille_SAQ&action=saisie-semi-automatique', {method: 'POST', body: JSON.stringify(params)});
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
			};
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
			}
			else{
				document.getElementById('recherche').style.display = "none";
			};
		};
	};

	
	if(inputNomBouteille){
		inputNomBouteille.addEventListener('keyup', function(evt){
			let nom = inputNomBouteille.value;
			if (liste) {
				liste.innerHTML = '';
				if(nom){
					let requete = new Request('index.php?bouteille_SAQ&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + nom + '"}'});
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
							+ 'data-code_saq="' + element.code_saq + '"'
							+ '>'
							+ element.nom + '</li>';
						} )
					}).catch(error => {
						console.error(error);
					});
				};
			};
		});

		let bouteille = {
				nom : document.getElementById('nom_bouteille'),
				millesime : document.getElementById('millesime'),
				prix : document.getElementById('prix'),
				pays : document.getElementById('pays'),
				format : document.getElementById('format'),
				id_type : document.querySelector('[name="type"]'),
				code_saq : document.querySelector('[name="code_saq"]')
			};
		if(liste){
			liste.addEventListener('click', function(evt){
				if(evt.target.tagName == 'LI'){			
					bouteille.nom.value = evt.target.innerHTML;
					bouteille.prix.value = evt.target.dataset.prix;
					bouteille.millesime.value = evt.target.dataset.millesime;
					bouteille.pays.value = evt.target.dataset.pays;
					bouteille.format.value = evt.target.dataset.format;
					bouteille.code_saq.value = evt.target.dataset.code_saq;
					liste.innerHTML = '';
					inputNomBouteille.value = '';
				}
			});
		};
	}
	
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

	let NomBouteille = document.querySelector('[name="une_bouteille"]');
	let la_liste = document.querySelector('.listeBouteilles');
	
	if(NomBouteille){
		NomBouteille.addEventListener('keyup', function(evt){
			let un_nom = NomBouteille.value;
			la_liste.innerHTML = '';
			if(un_nom){
				let requete = new Request('index.php?bouteille_SAQ&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + un_nom + '"}'});
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
						la_liste.innerHTML += '<li data-id_bouteille_saq="' + element.id_bouteille_saq + '">' + element.nom + '</li>';
					} )
				}).catch(error => {
					console.error(error);
				});
			}
		} );

		let mes_achats = document.getElementById('mes_achats');
		la_liste.addEventListener('click', function(evt){
			if(evt.target.tagName == 'LI'){
				mes_achats.innerHTML += '<div name="laDiv" class="mdl-textfield mdl-js-textfield"><input type="hidden" name="id_bouteille_saq" value="' + evt.target.dataset.id_bouteille_saq + '" /><span>' + evt.target.innerHTML + '</span> <button class="btnSupprimerItem">Supprimer</button></div>';
			}
		});

		let les_bouteilles = document.getElementsByName('laDiv');
		mes_achats.addEventListener('click', function(evt){
			if(evt.target.tagName == 'BUTTON'){
				evt.target.parentElement.innerHTML = "";
				for(var i=0; i<les_bouteilles.length; i++){
					if(les_bouteilles[i].innerHTML == '') {
						mes_achats.removeChild(les_bouteilles[i]);
					}
				}
			}			
		});			
	}	
});


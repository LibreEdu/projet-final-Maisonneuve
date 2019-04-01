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

	//Recuperer le bouton recherche et diriger ver le conroleur cellier
	var pageRecherche = document.getElementById('pageRecherche');
	if(pageRecherche){
		pageRecherche.addEventListener('click', function(){
			var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
			var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
			window.location = 'index.php?cellier&action=pageRecherche&id_cellier='+id_cellier;
		});
	};

	//Recuperer le bouton recherche bouteille et le type choisit puis diriger vers le controleur bouteille SAQ
	if(document.getElementById('recherchePar')) {
	let recherchePar = document.getElementById('recherchePar'); 
	recherchePar.addEventListener('change', function(element){
		//ajouter un champ de recherche suplemetaire pour les recherche en numerique
		console.log(recherchePar.value);
		var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
		var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
		var operation = "=";
		var rechercheSpecifique = document.getElementById('rechercheSpecifique');
		var btnRecherche = document.getElementById('btnRecherche');
		let affichageResultat = document.querySelector('.affichageResultat');
		let valeurRechercher = document.querySelector('[name="valeurRechercher"]');
		
		if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
			rechercheSpecifique.style.visibility = 'visible';	
			btnRecherche.style.visibility = "hidden";
			btnRecherche.value = "";		
			//Si la selection est fait on affiche la barre de recherche
			rechercheSpecifique.addEventListener('change', function(element){
				//Faire apparaitre la lingne pour ecrire l'element à rechercher				
				btnRecherche.style.visibility = "visible";
				btnRecherche.value = "";	
				//Recupérer la valeur de la selection éffectuer
				operation = rechercheSpecifique.options[rechercheSpecifique.selectedIndex].value;
			},false);
		}

		else if (recherchePar.value === 'nom' || recherchePar.value === 'type' || recherchePar.value === 'pays'){
			rechercheSpecifique.style.visibility = 'hidden';
			//Faire apparaitre la lingne pour ecrire l'element à rechercher
			btnRecherche.style.visibility = "visible";
			btnRecherche.value = "";
		}

		btnRecherche.addEventListener('keyup',function(e){
			if (e.keyCode === 13) {	
				if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
					console.log(isNaN(btnRecherche.value));
					if (isNaN(btnRecherche.value)) {
						alert("Veuiller entrer un chiffre!");
						btnRecherche.value = "";
					}
				}				
				if(affichageResultat){
					affichageResultat.innerHTML = '';	
					//Cree un tableau de paramétre pour pour les envoyés au controleur SAQ 
					var params = {
						'id_cellier':id_cellier,
						'recherchePar':recherchePar.value,
						'valeur':valeurRechercher.value,
						'operation': operation										
					};
					let requete = new Request('index.php?cellier&action=recherche', {method: 'POST', body: JSON.stringify(params)});
					fetch(requete)
					.then(response => {
						if (response.status === 200) {
							return response.json();
						} else {
						throw new Error('Erreur');
						}
					})
					.then(response => {
						if (response===0) {
							alert("Aucune reponse pour cette recheche. Veuiller reessayer!");
							btnRecherche.value = "";
						}
						else {
							response.forEach(function(element){
								affichageResultat.innerHTML += '<li '
								+ 'data-id="' + element.id_bouteille_saq + '" '
								+ 'data-prix="' + element.prix + '"'
								+ 'data-millesime="' + element.millesime + '"'
								+ 'data-pays="' + element.pays + '"'
								+ 'data-format="' + element.format + '"'
								+ '>'
								+ element.nom +' - '+element.prix+'$</li>';
							});
						}
					}).catch(error => {
						console.error(error);
					});				
				}
			}	
		},false);
	},false);
	}
	
	//Recuperer le bouton recherche bouteille et le type choisit puis diriger vers le controleur bouteille SAQ
	/*let btnRechercheBouteille = document.getElementById('btnRecherche');
	if(btnRechercheBouteille){
		btnRechercheBouteille.addEventListener('keyup', function(e){
			if (e.keyCode === 13) {	
				let recherchePar = document.querySelector('[name="recherchePar"]');
				let inputNomBouteille = document.querySelector('[name="nom_bouteille"]');
				let liste = document.querySelector('.autoComplete');
				if(liste){
					liste.innerHTML = '';	
					var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
					var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
					//ajouter un champ de recherche suplemetaire pour les recherche en numerique
					recherchePar.addEventListener('change', function(element){
						alert('ss');
						if (element.value === 'prix') {

							var rechercheSpecifique = document.getElementById('recherchePlusSpecifique');
							rechercheSpecifique.innerHTML = '';
							rechercheSpecifique.innerHTML += '<select>'
							+ '<option valeur="plusGrandQue">plus grand que</option>'
							+ '<option valeur="plusPetitQue">plus petit que</option>'
							+ '</select>';
						};
					},false);
					var params = {
						'id_cellier':id_cellier,
						'recherchePar':recherchePar.value,
						'valeur':inputNomBouteille.value										
					};
					console.log(params);
					let requete = new Request('index.php?bouteille_SAQ&action=recherche', {method: 'POST', body: JSON.stringify(params)});
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
			}
		},false);
	};*/
	
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
				quantite.innerHTML = 'Quantité : '+ response.quantite;
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
				quantite.innerHTML = 'Quantité : '+ response.quantite;
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
				let requete = new Request('index.php?liste_achat&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + un_nom + '"}'});
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
						//console.log(response);
					} )
				}).catch(error => {
					console.error(error);
				});
			}
		} );

		let mes_achats = document.getElementById('mes_achats');
		la_liste.addEventListener('click', function(evt){
			if(evt.target.tagName == 'LI'){
				mes_achats.innerHTML += '<div name="laDiv" class="mdl-textfield mdl-js-textfield"><input type="hidden" name="id_bouteille_saq[]" value="' + evt.target.dataset.id_bouteille_saq + '" /><span>' + evt.target.innerHTML + '</span> <button class="btnSupprimerItem">Supprimer</button></div>';
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
		
		/*if(document.querySelectorAll('.details')){
			document.querySelectorAll('.details').style.display = "none";
			console.log(document.querySelectorAll('.details')[0]);		
		};
		let liste_achats = document.getElementsByName('achats');

		liste_achats.addEventListener('click', function(evt){
			if(evt.target.tagName == 'BUTTON'){
				if(evt.target.nextSibling.style.display == "none"){
					evt.target.nextSibling.style.display = "initial";
				}
				else {
					evt.target.nextSibling.style.display = "none";
				}*/
		document.querySelectorAll('.afficher_details').forEach(function(element){
			element.addEventListener('click', function(evt){
				console.log(document.querySelectorAll('.afficher_details').value);
				window.location = 'index.php?listee&action=ajouter_list';
			});
		});
	}	
});


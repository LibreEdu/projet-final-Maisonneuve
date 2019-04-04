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
	// En cliquant sur le bouton ajouter cellier il le redirige vers le controleur cellier
	let btnAjouterCellier = document.getElementById('btnAjouterCellier');
	if(btnAjouterCellier){
		btnAjouterCellier.addEventListener('click', function(){
			window.location = 'index.php?cellier&action=ajouter-form';
		});
	};

	// En cliquant sur le bouton visiter, il recupere le id du cellier et le redirige vers le controlleur bouteille
	document.querySelectorAll('.btnVisiterCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id_cellier = evt.target.parentElement.dataset.id_cellier;
			console.log(id_cellier);
			window.location = 'index.php?cellier&action=voir&id_cellier='+id_cellier;
		});
	});

	// En cliquant sur le boutton supprimer cellier il le supprime le cellier au complet et redirige vers le controleur cellier
	document.querySelectorAll('.btnSupprimerCellier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id_cellier = evt.target.parentElement.dataset.id_cellier;
			// Affichage de message de confirmation de suppression
			var confirmSuppression = confirm("Êtes-vous sûr de vouloir supprimer votre cellier avec tous les boutteilles?");
			console.log(confirmSuppression);
			// Si la suppression à été confirmer, il fait appelle au controleur cellier pour après, faire appelle à l'action de suppression
			if (confirmSuppression) {
				let requete = new Request('index.php?cellier&action=supprimer', {method: 'POST', body: '{"id_cellier": ' + id_cellier + '}'});
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
			}
		});
	});

	// Recuperer le bouton ajouter bouteille et diriger vers le controleur bouteille
	let btnAjouterBouteille = document.getElementById('btnAjouterBouteille');
	var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
	var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
	console.log(id_cellier);
	if(btnAjouterBouteille){
		btnAjouterBouteille.addEventListener('click', function(){
			window.location = 'index.php?bouteille&action=ajouter-form&id_cellier='+id_cellier;
		});
	};

	// Récuperer la class de bouton supprimer pour supprimer une bouteiile spécifique
	document.querySelectorAll('.supprimerBouteille').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id_bouteille_supprimer = evt.target.dataset.id_bouteille_supprimer;
			// Affichage de message de confirmation de suppression
			var confirmSuppression = confirm("Êtes-vous sûr de vouloir supprimer ce boutteille?");
			console.log(confirmSuppression);
			if (confirmSuppression) {
				let requete = new Request("index.php?bouteille&action=supprimer_bouteille", {method: 'POST', body: '{"id_bouteille_supprimer": ' + id_bouteille_supprimer + '}'});
				fetch(requete)
				.then(response => {
					if (response.status === 200) {
						return response.json();
					} else {
						throw new Error('Erreur');
					}
				})
				.then(response => {
					var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
					var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
					window.location = 'index.php?cellier&action=voir&id_cellier='+id_cellier;;
				}).catch(error => {
					console.error(error);
				});
			};
 		})
	});


	// Recuperer le bouton recherche et diriger ver le conroleur cellier
	var pageRecherche = document.getElementById('pageRecherche');
	if(pageRecherche){
		pageRecherche.addEventListener('click', function(){
			var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
			var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier window.location = 'index.php?cellier&action=pageRecherche&id_cellier='+id_cellier;
			window.location = 'index.php?cellier&action=pageRecherche&id_cellier='+id_cellier;
		});
	};

	// Recuperer le bouton recherche bouteille et le type choisit puis diriger vers le controleur bouteille SAQ
	var recherchePar = document.getElementById('recherchePar'); 
	var affichageResultat = document.querySelector('.affichageResultat');
	var affichageDetails = document.getElementById('affichageDetails');
	var rechercheSpecifique = document.getElementById('rechercheSpecifique');
	var valeurRechercher = document.getElementById('valeurRechercher');
	var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
	var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
	var operation = "=";
	// Si le bouton recherche est cliqué
	if(recherchePar) {	
		recherchePar.addEventListener('change', function(element){
			affichageResultat.innerHTML = '';
			affichageDetails.style.visibility = 'hidden';
			valeurRechercher.value = "";					
			// Faire une division dans les champs choisit, et selon les champs choisit il affiche les champs appropriee
			if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
				rechercheSpecifique.style.visibility = 'visible';	
				valeurRechercher.style.visibility = "hidden";
				valeurRechercher.value = "";		
				// Si la selection est fait on affiche la barre de recherche pour entrer l'element à rechercher
				rechercheSpecifique.addEventListener('change', function(element){
					affichageResultat.innerHTML = '';	
					affichageDetails.style.visibility = 'hidden';			
					valeurRechercher.style.visibility = "visible";
					valeurRechercher.value = "";	
					// Recupérer la valeur de la selection éffectuer
					operation = rechercheSpecifique.options[rechercheSpecifique.selectedIndex].value;
				});
			}

			// Si nom, type ou pays sont choisit (qui sont pas des integer), on affiche la barre de recherche
			else if (recherchePar.value === 'nom' || recherchePar.value === 'type' || recherchePar.value === 'pays'){
				affichageDetails.style.visibility = 'hidden';
				rechercheSpecifique.style.visibility = 'hidden';
				//Faire apparaitre la lingne pour ecrire l'element à rechercher
				valeurRechercher.style.visibility = "visible";
				valeurRechercher.value = "";
			}
		},false);
	}

	// Si la valeur à rechercher existe
	if (valeurRechercher) {
		valeurRechercher.addEventListener('keyup',function(e){
			if (e.keyCode === 13) {	
				affichageDetails.style.visibility = 'hidden';
				affichageResultat.innerHTML = '';
				if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
					// Si la recherche n'a pas eu de réslutat
					if (isNaN(valeurRechercher.value)) {
						alert("Veuiller entrer un chiffre!");
						valeurRechercher.value = "";
					}
				}				
				if(affichageResultat){
					affichageResultat.innerHTML = '';	
					// Crer un tableau de paramétre pour pour les envoyés au controleur SAQ 
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
						if (response==false) {
							alert("Aucune reponse pour cette recheche. Veuiller reessayer!");
							valeurRechercher.value = "";
						}
						else {
							// Création de Li pour afficher le ou les résultat obtenu par la recherche
							response.forEach(function(element){
								affichageResultat.innerHTML += '<li '
								+ 'data-nom="' + element.nom + '" '
								+ 'data-id_bouteille="' + element.id_bouteille + '" '
								+ 'data-millesime="' + element.millesime + '"'
								+ 'data-type="' + element.type + '"'
								+ 'data-pays="' + element.pays + '"'
								+ 'data-format="' + element.format + '"'
								+ 'data-quantite="' + element.quantite + '"'
								+ 'data-date_achat="' + element.date_achat + '"'
								+ 'data-boire_avant="' + element.boire_avant + '"'
								+ 'data-prix="' + element.prix + '"'
								+ 'data-code_saq="' + element.code_saq + '"'
								+ '>'
								+ element.nom +'</li>';
							});
						}
					}).catch(error => {
						console.error(error);
					});				
				}
			}	
		},false);
	}	

	// Récuperation des champs invisibles dans vues/cellier/recherche.php 
	let bouteille = {
		nom : document.getElementById('nom_bouteille'),
		millesime : document.getElementById('millesime'),
		type : document.getElementById('type'),
		format : document.getElementById('format'),
		pays : document.getElementById('pays'),
		quantite : document.getElementById('quantite'),
		date_achat : document.getElementById('date_achat'),
		boire_avant : document.getElementById('boire_avant'),
		prix : document.getElementById('prix'),
		code_saq : document.getElementById('code_saq')
	};

	// Si il ya eu des résultats de recherche effectuer précédemment, il insert les données obtenue à l'interieur des champs qui sont récuperer au paravant
	if(affichageResultat){
		affichageResultat.addEventListener('click', function(evt){
			affichageDetails.style='display';
			if(evt.target.tagName == 'LI'){			
				bouteille.nom.innerHTML = evt.target.dataset.nom;
				// Si il exisite des détails qui sont vides, il les supprime dans l'affichage des résultats
				if (evt.target.dataset.millesime!="null") {
					bouteille.millesime.innerHTML = evt.target.dataset.millesime+ ', ' +evt.target.dataset.type;
				}	
				else {
					bouteille.millesime.innerHTML = " ";
					bouteille.type.innerHTML = evt.target.dataset.type;	
				}				
				bouteille.pays.innerHTML = evt.target.dataset.pays+', '+evt.target.dataset.format;
				bouteille.quantite.innerHTML = "Quantité : ";
				bouteille.quantite.innerHTML += evt.target.dataset.quantite;
				if (evt.target.dataset.date_achat!="null") {
					bouteille.date_achat.innerHTML = "Date d'achat : ";
					bouteille.date_achat.innerHTML += evt.target.dataset.date_achat;
				}	
				else {
					bouteille.date_achat.innerHTML = " ";
				}	
				if (evt.target.dataset.boire_avant!="null") {
					bouteille.boire_avant.innerHTML = "Boire avant : ";
					bouteille.boire_avant.innerHTML += evt.target.dataset.boire_avant;
				}	
				else {
					bouteille.boire_avant.innerHTML = " ";
				}
				bouteille.prix.innerHTML = evt.target.dataset.prix;
				bouteille.prix.innerHTML += '$';
				if (evt.target.dataset.code_saq!="null") {
					bouteille.code_saq.innerHTML = "<img src='https://s7d9.scene7.com/is/image/SAQ/"+evt.target.dataset.code_saq+"_is?$saq-rech-prod-gril$'>";
				}
				else {
					bouteille.code_saq.innerHTML = "<img src='../www/images/vin_rouge.jpg'>";
				}
			}
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
	
	// Recuperer les boutons modifier bouteille et l'id' puis diriger vers le controleur bouteille
	var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
	var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
	document.querySelectorAll('.btnModifier').forEach(function(element){
		element.addEventListener('click', function(evt){
			let id = evt.target.parentElement.dataset.id;
			window.location = 'index.php?bouteille&action=modifier-form&id='+id+'&id_cellier='+id_cellier;
		});
	});

	// Recuperer les éléments inputNomBouteille et liste du document
	let inputNomBouteille = document.querySelector('[name="nom_bouteille"]');
	let liste = document.querySelector('.listeAutoComplete');

	// Si il y a une element avec l'id recherche, il le cache
	if(document.getElementById('recherche')){
		document.getElementById('recherche').style.display = "none";
	};

	// Si il y a une element avec l'id afficher, il va ajouter la fonction onclick pour cacher/afficher l'élément avec l'id recherche
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

	//Si il y'a une valeur dans le champ inputNomBouteille, il fait une requête de concordance dans la table vino_bouteilles_saq
	if(inputNomBouteille){
		inputNomBouteille.addEventListener('keyup', function(evt){
			let nom = inputNomBouteille.value;
			if (liste) {
				liste.innerHTML = '';
				if(nom){
					let requete = new Request('index.php?liste_achat&action=saisie-semi-automatique', {method: 'POST', body: '{"nom": "' + nom + '"}'});
					fetch(requete)
					.then(response => {
						if (response.status === 200) {
							return response.json();
						} else {
						throw new Error('Erreur');
						}
					})
					.then(response => {
						// Pour chaque concordance on affiche les valeurs
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
						})
					}).catch(error => {
						console.error(error);
					});
				};
			};
		});

		//Recuperation des champs pour les assigner un objet bouteille
		let bouteille = {
			nom : document.getElementById('nom_bouteille'),
			millesime : document.getElementById('millesime'),
			prix : document.getElementById('prix'),
			pays : document.getElementById('pays'),
			format : document.getElementById('format'),
			id_type : document.querySelector('[name="type"]'),
			code_saq : document.querySelector('[name="code_saq"]')
		};

		// Si la liste existe
		if(liste){
			liste.addEventListener('click', function(evt){
				// On assigne les valeurs à l'objet bouteille
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
	
	/*let btnAjouter = document.querySelector('[name="ajouterBouteilleCellier"]');
	
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
			'id_cellier':id_cellier
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
	}*/

	// Recuperer les éléments NomBouteille et la_liste du document
	let NomBouteille = document.querySelector('[name="une_bouteille"]');
	let la_liste = document.querySelector('.listeBouteilles');
	
	//Si il y'a une valeur dans le champ NomBouteille, il fait une requête de concordance dans la table vino_bouteilles_saq
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
					// Pour chaque concordance on affiche les valeurs
					response.forEach(function(element){
						la_liste.innerHTML += '<li data-id_bouteille_saq="' + element.id_bouteille_saq + '">' + element.nom + '</li>';
					} )
				}).catch(error => {
					console.error(error);
				});
			}
		} );

		// Récupérer l'élément mes_achats
		let mes_achats = document.getElementById('mes_achats');

		// Assigner l'événement click à chaque li et afficher le résultat
		la_liste.addEventListener('click', function(evt){
			if(evt.target.tagName == 'LI'){
				mes_achats.innerHTML += '<div name="laDiv" class="bouteille_liste"><input type="hidden" name="id_bouteille_saq[]" value="' + evt.target.dataset.id_bouteille_saq + '" /><table style="width:100%;"><tr><td style="width:90%;">' + evt.target.innerHTML + '</td><td style="width:10%;"><button class="mdl-button mdl-js-button mdl-button--raised"><i class="far fa-trash-alt"></i></button></td><tr></table></div>';				
				la_liste.innerHTML = '';
				NomBouteille.value = '';
			}
		});

		// Récupérer les div avec le nom laDiv
		let les_bouteilles = document.getElementsByName('laDiv');

		// Assigner l'événement click l'élément mes_achats, le vider et supprimer l'enfant vide
		mes_achats.addEventListener('click', function(evt){
			if(evt.target.tagName == 'BUTTON'){
				for(var i=0; i<les_bouteilles.length; i++) {
					mes_achats.removeChild(les_bouteilles[i]);
				}
			}			
		});
	}	

	// Récupérer les éléments id_nom et les boutons supprimer pour chacun
	let id_nom = document.getElementsByName('le_nom');
	let bouton = document.getElementsByName('btnSupprimerListe');

	// Pour chaque bouton, assigner l'événement click et le diriger vers le contrôleur Liste_Achat pour supprimer la liste dont l'id est envoyé
	for(var i=0; i<id_nom.length; i++){
		let nomsListe = id_nom[i].value;
		bouton[i].addEventListener('click', function(evt){
			window.location = 'index.php?liste_achat&action=supprimer_liste_achat&id_liste_achat='+nomsListe;
		});
	}
});


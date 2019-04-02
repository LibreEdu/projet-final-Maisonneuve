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
			console.log($id_cellier);	
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
	var recherchePar = document.getElementById('recherchePar'); 
	var affichageResultat = document.querySelector('.affichageResultat');
	var affichageDetails = document.getElementById('affichageDetails');
	var rechercheSpecifique = document.getElementById('rechercheSpecifique');
	var btnRecherche = document.getElementById('btnRecherche');
	var url_array = document.URL.split('=') //Divise le url en array avec = commme separateur
	var id_cellier = url_array[url_array.length-1];//Obtien le dernier parametre de array qui est le id du cellier
	var operation = "=";

	if(recherchePar) {	
		recherchePar.addEventListener('change', function(element){
			affichageResultat.innerHTML = '';
			affichageDetails.style.visibility = 'hidden';
			btnRecherche.value = "";					
			
			if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
				rechercheSpecifique.style.visibility = 'visible';	
				btnRecherche.style.visibility = "hidden";
				btnRecherche.value = "";		
				//Si la selection est fait on affiche la barre de recherche
				rechercheSpecifique.addEventListener('change', function(element){
					affichageResultat.innerHTML = '';
					//Faire apparaitre la lingne pour ecrire l'element à rechercher	
					affichageDetails.style.visibility = 'hidden';			
					btnRecherche.style.visibility = "visible";
					btnRecherche.value = "";	
					//Recupérer la valeur de la selection éffectuer
					operation = rechercheSpecifique.options[rechercheSpecifique.selectedIndex].value;
				});
			}

			else if (recherchePar.value === 'nom' || recherchePar.value === 'type' || recherchePar.value === 'pays'){
				affichageDetails.style.visibility = 'hidden';
				rechercheSpecifique.style.visibility = 'hidden';
				//Faire apparaitre la lingne pour ecrire l'element à rechercher
				btnRecherche.style.visibility = "visible";
				btnRecherche.value = "";
			}
		},false);
	}

	if (btnRecherche) {
		btnRecherche.addEventListener('keyup',function(e){
			if (e.keyCode === 13) {	
				affichageDetails.style.visibility = 'hidden';
				affichageResultat.innerHTML = '';
				if (recherchePar.value === 'millesime' || recherchePar.value === 'prix' || recherchePar.value === 'quantite') {
					//Si la recherche n'a pas eu de reslutat
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
						'valeur':btnRecherche.value,
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
							btnRecherche.value = "";
						}
						else {
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

	//Recuperation des champs invisibles dans vues/cellier/recherche.php 
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

	//Si il ya eu des resultats, il insert les donnees obtenue a l'interieur des champs qui sont recuperer au par boire_avant
	if(affichageResultat){
		affichageResultat.addEventListener('click', function(evt){
			affichageDetails.style='display';
			if(evt.target.tagName == 'LI'){			
				bouteille.nom.innerHTML = evt.target.dataset.nom;
				if (evt.target.dataset.millesime!="null") {
					bouteille.millesime.innerHTML = evt.target.dataset.millesime;
				}	
				else {
					bouteille.millesime.innerHTML = " ";
				}	
				bouteille.type.innerHTML = evt.target.dataset.type;				
				bouteille.pays.innerHTML = evt.target.dataset.pays;
				bouteille.format.innerHTML = evt.target.dataset.format;
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
					bouteille.code_saq.innerHTML = "<img src='../divers/images/bouteille.jpg'>";
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
						})
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
				la_liste.innerHTML = '';
				NomBouteille.value = '';
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


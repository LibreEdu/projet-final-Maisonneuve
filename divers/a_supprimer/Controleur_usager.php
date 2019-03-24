<?php
	class Controleur_Usager extends BaseControleur
	{
		public function traite(array $params)
		{
			switch($params['action'])
			{
				case 'afficheUsagers':
					$modeleUsager = $this->getDAO('Usager');
					
					$donnees['usager'] = $modeleUsager->obtenir_tous();
					
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					//$this->afficheVue('cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;
				default :
					trigger_error('Action invalide.');
			}
		}

		// /*=====  Fonction d'affichage du formulaire d'ajout d'un sujet  ======*/
		
		// public function afficheFormInscription($erreurs = "")
		// {
		// 	// Récupérer le modèle sujets
		// 	$modeleUsager = $this->getDAO("Usager");
		// 	// Récupérer la liste des sujets
		// 	$donnees["usager"] = $modeleUsager->obtenir_tous();
		// 	// $donnees["Sujets"] = $modeleSujets->ObtenirTousParReponses();

		// 	// Remplir le tableau erreurs
		// 	$donnees["erreurs"] = $erreurs;
		// 	// Afficher le formulaire Ajouter un sujet
		// 	$vue = "inscription";
		// 	$this->afficheVue($vue, $donnees);
		// }

	}

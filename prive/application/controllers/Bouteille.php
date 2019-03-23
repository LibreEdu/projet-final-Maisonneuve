<?php
	class Controleur_Bouteille extends BaseControleur
	{
		public function traite(array $params)
		{
			// On vérifie que l’usagé est bien connecté
			if ( ! isset($_SESSION["idUsager"]) )
			{
				header('Location: ' . BASEURL );
			}
			switch($params['action'])
			{
				case 'index':
					$modeleBouteille = $this->getDAO('Bouteille');
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'visiterCellier':

					// Recuperation de nom de cellier pour l'afficher en haut de la page
					$modeleCellier = $this->getDAO('Cellier');
					$idCellier = $modeleCellier->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

					if ($idCellier == null) {
						header('Location: ' . BASEURL . 'index.php?login&action=logout');
					}

					// Recuperation de tous les bouteilles qui appartient a un cellier specifique
					$modeleBouteille = $this->getDAO('Bouteille');
					$resultat = $modeleCellier->obtenir_par_id_cellier($_GET['id']);
					$donnees['bouteilles'] = $modeleBouteille->lireAvecType($_GET['id']);
					$monCellier = $resultat[0];
					$donnees['cellier'] = $monCellier->nom;


					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'modifier-form':

					$modeleBouteille = $this->getDAO('Bouteille');
					$idBouteille = $modeleBouteille->verifParUsager($_GET['id'],$_SESSION["idUsager"]);

					if ($idBouteille == null) {
						header('Location: ' . BASEURL . 'index.php?login&action=logout');
					}
					
					$donnees['bouteille'] = $modeleBouteille->obtenir_par_id($_GET['id']);
					$modeleType = $this->getDAO('Type');
					$donnees['types'] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION["idUsager"]);
					$donnees['titre'] = 'Modifier Bouteille';
					$donnees['actionBouton'] = 'modifier';
					$donnees['titreBouton'] = 'Modifier la bouteille';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('bouteille/formulaire', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'modifier':
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->modifierBouteille();
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					echo '<script>alert("La bouteille a été modifiée.")</script>';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'ajouter':
					// Recuperation de tous les bouteilles qui appartient a un cellier specifique
					$modeleBouteille = $this->getDAO('Bouteille');
					$resultat = $modeleBouteille->obtenir_par_id_cellier($_POST['id_cellier']);
					$donnees['bouteilles'] = $modeleBouteille->lireAvecType($_POST['type']);
					$monCellier = $resultat[0];
					$donnees['cellier'] = $monCellier->nom;
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->ajouterUneBouteille();
					$donnees['bouteilles'] = $modeleBouteille->obtenir_tous();
					echo '<script>alert("La bouteille a été ajoutée.")</script>';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('cellier/cellier', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'boire-js':
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id,-1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);	
					echo json_encode($resultat);
					break;
					
				case 'ajouter-js':
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					$modeleBouteille->modifierQuantiteBouteilleCellier($body->id, 1);
					$resultat = $modeleBouteille->recupererQuantiteBouteilleCellier($body->id);
					// var_dump($resultat);
					echo json_encode($resultat);
					break;
					
				case 'ajouter-form':
					$modeleType = $this->getDAO('Type');
					$donnees['types'] = $modeleType->obtenir_tous();
					$modeleCellier = $this->getDAO('Cellier');
					$donnees['celliers'] = $modeleCellier->obtenir_par_id($_SESSION["idUsager"]);
					$donnees['titre'] = 'Ajouter Bouteille';
					$donnees['actionBouton'] = 'ajouter';
					$donnees['titreBouton'] = 'Ajouter la bouteille';
					$this->afficheVue('modeles/en-tete');
					$this->afficheVue('modeles/menu-usager');
					$this->afficheVue('bouteille/formulaire', $donnees);
					$this->afficheVue('modeles/bas-de-page');
					break;

				case 'saisie-semi-automatique':
					$body = json_decode(file_get_contents('php://input'));
					$modeleBouteille = $this->getDAO('Bouteille');
					$listeBouteilles = $modeleBouteille->autocomplete($body->nom);
					echo json_encode($listeBouteilles);
					break;

				default :
					trigger_error('Action invalide.');
			}
		}
	}

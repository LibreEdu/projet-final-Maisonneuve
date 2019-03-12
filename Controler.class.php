<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @author Alexandre Pachot
 * @version 1.0
 * @update 2019-03-10
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler 
{
	
		/**
		 * Traite la requête
		 * @return void
		 */
		public function gerer()
		{
			
			switch ($_REQUEST['requete'])
			{
				case 'listeBouteille':
					$this->listeBouteille();
					break;
				case 'autocompleteBouteille':
					$this->autocompleteBouteille();
					break;
				case 'ajouterNouvelleBouteilleCellier':
					$this->ajouterNouvelleBouteilleCellier();
					break;
				case 'ajouterBouteilleCellier':
					$this->ajouterBouteilleCellier();
					break;
				case 'boireBouteilleCellier':
					$this->boireBouteilleCellier();
					break;
				case 'alex':
					$this->alex();
					break;
				case 'modifierBouteille':
					$this->modifierBouteille();
					break;
				case 'modifier':
					$this->modifierUneBouteille($_POST['id'], $_POST['nom'], $_POST['millesime'], $_POST['quantite'], $_POST['date_achat'], $_POST['date_buvable'], $_POST['prix'], $_POST['pays'], $_POST['format'], $_POST['type'], $_POST['notes']);
					//$this->modifierLaBouteille($_POST);
					break;
				default:
					$this->accueil();
					break;
			}
		}

		private function accueil()
		{
			$bouteille_cellier = new Bouteille();
			$donnees = $bouteille_cellier->obtenir_liste_bouteilles_cellier(1);
			// var_dump($donnees);die;
			include("vues/entete.php");
			include("vues/cellier.php");
			include("vues/pied.php");
		}
		
		private function alex()
		{
			$bouteille_cellier = new Bouteille();
			$donnees = $bouteille_cellier->obtenir_liste_bouteilles_cellier(1);
			include("vues/entete2.php");
			include("vues/cellier2.php");
			include("vues/pied2.php");
		}

		private function listeBouteille()
		{
			$bte = new Bouteille();
			$cellier = $bte->getListeBouteilleCellier();
			
			echo json_encode($cellier);
				  
		}
		
		private function autocompleteBouteille()
		{
			$bte = new Bouteille();
			//var_dump(file_get_contents('php://input'));
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
			$listeBouteille = $bte->autocomplete($body->nom);
			
			echo json_encode($listeBouteille);
				  
		}
		private function ajouterNouvelleBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			//var_dump($body);
			if(!empty($body)){
				$bte = new Bouteille();
				//var_dump($_POST['data']);
				
				//var_dump($data);
				$resultat = $bte->ajouterBouteilleCellier($body);
				echo json_encode($resultat);
			}
			else{
				include("vues/entete.php");
				include("vues/ajouter.php");
				include("vues/pied.php");
			}
		}
		
		private function boireBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
			$resultat = $bte->recupererQuantiteBouteilleCellier($body->id);
			echo json_encode($resultat);
		}

		private function ajouterBouteilleCellier()
		{
			$body = json_decode(file_get_contents('php://input'));
			
			$bte = new Bouteille();
			$resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
			$resultat = $bte->recupererQuantiteBouteilleCellier($body->id);
			echo json_encode($resultat);
		}

		private function modifierBouteille()
		{
			$bte = new Bouteille();
			$data = $bte->getBouteilleParId($_GET["id"]);
			$type = $bte->listeType();
			include("vues/entete.php");
			include("vues/modifier.php");
			include("vues/pied.php");
		}

		private function modifierUneBouteille($id, $nom, $millesime, $quantite, $date_achat, $date_buvable, $prix, $pays, $format, $type, $notes)
		{
			$bte = new Bouteille();
			
			$data = $bte->modifierBouteille($id, $nom, $millesime, $quantite, $date_achat, $date_buvable, $prix, $pays, $format, $type, $notes);
			$this->accueil();
			
		}
		
}

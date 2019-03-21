<?php
	class Modele_BouteilleSaq extends BaseDAO
	{
		public function getTableName()
		{
			return 'vino_bouteille_saq';
		}
		
		public function getClePrimaire()
		{
			return 'id_bouteille_saq';
		}

		public function getProduits($debut = 0, $nombre = 10) {
			// Initialisation du gestionnaire du client URL.
			$gc = curl_init();
	
			// URL à récupérer.
			curl_setopt($gc, CURLOPT_URL, 'https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?storeId=20002&searchTerm=vin&beginIndex=' . $debut . '&pageSize=' . $nombre);
	
			// Retourne directement le transfert sous forme de chaine au lieu de l’afficher directement.
			curl_setopt($gc, CURLOPT_RETURNTRANSFER, true);
	
			// Pour que le php laisse accesse a https
			curl_setopt($gc, CURLOPT_SSL_VERIFYPEER, false);
	
			// Exécution de la session cURL.
			self::$_pageweb = curl_exec($gc);
	
			// Lecture du dernier code de réponse.
			self::$_status = curl_getinfo($gc, CURLINFO_HTTP_CODE);
	
			// Fermeture de la session.
			curl_close($gc);
	
			$doc = new DOMDocument();
	
			// Activation du mode « recovery », c.-à-d. tentative d’analyser un document mal formé.
			$doc->recover = true;
	
			// Ne lance pas une DOMException en cas d’erreur.
			$doc->strictErrorChecking = false;
	
			// Chargement du code HTML à partir d’une chaîne de caractères (self::$_pageweb)
			// @ : permet de ne pas afficher l’éventuel message d’erreur que pourrait retourner la fonction
			@$doc->loadHTML(self::$_pageweb);
	
			// Recherche tous les éléments qui ont une balise <div>
			$elements = $doc->getElementsByTagName('div');
	
			$nombreDeProduits = 0;
	
			foreach ($elements as $noeud) {
				if (strpos($noeud->getAttribute('class'), 'resultats_product') !== false) {
					$info = self::recupereInfo($noeud);
					//var_dump($info);
					$retour = $this->ajoutProduit($info);
					if ($retour->succes == false) {
						$retour->raison;
					} else {
						$nombreDeProduits++;
					}
				}
			}
			return $nombreDeProduits;
		}
	
	}
?>
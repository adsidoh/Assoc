<?php 
	/*
	* @Module: Fournitures
	* @Objectif: Gestion des fourniture de l'association, principalement des livres.
	* @Vue: bal_vue_e001_users 
	*/
	class FournituresController extends AppController {

		/**
		 * Fonction permettant d'effectuer un traitement avant l'action
		 */
		public function beforeFilter(){
			parent::beforeFilter();
		}
		
		/**
		 * Action permettant d'accéder à un bon d'opération et lui ajouter/supprimer des livres
		 */
		public function E300($bonOperationId=null, $classeId=null, $coursId=null){

			// Dans Students controller, recuperation de l'id (InterlocuteurId de l'eleve) et ecriture dans la variable de session

			$precal = $this->Fourniture->query("SELECT * FROM  ")

			/**
			 * Permet de récupérer les lignes de bons
			 */
			$queryLigneDeBon = $this->Fourniture->query("SELECT DISTINCT * FROM bal_vue_e300_lignedebon WHERE BonOperationId=$bonOperationId;");
			$quantiteProduit = $this->Fourniture->query("SELECT SUM(Nombre) FROM bal_vue_e300_lignedebon WHERE BonOperationId=$bonOperationId;");

			// Pour chaque ligne de bon calcul les totaux
			for ($i=0; $i < sizeof($queryLigneDeBon); $i++) { 
				foreach ($queryLigneDeBon[$i]['bal_vue_e300_lignedebon'] as $key => $value) {
					$lignedebon[$i][$key] = $value;
				}
			}
			
			//debug($queryLigneDeBon);  die();
			$prixTotal = 0;
			if (!empty($lignedebon)) {
				
				
				for($i=0 ; $i < sizeof($lignedebon); $i++){
					$prixTotal +=  $lignedebon[$i]['Nombre'] * $lignedebon[$i]['PrixSpecial'];
				}

			}
			
			// Envoi de tous les lignes de bons
			if (isset($lignedebon)) $this->set('lignedebon', $lignedebon);

			//die();
			// Envoi nombre de produit
			if (isset($quantiteProduit)) $this->set('quantiteProduit', $quantiteProduit[0][0]['SUM(Nombre)']);
			// Envoi nombre de produit
			if (isset($prixTotal)) $this->set('prixTotal', $prixTotal);

			/**
			 * Permet de récupérer les bons
			 */
			$queryBon = $this->Fourniture->query(
				"SELECT * FROM bal_vue_e300_bon WHERE BonOperationId=$bonOperationId;"
			);
			for ($i=0; $i < sizeof($queryBon); $i++) { 
				foreach ($queryBon[$i]['bal_vue_e300_bon'] as $key => $value) {
						$bon[$key] = $value;			
				}
			}
			// Envoi de tous les bons
			if (isset($bon)) $this->set('bon', $bon);
			$this->set('bonOperationId', $bonOperationId);

			/**
			 * Permet de récupérer les produits
			 */
			if ($classeId != null && $coursId != null) {
				$queryProduit = $this->Fourniture->query(
					"SELECT CodeBarre, OptionNom FROM bal_vue_e300_produit WHERE CoursId=$coursId AND ClasseId=$classeId AND Fin IS NULL;"
				);
				for ($i=0; $i < sizeof($queryProduit); $i++) { 
						$produit['CodeBarre'] = $queryProduit[$i]['bal_vue_e300_produit']['CodeBarre'];
						$produit['OptionNom'] = $queryProduit[$i]['bal_vue_e300_produit']['OptionNom'];
				}
			}
			else {
				$produit = null;
			}
			// Envoi de tous les bons
			$this->set('produit', $produit);
			$this->set('currentCoursId', $coursId);

			/**
			 * Permet de récupérer les disciplines
			 */
			$EtablissementId = $this->Session->read('Association.EtablissementId');
			if (!is_null($classeId)) {
				$queryDiscipline = $this->Fourniture->query("SELECT CoursId, OptionNom, CoursNom FROM bal_vue_e300_discipline WHERE ClasseId=$classeId AND EtablissementId=$EtablissementId GROUP BY CoursId;");
				for ($i=0; $i < sizeof($queryDiscipline); $i++) { 
					$discipline[$i]['CoursId'] = $queryDiscipline[$i]['bal_vue_e300_discipline']['CoursId'];		
					$discipline[$i]['OptionNom'] = $queryDiscipline[$i]['bal_vue_e300_discipline']['OptionNom'];
					$discipline[$i]['CoursNom'] = $queryDiscipline[$i]['bal_vue_e300_discipline']['CoursNom'];
				}
			}
			else {
				$discipline = null;
			}
			// Envoi de toutes les disciplines
			$this->set('discipline', $discipline);
			$this->set('currentClasseId', $classeId);

			/**
			 * Permet de récupérer les classes
			 */
			$queryClasse = $this->Fourniture->query(
				"SELECT ClasseDesignation, ClasseId FROM bal_vue_e201_classe
				WHERE EtablissementId=$EtablissementId AND Fin IS NULL;"
			);
			for ($i=0; $i < sizeof($queryClasse); $i++) { 
				$classe[$queryClasse[$i]['bal_vue_e201_classe']['ClasseId']] = $queryClasse[$i]['bal_vue_e201_classe']['ClasseDesignation'];		
			}
			// Envoi de toutes les classes
			if (isset($classe)) $this->set('classe', $classe);
		
			if($this->request->is("post")) 	{
				$this->Session->setFlash('Livre ajouté.', 'flash/success');
				$this->redirect(array('action'=>'E300'));
			}

			/**
			 * Permet de récupérer tous les nom de vetusté
			 */
			$queryVetustenom = $this->Fourniture->query("SELECT vetustenom FROM bal_vetuste;");
			for ($i=0; $i < sizeof($queryVetustenom); $i++) { 
				foreach ($queryVetustenom[$i]['bal_vetuste'] as $key => $value) {
						$vetustenom[$value] = $value;			
				}
			}
			// Envoi de tous les noms de vetusté
			if (isset($vetustenom)) $this->set('vetustenom', $vetustenom);

			/**
			 * Permet de récupérer tous les statuts de stockage
			 */
			$queryStatutStockage = $this->Fourniture->query("SELECT StatutDeStockageNom FROM bal_statutdestockage;");
			for ($i=0; $i < sizeof($queryStatutStockage); $i++) { 
				foreach ($queryStatutStockage[$i]['bal_statutdestockage'] as $key => $value) {
						$statutStockage[$value] = $value;			
				}
			}
			// Envoi de tous les noms de vetusté
			if (isset($statutStockage)) $this->set('statutStockage', $statutStockage);

		}

		/**
		 * Action permettant de créer un nouveau bon d'opération Commande, Reprise, etc...
		 */
		public function E300new($typedebon) {
			/**
			*	Pour avoir l'id de l'interlocuteur ( Eleve )
			*/
			
			$newOperation['PSessionId'] = $_SESSION['Auth']['User']['SessionId'];
			$newOperation['PBonOperationId'] = null;
			$newOperation['PConseilFCPEId'] = $_SESSION['Association']['ConseilFCPEId'];
			$newOperation['PInterlocuteurId'] = $_SESSION['Dossier']['Eleve']['InterlocuteurId'];
			$newOperation['PTypeDeBonNom'] = $typedebon;
			$newOperation['PExercice'] = $_SESSION['Exercice'];
			/**
			 * Appel de la procédure pour sauvegarder un nouveua bon d'opération
			 */
			$this->makeCall("Save_BAL_Vue_E300_Bon", $newOperation);
			$this->Session->setFlash('Opération créée avec succès.', 'flash/success');
			$sessionid = $_SESSION['Auth']['User']['SessionId'];
			/**
			 * Récupération de l'id du bon d'opération tout juste créé
			 */
			$bonoperationid = $this->Fourniture->query("SELECT MAX(SUIVIIDLastId) FROM bal_suiviid WHERE SUIVIIDSessionId='$sessionid' AND SUIVIIDTableNom='BAL_BonOperation';");
			/**
			 * Redirection vers la page d'ajout/supression de livres de ce bon d'opération
			 */
			$this->redirect(array('action' => 'E300', $bonoperationid[0][0]['MAX(SUIVIIDLastId)']));
		}

		/**
		 * Action permettant d'ajouter des etats de vetusté avec leur taux de reduction
		 */
		public function E301($exercice=null){
			/**
			 * Permet de récupérer tous les exercices existant
			 */
			$queryExercices = $this->Fourniture->query("SELECT DISTINCT Exercice FROM bal_vue_e301_vetuste ORDER BY Exercice DESC;");
			for ($i=0; $i < sizeof($queryExercices); $i++) { 
				foreach ($queryExercices[$i]['bal_vue_e301_vetuste'] as $key => $value) {
						$exercices[$value] = $value;			
				}
			}
			// Envoi de tous les exercices
			if (isset($exercices)) $this->set('exercices', $exercices);
			else $this->set('exercices', null);

			/**
			 * Permet de récupérer l'exercice courrant
			 */
			if ($exercice == null) $currExercice = $_SESSION['Exercice'];
			else $currExercice = $exercice;
			// Envoi de l'exercice demandé
			$this->set('currExercice', $exercice);
			
			/**
			 * Permet de récupérer tous les états de vetusté pour l'exercice choisi
			 */
			$conseilfcpeid = $this->Session->read('Association.ConseilFCPEId');
			$queryRes = $this->Fourniture->query("SELECT * FROM bal_vue_e301_vetuste WHERE ConseilFCPEId=$conseilfcpeid AND Exercice=$currExercice;");
			for ($i=0; $i < sizeof($queryRes); $i++) { 
				foreach ($queryRes[$i]['bal_vue_e301_vetuste'] as $key => $value) {
						$vetuste[$i][$key] = $value;			
				}
			}
			// Envoi du toutes les résultat des états de vetusté
			if (isset($vetuste)) $this->set('vetuste', $vetuste);
			else $this->set('vetuste', null);

			/**
			 * Permet de récupérer tous les type de bon
			 */
			$queryTypedebon = $this->Fourniture->query("SELECT typedebonnom FROM bal_typedebon;");
			for ($i=0; $i < sizeof($queryTypedebon); $i++) { 
				foreach ($queryTypedebon[$i]['bal_typedebon'] as $key => $value) {
						$typedebon[$value] = $value;			
				}
			}
			// Envoi de tous les types de bon
			$this->set('typedebon', $typedebon);

			/**
			 * Permet de récupérer tous les nom de vetusté
			 */
			$queryVetustenom = $this->Fourniture->query("SELECT vetustenom FROM bal_vetuste;");
			for ($i=0; $i < sizeof($queryVetustenom); $i++) { 
				foreach ($queryVetustenom[$i]['bal_vetuste'] as $key => $value) {
						$vetustenom[$value] = $value;			
				}
			}
			// Envoi de tous les types de bon
			$this->set('vetustenom', $vetustenom);
		}

		/**
		 * Fonction permettant de supprimer un état de vetusté avec son taux de réduction
		 */
		public function deleteVetuste($vetusteNom=null, $typedebon=null, $exercice=null) {
			$deleteVetuste['PSessionId'] = $this->Session->read('Auth.User.SessionId');
			$deleteVetuste['PVetusteNom'] = $vetusteNom;
			$deleteVetuste['PConseilFCPEId'] = $this->Session->read('Association.ConseilFCPEId');
			$deleteVetuste['PTypeDeBonNom'] = $typedebon;
			$deleteVetuste['PExercice'] = $exercice;
			/**
			 * Appel de la procédure de suppression de l'état de vétusté
			 */
			$this->makeCall("Delete_BAL_Vue_E301_Vetuste", $deleteVetuste);
			$this->Session->setFlash('Etat de vetusté supprimé.', 'flash/success');
			/**
			 * Redirection vers la page précédente (donc vue E301)
			 */
			$this->redirect($this->referer());
		}

		/**
		 * Fonction permettant de sauvegarder un état de vetusté avec son taux de réduction
		 */
		public function saveVetuste($vetusteNom=null, $typedebon=null, $taux=null, $exercice=null) {
			/**
			 * Si taux correct compris entre 0 et 10
			 */
			if ($taux>=0.00 && $taux<=10.00) {
				$saveVetuste['PSessionId'] = $this->Session->read('Auth.User.SessionId');
				$saveVetuste['PVetusteNom'] = $vetusteNom;
				$saveVetuste['PConseilFCPEId'] = $this->Session->read('Association.ConseilFCPEId');
				$saveVetuste['PTypeDeBonNom'] = $typedebon;
				$saveVetuste['PTaux'] = $taux;
				$saveVetuste['PExercice'] = $exercice;
				/**
				 * Appel de la procédure de sauvegarde de l'état de vetusté
				 */
				$res = $this->makeCall("Save_BAL_Vue_E301_Vetuste", $saveVetuste);
				$this->Session->setFlash('Etat de vetusté ajouté.', 'flash/success');
				/**
				 * Redirection vers la page précédente (donc vue E301)
				 */
				$this->redirect($this->referer());
			}
			/**
			 * Sinon si taux > 10
			 */
			else {
				$this->Session->setFlash('Le taux doit être compris entre 0 et 10.', 'flash/error');
				/**
				 * Redirection vers la page précédente (donc vue E301)
				 */
				$this->redirect($this->referer());
			}
		}

		/**
		 * Fonction permettant d'ajouter une ligne de bon (livre) à un bon d'opération
		 */
		public function addLigneDeBon($bonOperationId, $codeBarre, $nombre) {
			/**
			 * Si $codeBarre et $nombre spécifiés en arguments
			 */
			if (isset($codeBarre, $nombre)) {
				$addLigneDeBon['PSessionId'] = $this->Session->read('Auth.User.SessionId');
				$addLigneDeBon['PContientId'] = null;
				$addLigneDeBon['PBonOperationId'] = $bonOperationId;
				$addLigneDeBon['PCodeBarre'] = $codeBarre;
				$addLigneDeBon['PStatutStockageNom'] = null;
				$addLigneDeBon['PVetusteNom'] = 'Neuf';
				$addLigneDeBon['PNumeroExemplaire'] = null;
				$addLigneDeBon['PNombre'] = $nombre;
				$addLigneDeBon['PPrixSpecial'] = null;

				/**
				 * Appel de la procédure de sauvegarde d'une nouvelle ligne de bon
				 */
				$this->makeCall("Save_BAL_Vue_E300_LigneDeBon", $addLigneDeBon);
				$this->Session->setFlash('Ligne de bon ajoutée.', 'flash/success');
				/**
				 * Redirection vers la page précédente (E300)
				 */
				$_SESSION['Fourniture']['ajouter'] = true;
				$this->redirect($this->referer());
			}
			/**
			 * Si $codeBarre et $nombre non spécifiés en arguments
			 */
			else {
				$this->Session->setFlash('Veuillez spécifier tous les champs.', 'flash/error');
				/**
				 * Redirection vers la page précédente (E300)
				 */
				$this->redirect($this->referer());
			}
		}

		/**
		 * Fonction permettant d'update une ligne de bon (livre) à un bon d'opération
		 */
		public function saveLigneDeBon($contientId, $bonOperationId, $codeBarre, $statutStockage=null, $vetusteNom=null, $nombre=null, $prixSpecial=null) {
			$saveLigneDeBon['PSessionId'] = $this->Session->read('Auth.User.SessionId');
			$saveLigneDeBon['PContientId'] = $contientId;
			$saveLigneDeBon['PBonOperationId'] = $bonOperationId;
			$saveLigneDeBon['PCodeBarre'] = $codeBarre;
			$saveLigneDeBon['PStatutStockageNom'] = $statutStockage;
			$saveLigneDeBon['PVetusteNom'] = $vetusteNom;
			$saveLigneDeBon['PNumeroExemplaire'] = "";
			$saveLigneDeBon['PNombre'] = $nombre;
			$saveLigneDeBon['PPrixSpecial'] = $prixSpecial;
			/**
			 * Appel de la procédure d'update de la ligne de bon
			 */
			$this->makeCall("Save_BAL_Vue_E300_LigneDeBon", $saveLigneDeBon);
			$this->Session->setFlash('Modification effectuée.', 'flash/success');
			/**
			 * Redirection vers la page précédente (E300)
			 */
			$this->redirect($this->referer());
		}

		/**
		 * Fonction permettant de supprimer une ligne de bon (livre) à un bon d'opération
		 */
		public function deleteLigneDeBon($contientId) {
			$deleteLigneDeBon['PSessionId'] = $this->Session->read('Auth.User.SessionId');
			$deleteLigneDeBon['ContientId'] = $contientId;
			/**
			 * Appel de la procédure de suppresion de la ligne de bon
			 */
			$this->makeCall("Delete_BAL_Vue_E300_LigneDeBon", $deleteLigneDeBon);
			$this->Session->setFlash('Ligne de bon supprimée.', 'flash/success');
			/**
			 * Redirection vers la page précédente (E300)
			 */
			$this->redirect($this->referer());
		}

		/**
		 * Action permettant d'ajouter/supprimer des livres à l'établissement rattaché à l'association
		 * NE FONCTIONNE PAS
		 */
		public function E302(/*$classeId=null, $optionNom=null, $coursId=null,*/ $ressourceId=null){
			//$_SESSION['Dossier']['EleveId'] = 5;
			/**
			 * Permet de récupérer les classes
			 */
			/*
			$EtablissementId = $this->Session->read('Dossier.EtablissementId');
			$EtablissementId = 4;
			$queryClasse = $this->Fourniture->query("SELECT ClasseDesignation, ClasseId FROM bal_vue_e201_classe WHERE EtablissementId=$EtablissementId AND Fin IS NULL;");
			for ($i=0; $i < sizeof($queryClasse); $i++) { 
				$classe[$queryClasse[$i]['bal_vue_e201_classe']['ClasseId']] = $queryClasse[$i]['bal_vue_e201_classe']['ClasseDesignation'];		
			}
			// Envoi de toutes les classes
			$this->set('classe', $classe);
			$this->set('currentClasseId', $classeId);
			*/

			/**
			 * Permet de récupérer les options
			 */
			/*
			if (!is_null($optionNom)) {
				$queryOption = $this->Fourniture->query("SELECT OptionNom FROM bal_vue_e201_option WHERE ClasseId=$classeId AND EtablissementId=$EtablissementId GROUP BY OptionNom;");
				for ($i=0; $i < sizeof($queryOption); $i++) { 
					$option[$i]['OptionNom'] = $queryOption[$i]['bal_vue_e201_option']['OptionNom'];
				}
			}
			*/
			// Envoi de toutes les options
			/*
			$this->set('option', $option);
			$this->set('currentOptionNom', $optionNom);*/

			/**
			 * Permet de récupérer les disciplines
			 */
			/*
			if (!is_null($classeId)) {
				$queryDiscipline = $this->Fourniture->query("SELECT CoursId, OptionNom, CoursNom FROM bal_vue_e300_discipline NATURAL JOIN bal_vue_e201_option WHERE ClasseId=$classeId AND EtablissementId=$EtablissementId GROUP BY OptionNom;");
				for ($i=0; $i < sizeof($queryDiscipline); $i++) { 
					$discipline[$i]['CoursId'] = $queryDiscipline[$i]['bal_vue_e300_discipline']['CoursId'];		
					$discipline[$i]['OptionNom'] = $queryDiscipline[$i]['bal_vue_e300_discipline']['OptionNom'];
					$discipline[$i]['CoursNom'] = $queryDiscipline[$i]['bal_vue_e201_option']['CoursNom'];
				}
			}
			else {
				$discipline = null;
			}
			*/
			// Envoi de toutes les disciplines
			/*
			$this->set('discipline', $discipline);
			$this->set('currentCoursId', $coursId);
			*/

			if ($ressourceId!=null) {
				/**
				 * Permet de récupérer tous les types de produits
				 */
				$queryTypeProduit = $this->Fourniture->query("SELECT * FROM bal_vue_e302_produit GROUP BY TypeDeProduitNom;");
				for ($i=0; $i < sizeof($queryTypeProduit); $i++) { 
					$typedeproduit[$i]['TypeDeProduitNom'] = $queryTypeProduit[$i]['bal_vue_e302_produit']['TypeDeProduitNom'];
					$typedeproduit[$i]['EstReutilisable'] = $queryTypeProduit[$i]['bal_vue_e302_produit']['EstReutilisable'];
				}
				// Envoi de tous les types de bon
				$this->set('typedeproduit', $typedeproduit);

				/**
				 * Permet de récupérer les produits
				 */
				$queryProduit = $this->Fourniture->query("SELECT * FROM bal_vue_e302_produit WHERE Fin IS NULL AND RessourceId=$ressourceId;");
				$obtenuDepuis = $this->Fourniture->query("SELECT MIN(Debut) FROM bal_vue_e302_produit WHERE Fin IS NULL AND ConseilFCPEId=5;");
				for ($i=0; $i < sizeof($queryProduit); $i++) { 
					foreach ($queryProduit[$i]['bal_vue_e302_produit'] as $key => $value) {
						$produit[$i][$key] = $value;
					}
				}
				$this->set('produit', $produit);
				$this->set('obtenuDepuis', $obtenuDepuis[0][0]['MIN(Debut)']);
			}
		}

		/**
		 * Fonction permettant de supprimer un produit de l'établissement rattaché à l'association
		 */
		public function deleteProduit($codebarre) {
			$deleteProduit['PSessionId'] = $this->Session->read('Auth.User.SessionId');
			$deleteProduit['PCodeBarre'] = $codebarre;
			/**
			 * Appel de la procédure pour supprimer un produit
			 */
			$this->makeCall("Delete_BAL_Vue_E302_Produit", $deleteProduit);
			$this->Session->setFlash('Produit supprimé.', 'flash/success');
			/**
			 * Redirection vers la page précédente (E302)
			 */
			$this->redirect($this->referer());
		}

		/**
		 * Fonction permettant d'ajouter un produit de l'établissement rattaché à l'association
		 */
		public function saveProduit($ressourceId, $codebarre, $designation, $anneeparution, $editeur, $auteur, $typedeproduit) {
			/**
			 * Si tous les champs renseignés
			 */
			if ($ressourceId!=null && $codebarre!=null && $designation!=null && $anneeparution!=null && $editeur!=null && $typedeproduit!=null) {
				$saveProduit['PSessionId'] = $this->Session->read('Auth.User.SessionId');
				$saveProduit['PRessourceId'] = $ressourceId;
				$saveProduit['PCodeBarre'] = $codebarre;
				$saveProduit['PDesignation'] = $designation;
				$saveProduit['PAnneeParution'] = $anneeparution;
				$saveProduit['PMarqueOuEditeur'] = $editeur;
				$saveProduit['PAuteur'] = $auteur;
				$saveProduit['PTypeDeProduitNom'] = $typedeproduit;
				/**
				 * Appel de la procédure de sauvegarde du produit
				 */
				$this->makeCall("Save_BAL_Vue_E302_Produit", $saveProduit);
				$this->Session->setFlash('Produit ajouté.', 'flash/success');
				/**
				 * Redirection vers la page précédente (E302)
				 */
				$this->redirect($this->referer());
			}
			/**
			 * Si tous les champs ne sont pas renseignés
			 */
			else {
				$this->Session->setFlash('Veuillez spécifier tous les champs.', 'flash/error');
				/**
				 * Redirection vers la page précédente (E302)
				 */
				$this->redirect($this->referer());
			}
		}
	}

 ?>
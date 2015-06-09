<?php 

	class RecherchesController extends AppController {

		/*
		*	appel du beforeFilter parent
		*/
		public function beforeFilter(){
			parent::beforeFilter();
			$this->loadModel('Recherche');
			
		}

		/*
		*	Action permettant l'envoie du comptenu du champ rech dans la vu à l'action find
		*/
		public function seek(){
			unset($_SESSION['Dossier']);
			
			if($this->request->is('post')){
				$this->redirect(array('controller'=>'recherches', 'action'=>'find', $this->request->data['form']['rech']));
			}
		}


		/*
		*	A partir du paramètre recherche toutes association de la variable dans le vue recherche.
		*/
		public function find($var=null){	
			/*
			*	Test si la variable n'est pas vide
			*/
			if(empty($var)){
				$this->Session->setFlash('Recherche vide.', 'flash/error');
				$this->redirect('/');
			}	
			/*
			* remplace les espace pour une meilleur interprétatoin en BDD
			*/
			$var = str_replace(' ', '%', $var);

			/*
			* 	Récupératoins des donénes en BDD
			*/
			$res = $this->Recherche->query("select * from BAL_Vue_Recherche where Exercice=".$_SESSION['Exercice']." AND (Texte like '%$var%' or TelParent like '%$var%' or TelEleve like '%$var%' or BonOperationId='$var' or FactureId='$var')");

			if(!empty($res)){
				/* 
				* 	Filtrage données pour éviter les doubllon de personne
				*/
				foreach ($res as $key => $value) {
					$personne[$value['BAL_Vue_Recherche']['PersonneId']]='';
					$eleve[$value['BAL_Vue_Recherche']['EleveId']]='';

				}

				/*
				*	Formatage des donénes a envoyer a la vue
				*/
				foreach ($personne as $key => $value) {
					$p = $this->Recherche->query('SELECT * FROM `bal_vue_e100_personne` WHERE PersonneId='.$key);
					$parentBis[] = $p[0];
				}
				foreach ($eleve as $key => $value) {
					if($key != ''){
						$e = $this->Recherche->query('SELECT * FROM `bal_vue_e200_eleve` WHERE EleveId='.$key);
						$eleveBis[] = $e[0];
					}
				}
			}
			else{
				$eleveBis=array();
				$parentBis=array();
			}

			/*
			*	Envoie des variables à la vue.
			*/
			$this->set('eleve', $eleveBis);
			$this->set('parent', $parentBis);

		}

		/*
		*	 Permet de clore un dossier ouvert en supprimant les variable de session Dossier
		*/
		public function cloreDossier(){
			unset($_SESSION['Dossier']);
			$this->redirect(array('controller'=>'recherches', 'action'=>'seek'));
		}

		/*
		*	Permet l'ouverture d'un dossier depuis un élève.
		*/
		public function dossierEleve($EleveId = null){
			/*
			*	 Test si la variable passé est non vvide et au format numérique
			*/
			if(empty($EleveId) || !is_numeric($EleveId)){
				$this->redirect(array('action'=>'seek'));
			}

			/*
			*	Récupération des infos de lélève et du parent
			*/
			$eleve=$this->Recherche->query('SELECT * FROM bal_vue_e200_eleve WHERE EleveId='.$EleveId);
			$parent = $this->Recherche->query("SELECT * FROM bal_vue_e100_personne NATURAL JOIN bal_estresponsablelegal WHERE EleveId =".$EleveId);
			
			/*
			*	 Mise en session des variables.
			*/
			$_SESSION['Dossier']['Parent']['InterlocuteurId']= $parent[0]['bal_vue_e100_personne']['InterlocuteurId'];
			$_SESSION['Dossier']['Parent']['ParentId']= $parent[0]['bal_vue_e100_personne']['PersonneId'];
			$_SESSION['Dossier']['Parent']['EndroitId']=  $parent[0]['bal_vue_e100_personne']['EndroitId'];
			$_SESSION['Dossier']['Parent']['PersonneNom']= $parent[0]['bal_vue_e100_personne']['PersonneNom'];
			$_SESSION['Dossier']['Parent']['PersonnePrenom']= $parent[0]['bal_vue_e100_personne']['PersonnePrenom'];

			$_SESSION['Dossier']['Eleve']['EleveId']= $eleve[0]['bal_vue_e200_eleve']['EleveId'];
			$_SESSION['Dossier']['Eleve']['EleveNom']= $eleve[0]['bal_vue_e200_eleve']['EleveNom'];
			$_SESSION['Dossier']['Eleve']['ElevePrenom']= $eleve[0]['bal_vue_e200_eleve']['ElevePrenom'];
			$_SESSION['Dossier']['Eleve']['InterlocuteurId']= $eleve[0]['bal_vue_e200_eleve']['InterlocuteurId'];
			
			$this->redirect(array('controller'=>'Students', 'action'=>'E200Update'));
		}

		/*
		*	Permet l'ouverture d'un dossier depuis un parent.
		*/
		public function dossierPersonne($PersonneID = null){
			/*
			*	 Test si la variable passé est non vvide et au format numérique
			*/
			if(empty($PersonneID) || !is_numeric($PersonneID)){
				$this->redirect(array('action'=>'seek'));
			}

			/*
			*	Récupération des infos du parent
			*/
			$parent = $this->Recherche->query("SELECT * FROM bal_vue_e100_personne WHERE PersonneId=".$PersonneID);
			
			/*
			*	Mise en session des infos du parent
			*/
			$_SESSION['Dossier']['Parent']['InterlocuteurId']= $parent[0]['bal_vue_e100_personne']['InterlocuteurId'];
			$_SESSION['Dossier']['Parent']['ParentId']= $parent[0]['bal_vue_e100_personne']['PersonneId'];
			$_SESSION['Dossier']['Parent']['EndroitId']=  $parent[0]['bal_vue_e100_personne']['EndroitId'];
			$_SESSION['Dossier']['Parent']['PersonneNom']= $parent[0]['bal_vue_e100_personne']['PersonneNom'];
			$_SESSION['Dossier']['Parent']['PersonnePrenom']= $parent[0]['bal_vue_e100_personne']['PersonnePrenom'];
			$eleve=$this->Recherche->query('SELECT DISTINCT EleveId,EleveNom,ElevePrenom FROM bal_vue_e200_eleve NATURAL JOIN bal_estresponsablelegal WHERE PersonneId ='.$PersonneID);
			
			/*
			* Récupération des données des élève associé au parents. Si plusieur élève on affiche le choix sur la page. Si un élève on charge en session les infos. Di pas d'élève on redirige vers la création d'un élève.
			*/
			$cpt = count($eleve);
			if($cpt == 0){
				$this->redirect(array('controller'=>'Student', 'action'=>'E200New'));
			}
			else if($cpt == 1){
				$eleve=$this->Recherche->query('SELECT DISTINCT EleveId,EleveNom,ElevePrenom,InterlocuteurId FROM bal_vue_e200_eleve NATURAL JOIN bal_estresponsablelegal WHERE PersonneId ='.$PersonneID);
				$_SESSION['Dossier']['Eleve']['EleveId']= $eleve[0]['bal_vue_e200_eleve']['EleveId'];
				$_SESSION['Dossier']['Eleve']['EleveNom']= $eleve[0]['bal_vue_e200_eleve']['EleveNom'];
				$_SESSION['Dossier']['Eleve']['ElevePrenom']= $eleve[0]['bal_vue_e200_eleve']['ElevePrenom'];
				$_SESSION['Dossier']['Eleve']['InterlocuteurId']= $eleve[0]['bal_vue_e200_eleve']['InterlocuteurId'];
				$this->redirect(array('controller'=>'Students', 'action'=>'e200Update'));
			}
			else{
				$this->set('eleve', $eleve);
			}
		}

	}
?>

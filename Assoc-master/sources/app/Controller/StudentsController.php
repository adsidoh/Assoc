<?php 
	/*
	* @Module: Eleves
	* @Objectif: Gestion des élèves qui rejoignent l'association
	*/

	class StudentsController extends AppController
	{
		/*
		*	Appel de la Fonction beforeFilter de la class AppController 
		*/
		public function beforeFilter(){
			parent::beforeFilter();
		}

		/*
		*	Action permettant la mise a jour des informations d'un élève
		*/
		public function E200Update($id = null){
			/*
			*	Test de la présence d'un dossier élève ouvert
			*/
			if(!isset($_SESSION['Dossier']['Eleve']['EleveId'])){
				$this->Session->setFlash('Aucun dossier élève selectionné', 'flash/success');
				$this->redirect(array('controller'=>'Students', 'action'=>'E200New'));
			}

			/*
			* 	Récupération des niformations de l'élève
			*/
			$telBis = array();
			$plaBis = array();
			$ele = $this->Student->find('first', array('conditions'=>array('Student.EleveId'=>$_SESSION['Dossier']['Eleve']['EleveId'])));
			$tel = $this->Student->query("SELECT * FROM bal_vue_e200_telephone WHERE InterlocuteurId=".$ele['Student']['InterlocuteurId']);
			$res = $this->Student->query("SELECT * FROM bal_personne INNER JOIN bal_estresponsablelegal ON bal_estresponsablelegal.PersonneId = bal_personne.PersonneId WHERE bal_estresponsablelegal.EleveId =".$ele['Student']['EleveId']);
			$pla = $this->Student->query("SELECT * FROM bal_personne INNER JOIN bal_habite ON bal_personne.PersonneId=bal_habite.PersonneId WHERE bal_habite.EndroitId=".$ele['Student']['EndroitId']);

			/*
			*	Formatage
			*/
			foreach ($res as $key => $value) {
				$resBis[$value['bal_personne']['PersonneId']]=$value['bal_personne']['PersonneNom'].' '.$value['bal_personne']['PersonnePrenom'].' - '.$value['bal_personne']['PersonneId'];
			}

			foreach ($tel as $key => $value) {
				$telBis[]=$value['bal_vue_e200_telephone']['TelephoneNum'];
			}

			$cpt=0;
			foreach ($pla as $key => $value) {
				$plaBis[$pla[$cpt]['bal_habite']['EndroitId']]=$value['bal_personne']['PersonneNom'].' '.$value['bal_personne']['PersonnePrenom'].' - '.$value['bal_personne']['PersonneId'];
				$cpt++;
			}

			$ele['Student']['appellation'] = $ele['Student']['EleveNom'].' '.$ele['Student']['ElevePrenom'].' - '.$ele['Student']['EleveId'];


			//Liste responsable
			$this->set('setResp', $resBis);

			//Liste phone
			$this->set('setPhone', $telBis);

			//Liste Adresse
			$this->set('setPlace', $plaBis);

			//Info Eleve
			$this->set('eleve', $ele);
			
			/*
			*	Sauvegarde du formulaire envoyé
			*/
			if($this->request->is('post')){
				/*
				* 	formatage pour appel makecall
				*/
				$in['PSessionId']=$_SESSION['Auth']['User']['SessionId'];
				$in['PConseilFCPEId']=$_SESSION['Association']['ConseilFCPEId'];
				$in['PEleveId']=$ele['Student']['EleveId'];
				$in['PEleveNom']=$this->request->data['Student']['nom'];
				$in['PElevePrenom']=$this->request->data['Student']['prenom'];
				$in['PEleveMasculin']=($this->request->data['Student']['sexe']=='H');
				$in['PRespLegalId']=$this->request->data['Student']['responsable_legal'];
				$in['PEndroitId']=$_SESSION['Dossier']['Parent']['EndroitId'];
				$in['PEMail']=$this->request->data['Student']['Email'];
				$in['PEMailValide']=0;
				$in['PPassword']='';
				$in['PNumEtVoie']=$this->request->data['Student']['num'];
				$in['PLieuDit']=$this->request->data['Student']['lieudit'];
				$in['PVille']=$this->request->data['Student']['ville'];
				$in['PPays']='France';
				$in['PCodePostal']=$this->request->data['Student']['code_postal'];
				$in['PApptBatResidence']=$this->request->data['Student']['appbatres'];
				$in['PBP']=$this->request->data['Student']['BP'];

				/*
				*	Enregistrement des information en BDD
				*	Mise a jour variable de SESSION
				*/
				$this->makeCall('Save_BAL_Vue_E200_Eleve', $in);
				$this->Session->setFlash('Eleve enregistré', 'flash/success');
				$_SESSION['Dossier']['Eleve']['EleveId']= $ele['Student']['EleveId'];
				$_SESSION['Dossier']['Eleve']['EleveNom']= $in['PEleveNom'];
				$_SESSION['Dossier']['Eleve']['ElevePrenom']= $in['PElevePrenom'];
				$this->redirect(array('controller'=>'Students', 'action'=>'e200Update'));

			}

		}

		/*
		*	Action permettant la cr"ation d'un élève
		*/
		public function E200New(){

			/*
			*	Test la présence d'un dossier responsable légal
			*/
			if(!isset($_SESSION['Dossier']['Parent']['ParentId'])){
				$this->Session->setFlash('Aucun dossier parent trouvé', 'flash/success');
				$this->redirect(array('controller'=>'Responsable', 'action'=>'nouveau', 2));
			}

			/*
			*	Enregistrement des données envoyé par le formulaire
			*/
			if($this->request->is('post')){
				
				/*
				*	Formatage pour makecall
				*/
				$in['PSessionId']=$_SESSION['Auth']['User']['SessionId'];
				$in['PConseilFCPEId']=$_SESSION['Association']['ConseilFCPEId'];
				$in['PEleveId']=null;
				$in['PEleveNom']=$this->request->data['Student']['nom'];
				$in['PElevePrenom']=$this->request->data['Student']['prenom'];
				$in['PEleveMasculin']=($this->request->data['Student']['sexe']=='H');
				$in['PRespLegalId']=$_SESSION['Dossier']['Parent']['ParentId'];
				$in['PEndroitId']=null;
				$in['PEMail']=$this->request->data['Student']['Email'];
				$in['PEMailValide']=0;
				$in['PPassword']='';
				$in['PNumEtVoie']=$this->request->data['Student']['num'];
				$in['PLieuDit']=$this->request->data['Student']['lieudit'];
				$in['PVille']=$this->request->data['Student']['ville'];
				$in['PPays']='France';
				$in['PCodePostal']=$this->request->data['Student']['code_postal'];
				$in['PApptBatResidence']=$this->request->data['Student']['appbatres'];
				$in['PBP']=$this->request->data['Student']['BP'];


				/*
				*	Enregistrement des information en BDD
				*	Mise a jour variable de SESSION
				*/
				$this->makeCall('Save_BAL_Vue_E200_Eleve', $in);
				$EleveID = $this->Student->query("SELECT SUIVIIDLastId FROM bal_suiviid WHERE SUIVIIDSessionId ='".$_SESSION['Auth']['User']['SessionId']."' AND SUIVIIDTableNom='BAL_Eleve' ORDER BY SUIVIIDId DESC LIMIT 0,1");
				$this->Session->setFlash('Eleve enregistré', 'flash/success');
				$this->Session->write('Dossier.Eleve.EleveId',$EleveID[0]['bal_suiviid']['SUIVIIDLastId']);
				$this->Session->write('Dossier.Eleve.EleveNom',$in['PEleveNom']);
				$this->Session->write('Dossier.Eleve.ElevePrenom',$in['PElevePrenom']);
				$this->redirect(array('controller'=>'Students', 'action'=>'E201'));
			}
		}


		/*
		*	Action permettant de supprimer un eleve
		*	
		*/

		public function E200Del(){

			//Envoie  des informations sur l'eleve a la vue e200_del
			$eleve = $this->Student->find('all', array(
          		'conditions' => array('Student.EleveId' => $this->Session->read('Dossier.Eleve.EleveId')))
      		);
      		$this->set(compact('eleve'));
		}

		/*
		*	Action associée a E200Del
		*/
		public function deleteStudent(){

			$eleve['EleveSessionId'] = $_SESSION['Auth']['User']['SessionId'];
     		$eleve['EleveId'] = $_SESSION['Dossier']['Eleve']['EleveId'];
	      	$this->makeCall("Delete_BAL_Vue_E200_Eleve", $eleve); // Supprime l'eleve de la base de données
			unset($_SESSION['Dossier']['Eleve']);  // Detruit dossier de l'eleve
			$this->Session->setFlash('Eleve supprimé', 'flash/success');
			$this->redirect(array('controller' => 'Students' , 'action' => 'E200New'));

		}



		/*
		*	Action sans vue
		*	Permet l'ajout d'un numéro de téléphone à un élève.
		*/
		public function addTel($tel = null, $id=null, $int=null){
			/*
			*	Check des variable passé en arguments
			*/
			if(!is_numeric($id) || $tel==null || $id==null || $int==null || !is_numeric($int)){
				$this->Session->setFlash('Eleve non reconnu', 'flash/error');
				$this->redirect('/');
			}
			
			/*
			* 	Formatage des données pour makecall
			*/
			$in['PSessionId']=$_SESSION['Auth']['User']['SessionId'];
			$in['PEleveId']=$id;
			$in['PInterlocuteurId']=$int;
			$in['PTelephoneNum']="$tel";

			/*
			*	Sauvegarde du numéros
			*/
			$this->makeCall('Save_BAL_Vue_E200_Telephone', $in);
			$this->Session->setFlash('Numéros ajouté', 'flash/success');
			$this->redirect(array('controller'=>'Students', 'action'=>'E200Update'));
		}

		/*
		*	Action sans vue
		*	Permet la supression d'un numéros d'un élève.
		*/
		public function delTel($tel = null, $id=null){
			/*
			*	Check des variable passé en arguments
			*/
			if( $tel==null || $id==null || !is_numeric($id)){
				$this->Session->setFlash('Eleve non reconnu', 'flash/error');
				$this->redirect('/');
			}
			
			/*
			* 	Formatage des données pour makecall
			*/
			$in['PSessionId']=$_SESSION['Auth']['User']['SessionId'];
			$in['PInterlocuteurId']=$id;
			$in['PTelephoneNum']="$tel";
			/*
			*	Sauvegarde du numéros
			*/
			$this->Student->query('call Delete_BAL_Vue_E200_Telephone ("'.$_SESSION['Auth']['User']['SessionId'].'", '.$id.', "'.$tel.'") ;');
			$this->Session->setFlash('Numéros supprimé', 'flash/success');
			$this->redirect(array('controller'=>'Students', 'action'=>'E200Update'));
		}

		/*
		*	Action permettant de saisir le cursus d'un élève.
		*/
		public function E201(){
			/*
			*	récupération des infos de l'élève ouvert dans le dossier
			*/
			$eleve = $this->Student->find('first', array('conditions'=>array('Student.EleveId'=>$_SESSION['Dossier']['Eleve']['EleveId'])));
			$classe = $this->Student->query("SELECT ClasseId,ClasseDesignation,Fin FROM bal_vue_e201_classe WHERE EtablissementId=".$_SESSION['Association']['EtablissementId']);
			$res = $this->Student->query("SELECT * FROM bal_personne INNER JOIN bal_estresponsablelegal ON bal_estresponsablelegal.PersonneId = bal_personne.PersonneId WHERE bal_estresponsablelegal.EleveId =".$eleve['Student']['EleveId']);
			
			/*
			*	Formatage des classes de l'établissement pour être envoyé a la vue
			*/
			$classeBis[0]='';
			foreach ($classe as $key => $value) {
				$fin = $value['bal_vue_e201_classe']['Fin'];
				if($fin === NULL || $fin > date('Y'))
				$classeBis[$value['bal_vue_e201_classe']['ClasseId']]=$value['bal_vue_e201_classe']['ClasseDesignation'];
			}

			/*
			*	Envoie des variables à la vue
			*/
			$this->set('setClasse', $classeBis);
			$this->set('eleve', $eleve);
			$this->set('resp', $res);
		

			/*
			*	Gestion données envoyé par le formulaire de la vue
			*/
			if($this->request->is("post")){
				
				/*
				*	Formatage pour makecall
				*/
				$in['PSessionId']=$_SESSION['Auth']['User']['SessionId'];
				$in['PEleveId']=$_SESSION['Dossier']['Eleve']['EleveId'];
				$in['PEtablissementId']=$_SESSION['Association']['EtablissementId'];
				$in['PClasseId']=$this->request->data['classe'];
				$in['POptionNom']=null;
				$in['PCoursId']=null;
				$in['PExercice']=$_SESSION['Exercice'];

				/*
				*	Appel d'un makecall pour chaque matière et langues
				*/
				foreach ($this->request->data['Student'] as $key => $value) {
					if($value != 0){
						$in['POptionNom']=$key;
						$in['PCoursId']=$value;
						$this->makeCall('Save_BAL_Vue_E201_EleveInscrit', $in);
					}
				}

				/*
				*	Appel d'un makecall pour chaque optiones
				*/
				if(isset($this->request->data['Option']))
				foreach ($this->request->data['Option'] as $key => $value) {
					$in['POptionNom']=$value;
					$in['PCoursId']=$key;
					$this->makeCall('Save_BAL_Vue_E201_EleveInscrit', $in);
				}

				$this->Session->setFlash('Parcour enregistré.', 'flash/success');
				$this->redirect(array('action'=>'E201'));
			}
		}

		/*
		*	Récupération en ajax de la liste des langues
		*/
		public function ajaxE201b($id=null, $sk=null){
			
			if ( $this->request->is( 'ajax' ) && ($sk=="LV1" || $sk=="LV2" || $sk=="LV3")) {
				$langues = $this->Student->query('SELECT * FROM bal_vue_e201_option WHERE EtablissementId='.$_SESSION['Association']['EtablissementId'].' AND ClasseId='.$id.' AND OptionNom="'.$sk.'"');
				$res[]='';
				foreach ($langues as $key => $value) {
					$res[$value['bal_vue_e201_option']['CoursId']]=$value['bal_vue_e201_option']['CoursNom'];
				}

				echo json_encode($res);
				exit();
			}				
		}

		/*
		*	Récupération en ajax de la liste des options
		*/
		public function ajaxE201c($id=null){

			$cpt=0;
			if ( $this->request->is( 'ajax' ) ) {
				$langues = $this->Student->query('SELECT CoursId,CoursNom,OptionNom FROM bal_vue_e201_option WHERE EtablissementId='.$_SESSION['Association']['EtablissementId'].' AND ClasseId='.$id.' AND OptionNom not in (\'LV1\', \'LV2\', \'LV3\')');
				foreach ($langues as $key => $value) {
					$res[$cpt]['nom']=$value['bal_vue_e201_option']['CoursNom'];
					$res[$cpt]['optionNom']=$value['bal_vue_e201_option']['OptionNom'];
					$res[$cpt]['id']=$value['bal_vue_e201_option']['CoursId'];
					$cpt++;
				}

				echo json_encode($res);
	 
				exit();
			}
		}	
	}

?>
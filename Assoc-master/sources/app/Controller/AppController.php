<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $theme = "Cakestrap";

	public $components = array(
	    'Auth' => array(
	        'authenticate' => array(
	            'Form' => array(
	                'fields' => array('username' => 'EMail', 'password' => 'Password'),
	                'passwordHasher' => array(
	                    'className' => 'Simple',
	                    'hashType' => 'sha256'
	                )
	                
	            )
	        ),
	        'loginAction'=>array('controller'=>'users', 'action'=>'e001')
	    ),
	    'Session'
	);

	public function makeCall($callName, $datas) { 
		$this->loadModel('User'); 
		$ma_list= "";
		foreach ($datas as $key => $value) {
			if (is_numeric($value)) { 
				$ma_list.= $value.','; 
			}
			else if (is_null($value)) {
				$ma_list.='null'.',';
			}
			else {
				$ma_list.= '"'.$value.'",'; 
			}
		} 
		$ma_list= substr ($ma_list, 0, strlen($ma_list)-1); 
		return $this->User->query("call $callName ($ma_list);"); 
	}

	public function changeExercice($exercice) {
		$this->Session->write('Exercice', $exercice);
		$this->redirect($this->referer());
	}

	public function beforeFilter() {
		$this->Auth->allow('e001', 'e013');
		$this->Session->read(); 
		$this->Session->write('Association.EtablissementId', 4);
		//debug($_SESSION);
		/**
		 * Permet de récupérer les opérations ouvertes
		 */
		if (isset($_SESSION['Dossier']['Eleve']['InterlocuteurId']) && isset($_SESSION['Dossier']['Parent']['ParentId']) ) {
			$exercice = $_SESSION['Exercice'];
			$conseilfcpe = $_SESSION['Association']['ConseilFCPEId'];
			$interlocuteurid = $_SESSION['Dossier']['Eleve']['InterlocuteurId'];
			$this->loadModel('Fourniture');
			$bon = $this->Fourniture->query("SELECT * FROM bal_vue_e300_bon WHERE ConseilFCPEId=$conseilfcpe AND Exercice=$exercice AND InterlocuteurId=$interlocuteurid;");
			for ($i=0; $i < sizeof($bon); $i++) {
				$bonoperation[$i][$bon[$i]['bal_vue_e300_bon']['BonOperationId']] = $bon[$i]['bal_vue_e300_bon']['TypeDeBonNom'];
			}
			if (!empty($bonoperation)) $this->set('bonoperation', $bonoperation);
			else $this->set('bonoperation', null);

			$typedebonQuery = $this->Fourniture->query("SELECT TypeDeBonNom FROM bal_typedebon;");
			for ($i=0; $i < sizeof($typedebonQuery); $i++) { 
				foreach ($typedebonQuery[$i]['bal_typedebon'] as $key => $value) {
					$typedebon[$value] = $key;
				}
			}
			$this->set('typedebon', $typedebon);
		}

		/**
		 * Permet de gérer les droits d'accès aux pages
		 */
		// Association - Coordonnées
		if ($this->action=='E003' || $this->action=='e003') {
			if ($this->Session->read('Auth.User.Droit')<4) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Association - Responsables
		else if ($this->action=='E004' || $this->action=='e004') {
			if ($this->Session->read('Auth.User.Droit')<4) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Association - Affiliations
		else if ($this->action=='E005' || $this->action=='e005') {
			if ($this->Session->read('Auth.User.Droit')<3) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Association - Etiquettes
		else if ($this->action=='E006' || $this->action=='e006') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Association - Mailing
		else if ($this->action=='E007' || $this->action=='e007') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Parent - Coordonnées
		else if ($this->action=='E100' || $this->action=='e100') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		} 
		// Parent - Adhésion
		else if ($this->action=='E101' || $this->action=='e101') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Parent - Nouveau
		else if ($this->action=='E100new' || $this->action=='e100new') {
			if ($this->Session->read('Auth.User.Droit')<1) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Parent - Supprimer
		else if ($this->action=='E100del' || $this->action=='e100del') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Eleve - Coordonnées
		else if ($this->action=='E200update' || $this->action=='e200update') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		} 
		// Eleve - Scolarité
		else if ($this->action=='E201' || $this->action=='e201') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Eleve - Nouveau
		else if ($this->action=='E200new' || $this->action=='e200new') {
			if ($this->Session->read('Auth.User.Droit')<1) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Eleve - Supprimer
		else if ($this->action=='E200del' || $this->action=='e200del') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Fournitures - Opérations
		else if ($this->action=='E300' || $this->action=='e300') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Fournitures - Etats de vetusté
		else if ($this->action=='E301' || $this->action=='e301') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Fournitures - Produits
		else if ($this->action=='E302' || $this->action=='e302') {
			debug("qdqz");
			if ($this->Session->read('Auth.User.Droit')<3) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Fournitures - Fournisseurs
		else if ($this->action=='E303' || $this->action=='e303') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Fournitures - Nouveau
		else if ($this->action=='E300new' || $this->action=='e300new') {
			if ($this->Session->read('Auth.User.Droit')<1) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Compta - Dossier en cours
		else if ($this->action=='E400' || $this->action=='e400') {
			if ($this->Session->read('Auth.User.Droit')<0) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Compta - Opérations
		else if ($this->action=='E401' || $this->action=='e401') {
			if ($this->Session->read('Auth.User.Droit')<2) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Compta - Relevés fiscaux
		else if ($this->action=='E402' || $this->action=='e402') {
			if ($this->Session->read('Auth.User.Droit')<4) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
		// Compta - Modes de règlement
		else if ($this->action=='E404' || $this->action=='e404') {
			if ($this->Session->read('Auth.User.Droit')<1) {
				// REDIRECTION PAGE ERROR
				$this->Session->setFlash('Vous n\'avez pas les droits nécessaires pour accéder à cette page.', 'flash/error');
				$this->redirect($this->referer());
			}
		}
	}

}
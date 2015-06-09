<?php  

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * Controller permettant de gérer les utilisateurs
 */
class UsersController extends AppController {

    /**
     * Fonction permettant d'effectuer un traitement avant le traitement de l'action
     */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    /**
     * Vue permettant de créer un utilisateur
     */
    public function E013(){ 
        /**
         * Reception du formulaire comportant les informations de l'utilisateur
         */
        if ($this->request->is('post')) {
            $this->User->create();
            /**
             * Si l'email est le même que l'email confirmé
             */
            if ($this->request->data['User']['PEMail'] == $this->request->data['User']['PEMailConf']) {
                /**
                 * Si le mot de passe est le même que le mot de passe confirmé
                 */
                if ($this->request->data['User']['PPassword'] == $this->request->data['User']['PPasswordConf']) {
                    $user['PSessionId'] = $this->Session->read('Config.userAgent');
                    foreach ($this->request->data['User'] as $key => $value) {
                        if (!($key == 'PTelephoneNum')) {
                            /**
                             * Hachage du mot de passe
                             */
                            if ($key == 'PPassword' || $key == 'PPasswordConf') {
                                $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
                                $user['PPassword'] = $passwordHasher->hash($value);
                            }
                            else if ($key == 'PEMail' || $key == 'PEMailConf') {
                                $user['PEMail'] = $value;
                            }
                            else {
                                $user[$key] = $value;
                            }
                        }
                    }
                    $user['PTelephoneNum'] = $this->request->data['User']['PTelephoneNum'];
                    $user['PPersonneId'] = null;
                }
            }
            /**
             * Appel de la procédure de sauvegarde d'un nouvel utilisateur
             */
            $this->makeCall("Save_BAL_Vue_E013_Users", $user);
            $this->Session->setFlash('Utilisateur enregistré avec succès!', 'flash/success');
            // Envoi du mail pour activer son compte
            //ini_set('SMTP', 'smtp.gmail.com');
            //ini_set('sendmail_from', 'hubert.barret@gmail.com'); 
            //$message = "Bonjour,\nVeuillez activer votre compte pour pouvoir vous loguer prochainement: $this->Html->link('cliquez ici', array('controller'=>'users', 'action'=>'valideMail'))";
            //mail('hubert.barret@gmail.com', 'Activez votre compte FCPE', $message);
            /**
             * Redirection sur la page de connexion
             */
            $this->redirect(array('controller' => 'users', 'action' => 'E001'));
        }
    }

    /**
     * Vue permettant de loguer un utilisateur
     */
    public function E001() {
        /**
         * Si la personne n'est pas encore loggué
         */
        if (empty($_SESSION['Auth']['User']['InterlocuteurId'])) {
            /**
             * Reception du formulaire contenant les données de connexion de l'utilisateur
             */
            if ($this->request->is('post')) {
                /**
                 * $this->Auth->login: fonction de cakephp permettant de tester si l'utilisteur est inscris
                 * dans la table des utilisateurs (dans notre cas bal_vue_e001_users)
                 * si oui, écris les données de la table en variable de session
                 */
                if ($this->Auth->login()) {
                    $_SESSION['Exercice']=date('Y');
                    $user_id = $this->Session->read('Auth.User.InterlocuteurId');
                    $emailValide = $this->User->query("SELECT EMailValide FROM bal_interlocuteur WHERE InterlocuteurId=$user_id;");
                    /**
                     * Si l'email de l'utilisateur est non validé
                     */
                    if ($emailValide[0]['bal_interlocuteur']['EMailValide']==0) {
                        $this->Session->setFlash('Veuillez confirmer votre compte.', 'flash/error');
                        $this->Auth->logout();
                        unset($_SESSION['Association']);
                        unset($_SESSION['Dossier']);
                        unset($_SESSION['Exercice']);
                        /**
                         * Redirection vers la page de connexion
                         */
                        $this->redirect(array('controller' => 'users', 'action' => 'e001'));
                    }
                    /**
                     * Si l'email de l'utilisateur est validé
                     */
                    else {
                        $this->Session->setFlash('Vous êtes connecté!', 'flash/success');
                        /**
                         * Redirection vers la page de choix de connexion sur une association
                         */
                        $this->redirect(array('controller' => 'users', 'action' => 'asso'));
                    }
                }
                /**
                 * Si l'utilisateur n'est pas inscris ou erreur de password ou erreur identifiant
                 */
                else {
                    $this->Session->setFlash('Erreur de password/identifiant!', 'flash/error');
                    /**
                     * 
                     */
                    $this->redirect(array('controller' => 'users', 'action' => 'e001'));
                }
            }
        }
        /**
         * Si la personne est logguée on la redirige vers le module recherche
         */
        else {
            $this->redirect(array('controller' => 'recherches', 'action' => 'seek'));
        }
    }

    /**
     * Fonction permettant de déconnecté l'utilisateur
     */
    public function logout() {
        /**
         * Appel de la fonction cakephp de déconnection + unset des variables de sessions
         */
        $this->Auth->logout();
        unset($_SESSION['Association']);
        unset($_SESSION['Dossier']);
        unset($_SESSION['Exercice']);
        $this->Session->setFlash('Vous êtes déconnecté.', 'flash/success');
        /**
         * Redirection vers la page de connection
         */
        $this->redirect(array('controller' => 'users', 'action' => 'e001'));
    }

    /**
     * Fonction permettant de mettre à jour les variables de sessions après que l'utilisateur se soit connecté
     */
    public function logged($conseilfcpeid=null) {
        $conseilfcpenom = $this->User->query("SELECT ConseilFCPENom FROM bal_conseilfcpe WHERE ConseilFCPEId=$conseilfcpeid;");
        $user_id = $this->Session->read('Auth.User.InterlocuteurId');
        $habilitation = $this->User->query("SELECT HabilitationNom FROM bal_vue_e001_users WHERE ConseilFCPEId=$conseilfcpeid AND InterlocuteurId=$user_id");
        $etablissementid = $this->User->query("SELECT EtablissementId FROM bal_estassociea WHERE ConseilFCPEId=$conseilfcpeid;");
        $this->Session->write('Association.ConseilFCPEId', $conseilfcpeid);
        $this->Session->write('Association.ConseilFCPENom', $conseilfcpenom[0]['bal_conseilfcpe']['ConseilFCPENom']);
        $this->Session->write('Auth.User.HabilitationNom', $habilitation[0]['bal_vue_e001_users']['HabilitationNom']);
        $this->Session->write('Association.EtablissementId', $etablissementid[0]['bal_estassociea']['EtablissementId']);
        if ($habilitation[0]['bal_vue_e001_users']['HabilitationNom']=="Administrateur") {
            $this->Session->write('Auth.User.Droit', 4);
        }
        else if ($habilitation[0]['bal_vue_e001_users']['HabilitationNom']=="Responsable") {
            $this->Session->write('Auth.User.Droit', 3);
        }
        else if ($habilitation[0]['bal_vue_e001_users']['HabilitationNom']=="Gestionnaire") {
            $this->Session->write('Auth.User.Droit', 2);
        }
        else if ($habilitation[0]['bal_vue_e001_users']['HabilitationNom']=="Opérateur") {
            $this->Session->write('Auth.User.Droit', 1);
        }
        else if ($habilitation[0]['bal_vue_e001_users']['HabilitationNom']=="Membre") {
            $this->Session->write('Auth.User.Droit', 0);
        }
        $this->Session->setFlash('Vous êtes connecté sur l\'association.', 'flash/success');
        /**
         * Redirection vers le module recherche²
         */
        $this->redirect(array('controller' => 'recherches', 'action' => 'seek'));
    }

    /**
     * Vue permettant de choisir son association sur laquelle se loguer
     */
    public function asso() {
        $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
        $sessionid = $this->Session->read('Auth.User.EMail') . time();
        /**
         * Hachage de l'email de l'utilisateur + date en variable de session.
         */
        $sessionid = $passwordHasher->hash($sessionid);
        $this->Session->write('Auth.User.SessionId', $sessionid);
        $user_id = $this->Session->read('Auth.User.InterlocuteurId');
        /**
         * Récupération de toutes les association sur lesquelles l'utilisateur peut se connecter
         */
        $conseilfcpe = $this->User->query("SELECT ConseilFCPEId, ConseilFCPELabel FROM bal_vue_e001_assoc NATURAL JOIN bal_vue_e001_users WHERE InterlocuteurId=$user_id;");
        for ($i=0; $i < sizeof($conseilfcpe); $i++) { 
            $conseil[$i]['ConseilFCPEId'] = $conseilfcpe[$i]['bal_vue_e001_assoc']['ConseilFCPEId'];
            $conseil[$i]['ConseilFCPELabel'] = $conseilfcpe[$i]['bal_vue_e001_assoc']['ConseilFCPELabel'];
        }
        if (isset($conseil)) $this->set('conseil', $conseil);
        else $this->set('conseil', null);
    }

    /**
    *   Vue permettant la validation du mail d'un memblre de lassociation.
    */
    public function valideMail($mail = null){
        if(empty($mail)){
            $this->Session->setFlash('Email non valide.', 'flash/error');
            $this->redirect('/');
        }
        $this->makeCall('EMailConfirm', array($mail, true));
        $this->Session->setFlash('Email activé.', 'flash/success');
        $this->redirect('/');
    }

    /**
    *   Vue permettant la modification du password.
    */
    public function resetPassword(){
        if($this->request->is('post')){
            $mail = $this->request->data['resetMail']['mail'];
            $mdp = substr (md5($mail.time()), 0, 8);
            $crypt = $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
            $mdpCrypt = $crypt->hash($mdp);
            //mail($mail, 'rez mdp', 'Nouveau mot de pase: '.$mdp);
            $this->makeCall('ResetPassword', array($mail, $mdpCrypt));
            $this->Session->setFlash('Password modifié, vous le receverez par mail.', 'flash/success');
            $this->redirect('/');
        }
    }


}


?>
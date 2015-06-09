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

    public function accueil(){

        if(isset($_SESSION['Auth']['User']['InterlocuteurId']) && isset($_SESSION['Association']['ConseilFCPEId'])){
            $this->redirect(array('controller' => 'recherches', 'action' => 'seek'));
        }
        
        $association = $this->User->query(
            "SELECT ConseilFCPEId, ConseilFCPELabel FROM bal_vue_e001_assoc"
        );
            
        $this->set(compact('association'));
    }




    /**
     * Vue permettant de créer un utilisateur
     */
    public function E013(){ 
        /**
         * Reception du formulaire comportant les informations de l'utilisateur
         */
        if ($this->request->is('post')) {

            if( empty($this->request->data['User']['PPersonneNom']) || 
                empty($this->request->data['User']['PPersonnePrenom']) ||
                $this->request->data['User']['PPersonneMasculin'] == null ||
                empty($this->request->data['User']['PVille']) ||
                empty($this->request->data['User']['PPays']) ||
                empty($this->request->data['User']['PCodePostal']) ||
                empty($this->request->data['User']['PTelephoneNum']) ||
                empty($this->request->data['User']['PEMail']) || 
                empty($this->request->data['User']['PEMailConf']) || 
                empty($this->request->data['User']['PPassword']) ||
                empty($this->request->data['User']['PPasswordConf'])
            ){

                $this->Session->setFlash('Vous devez remplir tous les champs en *', 'flash/error');
                
            }
            else{

                /**
                 * Si l'email est le même que l'email confirmé
                 */
                if ($this->request->data['User']['PEMail'] == $this->request->data['User']['PEMailConf']) {


                    $atom   = '[-a-z0-9!#$%&\'*+\\/=?^_`{|}~]';   // caractères autorisés avant l'arobase
                    $domain = '([a-z0-9]([-a-z0-9]*[a-z0-9]+)?)'; // caractères autorisés après l'arobase (nom de domaine)
                                                   
                    $regex = '/^' . $atom . '+' .   // Une ou plusieurs fois les caractères autorisés avant l'arobase
                    '(\.' . $atom . '+)*' .         // Suivis par zéro point ou plus
                                                    // séparés par des caractères autorisés avant l'arobase
                    '@' .                           // Suivis d'un arobase
                    '(' . $domain . '{1,63}\.)+' .  // Suivis par 1 à 63 caractères autorisés pour le nom de domaine
                                                    // séparés par des points
                    $domain . '{2,63}$/i';          // Suivi de 2 à 63 caractères autorisés pour le nom de domaine

                    // test de l'adresse e-mail
                    if (preg_match($regex, $this->request->data['User']['PEMail'])) {

                        $email = $this->User->find('all', array('conditions' => array('User.EMail' => $this->request->data['User']['PEMail'])));

                        if ( empty($email) ){
                            /**
                             * Si le mot de passe est le même que le mot de passe confirmé
                             */
                            if ($this->request->data['User']['PPassword'] == $this->request->data['User']['PPasswordConf']) {
                                $user['PSessionId'] = $this->Session->read('Config.userAgent');
                                $user['PPersonneId'] = null;
                                $user['PPersonneId'] = null;
                                $user['PPersonneNom'] = $this->request->data['User']['PPersonneNom'];
                                $user['PPersonnePrenom'] = $this->request->data['User']['PPersonnePrenom'];
                                $user['PPersonneMasculin'] = $this->request->data['User']['PPersonneMasculin'];
                                $user['PEndroitId'] = null;
                                $user['PNumEtVoie'] = $this->request->data['User']['PNumEtVoie'];
                                $user['PLieuDit'] = $this->request->data['User']['PLieuDit'];
                                $user['PVille'] = $this->request->data['User']['PVille'];
                                $user['PPays'] = $this->request->data['User']['PPays'];
                                $user['PCodePostal'] = $this->request->data['User']['PCodePostal'];
                                $user['PApptBatResidence'] = $this->request->data['User']['PApptBatResidence'];                        
                                $user['PBP'] = $this->request->data['User']['PBP'];
                                $user['PInterlocuteurId'] = null;
                                $user['PEMail'] = $this->request->data['User']['PEMail'];
                                $user['PEMailValide'] = $this->request->data['User']['PEMailValide'];
                                $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
                                $user['PPassword'] = $passwordHasher->hash($this->request->data['User']['PPassword']);
                                $user['PTelephoneNum'] = $this->request->data['User']['PTelephoneNum'];
                                /**
                                 * Appel de la procédure de sauvegarde d'un nouvel utilisateur
                                */
                                $this->makeCall("Save_BAL_Vue_E013_Users", $user);
                                
                                                                
                                /**
                                *Envoi de mail pour activer le compte
                                *
                                */
                                                      
                                //Pour creer le lien a envoyé a l'utilisateur                                
                                $view = new View($this);
                                $html = $view->loadHelper('Html');
                                // Lien qui sera envoyé a l'utilisateur
                                $link = $html->url(array('controller' => 'users',
                                'action' => 'valideMail' , $user['PEMail'],$user['PSessionId']) , true);  

                                App::uses('CakeEmail', 'Network/Email');  // Pour utilise la fonction CakeMail 
                                $mail = new CakeEmail('smtp');
                            
                                // Evoie des donnees au template
                                $mail->viewVars(array('link' => $link));
                                $mail->viewVars(array('nom' => $user['PPersonneNom']));
                                $mail->viewvars(array('prenom' => $user['PPersonnePrenom']));
                                $mail->template('confirmation');
                                $mail->emailFormat('html');
                                $mail->to($user['PEMail']);     // Adresse mail de l'utilisateur    
                                $mail->subject('Confirmation de votre adresse mail');
                                if( $mail->send() ){
                                    $validerMail = true ;
                                    $this->set('validerMail' , $validerMail);
                                    $this->set('email' , $this->request->data['User']['PEMail']);                              
                                    $this->Session->setFlash('Votre espace utilisateur a bien &eacute;t&eacute; cr&eacute;e', 'flash/success');
                           
                                }
                                else{
                                    $this->Session->setFlash('Probleme rencontré lors de l\'envoie du mail d\'action', 'flash/error');
                                }

                            }
                            else{
                                $this->Session->setFlash('Vous devez renseigner le meme mot de passe ', 'flash/error');
                            }

                        }
                        else{
                            $this->Session->setFlash('Adress mail deja utilisé', 'flash/error');
                        }

                    }
                    else {
                        $this->Session->setFlash('Adress mail incorrecte', 'flash/error');
                    }

                }
                else{
                    $this->Session->setFlash('Vous devez renseigner le meme Email', 'flash/error');
                }

            }
            
        }
    }

    /**
     * Vue permettant de loguer un utilisateur
     */
    public function E001($id = null) {
        
        if($id == -1 || $id == null ){
            $this->Session->setFlash('Selectionner une association', 'flash/error');
            $this->redirect(array('action' => 'accueil'));
        }

        $conseilfcpenom = $this->User->query("SELECT ConseilFCPENom FROM bal_conseilfcpe WHERE ConseilFCPEId=$id;");

        if(empty($conseilfcpenom)){
            $this->Session->setFlash('Selectionner une association', 'flash/error');
            $this->redirect(array('action' => 'accueil'));
        }
        else{
            $this->set('conseilfcpenom' , $conseilfcpenom );
        }
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

                    $_SESSION['Exercice'] = date('Y');
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
                        $this->redirect(array('controller' => 'users', 'action' => 'e001', $id));
                    }
                    /**
                     * Si l'email de l'utilisateur est validé
                     */
                    else {

                        // Recherche de l'id de l'assocation
                        $users = $this->User->query("SELECT ConseilFCPEId FROM bal_vue_e001_users WHERE ConseilFCPEId=$id 
                            AND InterlocuteurId = ".$this->Session->read('Auth.User.InterlocuteurId')."");  

                        if( !empty($users) && $users[0]['bal_vue_e001_users']['ConseilFCPEId'] == $id ){

                            $passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
                            $sessionid = $this->Session->read('Auth.User.EMail') . time();
                            /**
                             * Hachage de l'email de l'utilisateur + date en variable de session.
                             */
                            $sessionid = $passwordHasher->hash($sessionid);
                            $this->Session->write('Auth.User.SessionId', $sessionid);

                            $this->Session->setFlash('Vous êtes connecté!', 'flash/success');
                            $this->redirect(array('controller' => 'users', 'action' => 'logged', $id)); 
                        }
                        else{
                            $this->Auth->logout();
                            unset($_SESSION['Association']);
                            unset($_SESSION['Dossier']);
                            unset($_SESSION['Exercice']);
                            $nonIdentife = true;
                            $this->set('nonIdentife', $nonIdentife);
                        }

                        
                    }
                }
                /**
                 * Si l'utilisateur n'est pas inscris ou erreur de password ou erreur identifiant
                 */
                else {
                    $this->Session->setFlash('Erreur de password/identifiant!', 'flash/error');

                    $this->redirect(array('controller' => 'users', 'action' => 'e001' , $id));
                }
            }
        }
        /**
         * Si la personne est logguée on la redirige vers le module recherche
         */
        else {
            //$this->redirect(array('controller' => 'recherches', 'action' => 'seek'));
            $this->Auth->logout();
            unset($_SESSION['Association']);
            unset($_SESSION['Dossier']);
            unset($_SESSION['Exercice']);
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
        unset($_SESSION['Fourniture']);
        $this->Session->setFlash('Vous êtes déconnecté.', 'flash/success');
        /**
         * Redirection vers la page de connection
         */
        $this->redirect(array('controller' => 'users', 'action' => 'accueil'));
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
    public function valideMail($mail = null, $sessionId=null){
        
        // L'adresse mail ou la cles n'est pas renseigner
        if( empty($mail) || empty($sessionId) ){
            $this->Session->setFlash('Vos informations sont incorrectes. Reessayez ', 'flash/error');
        }
        else{

            // Pour recuperer les infos de l'utilisateur en fonction des variables passées en parametres
            $requete = "SELECT EmailValide , ConseilFCPEId, InterlocuteurId FROM Bal_SuiviId , bal_vue_e100_personne
            WHERE SUIVIIDSessionId = '".$sessionId."' AND SUIVIIDTableNom = 'BAL_Interlocuteur' AND 
            EMail = '".$mail."' AND SUIVIIDLastId = InterlocuteurId";
            
            $res = $this->User->query($requete);
                        
            if( empty($res) ){   // L'utilisateur n'a pas ete retrouvé dans la base de donnees
                $this->Session->setFlash('Votre adresse e-mail ne peut pas etre activ&eacute; ou est d&eacutej&agrave; activ&eacute', 'flash/error');
                $this->redirect('/');
            }
            else{  
                // L'utilisateur a ete retrouvé mais son adresse mail est deja activé et il possède deja une association 
                if( $res[0]['bal_vue_e100_personne']['EmailValide'] == 1 && !is_null($res[0]['bal_vue_e100_personne']['ConseilFCPEId']) ){
                    $this->Session->setFlash('Selectionnez et Connectez vous a votre association ', 'flash/success');
                    $this->redirect('/');
                }
                else{    // On active l'adresse mail de l'utilisateur

                    // Conservation des informations permettant a l'utilisateur de creer une association
                    $_SESSION['Auth']['User']['InterlocuteurId'] = $res[0]['bal_vue_e100_personne']['InterlocuteurId'];
                    $_SESSION['Auth']['User']['SessionId'] = $sessionId;
                    $_SESSION['Auth']['User']['Droit'] = 4;  // On lui donne le droit de pouvoir creer une association
                    $this->makeCall('EMailConfirm', array($mail, true) );
                    $this->Session->setFlash('Votre Email est activ&eacute;.', 'flash/success');  
                    // Redirection vers la page de creation d'une association
                    $this->redirect(array('controller' => 'associations' , 'action' => 'e012' ));
                }
            }
        }

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
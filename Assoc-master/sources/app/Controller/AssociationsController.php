<?php
App::import('Vendor', 'pdf/fpdf');
App::import('Vendor', 'pdf/fpdi');
App::import('Vendor', 'pdf/PDF_Label');

/**
 * Controller permettant de gérer le module Association
 */
class AssociationsController extends AppController {
   
   /**
    * Fonction traitée avant le traitement de l'action
    */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('e012');
    }

    /**
     * Fonction permettant de créer une association
     */
    public function E012(){
        /**
         * Permet de récupérer toutes les associations créée, afin de faire une demande tutelle
         */
        $tutelleQuery = $this->Association->query("SELECT ConseilFCPEId, ConseilFCPELabel FROM bal_vue_e001_assoc;");
        for ($i=0; $i < sizeof($tutelleQuery); $i++) { 
            foreach ($tutelleQuery[$i]['bal_vue_e001_assoc'] as $key => $value) {
                $tutelle[$tutelleQuery[$i]['bal_vue_e001_assoc']['ConseilFCPEId']] = $tutelleQuery[$i]['bal_vue_e001_assoc']['ConseilFCPELabel'];
            }
        }
        $this->set('tutelle', $tutelle);

        /**
         * Reception du formulaire de création d'une association
         */
        if ($this->request->is('post')) {
            /**
             * Si un champs est vide alors qu'il ne doit pas l'être
             */
            if ($this->request->data['Association']['PConseilFCPENom']=='' ||
                $this->request->data['Association']['PSCNumEtVoie']=='' ||
                $this->request->data['Association']['PSCVille']=='' ||
                $this->request->data['Association']['PSCPays']=='' ||
                $this->request->data['Association']['PSCCodePostal']=='' ||
                $this->request->data['Association']['PEtablissementNom']=='' ||
                $this->request->data['Association']['PTypeDEtablissementNom']=='' ||
                $this->request->data['Association']['PEtabNumEtVoie']=='' ||
                $this->request->data['Association']['PEtabVille']=='' ||
                $this->request->data['Association']['PEtabCodePostal']=='' ||
                $this->request->data['Association']['PEtabPays']=='') {
                $this->Session->setFlash('Veuillez compléter les champs obligatoires.', 'flash/error');
                $this->redirect($this->referer());
            }
            /**
             * Sinon on effectue l'enregistrement de l'utilisateur
             */
            else {
                $this->request->data['Association']['PInterlocuteurId'] = $this->Session->read('Auth.User.InterlocuteurId');
                $this->request->data['Association']['PConseilFCPEId'] = null;
                $this->request->data['Association']['PEtablissementId'] = null;
                $this->request->data['Association']['PSCEndroitId'] = null;
                $this->request->data['Association']['PEtabEndroitId'] = null;
                if ($this->request->data['Association']['PTutelleId']=='') {
                    $this->request->data['Association']['PTutelleId'] = null;
                }
                /**
                 * Appel de la procédure d'enregistrement d'un utilisateur
                 */
                $this->makeCall("Save_BAL_Vue_E012_Assoc", $this->request->data['Association']);
                $this->Session->setFlash('Association enregistré avec succès!', 'flash/success');
                /** 
                 * Redirection vers la page de connexion + création association
                 */
                $this->redirect(array('controller' => 'users', 'action' => 'asso'));
            }
        }
    }

    /*
    * Fonction permettant de metre à jour une association
    */
    public function E003() {
        $assocCourranteId =  $_SESSION['Association']['ConseilFCPEId'];
        $assocCourrante = $this->Association->query("SELECT * FROM bal_vue_e012_assoc WHERE ConseilFCPEId = $assocCourranteId;");
        $assocCourrante = $assocCourrante[0]['bal_vue_e012_assoc'];
        $this->set("assocCourrante",$assocCourrante);

        if($this->request->is('post')){
           
            $upAssoc['PSessionId'] = $_SESSION['Auth']['User']['SessionId'];
            $upAssoc['PInterlocuteurId'] =  $_SESSION['Auth']['User']['InterlocuteurId']; /* Id de la personne à déclarer comme administrateur de l'association */
            $upAssoc['PConseilFCPEId'] = $assocCourranteId;
            $upAssoc['PConseilFCPENom'] = $this->request->data['Association']['ConseilFCPENom'];
            $upAssoc['PTutelleId'] = $assocCourrante['TutelleId'];
            $upAssoc['PEtablissementId'] = null;
            $upAssoc['PSCEndroitId'] = null;
            $upAssoc['PSCNumEtVoie'] = $this->request->data['Association']['SCNumEtVoie'];
            $upAssoc['PSCLieuDit'] = $this->request->data['Association']['SCLieuDit'];
            $upAssoc['PSCVille'] = $this->request->data['Association']['SCVille'];
            $upAssoc['PSCPays'] = $assocCourrante['SCPays'];
            $upAssoc['PSCCodePostal'] = $this->request->data['Association']['SCCodePostal'];
            $upAssoc['PSCApptBatResidence'] = $this->request->data['Association']['SCApptBatResidence'];
            $upAssoc['PSCBP'] = $this->request->data['Association']['SCBP'];
            $upAssoc['PEtablissementNom'] = $this->request->data['Association']['EtablissementNom'];
            $upAssoc['PTypeDEtablissementNom'] = $this->request->data['Association']['TypeDEtablissementNom'];
            $upAssoc['PEtabEndroitId'] = null;
            $upAssoc['PEtabNumEtVoie'] = $this->request->data['Association']['EtabNumEtVoie'];
            $upAssoc['PEtabLieuDit'] = $this->request->data['Association']['EtabLieuDit'];
            $upAssoc['PEtabVille'] = $this->request->data['Association']['EtabVille'];
            $upAssoc['PEtabPays'] = $assocCourrante['EtabPays'];
            $upAssoc['PEtabCodePostal'] = $this->request->data['Association']['EtabCodePostal'];
            $upAssoc['PEtabApptBatResidence'] = $this->request->data['Association']['EtabApptBatResidence'];
            $upAssoc['PEtabBP'] = $this->request->data['Association']['EtabBP'];
            $this->makeCall("Save_BAL_Vue_E012_Assoc", $upAssoc);
            $this->Session->setFlash('Coordonnées de l\'association modifiées.', 'flash/success');
            $this->redirect(array('controller' => 'Associations', 'action' => 'E003'));
        }
    }

    /*
        Action basé sur la maquette E004. Permet de gérer les responsabilités des membres de l'association en fonction de l'exercice
    */
    public function E004(){
            // Recherche de toutes les personnes inscrites
            $memberQuery = $this->Association->query("SELECT * FROM bal_vue_e001_users ORDER BY PersonneNom ASC;");
            for ($i=0; $i < sizeof($memberQuery); $i++) {
                if (!is_null($memberQuery[$i]['bal_vue_e001_users']['PersonneId'])) {
                    $personnes[$memberQuery[$i]['bal_vue_e001_users']['PersonneId']] = $memberQuery[$i]['bal_vue_e001_users']['PersonneNom'] . $memberQuery[$i]['bal_vue_e001_users']['PersonnePrenom'];
                }
            }
            $this->set('personnes', $personnes);
            // si post, insertion d'une nouvelle responsabilite
             if ($this->request->is('post')) {
                    $this->makeCall("Save_BAL_Vue_E004_Users",array($_SESSION["Auth"]["User"]["SessionId"],$this->request->data["NewStaff"]["Identite"],$_SESSION['Association']['ConseilFCPEId'],$_SESSION['Exercice'],$this->request->data["NewStaff"]["Poste"]) );
                    $this->Session->setFlash('Responsable ajouté avec succès.', 'flash/success');
                    $this->redirect( array('controller' => 'Associations', 'action' => 'E004'));
             }
             // requetes pour recup les données
            $request_role =$this->Association->query("SELECT RoleBureauNom FROM bal_vue_e004_roles;");
            $request_member = $this->Association->query("SELECT * FROM bal_vue_e101_adhesion LEFT JOIN bal_vue_e004_users ON bal_vue_e101_adhesion.PersonneId = bal_vue_e004_users.PersonneId WHERE  bal_vue_e101_adhesion.ConseilFCPEId =  ". $_SESSION["Association"]["ConseilFCPEId"]. " AND bal_vue_e101_adhesion.Exercice = ". $_SESSION['Exercice']  . ";");
            $request_staff = $this->Association->query("SELECT * FROM bal_vue_e004_users WHERE  ConseilFCPEId =  ".  $_SESSION['Association']['ConseilFCPEId']  . " AND Exercice = ". $_SESSION['Exercice']  . ";");     
            $role = array();
            $member = array();
            $staff = array();
            //mise en forme pour usage facile dans la vue
            foreach($request_role as $r)
            {
                $role[$r["bal_vue_e004_roles"]["RoleBureauNom"]] = $r["bal_vue_e004_roles"]["RoleBureauNom"]; 

            }

            foreach($request_member as $r)
            {
                $member[ $r["bal_vue_e101_adhesion"]["PersonneId"]] = $r["bal_vue_e004_users"]["Identite"]; 

            }
            $i =0;
            foreach($request_staff as $r)
            {
                $staff[$r["bal_vue_e004_users"]["PersonneId"]] = array("id"=>$r["bal_vue_e004_users"]["PersonneId"],"identite"=>$r["bal_vue_e004_users"]["Identite"],"role"=>$r["bal_vue_e004_users"]["RoleBureauNom"]);
                $i++;
            
            }
            $this->set("roles",$role);
            $this->set("staff",$staff);
            $this->set ("members",$member);
            $this->set ("annee",$_SESSION['Exercice']);
        }
        
    /*
        Action lié a la vue E004. Permet de supprimer une entrée dans ladite vue . Pas de vue, redirection directe

    */
    public function deleteStaff($idPersonne,$role) {
        if(isset($idPersonne)&&isset($role)) {
            $this->makeCall("Delete_BAL_Vue_E004_Users",array($idPersonne,$_SESSION['Association']['ConseilFCPEId'],$_SESSION['Exercice'],$role));
            $this->Session->setFlash('Responsable supprimé !', 'flash/success');
        }
        $this->redirect( array('controller' => 'Associations', 'action' => 'E004'));
    }
        
    /*
        Action lié a la vue E004. Permet de modifier une entrée dans ladite vue . Pas de vue, redirection directe
        par sécurité je supprime l'entrée d'abord.

    */
    public function updateStaff($idPersonne,$role,$exercice,$previous_id,$previous_role) {
        if(isset($idPersonne)&&isset($exercice)&&isset($role)) {
            $this->makeCall("Delete_BAL_Vue_E004_Users",array($previous_id,$_SESSION['Association']['ConseilFCPEId'],$_SESSION['Exercice'],$previous_role));
            $this->makeCall("Save_BAL_Vue_E004_Users",array($_SESSION["Auth"]["User"]["SessionId"],$idPersonne,$_SESSION['Association']['ConseilFCPEId'],$_SESSION['Exercice'],$role));
        }   
        $this->redirect( array('controller' => 'Associations', 'action' => 'E004'));
    }


    /*
        fonction permettant d'accepter/refuser les demmandes d'affiliations
    */
    public function E005() {
        $assocCourranteNom = $_SESSION['Association']['ConseilFCPENom'];
        $assocCourranteId = $_SESSION['Association']['ConseilFCPEId'];
        $this->set('assocCourranteNom',$assocCourranteNom);

        $tutelle = $this->Association->query("SELECT AffilieId,AffilieNom,EMail FROM bal_vue_e005_assoc WHERE TutelleId = $assocCourranteId AND StatutDemande = 1");
        $this->set('tutelle', $tutelle);

        $demandes = $this->Association->query("SELECT AffilieId,AffilieNom,EMail,StatutDemande FROM bal_vue_e005_assoc WHERE TutelleId = $assocCourranteId AND StatutDemande != 1");
        $this->set('demandes', $demandes);
        
    }

    /*
        fonction liée à E005 permettant d'accepter/refuser les demmandes d'affiliations
    */
    public function gestionTutelle($assocId = null, $op = null){
        $gt['PSessionId'] = $_SESSION['Auth']['User']['SessionId'];
        $gt['PAffilieId'] = $assocId;
        $gt['PStatutDemande'] = $op;
        $this->makeCall("Save_BAL_Vue_E005_Assoc", $gt);
        $this->redirect(array('controller'=>'Associations', 'action'=>'e005'));
    }


    /*
    * Fonction permettant de generer des étiquetes
    */
    public function E006() {
        if ($this->request->is('post')) {
            //utilisation de la classe PDF_Label
            //le parametre du constructeur correspond au format des etiquetes (voir PDF_Label.php)
            $pdf = new PDF_Label('3422');  
            $pdf->AddPage(); 
            $personnesInfo = $this->Association->query("SELECT * FROM bal_vue_e006_etiquettes");

            foreach ($personnesInfo as $key => $value) {  
                $value = $value['bal_vue_e006_etiquettes'];

                $nom = $value['PersonneNom'];
                $prenom = $value['PersonnePrenom'];
                $num = $value['NumEtVoie'];
                $resid = $value['ApptBatResidence'];
                $ld = $value['LieuDit'];
                $ville = $value['Ville'];
                $cp = $value['CodePostal'];
                $pays = $value['Pays'];

                $text = sprintf("%s %s\n%s\n%s\n%s\n %s, %s", "$prenom", "$nom","$num", "$resid", "$cp", "$ville", "$pays");
                //utf8_decode permet la gestion des chaine accentué.
                $text = utf8_decode($text);
                $pdf->Add_Label($text);
            }
            //output permet le téléchargement du pdf generé
            $pdf->Output("Etiquettes.pdf", "D"); 
        }
    }
}

?>
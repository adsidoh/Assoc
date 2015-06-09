
<?php  

/**
 * Classe permettant de gérer la compta
 */

App::import('Vendor', 'pdf/fpdf');
App::import('Vendor', 'pdf/fpdi');
App::import('Vendor', 'pdf/PDF_Label');
class ComptasController extends AppController {

	public function beforeFilter() {
        parent::beforeFilter();
    }
    /*
        Action correpsondant a la vue E400



    */
    public function E400($cheque=null) {
        $personneId = $_SESSION['Dossier']['Parent']['ParentId'];
        $conseilfcpeId = $_SESSION['Association']['ConseilFCPEId'];
        $queryEntete = $this->Compta->query("SELECT * FROM bal_vue_e400_entete NATURAL JOIN bal_facture WHERE PersonneId=$personneId AND ConseilFCPEId=$conseilfcpeId;");
        for ($i=0; $i < sizeof($queryEntete); $i++) { 
            $entete['FactureId'] = $queryEntete[$i]['bal_vue_e400_entete']['FactureId'];
            $entete['CreationFact'] = $queryEntete[$i]['bal_vue_e400_entete']['CreationFact'];
            $entete['Montant'] = $queryEntete[$i]['bal_vue_e400_entete']['Montant'];
            $entete['Reglement'] = $queryEntete[$i]['bal_vue_e400_entete']['Reglement'];
        }
        if (isset($entete)) $this->set('entete', $entete);
        else $this->set('entete', null);

        $queryMoyen = $this->Compta->query("SELECT MoyenDePaiementNom FROM bal_vue_e400_modespaiement;");
        for ($i=0; $i < sizeof($queryMoyen); $i++) { 
            $moyendepaiement[$queryMoyen[$i]['bal_vue_e400_modespaiement']['MoyenDePaiementNom']] = $queryMoyen[$i]['bal_vue_e400_modespaiement']['MoyenDePaiementNom'];
        }
        if (isset($moyendepaiement)) $this->set('moyendepaiement', $moyendepaiement);
        else $this->set('moyendepaiement', null);

        if (isset($entete['FactureId'])) {
            $factureId = $entete['FactureId'];
            if (!empty($factureId)) {
                $queryOperations = $this->Compta->query("SELECT * FROM bal_vue_e400_operations WHERE FactureId=$factureId;");
                for ($i=0; $i < sizeof($queryOperations); $i++) { 
                    foreach ($queryOperations[$i]['bal_vue_e400_operations'] as $key => $value) {
                        $operations[$i][$key] = $value;
                    }
                }
                $this->set('operations', $operations);
            }
        }
        else $this->set('operations', null);

        if ($this->request->is('post')) {
            if (!isset($this->request->data['Compta']['MontantRendu'], $this->request->data['Compta']['MontantPaiement'])) {
                $this->Session->setFlash('Exactement une valeur instanciée parmi Débit et Crédit.', 'flash/error');
                $this->redirect($this->referer());
            }
            else if (!empty($this->request->data['Compta']['MontantRendu']) &&  !empty($this->request->data['Compta']['MontantPaiement'])) {
                $this->Session->setFlash('Exactement une valeur instanciée parmi Débit et Crédit.', 'flash/error');
                $this->redirect($this->referer());
            }
            else if (!empty($this->request->data['Compta']['BanqueNom']) && $this->request->data['Compta']['MoyenDePaiementNom']!="Chèque") {
                $this->Session->setFlash('Le nom de la banque doit être seulement spécifié pour un paiement par chèque bancaire.', 'flash/error');
                $this->redirect($this->referer());
            }
            else {
                $saveOperation['PSessionId'] = $this->Session->read('Auth.User.SessionId');
                if ($this->request->data['Compta']['ComptabiliteId']=="") {
                    $saveOperation['PComptabiliteId'] = null;
                }
                else {
                    $saveOperation['PComptabiliteId'] = $this->request->data['Compta']['ComptabiliteId'];
                }
                $saveOperation['PFactureId'] = $this->request->data['Compta']['FactureId'];
                $saveOperation['PMoyenDePaiementNom'] = $this->request->data['Compta']['MoyenDePaiementNom'];
                if ($this->request->data['Compta']['BanqueNom']=="") {
                    $saveOperation['PBanqueNom'] = null;
                }
                else {
                    $saveOperation['PBanqueNom'] = $this->request->data['Compta']['BanqueNom'];
                }
                $saveOperation['PIdentifiantTransaction'] = $this->request->data['Compta']['IdentifiantTransaction'];
                if ($this->request->data['Compta']['MontantPaiement']=="") {
                    $saveOperation['PMontantPaiement'] = null;
                }
                else {$saveOperation['PMontantPaiement'] = $this->request->data['Compta']['MontantPaiement'];
                    $saveOperation['PMontantPaiement'] = $this->request->data['Compta']['MontantPaiement'];
                }
                if ($this->request->data['Compta']['MontantRendu']=="") {
                    $saveOperation['PMontantRendu'] = null;
                }
                else {$saveOperation['PMontantRendu'] = $this->request->data['Compta']['MontantRendu'];
                    $saveOperation['PMontantRendu'] = $this->request->data['Compta']['MontantRendu'];
                }
                $this->makeCall("Save_BAL_Vue_E400_Operations", $saveOperation);
                $this->Session->setFlash('Opération ajoutée/modifiée.', 'flash/success');
                $this->redirect($this->referer());
            }
        }
    }

    public function saveOperation($comptabiliteId=null, $factureId=null, $moyendepaiement=null, $banquenom=null, $identifiantTransaction=null, $montantPaiement=null, $montantRendu=null) {
        $saveOperation['PSessionId'] = $this->Session->read('Auth.User.SessionId');
        $saveOperation['PComptabiliteId'] = $comptabiliteId;
        $saveOperation['PFactureId'] = $factureId;
        $saveOperation['PMoyenDePaiementNom'] = $moyendepaiement;
        $saveOperation['PBanqueNom'] = $banquenom;
        $saveOperation['PIdentifiantTransaction'] = $identifiantTransaction;
        $saveOperation['PMontantPaiement'] = $montantPaiement;
        $saveOperation['PMontantRendu'] = $montantRendu;
        $this->makeCall("Save_BAL_Vue_E400_Operations", $saveOperation);
        $this->Session->setFlash('Opération modifiée.', 'flash/success');
        $this->redirect($this->referer());
    }

    public function deleteOperation($comptaid) {
        $deleteOperation['PSessionId'] = $this->Session->read('Auth.User.SessionId');
        $deleteOperation['PComptabiliteId'] = $comptaid;
        $this->makeCall("Delete_BAL_Vue_E400_Operations", $deleteOperation);
        $this->Session->setFlash('Opération supprimée.', 'flash/success');
        $this->redirect($this->referer());
    }

 /*
    Action lié a la maquette E401. Le but de cette action est d'afficher un tableau de toute 
    les opérations d'une association sur un exercice donné. Toute les opérations ne sont pas affichés en 1 seule page.
    Par défauts je trie les opérations par ordre alhpabétique du libellé. 
    L'argument correspond à la position dans le tableau d'opérations. La vue contient des bouttons qui 
    sont des liens vers la même action avec comme argmument $decalage +[cte selon le boutton]
    c'est ainsi que je gère le déplacement dans les opérations
    La vue permet également de supprimer des opérations et d'insérer des dates en série dedans .


 */
function E401($decalage =0){                
                 if ($this->request->is('post')) {    
                    // si aucune date a insérer toute la suite ne sert a rien.              
                    if (($this->request->data["maj_op"]["date Depot"] != "")||($this->request->data["maj_op"]["date Valeur"] != ""))
                    {

                        // parcours de la liste des champs
                         foreach ($this->request->data["maj_op"] as $key => $value) {
                            if (substr($key, 0,1)=='Z')// l'id des champs contenant les dates sont préfixés par Z ...
                            {

                                //... et par a ou b selon la colonne. Artisanal mais ca marche.
                                if (substr($key, 1,1)=='a') $provi = $this->request->data["maj_op"]["date Depot"]; else $provi =$this->request->data["maj_op"]["date Valeur"];
                                
                                // un champ peut contenir 3 valeurs
                                if ($value == 0) { // Date non renseigné et non coché -> rien a insérer
                                    $fields[substr($key, 2)][substr($key, 1,1)]= null;
                                }elseif ($value == 1) { // date non renseigné et coché -> il faut inserer la valeur entrée dans le champ tout en haut de la colonne

                                    $fields[substr($key, 2)][substr($key, 1,1)]= $provi;
                                    $fields[substr($key, 2)]["update"] = true; // on indique que l'opération doit être sauvegardé pour au moins 1 de ses champs
                                }else // date déja renseigné. On remet la même valeur.
                                {
                                    $fields[substr($key, 2)][substr($key, 1,1)]= $value;
                                }
                            }
                        }

                        foreach ($fields as $key => $value) {
                            if (isset($value["update"])) // update est set si l'une des 2 dates est a inserer.
                            {
                                //appel a la procédure fournie
                                $this->makeCall("Save_BAL_Vue_E401_Operations",
                                        array($_SESSION["Auth"]["User"]["SessionId"],$key, $value["a"],$value["b"]));
                            }
                        }
                    }
                          $this->redirect(
                         array('controller' => 'Comptas', 'action' => 'E401',$decalage + $this->request->data["maj_op"]["test"]));

                }            
                $size = 20; // nombre d'opérations par pages. 
                $requestOperations =$this->Compta->query("SELECT * FROM bal_vue_e401_operations Where ConseilFCPEId= ".$_SESSION['Association']['ConseilFCPEId']." and Exercice = ".$_SESSION['Exercice'] ." order by Libelle ;");
                 $nb_rep = count($requestOperations);
               //gestion d'erreurs sur l'index dans la liste des opérations.
                if ($decalage<0) { $this->redirect(
                         array('controller' => 'Comptas', 'action' => 'E401',0));}
                if ($decalage>$nb_rep) { $this->redirect(
                         array('controller' => 'Comptas', 'action' => 'E401', ((int) ($nb_rep/$size))*$size));}
                $this->set("op",$requestOperations);
                $this->set("decal",$decalage);
                $this->set("size",$size);
                $this->set("nb_rep",$nb_rep);
        }

        /*  
        Action Lié a E401. Supprime une opération via le call Delete_Bal_Vue_E401

        */
        function deleteOp($id,$decal)
        {
            $this->makeCall("Delete_BAL_Vue_E401_Operations",array($_SESSION["Auth"]["User"]["SessionId"],$id));
             $this->redirect(
                         array('controller' => 'Comptas', 'action' => 'E401', $decal));

        }

        /*
            generation de PDF des reçus fiscaux
        */
        public function e402($op = null){
        $assosId = $_SESSION['Association']['ConseilFCPEId'];
        $nomassoc = $_SESSION['Association']['ConseilFCPENom'];
        $exercice = $_SESSION['Exercice'];
        $this->set('nomassoc', $nomassoc);
        $this->set('exercice', $exercice);

        //reçus de tous les membres de l'associations
        if($op == 1){
            //création d'un PDF
            $pdfi = new FPDI();
            $releves = $this->Compta->find('all', array('conditions' => array('Compta.ConseilFCPEId' => $assosId , 'Compta.Exercice' => $exercice)));
           
            foreach ($releves as $key => $value) {
                //utilisation du template "recu.pdf" disponible dans le dossier "webroot"
                $pdfi->AddPage();
                $pageCount = $pdfi->setSourceFile("recu.pdf");
                $tplIdx = $pdfi->importPage(1);
                $pdfi->useTemplate($tplIdx);

                //décodage de chaque chaine afin de ne pas avoir de probleme d'accentuation
                $ordreRecu = utf8_decode($value['Compta']['NumeroDOrdre']);
                $conseilLocal = utf8_decode($value['Compta']['NomAssociation']);
                $nomprenom = utf8_decode( $value['Compta']['Personne']);
                $adresse1 = utf8_decode( $value['Compta']['Adresse2']);
                $adresse2 = utf8_decode( $value['Compta']['Adresse3']);
                $montantC = utf8_decode( $value['Compta']['MontantChiffres']) ."EUR";
                $montantL = utf8_decode( $value['Compta']['MontantLettres']);
                $date = utf8_decode( $value['Compta']['DateRecu']);
                $nomSignataire = utf8_decode( $value['Compta']['NomSignataire']);
                $qualiteSignataire = utf8_decode( $value['Compta']['QualiteSignataire']);
                $mode = utf8_decode( $value['Compta']['ModeDePaiement']);

                //selection de la police
                $pdfi->SetFont('Arial');
                //couleur de la police
                $pdfi->SetTextColor(255, 0, 0);

                //positionnement de la chaine à ecrire (mm)
                $pdfi->SetXY(152, 27);
                $pdfi->Write(0, $ordreRecu);

                $pdfi->SetXY(41, 57);
                $pdfi->Write(0, $conseilLocal);             

                $pdfi->SetXY(48, 86);
                $pdfi->Write(0, $nomprenom);

                $pdfi->SetXY(35, 96);
                $pdfi->Write(0, $adresse1);

                $pdfi->SetXY(65, 107);
                $pdfi->Write(0, $adresse2);

                $pdfi->SetXY(36, 122);
                $pdfi->Write(0, $montantC);

                $pdfi->SetXY(36, 127);
                $pdfi->Write(0, $montantL);

                $pdfi->SetXY(73, 141);
                $pdfi->Write(0, $date);

                $pdfi->SetXY(155, 241);
                $pdfi->Write(0, $nomSignataire);

                $pdfi->SetXY(155, 246);
                $pdfi->Write(0, $qualiteSignataire);

                //mode de paiement représenté par des "X"
                if($mode == "Especes"){
                    $pdfi->SetXY(14.5, 195.5);
                    $pdfi->Write(0, 'X');
                }
                elseif ($mode == "Chèque") {
                    $pdfi->SetXY(78, 195.5);
                    $pdfi->Write(0, 'X');
                }
                else{
                    $pdfi->SetXY(119.5, 195.5);
                    $pdfi->Write(0, 'X');
                }

            }
            $pdfi->Output("Recu.pdf", "D"); 
        }
        //reçus des membres de l'associations ne disposant pas de boite mail. le fonctionnement est exactement le même que ci dessus.
        else if($op == 2){
            $pdfi = new FPDI();

            $relevesSansMail = $this->Compta->query("SELECT * FROM bal_vue_e402_recufiscal NATURAL JOIN bal_interlocuteur WHERE ConseilFCPEId=$assosId AND Exercice=$exercice AND EMail IS NULL");

            foreach ($relevesSansMail as $key => $value) {
                $value = $value['bal_vue_e402_recufiscal'];
                $pdfi->AddPage();
                $pageCount = $pdfi->setSourceFile("recu.pdf");
                $tplIdx = $pdfi->importPage(1);
                $pdfi->useTemplate($tplIdx);

                $ordreRecu = utf8_decode($value['NumeroDOrdre']);
                $conseilLocal = utf8_decode($value['NomAssociation']);
                $nomprenom = utf8_decode( $value['Personne']);
                $adresse1 = utf8_decode( $value['Adresse2']);
                $adresse2 = utf8_decode( $value['Adresse3']);
                $montantC = utf8_decode( $value['MontantChiffres']) ."EUR";
                $montantL = utf8_decode( $value['MontantLettres']);
                $date = utf8_decode( $value['DateRecu']);
                $nomSignataire = utf8_decode( $value['NomSignataire']);
                $qualiteSignataire = utf8_decode( $value['QualiteSignataire']);
                $mode = utf8_decode( $value['ModeDePaiement']);


                $pdfi->SetFont('Arial');
                $pdfi->SetTextColor(255, 0, 0);
                $pdfi->SetXY(152, 27);
                $pdfi->Write(0, $ordreRecu);

                $pdfi->SetXY(41, 57);
                $pdfi->Write(0, $conseilLocal);             

                $pdfi->SetXY(48, 86);
                $pdfi->Write(0, $nomprenom);

                $pdfi->SetXY(35, 96);
                $pdfi->Write(0, $adresse1);

                $pdfi->SetXY(65, 107);
                $pdfi->Write(0, $adresse2);

                $pdfi->SetXY(36, 122);
                $pdfi->Write(0, $montantC);

                $pdfi->SetXY(36, 127);
                $pdfi->Write(0, $montantL);

                $pdfi->SetXY(73, 141);
                $pdfi->Write(0, $date);

                $pdfi->SetXY(155, 241);
                $pdfi->Write(0, $nomSignataire);

                $pdfi->SetXY(155, 246);
                $pdfi->Write(0, $qualiteSignataire);


                if($mode == "Especes"){
                    $pdfi->SetXY(14.5, 195.5);
                    $pdfi->Write(0, 'X');
                }
                elseif ($mode == "Chèque") {
                    $pdfi->SetXY(78, 195.5);
                    $pdfi->Write(0, 'X');
                }
                else{
                    $pdfi->SetXY(119.5, 195.5);
                    $pdfi->Write(0, 'X');
                }

            }
            $pdfi->Output("Recu.pdf", "D");
        }
    }

    /*
        gestion des modes de paiement
    */
    public function e404(){
        $moyenPayment = $this->Compta->query("SELECT * FROM bal_vue_e400_modespaiement");
        
        $this->set('moyenPayment',$moyenPayment);

        //ajout d'un nouveau moyen de paiement
        if ($this->request->is('post')) {
            $addMP['PSessionId'] = '';
            $addMP['PMoyenDePaiementNom'] = $this->request->data['paiement']['Designation'];

            if($this->request->data['paiement']['cb1'] == null)
                $addMP['PAvecTransactionsIdentifiees'] = 0;
            else    
                $addMP['PAvecTransactionsIdentifiees'] = $this->request->data['paiement']['cb1'];

            if($this->request->data['paiement']['cb2'] == null)
                $addMP['PAvecBanqueIdentifiee'] = 0;
            else    
                $addMP['PAvecBanqueIdentifiee'] = $this->request->data['paiement']['cb2'];

            $addMP['PValeurMaximale'] = $this->request->data['paiement']['ValeurMaximale'];

            $this->makeCall("Save_BAL_Vue_E400_ModesPaiement", $addMP);
            $this->redirect(array('controller' => 'Comptas', 'action' => 'E404'));
        }
    }

    /*
        fonction permettant de supprimer un moyen de paiement
    */
    public function delMP($mode = null){
        $delMP['PSessionId'] = '';
        $delMP['PMoyenDePaiementNom'] = $mode;
        $this->makeCall("Delete_BAL_Vue_E400_ModesPaiement", $delMP);
        $this->redirect(array('controller' => 'Comptas', 'action' => 'E404'));
    }

    /*
        fonction permettant de modifier un moyen de paiement 
    */
    public function updateMP($a1 = null ,$a2 = 0,$a3 = 0,$a4 = null){
        $updateMP['PSessionId'] = '';
        $updateMP['PMoyenDePaiementNom'] = $a1;
        $updateMP['PAvecTransactionsIdentifiees'] = $a2;
        $updateMP['PAvecBanqueIdentifiee'] = $a3;
        $updateMP['PValeurMaximale'] = $a4;

        debug($updateMP);
        $this->makeCall("Save_BAL_Vue_E400_ModesPaiement", $updateMP);
        $this->redirect($this->referer());
        $this->redirect(array('controller' => 'Comptas', 'action' => 'E404'));
    }
}

?>
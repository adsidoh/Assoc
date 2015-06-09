<?php

class ResponsablesController extends AppController {

    public function beforeFilter(){
      parent::beforeFilter();

    }
    
    /*
      gestion d'un responsable legale
    */
    public function e100() {
      $interlocuteur = $_SESSION['Dossier']['Parent']['InterlocuteurId'];
      $perso = $this->Responsable->find('all', array('conditions' => array('Responsable.InterlocuteurId' => $interlocuteur)));

      $perso = $perso[0]['Responsable'];      
       
      //recuperation des numéros de telephones de la personne
      $teltmp = $this->Responsable->query("SELECT * FROM bal_vue_e100_tel WHERE InterlocuteurId = $interlocuteur;");
      foreach ($teltmp as $key => $value) {
        $tel[$key] = $value['bal_vue_e100_tel']['TelephoneNum'];
      }
      $this->set('perso', $perso);
      if (isset($tel))
        $this->set('tel', $tel);

      if ($this->request->is('post')) {
          
        if ($this->request->data['Responsable']['ParentAppellation'] == 'Monsieur')
          $appellation = 1;
        else
          $appellation = 0;

        if ($this->request->data['Responsable']['AdNiveauDInformationNom'] == 0)
          $ni = "Personnel";
        else if ($this->request->data['Responsable']['AdNiveauDInformationNom'] == 1)
          $ni = "Personnel & Association";
        else
          $ni = "Personnel & Association & Tutelles";

        
        $uperso['PSessionId' ] = $_SESSION['Auth']['User']['SessionId'];
        $uperso['PConseilFCPEId' ] = $_SESSION['Association']['ConseilFCPEId'];
        $uperso['PExercice' ] =  $_SESSION['Exercice'];
        $uperso['PPersonneId' ] = $perso['PersonneId'];
        $uperso['PPersonneNom' ] = $this->request->data['Responsable']['ParentNom'];
        $uperso['PPersonnePrenom' ] = $this->request->data['Responsable']['ParentPrenom'];
        $uperso['PPersonneMasculin' ] = $appellation;
        $uperso['PInterlocuteurId' ] = $perso['InterlocuteurId'];
        $uperso['PEMail' ] = $this->request->data['Responsable']['AdMail'];
        $uperso['PEMailValide' ] = $perso['EMailValide'];
        $uperso['PPassword' ] = $perso['Password'];
        $uperso['PNiveauDInformationNom' ] = $this->request->data['Responsable']['AdNiveauDInformationNom'];
        $uperso['PEndroitId' ] = null;
        $uperso['PNumEtVoie' ] = $this->request->data['Responsable']['AdNumEtVoie'];
        $uperso['PLieuDit' ] = $this->request->data['Responsable']['AdLieuDit'];
        $uperso['PVille' ] = $this->request->data['Responsable']['AdVille'];
        $uperso['PPays' ] = $perso['Pays'];
        $uperso['PCodePostal' ] = $this->request->data['Responsable']['AdCodePostal'];
        $uperso['PApptBatResidence' ] = $this->request->data['Responsable']['AdApptBatResidence'];
        $uperso['PBP' ] = $this->request->data['Responsable']['AdBP'];
        $this->makeCall("Save_BAL_Vue_E100_Personne", $uperso);
        $this->redirect(array('controller'=>'Responsables', 'action'=>'e100'));

      }
    }

    /*
      création d'un nouveau responsable legale
    */
    public function e100new(){
      $user = $_SESSION['Auth']['User']['SessionId'];
      if ($this->request->is('post')) {
        if ($this->request->data['Responsable']['ParentAppellation'] == 0)
          $appellation = 1;
        else
          $appellation = 0;

        if ($this->request->data['Responsable']['AdNiveauDInformationNom'] == 0)
          $ni = "Personnel";
        else if ($this->request->data['Responsable']['AdNiveauDInformationNom'] == 1)
          $ni = "Personnel & Association";
        else
          $ni = "Personnel & Association & Tutelles";


        $uperso['PSessionId' ] = $_SESSION['Auth']['User']['SessionId'];
        $uperso['PConseilFCPEId' ] = $_SESSION['Association']['ConseilFCPEId'];
        $uperso['PExercice' ] =  $_SESSION['Exercice'];
        $uperso['PPersonneId' ] = null;
        $uperso['PPersonneNom' ] = $this->request->data['Responsable']['ParentNom'];
        $uperso['PPersonnePrenom' ] = $this->request->data['Responsable']['ParentPrenom'];
        $uperso['PPersonneMasculin' ] = $appellation;
        $uperso['PInterlocuteurId' ] = null;
        $uperso['PEMail' ] = $this->request->data['Responsable']['AdMail'];
        $uperso['PEMailValide' ] = null;
        $uperso['PPassword' ] = null;
        $uperso['PNiveauDInformationNom' ] = $ni;
        $uperso['PEndroitId' ] = null;
        $uperso['PNumEtVoie' ] = $this->request->data['Responsable']['AdNumEtVoie'];
        $uperso['PLieuDit' ] = $this->request->data['Responsable']['AdLieuDit'];
        $uperso['PVille' ] = $this->request->data['Responsable']['AdVille'];
        $uperso['PPays' ] = "france";
        $uperso['PCodePostal' ] = $this->request->data['Responsable']['AdCodePostal'];
        $uperso['PApptBatResidence' ] = $this->request->data['Responsable']['AdApptBatResidence'];
        $uperso['PBP' ] = $this->request->data['Responsable']['AdBP'];
        $this->makeCall("Save_BAL_Vue_E100_Personne", $uperso);

        //recuperation de l'id du parent crée
        $nouveauParentId = $this->Responsable->query("SELECT SUIVIIDLastId FROM bal_suiviid WHERE SUIVIIDSessionId = '$user' AND SUIVIIDTableNom = 'BAL_Personne' ORDER BY SUIVIIDId DESC LIMIT 0,1;");
        //recuperation de l'interlocuteurId du parent crée
        $nouveauParentInterlocuteurId = $this->Responsable->query("SELECT SUIVIIDLastId FROM bal_suiviid WHERE SUIVIIDSessionId = '$user' AND SUIVIIDTableNom = 'BAL_Interlocuteur' ORDER BY SUIVIIDId DESC LIMIT 0,1;");
         //recuperation de l'endroitId du parent crée
        $nouveauParentEndroitId= $this->Responsable->query("SELECT SUIVIIDLastId FROM bal_suiviid WHERE SUIVIIDSessionId = '$user' AND SUIVIIDTableNom = 'BAL_Endroit' ORDER BY SUIVIIDId DESC LIMIT 0,1;");
        unset($_SESSION['Dossier']);

        $this->Session->write('Dossier.Parent.ParentId',$nouveauParentId[0]['bal_suiviid']['SUIVIIDLastId']);
        $this->Session->write('Dossier.Parent.InterlocuteurId',$nouveauParentInterlocuteurId[0]['bal_suiviid']['SUIVIIDLastId']);
        $this->Session->write('Dossier.Parent.EndroitId',$nouveauParentEndroitId[0]['bal_suiviid']['SUIVIIDLastId']);

        $this->Session->write('Dossier.Parent.PersonneNom' , $uperso['PPersonneNom' ]);
        $this->Session->write('Dossier.Parent.PersonnePrenom' , $uperso['PPersonnePrenom' ]);
       
        $this->Session->setFlash('Parent créé.', 'flash/success');
        $this->redirect(array('controller'=>'Responsables', 'action'=>'e100'));
      }
    


if ($this->request->is('post')) {
            /**
             * Si un champs est vide alors qu'il ne doit pas l'être
             */
            if ($this->request->data['Personne']['PersonneNom']=='' //||
                //$this->request->data['Personne']['PPSCNumEtVoie']=='' ||
               // $this->request->data['Personne']['PEMail']=='' ||
                //$this->request->data['Personne']['PNumEtVoie']=='' ||
                //$this->request->data['Personne']['PLieuDit']=='' ||
                //$this->request->data['Personne']['PPays']=='' ||
                //$this->request->data['Personne']['PCodePostal']=='' ||
                //$this->request->data['Personne']['PApptBatResidence']=='' ||
                //$this->request->data['Personne']['PBP']=='' 
                )
            {
               $this->redirect(array('controller' => 'users', 'action' => 'asso'));
               // $this->Session->setFlash('Veuillez compléter les champs obligatoires.', 'flash/error');
               // $this->redirect($this->referer());
            }
}

}


    

    /*
      supression d'un responsable legale
    */
    public function e100del(){

      $interlocuteur = $_SESSION['Dossier']['Parent']['InterlocuteurId'];
      //recuperation des information de la personne
      $perso = $this->Responsable->find('all', array(
          'conditions' => array('Responsable.InterlocuteurId' => $interlocuteur)));

      $perso = $perso[0]['Responsable'];      
       
      //recuperation des numeros de telephone la personne
      $teltmp = $this->Responsable->query("SELECT * FROM bal_vue_e100_tel WHERE InterlocuteurId = $interlocuteur;");
      foreach ($teltmp as $key => $value) {
        $teltmp[$key] = $value['bal_vue_e100_tel']['TelephoneNum'];
      }
      $this->set('perso', $perso);
      $this->set('teltmp', $teltmp);
    
    }

    /*
      fonction associé à e100del
    */
    public function deletePerso(){
      //supression d'une personne
      $perso['PSessionId'] = $_SESSION['Auth']['User']['SessionId'];
      $perso['PPersonneId'] = $_SESSION['Dossier']['Parent']['ParentId'];
      $this->makeCall("Delete_BAL_Vue_E100_Personne", $perso);
      unset($_SESSION['Dossier']);
      $this->redirect("/");
    }

    /*
      fonction associé à e100 afin de géré les numeros de téléphone
    */
    public function deletetel($num = null, $op = null){
      //gestion des ajout/supression des numeros de telephone

      $usrInterlocuteur = $_SESSION['Auth']['User']['SessionId'];
      $interlocuteur = $_SESSION['Dossier']['Parent']['InterlocuteurId'];
      if($op == 0){
        //supression
        $this->Responsable->query("call Delete_BAL_Vue_E100_Tel('$usrInterlocuteur', $interlocuteur, '$num' )");
        $this->Session->setFlash('Numéro supprimé.', 'flash/success');
        $this->redirect(array('controller'=>'Responsables', 'action'=>'e100'));
      }
      else{
        //ajout
        $NewTel['PSessionId'] = $usrInterlocuteur;
        $NewTel['PInterlocuteurId'] =  $interlocuteur;
        $NewTel['PTelephoneNum'] = $num;
        $this->makeCall("Save_BAL_Vue_E100_Tel", $NewTel);
        $this->Session->setFlash('Numéro ajouté.', 'flash/success');
        $this->redirect(array('controller'=>'Responsables', 'action'=>'e100'));
      }
    }


    /*
      gestion des adhesions d'un responsable legale
    */
    public function e101() {
      $exercice = $_SESSION['Exercice'];
      $interlocuteur = $_SESSION['Dossier']['Parent']['ParentId'];///////////////////////////////////////////////////////////////////////////////
      $perso = $this->Responsable->find('all', array(
        'conditions' => array('Responsable.PersonneId' => $interlocuteur)));

      $perso = $perso[0]['Responsable'];     
      $this->set('perso', $perso);


      $assocCouranteID = $_SESSION['Association']['ConseilFCPEId'];
      //recuperation du nom de l'association courante
      $assocCourante = $this->Responsable->query("SELECT * FROM bal_conseilfcpe WHERE ConseilFCPEId = $assocCouranteID");
      $assocCourante = $assocCourante[0]['bal_conseilfcpe']['ConseilFCPENom'];      
      $this->set('assocCourante', $assocCourante);

      //recuperation des id des tutelles de l'association courante
      $tutelle[0] = $this->Responsable->query("SELECT * FROM bal_vue_e101_tutelle WHERE AffilieeId = $assocCouranteID;");
      $i = 1;      
      while (count($tutelle) == $i){
        $tmp = $i-1;

        $tuId = $tutelle[$tmp][0]['bal_vue_e101_tutelle']['TutelleId'];
        $tu = $this->Responsable->query("SELECT * FROM bal_vue_e101_tutelle WHERE AffilieeId = $tuId;");

          if(count($tu) == 1)
            $tutelle[$i] = $tu;
  
        $i++;
      }

      //recuperation des nom des tutelles de l'association courante
      foreach ($tutelle as $key => $value) {
        $tuId = $tutelle[$key][0]['bal_vue_e101_tutelle']['TutelleId'];
        $assocTu = $this->Responsable->query("SELECT * FROM bal_conseilfcpe WHERE ConseilFCPEId = $tuId");
        $assocTu = $assocTu[0]['bal_conseilfcpe']['ConseilFCPENom']; 
        $assoc[$key] = $assocTu;
      }
      $this->set('assoc', $assoc);

      //recherche si la personne adhere à l'association courante
      $adhesionTmp = $this->Responsable->query("SELECT * FROM bal_vue_e101_adhesion WHERE PersonneId = $interlocuteur AND ConseilFCPEId = $assocCouranteID AND Exercice = $exercice");
      if($adhesionTmp != null){
          $factureId = $adhesionTmp[0]['bal_vue_e101_adhesion']['FactureId'];
          $facture = $this->Responsable->query("SELECT * FROM bal_facture WHERE FactureId = $factureId");
          $adhesion[0] = $facture[0]['bal_facture']['CreationFact'];
      }
      else
         $adhesion[0] = null;

       //recherche si la personne adhere aux associations de tutelle de l'association courante
      foreach ($tutelle as $key => $value) {
        $tuId = $tutelle[$key][0]['bal_vue_e101_tutelle']['TutelleId'];

        $adhesionTmp = $this->Responsable->query("SELECT * FROM bal_vue_e101_adhesion WHERE PersonneId = $interlocuteur AND ConseilFCPEId = $tuId AND Exercice = $exercice");
        
        if($adhesionTmp != null){
          $factureId = $adhesionTmp[0]['bal_vue_e101_adhesion']['FactureId'];
          $facture = $this->Responsable->query("SELECT * FROM bal_facture WHERE FactureId = $factureId");
          $adhesion[$key+1] = $facture[0]['bal_facture']['CreationFact'];
        }
        else
          $adhesion[$key+1] = null;
      }
      $this->set('adhesion', $adhesion);
    }

    /*
      fonction associé à e100
    */
    public function gestionAdhesion($assoc = null, $op = null) {
      $interlocuteur = $_SESSION['Dossier']['Parent']['ParentId'];
      $exercice = $_SESSION['Exercice'];

      $fcpe = $this->Responsable->query("SELECT * FROM bal_conseilfcpe");
      
      foreach ($fcpe as $key => $value) {
        if ($value['bal_conseilfcpe']['ConseilFCPENom'] == $assoc)
            $assocCouranteID = $value['bal_conseilfcpe']['ConseilFCPEId'];
      }

      //recuperation des associations de tutelle
      $tutelle[0] = $this->Responsable->query("SELECT * FROM bal_vue_e101_tutelle WHERE AffilieeId = $assocCouranteID;");
      $i = 1;      
      while (count($tutelle) == $i){
        $tmp = $i-1;

        $tuId = $tutelle[$tmp][0]['bal_vue_e101_tutelle']['TutelleId'];
        $tu = $this->Responsable->query("SELECT * FROM bal_vue_e101_tutelle WHERE AffilieeId = $tuId;");

          if(count($tu) == 1)
            $tutelle[$i] = $tu;
  
        $i++;
      }

      $addAdhesion['PSessionId'] = $_SESSION['Auth']['User']['SessionId'];
      $addAdhesion['PPersonneId'] = $interlocuteur;
      $addAdhesion['PConseilFCPEId'] = $assocCouranteID;
      $addAdhesion['PExercice'] = $exercice;

      if($op == 1){
        //adhesion d'une personne
        $this->makeCall("Save_BAL_Vue_E101_Adhesion", $addAdhesion);
          foreach ($tutelle as $key => $value) {
            $addAdhesion['PConseilFCPEId'] = $value[0]['bal_vue_e101_tutelle']['TutelleId'];
            $this->makeCall("Save_BAL_Vue_E101_Adhesion", $addAdhesion);
          }

      }
      else{
        //desadhesion d'une personne
        $this->makeCall("Delete_BAL_Vue_E101_Adhesion", $addAdhesion);
        //recherche si la personne adhere deja à une association de tutelle via une autre association local
        foreach ($tutelle as $key => $value) {
          $addAdhesion['PConseilFCPEId'] = $value[0]['bal_vue_e101_tutelle']['TutelleId'];
          $tuId = $addAdhesion['PConseilFCPEId'];

          $bla = $this->Responsable->query("SELECT * FROM bal_vue_e101_tutelle INNER JOIN bal_vue_e101_adhesion ON bal_vue_e101_tutelle.AffilieeId = bal_vue_e101_adhesion.ConseilFCPEId WHERE bal_vue_e101_adhesion.PersonneId = $interlocuteur AND bal_vue_e101_tutelle.TutelleId = $tuId AND Exercice = $exercice;");
          debug($value);
          debug($bla);
          if(count($bla)<1)
            $this->makeCall("Delete_BAL_Vue_E101_Adhesion", $addAdhesion);
        }
      }

    $this->redirect(array('controller'=>'Responsables', 'action'=>'e101'));
    }

}


?>
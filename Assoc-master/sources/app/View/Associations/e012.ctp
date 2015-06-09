<div class="row">
<div class="col-md-10 col-md-offset-1">

<h2>Création d'espace d'association</h2>

</br></br>

<?php

    echo $this->Form->create('Association', array(
        'class' => 'form-horizontal',
        'inputDefaults' => array(
            'div' => 'form-group',
            'class' => 'form-control',
            'format' => array('label', 'before', 'input', 'after'),
            'before' => '<div class="col-md-10">',
            'after' => '</div>'
        )
    ));

?>

</br></br>
<p style="font-size:x-large; font-style:normal;">Association</p>

<?php  
    echo $this->Form->hidden('PSessionId');

    echo $this->Form->hidden('PInterlocuteurId');;

    echo $this->Form->hidden('PConseilFCPEId');

    echo $this->Form->input('PConseilFCPENom', array(
        'class' => 'form-control',
        'placeholder' => 'Nom d\'association',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Nom d\'association'
        )
    )); 

    echo $this->Form->input('PTutelleId', array(
        'class' => 'form-control',
        'options' => $tutelle,
        'empty' => '',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Demande d\'affiliation à'
        )
    ));

?>

</br></br>
<p style="font-size:x-large; font-style:normal;">Siège social</p>

<?php  

    echo $this->Form->hidden('PEtablissementId');

    echo $this->Form->hidden('PSCEndroitId');

    echo $this->Form->input('PSCNumEtVoie', array(
        'class' => 'form-control',
        'placeholder' => 'Numéro, Voie',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Numéro, Voie'
        )
    )); 

    echo $this->Form->input('PSCLieuDit', array(
        'class' => 'form-control',
        'placeholder' => 'Lieu-Dit',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Lieu-Dit'
        )
    )); 

    echo $this->Form->input('PSCVille', array(
        'class' => 'form-control',
        'placeholder' => 'Ville',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Ville'
        )
    ));

    echo $this->Form->input('PSCPays', array(
        'class' => 'form-control',
        'placeholder' => 'Pays',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Pays'
        )
    ));

    echo $this->Form->input('PSCCodePostal', array(
        'class' => 'form-control',
        'placeholder' => 'Code Postal',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Code Postal'
        )
    ));
    
    echo $this->Form->input('PSCApptBatResidence', array(
        'class' => 'form-control',
        'placeholder' => 'Appt, Bât, Résidence',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Appt, Bât, Résidence'
        )
    )); 

    echo $this->Form->input('PSCBP', array(
        'class' => 'form-control',
        'placeholder' => 'BP',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'BP'
        )
    ));
?>

</br></br>
<p style="font-size:x-large; font-style:normal;">Etablissement scolaire</p>

<?php

    echo $this->Form->input('PEtablissementNom', array(
        'class' => 'form-control',
        'placeholder' => 'Nom de l\'établissement',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Nom de l\'établissement'
        )
    ));

    echo $this->Form->input('PTypeDEtablissementNom', array(
        'class' => 'form-control',
        'options' => array('Lycée'=>'Lycée', 'Collège'=> 'Collège', 'Primaire' => 'Primaire'),
        'empty' => '',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Etablissement scolaire'
        )
    ));

    echo $this->Form->hidden('PEtabEndroitId');

    echo $this->Form->input('PEtabNumEtVoie', array(
        'class' => 'form-control',
        'placeholder' => 'Numéro, Voie',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Numéro, Voie'
        )
    ));

    echo $this->Form->input('PEtabLieuDit', array(
        'class' => 'form-control',
        'placeholder' => 'Lieu-Dit',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Lieu-Dit'
        )
    ));    

    echo $this->Form->input('PEtabVille', array(
        'class' => 'form-control',
        'placeholder' => 'Ville',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Ville'
        )
    ));

    echo $this->Form->input('PEtabPays', array(
        'class' => 'form-control',
        'placeholder' => 'Pays',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Pays'
        )
    ));

    echo $this->Form->input('PEtabCodePostal', array(
        'class' => 'form-control',
        'placeholder' => 'Code Postal',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Code Postal'
        )
    ));

    echo $this->Form->input('PEtabApptBatResidence', array(
        'class' => 'form-control',
        'placeholder' => 'Appt, Bat, Residence',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'Appt, Bat, Residence'
        )
    ));

    echo $this->Form->input('PEtabBP', array(
        'class' => 'form-control',
        'placeholder' => 'BP',
        'label' => array(
            'class' => 'col-sm-2 control-label',
            'text' => 'BP'
        )
    ));

?>

<div class="col-sm-offset-2 col-sm-10">
<?php
    echo $this->Form->submit('Enregistrer', array(
        'type' => 'submit',
        'class' => 'btn btn-default'
    ));
?>

</div>
</div>
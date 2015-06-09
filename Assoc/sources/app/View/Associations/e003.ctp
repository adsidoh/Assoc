<div class="row">
	<div class="col-md-5">
		<p style="font-size:x-large; font-style:normal;">Association</p>
		<?php 
			echo $this->Form->create('Association', array(
		        'inputDefaults' => array(
		            'div' => 'form-group',
		            'class' => 'form-control'
		        )
		    ));

		    echo $this->Form->input('ConseilFCPEId', array(
		    	'class' => 'form-control',
		        'value' => $assocCourrante['ConseilFCPEId'],
		        'disabled' => true,
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Identifiant association'
		        )
		    ));

		    echo $this->Form->input('ConseilFCPENom', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['ConseilFCPENom'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Nom association'
		        )
		    ));

		    echo $this->Form->input('TutelleId', array(
		        'class' => 'form-control',
		        'disabled' => true,
		        'value' => $assocCourrante['TutelleId'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Affiliation'
		        )
		    ));

		    echo $this->Form->input('AdministrateurId', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Administrateur'
		        )
		    ));

		?>
		</br></br>
		<p style="font-size:x-large; font-style:normal;">Siège social</p>
		<?php 
			echo $this->Form->input('SCNumEtVoie', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCNumEtVoie'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Numéro, Voie'
		        )
		    ));

		    echo $this->Form->input('SCApptBatResidence', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCApptBatResidence'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appt, Bat, Résidence'
		        )
		    ));

		    echo $this->Form->input('SCLieuDit', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCLieuDit'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Lieu-Dit'
		        )
		    ));

		    echo $this->Form->input('SCVille', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCVille'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Ville'
		        )
		    ));

		    echo $this->Form->input('SCCodePostal', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCCodePostal'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Code postal'
		        )
		    ));

		    echo $this->Form->input('SCBP', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['SCBP'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'BP'
		        )
		    ));

		?>
		
	</div>
	<div class="col-md-2">
	</div>
	<div class="col-md-5">
		<p style="font-size:x-large; font-style:normal;">Etablissement scolaire</p>
		<?php
			echo $this->Form->input('TypeDEtablissementNom', array(
		        'class' => 'form-control',
		        'options' => array('Lycée' => 'Lycée', 'Collège' => 'Collège', 'Primaire' => 'Primaire'),		        
		        'selected' => $assocCourrante['TypeDEtablissementNom'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Type'
		        )
		    ));

		    echo $this->Form->input('EtablissementNom', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtablissementNom'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Nom'
		        )
		    ));

		    echo $this->Form->input('EtabNumEtVoie', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabNumEtVoie'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Numéro, Voie'
		        )
		    ));

		    echo $this->Form->input('EtabApptBatResidence', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabApptBatResidence'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appt, Bat, Résidence'
		        )
		    ));

		    echo $this->Form->input('EtabLieuDit', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabLieuDit'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Lieu-Dit'
		        )
		    ));

		    echo $this->Form->input('EtabVille', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabVille'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Ville'
		        )
		    ));

		    echo $this->Form->input('EtabCodePostal', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabCodePostal'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Code postal'
		        )
		    ));

		    echo $this->Form->input('EtabBP', array(
		        'class' => 'form-control',
		        'value' => $assocCourrante['EtabBP'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'BP'
		        )
		    ));
		?>

		</br></br>
		<?php
		    echo $this->Form->submit('Enregistrer', array(
		        'type' => 'submit',
		        'class' => 'btn btn-default'
		    ));
		?>

	</div>
</div>
<h2>Création d'espace d'utilisateur</h2>

</br></br>

<div class="row">
	<div class="col-md-5">
		<p style="font-size:x-large; font-style:normal;">Identité</p>
		<?php 
			echo $this->Form->create('User', array(
		        'inputDefaults' => array(
		            'div' => 'form-group',
		            'class' => 'form-control'
		        )
		    ));

		    echo $this->Form->hidden('PPersonneId');

		    echo $this->Form->input('PPersonneNom', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Nom'
		        )
		    ));

		    echo $this->Form->input('PPersonnePrenom', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Prénom'
		        )
		    ));
		?>
		
		<label class="control-label">Sexe</label>
		<?php
			echo $this->Form->input('PPersonneMasculin', array(
				'class' => 'radio-inline',
				'type' => 'radio',
				'label' => false,
				'legend' => false,
				'options' => array('0' => 'Féminin', '1' => 'Masculin')
			));
		?>
		
		</br></br>
		<p style="font-size:x-large; font-style:normal;">Adresse</p>

		<?php
			echo $this->Form->hidden('PEndroitId');

		    echo $this->Form->input('PNumEtVoie', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Numéro, Voie'
		        )
		    ));

		    echo $this->Form->input('PLieuDit', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Lieu-Dit'
		        )
		    ));

		    echo $this->Form->input('PVille', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Ville'
		        )
		    ));

		    echo $this->Form->input('PPays', array(
		        'class' => 'form-control',
		        'options' => array('France' => 'France'),
		        'empty' => '',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Pays'
		        )
		    ));

		     echo $this->Form->input('PCodePostal', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Code Postal'
		        )
		    ));

		   	echo $this->Form->input('PApptBatResidence', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appt, Bat, Résidence'
		        )
		    ));

		    echo $this->Form->input('PBP', array(
		        'class' => 'form-control',
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
		<p style="font-size:x-large; font-style:normal;">Téléphone</p>
		<?php
			echo $this->Form->hidden('PInterlocuteurId');

			echo $this->Form->input('PTelephoneNum', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Téléphone'
		        )
		    ));
		?>

		</br></br></br></br></br></br>
		<p style="font-size:x-large; font-style:normal;">Informations de connexion</p>
		<?php  
			echo $this->Form->input('PEMail', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'EMail'
		        )
		    ));

		    echo $this->Form->input('PEMailConf', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Vérification EMail'
		        )
		    ));

		    echo $this->Form->input('PEMailValide', array(
		    	'value' => 0,
		    	'type' => 'hidden'
		    ));

		    echo $this->Form->input('PPassword', array(
		        'class' => 'form-control',
		        'type' => 'password',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Mot de passe'
		        )
		    ));

		    echo $this->Form->input('PPasswordConf', array(
		        'class' => 'form-control',
		        'type' => 'password',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Verif. Mot de passe'
		        )
		    ));
		?>

		</br></br>
		<?php
		    echo $this->Form->submit('Enregistrer', array(
		        'rule' => 'submit',
		        'class' => 'btn btn-default'
		    ));

		    echo $this->Form->end();
		?>

	</div>
</div>
<?php if( !isset($validerMail) ) {  ?>
<h4> Avant la cr&eacute;ation de votre association, il vous faut cr&eacute;er un espace d'utilisateur. <br/> <br/> 
</h4>
<h3> Creation d'un espace d'utilisateur</h3>
Les champs en <span style="color:red"> *</span> sont obligatoires
<br/> <br/>
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
		            'text' => 'Nom  <span style="color:red"> *</span> '
		        )
		    ));

		    echo $this->Form->input('PPersonnePrenom', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Prénom <span style="color:red"> *</span>'
		        )
		    ));
		?>
		
		<label class="control-label">Sexe <span style="color:red">*</span></label>
		<?php
			echo $this->Form->input('PPersonneMasculin', array(
				'class' => 'radio-inline',
				'type' => 'radio',
				'label' => false,
				'legend' => false,
				'options' => array('0' => 'Féminin', '1' => 'Masculin')
			));
		?>
		
		</br>
		<p style="font-size:x-large; font-style:normal;">Adresse</p>

		<?php
			echo $this->Form->hidden('PEndroitId');

			echo $this->Form->input('PApptBatResidence', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appt, Bat, Résidence'
		        )
		    ));
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


		    echo $this->Form->input('PBP', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'BP'
		        )
		    ));

		    echo $this->Form->input('PVille', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Ville <span style="color:red">*</span>'
		        )
		    ));

		     echo $this->Form->input('PCodePostal', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Code Postal <span style="color:red">*</span>'
		        )
		    ));

		    echo $this->Form->input('PPays', array(
		        'class' => 'form-control',
		        'options' => array('France' => 'France'),
		        'empty' => '',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Pays <span style="color:red">*</span>'
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
		            'text' => 'Téléphone <span style="color:red">*</span>'
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
		            'text' => 'EMail <span style="color:red">*</span>'
		        )
		    ));

		    echo $this->Form->input('PEMailConf', array(
		        'class' => 'form-control',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Vérification EMail <span style="color:red">*</span>'
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
		            'text' => 'Mot de passe <span style="color:red">*</span> '
		        )
		    ));

		    echo $this->Form->input('PPasswordConf', array(
		        'class' => 'form-control',
		        'type' => 'password',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Verif. Mot de passe <span style="color:red">*</span>'
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

<?php }

else{ ?>
	
<p> Votre compte a bien &eacute;t&eacute; cr&eacute;e et un mail de confirmation a &eacute;t&eacute; envoy&eacute; a cette adresse <?php echo $email; ?> </p>

<p> Pour continuer la cr&eacute;ation de votre association, vous devez vous connecter &agrave; cette adresse afin de pouvoir valider votre adresse mail. </p>  

<?php } ?>
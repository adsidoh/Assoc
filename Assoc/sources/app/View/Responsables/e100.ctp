<div class="row">
	<!--IDENTITE -->
	<div class="col-md-5">
		<p style="font-size:x-large; font-style:normal;">Identité</p>

		<?php 
			echo $this->Form->create('Responsable', array(
		        'inputDefaults' => array(
		            'div' => 'form-group',
		            'class' => 'form-control'
		        )
		    ));

			if ($perso['PersonneMasculin'] == 1)
				$Appellation = "Monsieur";
			else
				$Appellation = "Madame";

		    echo $this->Form->input('ParentAppellation', array(
		        'class' => 'form-control',
		        'options' => array('Monsieur' => 'Monsieur', 'Madame' => 'Madame'),
		        'selected' => $Appellation,
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appellation'
		        )
		    ));

		    echo $this->Form->input('ParentNom', array(
		        'class' => 'form-control',
		        'value' => $perso['PersonneNom'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Nom'
		        )
		    ));

		    echo $this->Form->input('ParentPrenom', array(
		        'class' => 'form-control',
		        'value' => $perso['PersonnePrenom'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Prenom'
		        )
		    ));
		?>
		</br>

		<!--Telephone -->
		<table class="table table-striped">
			<tr>
				<td>
	    		<span class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'Responsables', 'action'=>'deletetel')); ?>/" + document.getElementById("NewTel").value +"/1";'>Ajouter</span>
	    		</td>	    		
	    		<td>
					<INPUT id= "NewTel" type="text" placeholder="Numero?">
				</td>
			</tr>
			<?php 
				if (isset($tel)){
			    foreach ($tel as $key => $value) {
			?>
				<tr>
					<td>
			    		<a href="<?php echo $this->Html->url(array('controller'=>'Responsables', 'action'=>'deletetel',$value , 0)); ?>" class="btn btn-default" role="button">supprimer</a>
			    	</td>
			    	<td>			    		
						<p style="font-size:x-large; font-style:normal;"><?php echo $value; ?></p>			    						    	
				    </td>			    	
				</tr>
			<?php
				}}
			?>
		</table>
	</div>
	<div class="col-md-2">
	</div>

	<!-- ADRESSE -->
	<div class="col-md-5">
		<p style="font-size:x-large; font-style:normal;">Adresse</p>

		<?php

		    echo $this->Form->input('AdApptBatResidence', array(
		        'class' => 'form-control',
		        'value' => $perso['ApptBatResidence'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Appt, Bât, Résidence'
		        )
		    ));

		    echo $this->Form->input('AdNumEtVoie', array(
		        'class' => 'form-control',
		        'value' => $perso['NumEtVoie'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Numéro, Voie'
		        )
		    ));

		    echo $this->Form->input('AdLieuDit', array(
		        'class' => 'form-control',
		        'value' => $perso['LieuDit'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Lieu-Dit'
		        )
		    ));

		    echo $this->Form->input('AdVille', array(
		        'class' => 'form-control',
		        'value' => $perso['Ville'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Ville'
		        )
		    ));
		    ?>

		    <div class="row">
			    <div class="col-md-5">
			    <?php
			    echo $this->Form->input('AdCodePostal', array(
			        'class' => 'form-control',
			        'value' => $perso['CodePostal'],
			        'label' => array(
			            'class' => 'control-label',
			            'text' => 'Code postal'
			        )
			    ));
			    ?>
			    </div>
			    <div class="col-md-2">
				</div>

				<div class="col-md-5">
			    <?php
			    echo $this->Form->input('AdBP', array(
			        'class' => 'form-control',
			        'value' => $perso['BP'],
			        'label' => array(
			            'class' => 'control-label',
			            'text' => 'BP'
			        )
			    ));
			    ?>
				</div>
			</div>
		    <?php
		    echo $this->Form->input('AdMail', array(
		        'class' => 'form-control',
		        'value' => $perso['EMail'],
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'EMail'
		        )
		    ));
		    echo $this->Form->input('AdNiveauDInformationNom', array(
		    'class' => 'form-control',
		    'selected' =>  $perso['NiveauDInformationNom'],
		    'options' => array("Personnel" => "Personnel", "Personnel & Association" => "Personnel & Association", "Personnel & Association & Tutelles" => "Personnel & Association & Tutelles"),
		    'label' => array(
		        'class' => 'control-label',
		        'text' => 'Niveau d\'information souhaité'
		        )
		    ));

		?>


		</br></br>
		<?php
		    echo $this->Form->submit('Enregistrer', array(
		        'type' => 'submit',
		        'class' => 'btn btn-default'
		    ));

		    echo $this->form->end();
		?>

	</div>
</div>

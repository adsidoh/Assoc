<div class="row">
	<?php echo $this->Form->create('Student'); ?>
	<div class="col-md-6">
		<?php 

		/* Identité */
		echo '<h3>Identité</h3>';

		echo $this->Form->input('nom', array('class'=>'form-control'));
		echo $this->Form->input('prenom', array('class'=>'form-control'));
		echo $this->Form->input('Email', array('class'=>'form-control'));

		/* Téléphone */
		echo '<h3>Sexe</h3>';
		echo $this->Form->radio('sexe', array('H' => 'Homme', 'F' => ' Femme'), array('legend' => false, 'between'=>'/'));

		?>
							
	</div>
	
	<div class="col-md-6">
		<div class="row">

			<div class="col-md-12">
				<?php 

					/* Autre Adresse */
					echo '<h3>Autre adresse</h3>';

					echo $this->Form->input('appbatres', array('label'=>'Appt, Bât, Résidence', 'class'=>'form-control'));

					echo $this->Form->input('num', array('label'=>'Numéro, Voie', 'class'=>'form-control'));

					echo $this->Form->input('lieudit', array('label'=>'Lieu-Dit', 'class'=>'form-control'));

					echo $this->Form->input('ville', array('class'=>'form-control'));
					?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('code_postal', array('class'=>'form-control')); ?>
			</div>
			
			<div class="col-md-6">
				<?php echo $this->Form->input('BP', array('class'=>'form-control')); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<?php echo $this->Form->submit('Enregistrer', array('rule'=>'submit', 'class'=>'btn btn-default pull-right', 'before'=>'<br/>')); ?>
			</div>
		</div>
	</div>
	<?php $this->Form->end(); ?>
</div>
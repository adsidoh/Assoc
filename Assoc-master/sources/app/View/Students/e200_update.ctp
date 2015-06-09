<div class="row">
	<?php echo $this->Form->create('Student'); ?>
	<div class="col-md-6">
		<?php 

		/* responsable légal */
		echo '<h3>Responsable légal</h3>';
		echo $this->Form->input('responsable_legal', array('class'=>'form-control', 'label'=>false, 'options'=>$setResp));

		/* Identité */
		echo '<h3>Identité Elève</h3>';
		echo $this->Form->input('sexe', array('label'=>'Appellation','class'=>'form-control', 'options'=>array('H'=>'Monsieur', 'F'=>'Madame'), 'selected'=>($eleve['Student']['EleveMasculin'])?'H':'F'));
		echo $this->Form->input('nom', array('class'=>'form-control', 'value'=>$eleve['Student']['EleveNom']));
		echo $this->Form->input('prenom', array('class'=>'form-control', 'value'=>$eleve['Student']['ElevePrenom']));
		echo $this->Form->input('Email', array('class'=>'form-control', 'value'=>$eleve['Student']['EMail']));

		/* Téléphone */
		echo '<h3>Téléphone Elève</h3>';

		?>
		<div class="row">
					<div class="col-md-3"><span class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'students', 'action'=>'addTel')); ?>/" + document.getElementById("add_tel").value+"/"+<?php echo $eleve['Student']['EleveId']?>+"/"+<?php echo $eleve['Student']['InterlocuteurId'];?>;'>Ajouter</span></div>
					<div class="col-md-9"><?php echo $this->Form->input('addTel', array('after'=>'<br/>', 'label'=>false, 'class'=>'form-control', 'id'=>'add_tel')); ?></div>
				</div>

		<?php
		if(!empty($setPhone)){
			foreach ($setPhone as $key => $value) {
				
				?>
				<div class="row">
					<div class="col-md-3" ><span class="btn btn-danger" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'students', 'action'=>'delTel')); ?>/" + document.getElementById("Std<?php echo $key; ?>").value+"/"+<?php echo $eleve['Student']['InterlocuteurId']?>'>Supprimer</span></div>
					<div class="col-md-9"><?php echo $this->Form->input($key, array('id'=>'Std'.$key, 'after'=>'<br/>', 'value'=>$value, 'label'=>false, 'class'=>'form-control')); ?></div>
				</div>
				<?php
			}
		}
		?>
	</div>
	
	<div class="col-md-6">
		<div class="row">

			<div class="col-md-12">
				<?php 
					/* Adresse */
					echo '<h3>Adresse Elève</h3>';
					if(!empty($setPlace)){
							echo $this->Form->input('adresse', array('label'=>false, 'class'=>'form-control', 'options'=>$setPlace,'selected'=>$eleve['Student']['EndroitId'],
							));
					}

					/* Autre Adresse */
					echo '<h3>Autre adresse Elève</h3>';

					echo $this->Form->input('appbatres', array('label'=>'Appt, Bât, Résidence', 'class'=>'form-control', 'value'=>$eleve['Student']['ApptBatResidence']));

					echo $this->Form->input('num', array('label'=>'Numéro, Voie', 'class'=>'form-control', 'value'=>$eleve['Student']['NumEtVoie']));

					echo $this->Form->input('lieudit', array('label'=>'Lieu-Dit', 'class'=>'form-control', 'value'=>$eleve['Student']['LieuDit']));

					echo $this->Form->input('ville', array('class'=>'form-control', 'value'=>$eleve['Student']['Ville']));
					?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('code_postal', array('class'=>'form-control', 'value'=>$eleve['Student']['CodePostal'])); ?>
			</div>
			
			<div class="col-md-6">
				<?php echo $this->Form->input('BP', array('class'=>'form-control', 'value'=>$eleve['Student']['BP'])); ?>
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
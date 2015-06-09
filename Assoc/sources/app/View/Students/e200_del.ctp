<div class="row">
	<?php echo $this->Form->create('Student'); ?>
	<div class="col-md-6">
		<?php 
			
		/* Identité */
		echo '<h3>Identité</h3>';

		echo $this->Form->input('nom', array('class'=>'form-control' , 	'value' => 	$eleve[0]['Student']['EleveNom']));
		echo $this->Form->input('prenom', array('class'=>'form-control' , 'value' => 	$eleve[0]['Student']['ElevePrenom']));
		echo $this->Form->input('Email', array('class'=>'form-control' , 'value' => 	$eleve[0]['Student']['EMail']));

		?>
							
	</div>
	
	<div class="col-md-6">
		<div class="row">

			<div class="col-md-12">
				<?php 

					/* Autre Adresse */
					echo '<h3>Autre adresse</h3>';

					echo $this->Form->input('appbatres', array('label'=>'Appt, Bât, Résidence', 'class'=>'form-control' , 'value' => $eleve[0]['Student']['ApptBatResidence'] ));

					echo $this->Form->input('num', array('label'=>'Numéro, Voie', 'class'=>'form-control' , 'value' => $eleve[0]['Student']['NumEtVoie']));

					echo $this->Form->input('lieudit', array('label'=>'Lieu-Dit', 'class'=>'form-control' , 'value' => $eleve[0]['Student']['LieuDit']));

					echo $this->Form->input('ville', array('class'=>'form-control' , 'value' => $eleve[0]['Student']['Ville']));
				//	debug($eleve[0]['Student']);
					?>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('code_postal', array('class'=>'form-control' , 'value' => $eleve[0]['Student']['CodePostal']) ); ?>
			</div>
			
			<div class="col-md-6">
				<?php echo $this->Form->input('BP', array('class'=>'form-control' , 'value' => $eleve[0]['Student']['BP'] )); ?>
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

<?php 

		echo '<script type="text/javascript">';
		echo '$(window).load(function(){$(\'#myModal\').modal(\'show\');});';
		echo '</script>';
 ?>


<!-- Modal -->
<div class="modal" id="myModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        	voulez vous réellement procéder à la suppression de l'élève <?php echo $eleve[0]['Student']['ElevePrenom']; echo " ".$eleve[0]['Student']['EleveNom']; ?>
      </div>
      <div class="modal-footer">
      	<a href="<?php echo $this->Html->url(array('controller'=>'Students', 'action'=>'deleteStudent')); ?>" class="btn btn-primary" role="button">Confirmer</a>
      	<a href="<?php echo $this->Html->url(array('controller'=>'Students', 'action'=>'E200Update')); ?>" class="btn btn-primary" role="button">Annuler</a>     
      </div>
    </div>
  </div>
</div>
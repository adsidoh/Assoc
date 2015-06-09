<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<h3>Réinitialisation de mot de passe</h3>
		<hr>
		<?php 
			echo $this->Form->create('resetMail', array('class'=>'form-inline'));
			echo $this->Form->input('mail', array('class'=>'form-control', 'label'=>'Votre adresse mail:'));
			echo $this->Form->submit('Valider', array('class'=>'btn btn-default', 'before'=>'<br/>'));
			echo $this->Form->end();





		?>
	</div>
</div>
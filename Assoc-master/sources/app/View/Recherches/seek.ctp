<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h3>Rechercher</h3>
		<hr>
		
		<?php 
			echo $this->Form->create('form');
			echo $this->Form->input('rech', array(
				'label'=>false,
				'class'=>'form-control',
				'placeholder'=>'Rechercher...',
				'before'=>'<div class="form-group">',
				'after'=>'</div>'
			));
			echo $this->Form->submit('Rechercher', array('class'=>'btn btn-default'));
			echo $this->Form->end();

		?>
	</div>
</div>
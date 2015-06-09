<div class="row">

	<div class="col-md-4 col-md-offset-4">
		<?php
			echo $this->Form->create('Etiquette', array(
		        'class' => 'form-horizontal',
		        'inputDefaults' => array(
		            'div' => 'form-group',
		            'class' => 'form-control'
		        )
		    ));


			echo $this->Form->checkbox('all', array('hiddenField' => true,
				));

			echo $this->Form->input('Classe', array(
		        'class' => 'form-control',
		        'options' => array('2nd', '1ere', 'term'),
		        'empty' => 'Classe',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Paret D\'élèves de '
		        )
		    ));

		    echo $this->Form->input('Format', array(
		        'class' => 'form-control',
		        'options' => array('for1', 'for2', 'for3'),
		        'empty' => '',
		        'label' => array(
		            'class' => 'control-label',
		            'text' => 'Format d\'étiquettes'
		        )
		    ));


		    echo $this->Form->submit('Télécharger', array(
		        'type' => 'submit',
		        'class' => 'btn btn-default'
		    ));

		    echo $this->form->end();

		    
		?>
	<div>
<div>
<?php

	echo $this->Form->create('Fourniture', array('action'=>'blabla'));//blabla pas encore défini

	echo $this->Form->input('Nom', array(
		'name'=>'editNom',
		'id'=>'editNom',
		'class'=>'edit-form',
		'value'=>''.$data['Fourniture']['designation'].''
		)
	);

	echo $this->Form->input('Auteur', array(
		'name'=>'editAuteur',
		'id'=>'editAuteur',
		'class'=>'edit-form',
		'value'=>''.$data['Fourniture']['auteur'].''
		)
	);


	echo $this->Form->submit('Valider', array('rule'=>'submit', 'class'=>'btn btn-default', 'before'=>'<br/><br/><br/><br/>'));
	echo $this->Form->end();
?>
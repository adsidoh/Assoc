<?php

	//debug($queryNameSecondes);
	//debug($queryNamePrem);
	//debug($queryNameTerm);

	echo '<h3>Veuillez sélectionner un profil d\'élève pour afficher la liste de livres associée</h3><br/>';

	/*$data = array();
	$i = 0;

	foreach($queryNameSecondes as $value)
	{
		$data[$i] = $value['bal_vue_e201_classe']['ClasseDesignation'];
		++$i;	
	}

	echo $this->Form->input('Secondes', array('options'=>$data, 'empty'=>'Choisissez'));*/


	//Création des profils des Seconde
	echo '<table border="1" cellpadding="10" cellspacing="1" width="50%">';
	echo '<tr><th><h4>Secondes</h4></th></tr>';

	foreach($queryNameSecondes as $value)
	{
		echo '<tr>
				<td align = "center">'.$this->Html->link($value['bal_vue_e201_classe']['ClasseDesignation'], 
															array('controller'=>'fournitures', 'action'=>'choisirOptions')).
				'</td>
			</tr>';
	}
	echo '</table>';

	echo '<br/><br/>';

	//Création des profils pour les Premières
	echo '<table border="1" cellpadding="10" cellspacing="1" width="50%">';
	echo '<tr><th><h4>1ères</h4></th></tr>';

	foreach($queryNamePrem as $value)
	{
		echo '<tr>
				<td align = "center">'.$this->Html->link($value['bal_vue_e201_classe']['ClasseDesignation'], 
															array('controller'=>'fournitures', 'action'=>'choisirOptions')).
				'</td>
			</tr>';

	}
	echo '</table>';

	echo '<br/><br/>';

	//Création des profils pour les Terminales
	echo '<table border="1" cellpadding="10" cellspacing="1" width="50%">';
	echo '<tr><th><h4>Terminales</h4></th></tr>';

	foreach($queryNameTerm as $value)
	{
		echo '<tr>
				<td align = "center">'.$this->Html->link($value['bal_vue_e201_classe']['ClasseDesignation'], 
															array('controller'=>'fournitures', 'action'=>'choisirOptions')).
				'</td>
			</tr>';

	}
	echo '</table>';



?>

	
	<!--Vue qui représente l'interface de la page produit i.e une page qui liste les produit qui sont disponibles 
	en affichant leur nom, l'auteur, la marque/l'éditeur, leur année de parution, leur vetusté, le nombre de d'exemplaires qui sont
	encore en stock, le prix ainsi que le code barre.-->

	<!--Représentation de la varibale $queryNbProducts transmis par le controller FournituresController : 

	array(
		(int) 0 => array(
			(int) 0 => array(
				'COUNT(DISTINCT Designation)' => '331'
			)
		)
	)
	-->

	<!--//Représentation des données envoyées en mode post (donc $this->request->data) par la fonction choisirOptions du controller FournitureController :

	array(
		'classe' => '',
		'Fourniture' => array(
			'matière' => '',
			'options*' => array(
				(int) 0 => 'Communication',
				(int) 1 => 'Gestion'
			)
		)
	)
	-->

<!--<ul class="nav navbar-nav navbar-left">
	<form class="navbar-form navbar-right">
        <a class="btn btn-default" onclick='javascript:window.location = "<?php //echo $this->Html->url(array('controller'=>'users', 'action'=>'logout')); ?>";'>Ajouter Produit
        </a>
    </form>
</ul> -->

<?php

	echo $this->Html->link('Faire nouvelle recherche de produits', array('controller'=>'Fournitures', 'action'=>'choisirOptions'));

	echo '<br/><br/><br/>';
	echo '<table border="1" cellpadding="10" cellspacing="1" width="100%">
				<tr>
					<th>Nom</th>
					<th>Auteur</th>
					<th>Marque/Editeur</th>
					<th>Année parution</th>
					<th>Type de produit</th>
					<th>Code barre</th>
					<th>Editer</th>
				</tr>';

	
	//Pour chaque livre distinct trouvé		
	if(isset($queryProducts)){

		foreach($queryProducts as $value){
			echo'<tr>';
				//On écrit le nom du livre
				echo'<td>'.$value['bal_vue_e300_produit']['Designation'].'</td>';
				echo'<td>'.$value['bal_vue_e300_produit']['Auteur'].'</td>';
				echo'<td>'.$value['bal_vue_e300_produit']['MarqueOuEditeur'].'</td>';
				echo'<td>'.$value['bal_vue_e300_produit']['AnneeParution'].'</td>';
				echo'<td>'.$value['bal_produit']['TypeDeProduitNom'].'</td>';
				echo'<td>'.$value['bal_vue_e300_produit']['CodeBarre'].'</td>';
				
				//Création d'un formulaire pour éditer le produit caché dont les champs sont déjà prépremplis (l'utilisateur ne doit pas le voir).
				echo '<td>';
				echo $this->Form->create('Fourniture', array('action'=>'editerProduit'));

				echo $this->Form->hidden('designation', array('value'=> $value['bal_vue_e300_produit']['Designation']));
				echo $this->Form->hidden('auteur', array('value'=>$value['bal_vue_e300_produit']['Auteur']));
				echo $this->Form->hidden('marqueouediteur', array('value'=>$value['bal_vue_e300_produit']['MarqueOuEditeur']));
				echo $this->Form->hidden('anneeparution', array('value'=>$value['bal_vue_e300_produit']['AnneeParution']));
				echo $this->Form->hidden('typedeproduit', array('value'=>$value['bal_produit']['TypeDeProduitNom']));
				echo $this->Form->hidden('codebarre', array('value'=>$value['bal_vue_e300_produit']['CodeBarre']));
				echo $this->Form->submit('Editer', array('rule'=>'submit', 'class'=>'btn btn-default'));

				echo $this->Form->end().'</td>';

			echo'</tr>';
		}
	}
	else if(isset($queryProductsOptions)){
		
		foreach($queryProductsOptions as $value){
			
			echo'<tr>';
				//On écrit le nom du livre
				echo'<td>'.$value['Designation'].'</td>';
				echo'<td>'.$value['Auteur'].'</td>';
				echo'<td>'.$value['MarqueOuEditeur'].'</td>';
				echo'<td>'.$value['AnneeParution'].'</td>';
				echo'<td>'.$value['TypeDeProduitNom'].'</td>';
				echo'<td>'.$value['CodeBarre'].'</td>';
				
				/*Création d'un formulaire pour envoyer les données au controller/vue qui gèrera l'édition des produits.
				On met donc en hidden pour pas que l'utilisateur le voit*/

				echo'<td>';
				
				echo $this->Form->create('Fourniture', array('action'=>'editerProduit'));

				echo $this->Form->hidden('designation', array('value'=> $value['Designation']));
				echo $this->Form->hidden('auteur', array('value'=>$value['Auteur']));
				echo $this->Form->hidden('marqueouediteur', array('value'=>$value['MarqueOuEditeur']));
				echo $this->Form->hidden('anneeparution', array('value'=>$value['AnneeParution']));
				echo $this->Form->hidden('typedeproduit', array('value'=>$value['TypeDeProduitNom']));
				echo $this->Form->hidden('codebarre', array('value'=>$value['CodeBarre']));
				echo $this->Form->submit('Editer', array('rule'=>'submit', 'class'=>'btn btn-default'));

				echo $this->Form->end().'</td>';

			echo'</tr>';
		}
	}

	echo '</table>';
?>
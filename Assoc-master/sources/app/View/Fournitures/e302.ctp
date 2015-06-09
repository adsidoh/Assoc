<table class="table table-striped">
	<tr>
		<th>
			Classe
		</th>
		<th>
			Option
		</th>
		<th>
			Cours
		</th>
		<th>
			Ressource
		</th>
		<th>
			Incluse dans
		</th>
		<th>
			Action
		</th>
	</tr>

	<tr>
		<th>
			<select name="data[Fournitures][ClasseId]" class="form-control" id="FournituresClasseId" 
				onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E302')); ?>/" + document.getElementById("FournituresClasseId").value;'>
				<?php if (is_null($currentClasseId)) { ?>
				<option value=""></option>
				<?php } ?>
			 	<?php foreach ($classe as $key => $value): ?>
				<option value="<?php echo $key; ?>" <?php if ($key==$currentClasseId) { echo "selected"; } ?>><?php echo $value;?></option>
				<?php
					endforeach;
				?>
			</select>
		</th>
		<th>
			<select name="data[Fournitures][OptionNom]" class="form-control" id="FournituresOptionNom" 
				onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E302')); ?>/" + document.getElementById("FournituresClasseId").value + "/" + document.getElementById("FournituresOptionNom").value;'>
				<?php if (is_null($currentOptionNom)) { ?>
				<option value=""></option>
				<?php } ?>
			 	<?php for ($i=0; $i < sizeof($option); $i++) { ?>
				<option value="<?php echo $option[$i]['OptionNom']; ?>" <?php if ($option[$i]['OptionNom']==$currentOptionNom) { echo "selected"; } ?>><?php echo $option[$i]['OptionNom'];?></option>
				<?php } ?>
			</select>
		</th>
		<th>
			<select name="data[Fournitures][CoursId]" class="form-control" id="FournituresCoursId" 
				onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E302')); ?>/" + document.getElementById("FournituresClasseId").value + "/"  + document.getElementById("FournituresOptionNom").value + "/" + document.getElementById("FournituresCoursId").value;'>
				<?php if (is_null($currentCoursId)) { ?>
				<option value=""></option>
				<?php } ?>
			 	<?php for ($i=0; $i < sizeof($discipline); $i++) { ?>
				<option value="<?php echo $discipline[$i]['CoursId']; ?>" <?php if ($discipline[$i]['CoursId']==$currentCoursId) { echo "selected"; } ?>><?php echo $discipline[$i]['CoursNom'];?></option>
				<?php } ?>
			</select>
		</th>
		<th>
			<select class="form-control">
				<option>546</option>
				<option>547</option>
				<option>548?</option>
			</select>
		</th>
		<th>
			<select class="form-control">
				<option>546</option>
				<option>547</option>
				<option>548?</option>
			</select>
		</th>
		<th>
			<select class="form-control">
				<option>Nouvelle ressource pour le profil selec.</option>
				<option>Remplacer 546 partout</option>
				<option>548?</option>
			</select>
		</th>
	</tr>
</table>

<div class="row">
	<div class="col-md-12"><hr></div>
</div>

<b>Utilisé depuis </b> <?php echo $obtenuDepuis; ?>

<div class="row">
	<div class="col-md-12"><hr></div>
</div>

<table class="table table-striped">
	<tr>
		<th>
		</th>
		<th>
			Type
		</th>
		<th>
			Code Barre
		</th>
		<th>
			Désignation
		</th>
		<th>
			Marque/Editeur
		</th>
		<th>
			Parution
		</th>
		<th>
			Consommable
		</th>
	</tr>

	<!--<tr>
		<td>
			<a class="btn btn-default" role="button" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveProduit')); ?>/" + "<?php echo $produit[$i]['RessourceId'] . "/" . $produit[$i]['CodeBarre'] . "/" . $produit[$i]['Designation'] . "/" . $produit[$i]['AnneeParution'] . "/" . $produit[$i]['MarqueOuEditeur'] . "/" . $produit[$i]['Auteur'] . "/" . $produit[$i]['TypeDeProduitNom'] ?>"'>Ajouter</a>
		</td>
		<td>
			<input type="text" class="form-control" id="Type">
		</td>
		<td>
			<input type="text" class="form-control" id="CodeBarre">
		</td>
		<td>
			<input type="text" class="form-control" id="Designation">
		</td>
		<td>
			<input type="text" class="form-control" id="MarqueEditeur">
		</td>
		<td>
			<input type="text" class="form-control" id="Parution">
		</td>
		<td>
			<input type="checkbox" class="form-control" id="Consommable">
		</td>

	</tr> -->

	<!-- FOR EACH -->
	<?php 
		for ($i=0; $i < sizeof($produit); $i++) { 
	?>
	<tr>
		<td>
			<a class="btn btn-default" role="button" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'deleteProduit')); ?>/" + "<?php echo $produit[$i]['CodeBarre']; ?>"'>Supprimer</a>
		</td>
		<td>
			<select class="form-control" id="FournituresTypeDeProduit<?php echo $i; ?>" onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveProduit')) . '/' . $produit[$i]['RessourceId'] . '/' . $produit[$i]['CodeBarre'] . '/' . $produit[$i]['Designation'] ; ?>/" + document.getElementById("FournituresTypeDeProduit<?php echo $i; ?>").value;'>
				<?php 
					for ($j=0; $j < sizeof($typedeproduit); $j++) { 
				?>
				<option value="<?php echo $typedeproduit[$j]['TypeDeProduitNom']; ?>" <?php if ($typedeproduit[$j]['TypeDeProduitNom']==$produit[$i]['TypeDeProduitNom']) echo "selected"; ?>><?php echo $typedeproduit[$j]['TypeDeProduitNom']; ?></option>
				<?php 
					} 
				?>
			</select>
		</td>

		<td>
			<?php
				echo $this->Form->input('CodeBarre', array(
			        'class' => 'form-control',
			        'value' => $produit[$i]['CodeBarre'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>
		</td>

		<td>
			<?php
				echo $this->Form->input('Designation', array(
			        'class' => 'form-control',
			        'value' => $produit[$i]['Designation'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>
		</td>

		<td>
			<?php
				echo $this->Form->input('MarqueEditeur', array(
			        'class' => 'form-control',
			        'value' => $produit[$i]['MarqueOuEditeur'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>
		</td>

		<td>
			<?php
				echo $this->Form->input('Parution', array(
			        'class' => 'form-control',
			        'value' => $produit[$i]['AnneeParution'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>
		</td>

		<td>
			<input type="checkbox" class="form-control" <?php if ($produit[$i]['EstReutilisable']) echo "checked"; ?> disabled>
		</td>
	</tr>
	<?php } ?>
</table>
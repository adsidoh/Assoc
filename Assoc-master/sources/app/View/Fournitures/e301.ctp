<div class="row">
	<div class="col-md-2">	
		<div class="form-group">	
			<?php 
				$this->Form->create('Fournitures', array(
					'class' => 'form-horizontal',
	                'inputDefaults' => array(
	                    'div' => 'form-group',
	                    'class' => 'form-control'
	                )
	            ));
	        ?>

			 <label for="FournituresExercice" class="control-label">
			 	Taux de l'exercice
			 </label>
			 <select name="data[Fournitures][Exercice]" class="form-control" id="FournituresExercice" onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E301')); ?>/" + document.getElementById("FournituresExercice").value;'>
			 	<?php foreach ($exercices as $key => $value): ?>
				<option value="<?php echo $key; ?>" <?php if ($key==$currExercice) { echo "selected"; } ?>><?php echo $value;?></option>
				<?php endforeach ?>
			</select>
		</div>
	</div>
</div>

</br></br>

<table class="table table-striped">
	
	<tr>
		<th>
		</th>
		<th>
			Désignation
		</th>
		<th>
			Type de bon
		</th>
		<th>
			Taux
		</th>
	</tr>

	<tr>
		<td>
			<a class="btn btn-default" role="button" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveVetuste')); ?>/" + document.getElementById("FournituresVetusteNom").value + "/" + document.getElementById("FournituresTypeDeBonNom").value + "/" + document.getElementById("FournituresTaux").value + "/" + document.getElementById("FournituresExercice").value;'>Ajouter</a>
		</td>
		<td>
			<?php
				echo $this->Form->input("VetusteNom", array(
			        'class' => 'form-control',
			        'options' => $vetustenom,
			        'label' => false
			    ));
			?>
		</td>
		<td>
			<?php
				echo $this->Form->input("TypeDeBonNom", array(
			        'class' => 'form-control',
			        'options' => $typedebon,
			        'label' => false
			    ));
			?>
		<td>
			<?php
				echo $this->Form->input("Taux", array(
			        'class' => 'form-control',
			        'value' => '',
			        'label' => false,
			        'required' => true
			    ));
			?>
		</td>
	</tr>

	<!-- FOR EACH HERE -->
	<?php 
		for ($i=0; $i < sizeof($vetuste); $i++) { 
				
	 ?>
	<tr>
		<td>
			<a onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'deleteVetuste')); ?>/" + document.getElementById("FournituresVetusteNom<?php echo $i ?>").value + "/" + document.getElementById("FournituresTypeDeBonNom<?php echo $i ?>").value + "/" + document.getElementById("FournituresExercice").value;' class="btn btn-default" role="button">Supprimer</a>
		</td>
		<td>
			<?php

				echo $this->Form->input("VetusteNom$i", array(
			        'class' => 'form-control',
			        'value' => $vetuste[$i]['VetusteNom'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>

		</td>
		<td>
			<?php
			    echo $this->Form->input("TypeDeBonNom$i", array(
			    	'class' => 'form-control',
			    	'value' => $vetuste[$i]['TypeDeBonNom'],
			    	'label' => false,
			    	'disabled' => true
			    ));
			?>
		</td>

		<td>
			<?php
				echo $this->Form->input('Taux', array(
			        'class' => 'form-control',
			        'value' => $vetuste[$i]['Taux'],
			        'label' => false,
			        'disabled' => true
			    ));
			?>
		</td>
	</tr>
	<?php 
		}
	 ?>
</table>
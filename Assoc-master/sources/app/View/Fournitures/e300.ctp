<table class="table table-striped">
	<tr>
		<th>Responsable légal</th>
		<td>
			<?php echo $this->Session->read('Dossier.Parent.PersonneNom') . " " . $this->Session->read('Dossier.Parent.PersonnePrenom'); ?>
		</td>
		<td>
			<button class="btn btn-default pull-right">Imprimer Bon</button>
		</td>
	</tr>
	<tr>
		<th>Elève</th>
		<td>
			<?php echo $this->Session->read('Dossier.Eleve.EleveNom') . " " . $this->Session->read('Dossier.Eleve.ElevePrenom'); ?>
		</td>
		<td>
			<button class="btn btn-default pull-right">Facture</button>
		</td>
	</tr>
	<tr>
		<th>Exercice</th>
		<td><?php echo $this->Session->read('Exercice'); ?></td>
		<td></td>
	</tr>
	<tr>
		<th>Opération</th>
		<td>
			<?php 
				if (isset($bon)) {
					echo $bon['TypeDeBonNom'] . " " . $bon['BonOperationId'] . ", du " . $bon['Creation'] . ", imputé sur la facture " . $bon['FactureId'];
				}
			?>
		</td>
		<td></td>
	</tr>
</table>

<div class="row">
	<div class="col-md-12"><hr></div>
</div>

<div class="row">
	<div class="col-md-3">
		<select name="data[Fournitures][ClasseId]" class="form-control" id="FournituresClasseId" 
			onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E300')); ?>/" + <?php echo $bonOperationId; ?> + "/" + document.getElementById("FournituresClasseId").value;'>
			<?php if (is_null($currentClasseId)) { ?>
			<option value=""></option>
			<?php } ?>
		 	<?php foreach ($classe as $key => $value): ?>
			<option value="<?php echo $key; ?>" <?php if ($key==$currentClasseId) { echo "selected"; } ?>><?php echo $value;?></option>
			<?php
				endforeach;
			?>
		</select>
	</div>
	<div class="col-md-3">
		<select name="data[Fournitures][CoursId]" class="form-control" id="FournituresCoursId" 
			onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'E300')); ?>/" + <?php echo $bonOperationId; ?> + "/" + document.getElementById("FournituresClasseId").value + "/" + document.getElementById("FournituresCoursId").value;'>
			<?php if (is_null($currentCoursId)) { ?>
			<option value=""></option>
			<?php } ?>
		 	<?php for ($i=0; $i < sizeof($discipline); $i++) { ?>
			<option value="<?php echo $discipline[$i]['CoursId']; ?>" <?php if ($discipline[$i]['CoursId']==$currentCoursId) { echo "selected"; } ?>><?php echo $discipline[$i]['CoursNom'];?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-4">
		<select name="data[Fournitures][CodeBarre]" class="form-control" id="FournituresCodeBarre">
		 	<option></option>
		 	<?php for ($i=0; $i < sizeof($produit); $i++) { ?>
			<option value="<?php echo $produit['CodeBarre']; ?>"><?php echo $produit['OptionNom'] . " / " . $produit['CodeBarre'];?></option>
			<?php  } ?>
		</select>
	</div>
	<div class="col-md-2">
		<button class="btn btn-default pull-right" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'addLigneDeBon')); ?>/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre").value + "/1";'>Ajouter</button>
	</div>
</div>

<div class="row">
	<div class="col-md-12"><hr></div>
</div>

</br>

<?php if (isset($lignedebon)) { ?>
<div class="row">
	<div class="col-md-4">
		<center>
			<p>
				<b>Totaux: </b> 
				<?php  
					echo sizeof($lignedebon) . " produits";
				?>
			</p>
		</center>
	</div>
	<div class="col-md-4">
		<center>
			<p>
				<b>Quantité: </b> 
				<?php  
					echo $quantiteProduit;
				?> 
			</p>
		</center>
	</div>
	<div class="col-md-4">
		<center>
			<p>
				<b>Prix: </b> 
				<?php 
					echo $prixTotal . "€";
				?>
			</p>
		</center>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<hr>
		<table class="table table-striped">
			<tr>
				<td></td>
				<td><b>Cours</b></td>
				<td><b>Produit</b></td>
				<td><b>Vétusté</b></td>
				<td><b>Statut</b></td>
				<td><b>Quantité</b></td>
				<td><b>Montant U.</b></td>
			</tr>

			<?php 
				for ($i=0; $i < sizeof($lignedebon); $i++) { 
					echo '<input type="hidden" id="FournituresContientId'.$i.'" value="' . $lignedebon[$i]['ContientId']. '">';
					echo '<tr>';
			?>
					<td rowspan="2"><button class="btn btn-danger pull-right" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'deleteLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value;'>Supprimer</button></td>
			<?php
					echo '<td>' . $lignedebon[$i]['OptionNom'] . '-' . $lignedebon[$i]['CoursNom'] . '</td>';
			?>
					<td>
						<select name="data[Fournitures][CodeBarre]" class="form-control" id="FournituresCodeBarre<?php echo $i; ?>" 
						onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value + "/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresStatutStockageNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresVetusteNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresNombre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresPrixSpecial<?php echo $i; ?>").value;'>
						<?php foreach ($produits[$lignedebon[$i]['RessourceId']] as $key => $value): ?>
							<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
						<?php endforeach ?>
						</select> 
					</td>
					<td>
						<select name="data[Fournitures][VetusteNom]" class="form-control" id="FournituresVetusteNom<?php echo $i; ?>" 
						onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value + "/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresStatutStockageNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresVetusteNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresNombre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresPrixSpecial<?php echo $i; ?>").value;'>
						<?php foreach ($vetustenom as $key => $value): ?>
							<option value="<?php echo $key; ?>" <?php if ($value==$lignedebon[$i]['VetusteNom']) echo "selected"; ?>><?php echo $value; ?></option>
						<?php endforeach ?>
						</select> 
					</td>
					<td>
						<select name="data[Fournitures][StatutStockageNom]" class="form-control" id="FournituresStatutStockageNom<?php echo $i; ?>" 
						onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value + "/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresStatutStockageNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresVetusteNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresNombre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresPrixSpecial<?php echo $i; ?>").value;'>
						<?php foreach ($statutStockage as $key => $value): ?>
							<option value="<?php echo $key; ?>" <?php if ($value==$lignedebon[$i]['StatutDeStockageNom']) echo "selected"; ?>>
								<?php echo $value; ?>
							</option>
						<?php endforeach ?>
						</select>  
					</td>
					<td>
						<input class="form-control" id="FournituresNombre<?php echo $i; ?>" type="text" value="<?php echo $lignedebon[$i]['Nombre']; ?>" onblur='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value + "/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresStatutStockageNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresVetusteNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresNombre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresPrixSpecial<?php echo $i; ?>").value;'>
					</td>
					<td>
						<input class="form-control" id="FournituresPrixSpecial<?php echo $i; ?>" type="text" value="<?php echo $lignedebon[$i]['PrixSpecial']; ?>" onblur='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'saveLigneDeBon')); ?>/" + document.getElementById("FournituresContientId<?php echo $i; ?>").value + "/" + "<?php echo $bonOperationId; ?>" + "/" + document.getElementById("FournituresCodeBarre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresStatutStockageNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresVetusteNom<?php echo $i; ?>").value + "/" + document.getElementById("FournituresNombre<?php echo $i; ?>").value + "/" + document.getElementById("FournituresPrixSpecial<?php echo $i; ?>").value;'>
					</td>
				</tr>
				<tr>
					<td colspan='7'> 
						<?php 
					 		echo $lignedebon[$i]['Designation'] . ", Ed. " . $lignedebon[$i]['MarqueOuEditeur'] . ", Edition " . $lignedebon[$i]['AnneeParution'] . ", " . $lignedebon[$i]['TypeDeProduitNom'] . ".";
					 	?>
					 </td>
				</tr>
			<?php
				}
			?>
		</table>
	</div>
</div>
<?php } ?>
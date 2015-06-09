<table class="table table-striped">
	<tr>
		<th>Facture</th>
		<td>
			<?php echo $entete['FactureId']; ?>
		</td>
		<td>
			<?php echo $entete['CreationFact']; ?>
		</td>
		<td></td>
	</tr>
	<tr>
		<th>Personne</th>
		<td><?php echo $_SESSION['Dossier']['Parent']['PersonneNom'] . " " . $_SESSION['Dossier']['Parent']['PersonnePrenom'];?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th>Dû</th>
		<td><?php echo $entete['Montant'] . "€"; ?></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<th>Réglé</th>
		<td><?php echo $entete['Reglement'] . "€"; ?></td>
		<td></td>
		<td>
			<button class="btn btn-default pull-right">Imprimer Facture</button>
		</td>
	</tr>
	<tr>
		<th>Reste dû</th>
		<td><?php echo $entete['Montant'] - $entete['Reglement'] . "€"; ?></td>
		<td>
		</td>
		<td>
			<button class="btn btn-default pull-right">Imprimer Reçu Fiscal</button>
		</td>
	</tr>
</table>

<div class="row">
	<div class="col-md-12"><hr></div>
</div>

<table class="table table-striped">
	<tr>
		<th></th>
		<th>Nature</th>
		<th>Nom banque (si chèque)</th>
		<th>Identifiant</th>
		<th>Crédit</th>
		<th>Débit</th>
		<th>Date Opération</th>
		<th>Date Dépôt</th>
		<th>Date Valeur</th>
		<th></th>
	</tr>
	<tr>
		<td></td>
		<?php 
				echo $this->Form->create('Compta', array(
			        'inputDefaults' => array(
			            'div' => 'form-group',
			            'class' => 'form-control'
			        )
			    ));

			 ?>
		<td>
			<?php 
				echo $this->Form->input('ComptabiliteId', array(
			        'class' => 'form-control',
			        'type' => 'hidden',
			        'value' => null,
			        'label' => false
			    ));

			    echo $this->Form->input('FactureId', array(
			        'class' => 'form-control',
			        'type' => 'hidden',
			        'value' => 10,
			        'label' => false
			    ));

			    echo $this->Form->input('MoyenDePaiementNom', array(
			        'class' => 'form-control',
			        'options' => $moyendepaiement,
			        'empty' => '',
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('BanqueNom', array(
			        'class' => 'form-control',
			        'label' => false
			    ));
			?>
		</td>
		<td>
			<?php
				echo $this->Form->input('IdentifiantTransaction', array(
			        'class' => 'form-control',
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('MontantPaiement', array(
			        'class' => 'form-control',
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('MontantRendu', array(
			        'class' => 'form-control',
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<input type="text" id="DateOperation" class="form-control">
		</td>
		<td>
			<input type="text" id="DateDepot" class="form-control" disabled>
		</td>
		<td>
			<input type="text" id="DateValeur" class="form-control" disabled>
		</td>
		<td>
			<?php
				echo $this->Form->submit('Ajouter', array(
			        'type' => 'submit',
			        'class' => 'btn btn-default'
			    ));
			    echo $this->Form->end();
		    ?>
		</td>
	</tr>
	<?php for ($i=0; $i < sizeof($operations); $i++) { ?>
	<tr>
		<td>
			<?php if ($_SESSION['Auth']['User']['Droit']>=2) { ?>
			<button class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'comptas', 'action'=>'deleteOperation')); ?>/" + <?php echo $operations[$i]['ComptabiliteId']; ?>;'>Supprimer</button>
			<?php } ?>
		</td>
			<?php 
				echo $this->Form->create('Compta', array(
			        'inputDefaults' => array(
			            'div' => 'form-group',
			            'class' => 'form-control'
			        )
			    ));

			 ?>
		<td>
			<?php 
				echo $this->Form->input('ComptabiliteId', array(
			        'class' => 'form-control',
			        'type' => 'hidden',
			        'value' => $operations[$i]['ComptabiliteId'],
			        'label' => false
			    ));

			    echo $this->Form->input('MoyenDePaiementNom', array(
			        'class' => 'form-control',
			        'options' => $moyendepaiement,
			        'selected' => $operations[$i]['MoyenDePaiementNom'],
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('BanqueNom', array(
			        'class' => 'form-control',
			        'value' => $operations[$i]['BanqueNom'],
			        'label' => false
			    ));
			?>
		</td>
		<td>
			<?php
				echo $this->Form->input('IdentifiantTransaction', array(
			        'class' => 'form-control',
			        'value' => $operations[$i]['IdentifiantTransaction'],
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('MontantPaiement', array(
			        'class' => 'form-control',
			        'value' => $operations[$i]['MontantPaiement'],
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<?php 
				echo $this->Form->input('MontantRendu', array(
			        'class' => 'form-control',
			        'value' => $operations[$i]['MontantRendu'],
			        'label' => false
			    ));
			 ?>
		</td>
		<td>
			<input type="text" id="DateOperation<?php echo $i; ?>" class="form-control" value="<?php echo $operations[$i]['DateOperation']; ?>">
		</td>
		<td>
			<input type="text" id="DateDepot<?php echo $i; ?>" class="form-control" value="<?php echo $operations[$i]['DateDepot']; ?>" disabled>
		</td>
		<td>
			<input type="text" id="DateValeur<?php echo $i; ?>" class="form-control" value="<?php echo $operations[$i]['DateValeur']; ?>" disabled>
		</td>
		<td>
			<?php
				echo $this->Form->submit('Modifier', array(
			        'type' => 'submit',
			        'class' => 'btn btn-default'
			    ));
			    echo $this->Form->end();
		    ?>
		</td>
	</tr>
	<?php } ?>
</table>
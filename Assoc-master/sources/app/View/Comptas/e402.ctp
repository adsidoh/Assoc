<div class="row">

	<div class="col-md-8 col-md-offset-2">
		<h3>Association: <?php echo $nomassoc; ?></h3>
		<h3>Exercice: <?php echo $exercice; ?> </h3>
		<a href="<?php echo $this->Html->url(array('controller'=>'Comptas', 'action'=>'e402',1)); ?>" class="btn btn-default" role="button">Telecharger tous les reçus fiscaux</a>
		<br><br>
		<a href="<?php echo $this->Html->url(array('controller'=>'Comptas', 'action'=>'e402',2)); ?>" class="btn btn-default" role="button">Telecharger tous les reçus fiscaux des adhérents sans adresse email</a>
		<br><br>
		<a href="<?php echo $this->Html->url(array('controller'=>'Comptas', 'action'=>'e402')); ?>" class="btn btn-default" role="button" disabled>Envoyer par email son reçu fiscal à chaque adhérent</a>
	<div>
<div>
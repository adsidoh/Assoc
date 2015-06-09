<div class="row">
	<div class="col-md-12">
		<center>
			<table class="table table-striped">
				<?php 
					foreach ($eleve as $key => $value) {
						echo '<tr><td>'.$this->Html->link($value['bal_vue_e200_eleve']['EleveNom'].' '.$value['bal_vue_e200_eleve']['ElevePrenom'], array('controller'=>'recherches', 'action'=>'dossierEleve', $value['bal_vue_e200_eleve']['EleveId'])).'</td></tr>';
					}
				 ?>
			</table>
		</center>
	</div>
</div>
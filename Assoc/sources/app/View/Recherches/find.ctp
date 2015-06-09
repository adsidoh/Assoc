<div class="row">
	<div class="col-md-12">
		<table class="table table-striped">
			<tr>
				<th>Elèves</th>
				<th>Responsables Légals</th>
			</tr>

			<tr>
				<td>
					<?php 
					if(isset($eleve)) { 
						foreach ($eleve as $key => $value) {
							echo $this->Html->link('<b>'.$value['bal_vue_e200_eleve']['EleveNom'].'</b> '.$value['bal_vue_e200_eleve']['ElevePrenom'].'<br/>', array('controller'=>'Recherches', 'action'=>'dossierEleve', $value['bal_vue_e200_eleve']['EleveId']), array('escape'=>false));
						}
					}
					?>
				</td>
				<td>
					<?php 
						if(isset($parent)){
							foreach ($parent as $key => $value) {
								echo $this->Html->link('<b>'.$value['bal_vue_e100_personne']['PersonneNom'].'</b> '.$value['bal_vue_e100_personne']['PersonnePrenom'].'<br/>', array('controller'=>'Recherches', 'action'=>'dossierPersonne', $value['bal_vue_e100_personne']['PersonneId']), array('escape'=>false));
							}
						}
					?>
				</td>
			</tr>

		</table>
	</div>
</div>
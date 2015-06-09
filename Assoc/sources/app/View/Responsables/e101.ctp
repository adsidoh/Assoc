<div class="row">
	<!--EXERCICE / IDENTITE / ADRESSE-->
	<div class="col-md-3">
		<p style="font-size:x-large; font-style:normal;">Exercice</p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;">2014</p>
		<p style="font-size:x-large; font-style:normal;">Identité</p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['PersonneNom']; ?></p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['PersonnePrenom']; ?></p>
		<p style="font-size:x-large; font-style:normal;">Adresse</p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['NumEtVoie']; ?></p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['Ville']; ?></p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['CodePostal']; ?></p>
		<p style="font-size:medium; font-style:normal; text-indent:40px;"><?php echo $perso['Pays']; ?></p>		
	</div>


	<!-- GESTION ADHESION -->
	<div class="col-md-9">
		<table class="table table-striped">
			<TR> 
				<TH> Status </TH> 
				<TH> Adhésion à </TH> 
				<TH> Réglé le </TH> 
			</TR> 
			<TR> 
				<TH> Association </TH> 
				<TD> <?php echo $assocCourante; ?> </TD> 
				<TD>
					<?php 
						if($adhesion[0] == null){
					?>
					<a href="<?php echo $this->Html->url(array('controller'=>'Responsables', 'action'=>'gestionAdhesion', $assocCourante,1)); ?>" class="btn btn-default" role="button">ajouter</a> 

					<?php 
					}else{
						echo $adhesion[0];
					?>

					<a href="<?php echo $this->Html->url(array('controller'=>'Responsables', 'action'=>'gestionAdhesion', $assocCourante,0)); ?>" class="btn btn-default" role="button">supprimer</a> 
					<?php 
					}
					?>


				</TD>
			</TR>

			<?php
				foreach ($assoc as $key => $value) {					
			?>
			<TR> 
				<TH> Tutelle </TH> 
				<TD> <?php echo $value; ?> </TD>		
					<TD> 
					<?php 
						if($adhesion[$key+1] == null){
							echo "Non reglé";
					
						}else{
							echo $adhesion[$key+1];
						}
					?>
					</TD> 
			 </TR> 

			 <?php } ?>
		</table>
	</div>
</div>
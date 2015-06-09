<div class="row">

	<div class="col-md-12">
		<table class="table table-striped">
			<TR> 
				<TH><button class="btn btn-default" data-toggle="modal" data-target="#myModal">Ajouter</button></TH> 
				<TH>Désigation </TH> 
				<TH>Valeur Maximale</TH> 
				<TH>Idetification des transaction par un numéro</TH> 
				<TH>Rattachement à une banque</TH> 
			</TR> 
			<?php
				$i = 0;
				foreach ($moyenPayment as $key => $value) { 
				$a1 = $value['bal_vue_e400_modespaiement']['MoyenDePaiementNom'];
				$a2 = $value['bal_vue_e400_modespaiement']['AvecTransactionsIdentifiees'];
				$a3 = $value['bal_vue_e400_modespaiement']['AvecBanqueIdentifiee'];
				$a4 = $value['bal_vue_e400_modespaiement']['ValeurMaximale'];

			?>
			<TR>
				<TD><a href="<?php echo $this->Html->url(array('controller'=>'Comptas', 'action'=>'delMP',$a1)); ?>" class="btn btn-default" role="button">Suppr.</a></TD>
				<TD><?php echo $a1; ?></TD>
				<TD><input id = "<?php echo $i; ?>" class ="form-control" type="text" value = "<?php echo $a4; ?> " onblur ='update("<?php echo $a1; ?>","<?php echo $a2; ?>","<?php echo $a3; ?>","<?php echo $i; ?>");' disabled></TD>
				
				<TD>
					<?php  
						if($a2 == 1){
					?>
					<input type="checkbox" id="cb1" onclick='update("<?php echo $a1; ?>",0,"<?php echo $a3; ?>","<?php echo $i; ?>");' checked disabled>
					<?php 
						}else{
					 ?>
					<input type="checkbox" id="cb1" onclick='update("<?php echo $a1; ?>",1,"<?php echo $a3; ?>","<?php echo $i; ?>");' disabled>
					<?php 
						}
					 ?>
				</TD>
				<TD>
					<?php  
						if($a3 == 1){
					?>
					<input type="checkbox" id="cb2" onclick='update("<?php echo $a1; ?>","<?php echo $a2; ?>",0,"<?php echo $i; ?>");' checked disabled>
					<?php 
						}else{
					 ?>
					<input type="checkbox" id="cb2" onclick='update("<?php echo $a1; ?>","<?php echo $a2; ?>",1,"<?php echo $i; ?>");' disabled>
					<?php 
						}
					 ?>
				</TD>

			</TR>

			<?php $i++;} ?>
		</table>
	<div>
<div>

<script type="text/javascript">
	function update(a1,a2,a3,a4){
		a4 = document.getElementById(a4).value;

		if(a2 == '')
			a2 = 0;
		if(a3 == '')
			a3 = 0;
		window.location = "../Comptas/updateMP/"+a1+"/"+a2+"/"+a3+"/"+a4;
	}
</script>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Ajouter un moyen de paiement</h4>
      </div>
      <div class="modal-body">
        <div class="row">
        	<?php 
				echo $this->Form->create('paiement', array(
			        'inputDefaults' => array(
			            'div' => 'form-group',
			            'class' => 'form-control'
			        )
			    ));

			    echo $this->Form->input('Designation', array(
			        'class' => 'form-control',
			        'value' => '',
			        'label' => array(
			            'class' => 'control-label',
			            'text' => 'Designation'
			        )
		    	));
		    	echo $this->Form->input('ValeurMaximale', array(
			        'class' => 'form-control',
			        'value' => '',
			        'label' => array(
			            'class' => 'control-label',
			            'text' => 'Valeur Maximale'
			        )
		    	));
		    	echo $this->Form->label('Idetification des transaction par un numéro   ');
		    	echo $this->Form->checkbox('cb1', array('hiddenField' => false));

		    	echo '<br><br>';
		    	echo $this->Form->label('Rattachement à une banque');
		    	echo $this->Form->checkbox('cb2', array('hiddenField' => false));
		    ?>
        </div>
      </div>
      <div class="modal-footer">
        <?php 
        	echo $this->Form->submit('Ajouter', array(
		        'type' => 'submit',
		        'class' => 'btn btn-default'
		    ));
		    echo $this->form->end();
         ?>
      </div>
    </div>
  </div>
</div>
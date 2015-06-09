
<!-- onglet Recherche --> 
<div class="container">
		 <div class="row">
	    <div class="col-md-8 col-md-offset-2">	    	
	    		<h2> Responsables </h2>

	    		 
	    		<TABLE BORDER="0"> 
 					<TR> 
 						<TH> <a href="#" class="btn btn-lg btn-success"
  								data-toggle="modal"
   								data-target="#basicModal">Ajouter
   							</a> 
   						<?php
	   						if( !empty($staff) ) {
								echo '<TH> Personne </TH>';
	 							echo '<TH> Rôle </TH> ';						
	 						}
	 						else{
	 							echo '&nbsp;&nbsp;&nbsp;&nbsp;Ajouter de nouvelles responsabilites';
	 						}	
 						?>
 						</TH>
 					</TR> 

  			 <?php

	   			 	$idC = 0;
	   			 	//affichage des responsabilites
	   			 	foreach ($staff as $k => $s) {

	   			 		
	   			 		echo "<TR>";
	   			 		echo '<TD> '. $this->Html->link(
	   			 		'<span class="btn btn-danger">Supprimer</span>',
	   			 		array(
	   			 			"controller"	=>	"Associations",
	   			 			"action"		=>	"deleteStaff",
	   			 			$s["id"],
	   			 			$s["role"]

	   			 		),
	   			 		array('escape' => false)) .'</TD> '; 
	   			 		echo "<TD> ". $this->Form->input('',
	   			 			array(
      				 			'options' =>	$members,
      				 			'selected'=>	$s[ "id"],'id'=> 'I'.$idC,
      				 			'disabled' => true,
      				 			'onChange'=>	'update('.$idC.','.$s[ "id"].',"'.$s["role"].'");'
      				 		)
      				 	). "  </TD> ";
	   			 		echo "<TD> ". $this->Form->input('', array(
      				  		'options' =>$roles,
      				  		'selected' =>$s["role"],
      				  		'id'=> 'R'.$idC,
      				  		'onChange'=> 'update('.$idC.','.$s[ "id"].',"'.$s["role"].'");')) . "  </TD> ";
	   			 		echo "</TR>";
	   			 		$idC++;

	   			 	}
				?>
				
				</TABLE>
			 <?php  echo $this->Form->end();
				  ?>

    	 </div>	
	</div>
</div>


   <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<?php echo $this->Form->create('NewStaff');	?>
            <div class="modal-header">
        
            <h4 class="modal-title" id="myModalLabel">Ajouter un membre</h4>
            </div>
            <div class="modal-body">
                <?php
	    			
	    		 	
	    			echo $this->Form->input('Identite', array(
      					'options' 	=>  $personnes,
      					"class"		=>  "form-control",
      					"class"		=>  "form-control"
      				)); 

	    			echo $this->Form->input('Poste', array(
      					'options' 	=>	$roles,
      					"class"		=>	"form-control",
      					"class"		=>	"form-control"
      				)); 

	    		?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                <?php  echo $this->Form->submit('enregistrer',array("class"=>"btn btn-primary"));
                 echo $this->Form->end();
              
                ?>
        	</div>
    </div>
  </div>
</div>

<!-- Fonction js lié a chaque champs des responsables . Appelle l'action update.  --> 
<script> function update(idChamp,previous_id,previous_role)
		{
			 var selectI = document.getElementById('I'+idChamp );
			 var selectR = document.getElementById('R'+idChamp );
    		 var valeurI = selectI.options[selectI.selectedIndex].value;
		     var valeurR = selectR.options[selectR.selectedIndex].value;	
			document.location.href =  <?php 
				echo "'". $this->Html->url(
					array(
						"controller" 	=> "Associations",
						"action" 		=> "updateStaff")
					)."'";
				?> +'/'+valeurI +'/'+valeurR+'/'+<?php echo "'". $_SESSION['Exercice']."'";?>+'/'+previous_id+'/'+previous_role;
		}
</script> 
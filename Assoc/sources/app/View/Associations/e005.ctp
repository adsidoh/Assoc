
<div class="container">
	<div class="row">		 	
	    <div class="col-md-8 col-md-offset-2">
	    	  <!-- liste des affiliations -->
	    	<h2> Associations affiliés à <?php echo $assocCourranteNom; ?></h2>
	    	</br></br>
	    		<TABLE class="table table-striped">
		  			<?php  			 
		  			 	       	
			   			foreach ($tutelle as $key => $value)
			   			{
			   				echo "<TR>";
			   				echo "<TD> Tutelle de </TD>";
			   				echo "<TD>" . $value['bal_vue_e005_assoc']['AffilieNom']  .  "</TD>";
			   				echo '<TD> <a href="mailto:'.$value['bal_vue_e005_assoc']['EMail'].'"> <span class="btn btn-default">contacter </span> </a>  </TD> ';
			  
			   				echo '<TD> '. $this->Html->link('<button class="btn btn-danger">Supprimer</button>',array("controller"=>"Associations","action"=>"gestionTutelle",$value['bal_vue_e005_assoc']['AffilieId'] ,2),array('escape' => false)) .'</TD> '; 			 			
			   				echo "</TR>";
			   			}
			   			// liste des demandes d'assocs
			   			foreach ($demandes as $key => $value)
			   			{
			   					
			   				echo "<TR>";
			   				echo "<TD> Demande de Tutelle de  </TD>";
			   				echo "<TD>  "  . $value['bal_vue_e005_assoc']['AffilieNom']  .  " </TD>";
			   				echo '<TD> <a href="mailto:'.$value['bal_vue_e005_assoc']['EMail'].'"> <span class="btn btn-default">contacter </span> </a>  </TD> ';
			   				
			   		?>
			   		<td>
						<select id="ListeDemandes" onchange='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'Associations', 'action'=>'gestionTutelle' , $value['bal_vue_e005_assoc']['AffilieId'] )); ?>/" + document.getElementById("ListeDemandes").value;'>
							<option value="0"></option>
							<option value="1">Accepter</option>
						   	<option value="3">Refuser</option>
						</select>
					</td>
					</tr>	
			   		<?php 
			   			}
					?>

				</TABLE>

				 
				

    	 </div>	
	</div>
</div>
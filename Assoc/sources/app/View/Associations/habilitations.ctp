
<!-- onglet Recherche --> 
<div class="container">
		 <div class="row">
		 	<p> 	 		
	    		 <div class="col-md-2">
	    			Rechercher <br/>
	    			<input type="text" size="25">
	    		</div>	
    		</p>
	    <div class="col-md-8 col-md-offset-2">

	    	<p>
	    		<h2> Responsables </h2>

	    		<?php
	    			$années = array(2011,2012,2013,2014);
	    		 	 echo $this->Form->create('staff');	
	    			echo $this->Form->input('Exercice', array(
      				 'options' =>$années )); 
	    		?>
	    	</p>
	    		 <!-- table des responssables -->
	    		<TABLE BORDER="0"> 
 					<TR> 
 						<TH> <button class="btn btn-default">Ajouter </button>  </TH> 
						<TH> Personne </TH> 
 						<TH> Rôle </TH> 
 					</TR> 

  			 <?php
  		      

	   			 	foreach ($staff as $s)
	   			 	{
	   			 		$tmp = $s[0].' '.$s[1];
	   			 		echo "<TR>";
	   			 		echo '<TD> '. $this->Html->link('<span class="btn btn-danger">Supprimer</span>',array("controller"=>"Tests","action"=>"deleteStaff",$s[0]),array('escape' => false)) .'</TD> '; 
	   			 			echo "<TD> ". $this->Form->input('', array(
      				 'options' =>$members,'selected'=> $tmp)) . "  </TD> ";
	   			 		echo "<TD> ". $this->Form->input('', array(
      				 'options' =>$roles)) . "  </TD> ";
	   			 		echo "</TR>";
	   			 	}
				?>
				</p>
				</TABLE>
				<?php  echo $this->Form->submit('enregistrer',array("class"=>"btn btn-default"));

				  ?>

    	 </div>	
	</div>
</div>
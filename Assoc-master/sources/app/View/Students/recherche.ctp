<div class="row">
	<div class="col-md-9">
		<?php 

			echo $this->Form->create('seek');
			echo $this->Form->input('val', array(
				'id'=>'rech',
				'class'=>'form-control', 
				'label'=>false,
				'onkeyup'=>" $.get( '" . $this->Html->url( array( 'controller' => 'students', 'action' => 'ajaxRecherche' ), true ) . "/'+document.getElementById('rech').value,
                        function( data ) {
                            var obj = jQuery.parseJSON( data );
                            console.log(obj);

                            choix.innerHTML=null;

                            for (var i in obj){
								choix.innerHTML+='<span onclick=\"javascript:document.getElementById(\'rech\').value=\''+obj[i]+'\';choix.innerHTML=null;\">'+obj[i]+'</span><br/>';
							}
                        }
                );
                return false;"
			));
			

			//document.getElementById(\'rech\').value
		 ?>
		 <div id="choix" class="searchable-container">

		</div>
	</div>
	<div class="col-md-3">
		<?php 
			echo $this->Form->submit('rechercher', array('class'=>'btn btn-default'));
			echo $this->Form->end();
		 ?>
	</div>
</div>

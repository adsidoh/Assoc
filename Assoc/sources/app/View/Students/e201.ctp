<div class="row">
	<div class="col-md-6 col-md-offset-3">
		
			<!-- Responsable -->
			<h3>Responsable légal</h3>
			<p>
				<?php 
					echo ($resp[0]['bal_personne']['PersonneMasculin'])?'<b>Monsieur</b>':'<b>Madame</b>';

					echo ' '.$resp[0]['bal_personne']['PersonneNom'].' '.$resp[0]['bal_personne']['PersonnePrenom'].' - '.$resp[0]['bal_personne']['PersonneId'];
				 ?>

				</p>

			<!-- Eleve -->
			<h3>Elève</h3>
			<p><?php 
					echo ($eleve['Student']['EleveMasculin'])?'<b>Monsieur</b>':'<b>Madame</b>';

					echo ' '.$eleve['Student']['EleveNom'].' '.$eleve['Student']['ElevePrenom'].' - '.$eleve['Student']['EleveId'];


				 ?></p>

			
		<?php 

			/* Inscription */
			echo '<h3>Inscription</h3>';
			echo $this->Form->create('Student');

			echo $this->Form->input('classe', array(
				'name'=>'classe',
				'id'=>'classe',
				'class'=>'form-control',
				'options'=>$setClasse,
				'onchange'=>"$.get( '" . $this->Html->url( array( 'controller' => 'Students', 'action' => 'ajaxE201b' ), true ) . "/'+$( '#classe' ).val()+'/LV1',
                        function( data ) {
                            var obj = jQuery.parseJSON( data );

                            form.lv1.innerHTML=null;

                            for (var i in obj){
								form.lv1.options[form.lv1.options.length]=new Option(obj[i],i);
							}
                        }
                ), $.get( '" . $this->Html->url( array( 'controller' => 'Students', 'action' => 'ajaxE201c' ), true ) . "/'+$( '#classe' ).val(),
                        function( data ) {
                            var obj = jQuery.parseJSON( data );

                            console.log(obj);

                            listOpt.innerHTML=null;

                            for (var i in obj){
                            	if(obj[i]['nom'] != '' )
                            	listOpt.innerHTML += '<input type=\"checkbox\" name=\"data[Option]['+obj[i]['id']+']]\" id=\"'+i+'\" value=\"'+obj[i]['optionNom']+'\" /><label> '+obj[i]['nom']+'</label><br/>';
							}
                        }
                ),$.get( '" . $this->Html->url( array( 'controller' => 'Students', 'action' => 'ajaxE201b' ), true ) . "/'+$( '#classe' ).val()+'/LV3',
                        function( data ) {
                            var obj = jQuery.parseJSON( data );

                            form.lv3.innerHTML=null;

                            for (var i in obj){
								form.lv3.options[form.lv3.options.length]=new Option(obj[i],i);
							}
                        }
                ),$.get( '" . $this->Html->url( array( 'controller' => 'Students', 'action' => 'ajaxE201b' ), true ) . "/'+$( '#classe' ).val()+'/LV2',
                        function( data ) {
                            var obj = jQuery.parseJSON( data );

                            form.lv2.innerHTML=null;

                            for (var i in obj){
								form.lv2.options[form.lv2.options.length]=new Option(obj[i],i);
							}
                        }
                );
                return false;"
			));

			echo $this->Form->input('lv1', array(
				'id'=>'lv1',
				'class'=>'form-control',
				'options'=>array(''),

			));

			echo $this->Form->input('lv2', array(
				'id'=>'lv2',
				'class'=>'form-control',
				'options'=>'',
			));

			echo $this->Form->input('lv3', array(
				'id'=>'lv3',
				'class'=>'form-control',
				'options'=>''
			));

			/* Options */
			echo '<h3>Option</h3>';

			echo '<p id="listOpt"></p>';

			echo $this->Form->submit('Enregistrer', array('rule'=>'submit', 'class'=>'btn btn-default', 'before'=>'<br/>'));
			echo $this->Form->end();
		?>
	</div>

</div>
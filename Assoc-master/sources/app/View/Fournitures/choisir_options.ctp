
<?php
	
		echo $this->Form->create('Fourniture', array('action'=>'listeProduits'));
		echo $this->Html->css('main');//appel du fichier main.css
		
		echo '<div id="divClasse">';
		echo $this->Form->input('classe', array(
			'name'=>'classe',
			'id'=>'classe',
			'class'=>'form-control',
			'empty' => 'Aucune',
			'options'=>$setClasse,
			/*Dans onchange, on appelle la fonction déjà définie dans StudentsController qui est ajaxE201c et qui permet donc de récupérer dynamiquement en ajax
			les options. Quant à la fonction ajaxListeMatieres, on va la définir dans le controller des fournitures*/
			'onchange'=>"

			$.get( '" . $this->Html->url( array( 'controller' => 'Fournitures', 'action' => 'ajaxListeOptions' ), true ) . "/'+$( '#classe' ).val(),
                    function( data ) {//fonction callback qui est appelée si la requête a été effectuée

                    	var obj = jQuery.parseJSON( data );
						                    	
                        form.opt.innerHTML=null;

                        for (var i in obj){

                        	if(i == 0)//le premier choix proposé dans la liste déroulante est forcément 'Aucune'
                    			form.opt.options[form.opt.options.length]=new Option('Aucune','');//représente le champ empty (Aucune)
                    		else
								form.opt.options[form.opt.options.length]=new Option(obj[i]['option'],obj[i]['option']);
							
						}

						//Dans new Option(param1, param2) param1 correspond à la valeur qui sera visible dans la liste déroulante,
						//en l'occurence ici la liste des options. param2 correspond à la valeur que l'on récupèrera grâce à
						//this->request->data
                    }
            ),
			
			$.get('".$this->Html->url(array('controller' => 'Fournitures', 'action'=>'ajaxListeMatieres'),true)."/'+$('#classe').val(),
				function(data){
					
					var obj = jQuery.parseJSON(data);
					form.matiere.innerHTML = null;

					for(var i in obj){
						
						if(i == 0)
							form.matiere.options[form.matiere.options.length] = new Option('Aucune','');
						else
							form.matiere.options[form.matiere.options.length] = new Option(obj[i]['matiere'],obj[i]['matiere']);
					}
				}
			);
            return false;"
		));
		echo '</div>';

		echo '<div id="divMatiere">';
		
		echo $this->Form->input('matière', array(
			'name'=>'matiere',
			'id'=>'matiere',
			'class'=>'form-control',
			'empty' => 'Aucune',
			'options'=>$matieres
		));

		echo '</div>';

		echo '<div id="divOptions">';
		echo $this->Form->input('options*', array(
			'name'=>'options',
			'id'=>'opt',
			'class'=>'form-control',
			'multiple'=>true,
			'empty' => 'Aucune',
			'options'=>$options

		));
		echo '</div>';

		echo $this->Form->submit('Afficher livres', array('rule'=>'submit', 'class'=>'btn btn-default', 'before'=>'<br/><br/><br/><br/>'));
		echo $this->Form->end();
		echo '<h6>* Pour sélectionner plusieurs options, maintenez le bouton Ctrl en même temps que vous cliquez.</h6>';
	?>
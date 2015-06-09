<div class="row">
	<div class="col-md-4 col-md-offset-4">
        <?php if (isset($conseil)) { ?>
            <select class="form-control" id="ConseilFCPEId" >
                <?php for ($i=0; $i < sizeof($conseil); $i++) { ?>
                <option value="<?php echo $conseil[$i]['ConseilFCPEId']; ?>">
                    <?php echo $conseil[$i]['ConseilFCPELabel'];?>
                </option>
                <?php } ?>
            </select>

            </br>
            <a class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'logged')); ?>/" + document.getElementById("ConseilFCPEId").value;'>Me connecter sur l'association</a>
        <?php 
            }
        ?>

		</br></br>
        <p>
            <?php 
                if (!isset($conseil)) { 
                    echo "Vous n'avez pas encore d'association.";
                } 
                else {
                    echo "Votre association n'a pas encore d'espace?";
                }
            ?>
            <a href="<?php echo $this->Html->url(array('controller'=>'associations', 'action'=>'E012')); ?>" class="btn btn-default" role="button">Créer</a>
        </p>
	</div>
</div>
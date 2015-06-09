

<table class="acceuil">
<caption><p>
<h1>Bienvenue sur votre application </h1>
<p></caption>
<tr>
    <td>
        <div class="connexion_assoc">

            <table >
                <?php if (isset($association)) {  ?>
                <caption><h3>Acceder a mon espace association</h3></caption>
                <tr>
                    <td>
                        <select class="form-control" id="ConseilFCPEId" >
                            <option value=-1>
                                S&eacute;lectionnez l'association
                                </option> 
                                <?php for ($i=0; $i < sizeof($association); $i++) { ?>
                                    <option value="<?php echo $association[$i]['bal_vue_e001_assoc']['ConseilFCPEId']; ?>">
                                        <?php echo $association[$i]['bal_vue_e001_assoc']['ConseilFCPELabel'];?>
                                    </option>
                                <?php } ?>

                            </select>
                    </td>
                    <td>
                        dans laquelle vous &ecirc;tes inscrit
                    </td>
                </tr>

                <tr>
                    <td>
                        <a class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'e001')); ?>/" + document.getElementById("ConseilFCPEId").value;'>Aller sur votre assocition</a>
                    </td>

                    <td>
                        <span> en utilisant votre identifiant et votre mot de passe pour se connecter</span>
                    </td>
                </tr>
             </table>     
                

                <?php 
                }
                ?>

        </div>
    </td>

    <Td>
        <div class="creation_assoc">
        <h3>Creer une association</h3>

        <p> Vous voulez creer une association ? <a href="<?php echo $this->Html->url(array('controller' => 'users' , 'action' => 'e013')); ?>">cliquez ici </a></p>

        </div>
    </Td>
</tr>
</table>

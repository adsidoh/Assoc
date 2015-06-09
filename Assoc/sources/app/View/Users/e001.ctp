<div class="row">
    <div class="col-md-6 col-md-offset-3">

        <?php 
            if( isset($conseilfcpenom) ){
                echo "CONNEXION SUR L'ASSOCIATION ";
                 echo "<font color=\"red\"><b>".$conseilfcpenom[0]['bal_conseilfcpe']['ConseilFCPENom'] ."</b></font>";
            }
            echo "<br/><br/>";
            if( isset($nonIdentife) && $nonIdentife ){
                echo "<p> Vous n'etes pas inscrit sur cette association. <a href =".$this->Html->url(array('controller'=>'users', 'action'=>'accueil')) .">Selectionnez une autre association </a></p>";
            }
            echo "<br/>";
            echo $this->Form->create('User', array(
                'class' => 'form-horizontal',
                'inputDefaults' => array(
                    'div' => 'form-group',
                    'class' => 'form-control',
                    'format' => array('label', 'before', 'input', 'after'),
                    'before' => '<div class="col-sm-10">',
                    'after' => '</div>'
                )
            ));
            
            echo $this->Form->input('EMail', array(
                'placeholder' => 'EMail',
                'label' => array(
                    'class' => 'col-sm-2 control-label',
                    'text' => 'EMail'
                )
            ));
           
            echo $this->Form->input('Password', array(
                'placeholder' => 'Mot de passe',
                'label' => array(
                    'class' => 'col-sm-2 control-label',
                    'text' => 'Mot de passe'
                ),
                'type' => 'password',
                'value' => ''
            ));
           
        ?>
        <table class="connexion-users">

            <tr>
                <td>
                    <?php
                        echo $this->Form->submit('Me connecter', array(
                        'type' => 'submit',
                        'class' => 'btn btn-default'
                        ));

                        echo $this->Form->end();
                    ?>
                </td>
                <td>
                    <a href="#"> Mot de passe oubli&eacute; ?</a>
                </td>
            </tr>

        </table>
        <br><br/>
      <p>Des difficult&eacute;s &agrave; se connecter? </p>  
    </div>
</div>


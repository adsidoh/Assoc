<div class="row">
    <div class="col-md-6 col-md-offset-3">
<h5> je suis deja enregistré</h5>
</br>
        <?php 


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
           <div class="col-sm-offset-2 col-sm-10">
            <?php
                echo $this->Form->submit('Me connecter', array(
                    'type' => 'submit',
                    'class' => 'btn btn-default'
                ));

                echo $this->Form->end();
            ?>

        </br></br>
        <p>
            Je ne suis pas encore enregistré 
            </br></br>
            <a href="<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'E013')); ?>" class="btn btn-default" role="button">Créer mon compte</a>
        </p>

    </div>
</div>
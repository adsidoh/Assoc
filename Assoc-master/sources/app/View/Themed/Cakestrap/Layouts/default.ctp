<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Bourse aux livres - FCPE');
?>
<?php echo $this->Html->docType('html5'); ?> 
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $cakeDescription ?>:
			<?php echo $title_for_layout; ?>
		</title>
		<?php
			echo $this->Html->meta('icon', $this->Html->url('/fcpe.bmp'));
			
			echo $this->fetch('meta');

			echo $this->Html->css('bootstrap');
			echo $this->Html->css('main');

			echo $this->fetch('css');
			
			echo $this->Html->script('libs/jquery-1.10.2.min');
			echo $this->Html->script('libs/bootstrap.min');
			
			echo $this->fetch('script');
		?>
	</head>

	<body>

		<div id="main-container">
		
			<div id="header" class="container">
				<?php  
					if(AuthComponent::user('InterlocuteurId')){
						if (isset($_SESSION['Association']['ConseilFCPEId'])) {
							if ($_SESSION['Auth']['User']['HabilitationNom']=="Administrateur") {
								// Si habilitation = "Administrateur"
								echo $this->element('menu/admin_menu');
							} 
							if ($_SESSION['Auth']['User']['HabilitationNom']=="Responsable") {
								// Si habilitation = "Responsable"
								echo $this->element('menu/resp_menu');
							}
							else if ($_SESSION['Auth']['User']['HabilitationNom']=="Gestionnaire") {
								// Si habilitation = "Gestionnaire"
								echo $this->element('menu/gest_menu');
							}
							else if ($_SESSION['Auth']['User']['HabilitationNom']=="Opérateur") {
								// Si habilitation = "Opérateur"
								echo $this->element('menu/ope_menu');
							}
							else if ($_SESSION['Auth']['User']['HabilitationNom']=="Membre") {
								// Si habilitation = "Membre"
								echo $this->element('menu/memb_menu'); 
							}
						}
					}
				?>
			</div><!-- /#header .container -->
	
			<div id="content" class="container">
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div><!-- /#content .container -->
			
			<div id="footer" class="container">
				<?php //Silence is golden ?>
			</div><!-- /#footer .container -->
			
		</div><!-- /#main-container -->
		
	</body>

</html>
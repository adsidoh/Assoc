<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<a class="navbar-brand" href="<?php echo $this->Html->url('/'); ?>">Accueil</a>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Association <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php 
						if (isset($_SESSION['Association']['ConseilFCPENom'])) {
							echo "<li><a>" . $_SESSION['Association']['ConseilFCPENom'] . "</a></li>";
						} 
					?>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Parent <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php 
						if (isset($_SESSION['Dossier']['Parent']['PersonneNom'], $_SESSION['Dossier']['Parent']['PersonnePrenom'])) {
							echo "<li><a>" . $_SESSION['Dossier']['Parent']['PersonneNom'] . " " . $_SESSION['Dossier']['Parent']['PersonnePrenom'] . "</a></li>";
						} 
					?>
					<?php 
						if (isset($_SESSION['Exercice'])) {
							if (isset($_SESSION['Dossier']['Parent']['ParentId'])){
					?>
					<li><a href="<?php echo $this->Html->url(array('controller'=>'responsables', 'action'=>'E100')); ?>">Coordonnées</a></li>
					<li><a href="<?php echo $this->Html->url(array('controller'=>'responsables', 'action'=>'E101')); ?>">Adhésion</a></li>
					<?php 
							}
						}
					?>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Eleve <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php 
						if (isset($_SESSION['Dossier']['Eleve']['EleveNom'], $_SESSION['Dossier']['Eleve']['ElevePrenom'])) {
							echo "<li><a>" . $_SESSION['Dossier']['Eleve']['EleveNom'] . " " . $_SESSION['Dossier']['Eleve']['ElevePrenom'] . "</a></li>";
						} 
					?>
					<?php 
						if (isset($_SESSION['Dossier']['Parent']['ParentId'])){ 
					 ?>
					<li><a href="<?php echo $this->Html->url(array('controller'=>'eleves', 'action'=>'E200')); ?>">Coordonnées</a></li>
					<?php 
						}
						if (isset($_SESSION['Dossier']['Eleve']['EleveId'])){  
					?>
					<li><a href="<?php echo $this->Html->url(array('controller'=>'eleves', 'action'=>'E201')); ?>">Scolarité</a></li>
					<?php 
						}
					?>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Fournitures <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php  
						if (isset($_SESSION['Dossier']['Eleve']['EleveId'])){ 
					?>
					<li class="dropdown-submenu">
						<a href="#">Opérations</a>
						<?php if (isset($bonoperation)) { ?>
						<ul class="dropdown-menu">
							<?php 
								for ($i=0; $i < sizeof($bonoperation); $i++) { 
									foreach ($bonoperation[$i] as $key => $value) {		
							?>
								<li><a href="<?php echo $this->Html->url(array('controller'=>'fournitures', 'action'=>'e300', $key)); ?>"><?php echo $value . " " . $key; ?></a></li>
							<?php 
									}
								}
							?>
                		</ul> 
                		<?php } ?>
					</li>
					<?php 
						}
					?>
				</ul>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Compta <b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php 
						if (isset($_SESSION['Dossier']['Parent']['ParentId'])){ 
					?>
					<li><a href="<?php echo $this->Html->url(array('controller'=>'Comptas', 'action'=>'E400')); ?>">Dossier en cours</a></li>
					<?php 
						}
					?>
				</ul>
			</li>
			<?php 
				if (isset($_SESSION['Exercice'])){ 
			?>
			<ul class="nav navbar-nav navbar-right">
				<form class="navbar-form navbar-right" role="search">
			        <div class="form-group">
			          <input type="text" id="Recherche" class="form-control" placeholder="Rechercher">
			        </div>
			        <a class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'recherches', 'action'=>'find')); ?>/" + document.getElementById("Recherche").value;'>Rechercher</a>
			    </form>
			</ul>

			<?php } ?>
            <div class="navbar-brand">Exercice
               <select id="Exercice" class="span2" onchange='javascript:window.location = "<?php echo $this->Html->url(array('action'=>'changeExercice')); ?>/" + document.getElementById("Exercice").value;'>
                    <option value="2013" <?php if($_SESSION['Exercice']==2013) echo "selected"; ?>>2013</option>
                    <option value="2014" <?php if($_SESSION['Exercice']==2014) echo "selected"; ?>>2014</option>
                </select>
            </div>

            <div class="navbar-brand">
            	<?php 
            		echo "Dossier ouvert: ";
            		if (isset($_SESSION['Dossier']['Parent']['PersonneNom'], $_SESSION['Dossier']['Parent']['PersonnePrenom'])) {
            			echo "[Responsable - " . $_SESSION['Dossier']['Parent']['PersonneNom'] . " " . $_SESSION['Dossier']['Parent']['PersonnePrenom'] . "]";
            		}
            		if (isset($_SESSION['Dossier']['Eleve']['EleveNom'], $_SESSION['Dossier']['Eleve']['ElevePrenom'])) {
            			echo "[Eleve - " . $_SESSION['Dossier']['Eleve']['EleveNom'] . " " . $_SESSION['Dossier']['Eleve']['ElevePrenom'] . "]";
            		}
            		if (!isset($_SESSION['Dossier']['Eleve']['PersonneNom'], $_SESSION['Dossier']['Eleve']['PersonnePrenom'])) {
            			if (!isset($_SESSION['Dossier']['Eleve']['EleveNom'], $_SESSION['Dossier']['Eleve']['ElevePrenom'])) {
            				echo "[Aucun]";
            			}
            		}
            	?>
            </div>

            <?php if (isset($_SESSION['Auth']['User']['InterlocuteurId'])){ ?>
            <ul class="nav navbar-nav navbar-right">
				<form class="navbar-form navbar-right">
			        <a class="btn btn-default" onclick='javascript:window.location = "<?php echo $this->Html->url(array('controller'=>'users', 'action'=>'logout')); ?>";'>Se déconnecter</a>
			    </form>
			</ul>
			<?php } ?>
		</ul><!-- /.nav navbar-nav -->
	</div><!-- /.navbar-collapse -->
	</div>
</nav><!-- /.navbar navbar-default -->
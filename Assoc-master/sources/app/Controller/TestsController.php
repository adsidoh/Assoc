<?php
	class TestsController extends AppController{
		
		public function montest($idClasse){


			// $query = $this->Test->query("SELECT DISTINCT bal_traitede.DisciplineNom FROM bal_etablissement 
			// 	INNER JOIN bal_estutilisepour ON bal_etablissement.EtablissementId = bal_estutilisepour.EtablissementId
			// 	INNER JOIN bal_classe ON bal_estutilisepour.ClasseId = bal_classe.ClasseId
			// 	INNER JOIN bal_estinscriten ON bal_classe.ClasseId = bal_estinscriten.ClasseId
			// 	INNER JOIN bal_cours ON bal_estinscriten.CoursId = bal_cours.CoursId
			// 	INNER JOIN bal_traitede ON bal_cours.CoursId = bal_traitede.CoursId
			// 	WHERE bal_etablissement.EtablissementId = ".$_SESSION['Association']['EtablissementId'].""
			// );

			$query = $this->Test->query("SELECT DISTINCT bal_vue_e201_option.OptionNom FROM bal_vue_e201_option
				WHERE bal_vue_e201_option.ClasseId= $idClasse AND bal_vue_e201_option.EtablissementId = ".$_SESSION['Association']['EtablissementId'].""
			);

			$this->set('query',$query);
		
		}
	}
	
?>
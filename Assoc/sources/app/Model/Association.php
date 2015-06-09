<?php

/**
 * Classe permettant de gérer une Association
 */
class Association extends AppModel {

	/**
	 * On spécifie la table correspondante dans la base de donnée
	 */
	public $useTable = 'vue_e012_assoc';

	/**
	 * Permet de contrôler les champs lors de la validation des données
	 * pour l'enregistrement d'une association
	 */
	/*public $validate = array(
		'ConseilFCPENom' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le nom de l\'établissement scolaire'
		),

		'TypeDEtablissementNom' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le type de l\'établissement scolaire'
		),
		'EtablissementNom' => array(	
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Le nom de l\'établissement ne peut être vide'
		),
		'EtabNumEtVoie' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le numéro et le nom de la voie'
		),
		'EtabLieuDit' => array(
			'allowEmpty' => true,
			'required' => true
		),
		'EtabVille' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier la ville de l\'établissement scolaire'
		),
		'EtabPays' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le pays de l\'établissement scolaire'
		),
		'EtabCodePostal' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le code postal de l\'établissement scolaire'
		),
		'EtabApptBatResidence' => array(
			'allowEmpty' => true,
			'required' => false
		),
		'EtabBP' => array(
			'allowEmpty' => true,
			'required' => true
		),
		'ConseilFCPENom' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Le nom de l\'association ne peut être vide'
		),
		'TutelleId' => array(
			'allowEmpty' => true,
			'required' => true
		),
		'SCApptBatResidence' => array(
			'allowEmpty' => true,
			'required' => true
		),
		'SCNumEtVoie' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le numéro et le nom de la voie'
		),
		'SCLieuDit' => array(
			'allowEmpty' => true,
			'required' => true
		),
		'SCVille' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier la ville du siège social de l\'association'
		),
		'SCCodePostal' => array(
			'allowEmpty' => false,
			'required' => true,
			'message' => 'Veuillez spécifier le code postal du siège social de l\'association'
		),
		'SCBP' => array(
			'allowEmpty' => true,
			'required' => true
		)
	);*/

}

?>
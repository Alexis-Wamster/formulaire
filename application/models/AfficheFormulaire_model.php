<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AfficheFormulaire_model extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function getFormulaire($cleFormulaire){
		$this->load->database();
		$sql = "SELECT * FROM S2_2_Formulaire WHERE idFormulaire = ?";
	    $query = $this->db->query($sql, [$cleFormulaire]);
	    if ($query->num_rows() === 0) {
	        return null;
	    }
	    
	    $formulaire = array(
			'titre' => $query->row()->titre,
			'lieu' => $query->row()->lieu,
			'description' => $query->row()->description,
			'clefFormulaire' => $query->row()->idFormulaire,
			'date' => []
		);

		$sql = "SELECT * FROM S2_2_Horaire WHERE idFormulaire = ?";
	    $query = $this->db->query($sql, [$cleFormulaire]);
	    $donnees = $query->result();

	    foreach ($donnees as $row) {
    		$jour = $row->jour;
    		$horaire = $row->horaire;
    		if (!isset($formulaire['date'][$jour])) {
        		$formulaire['date'][$jour] = [];
    		}
    		$formulaire['date'][$jour][$horaire] = [];
		}
		return $formulaire;
	}
}
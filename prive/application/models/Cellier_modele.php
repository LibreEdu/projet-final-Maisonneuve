<?php
class Cellier_modele extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function bouteilles_par_cellier($id_cellier)
	{
		$this->db->select('cb.id AS id_cellier_bouteille');
		$this->db->select('date_achat');
		$this->db->select('quantite');
		$this->db->select('cellier.libelle AS nom_cellier');
		$this->db->select('bouteille.id AS id_bouteille');
		$this->db->select('bouteille.libelle AS nom');
		$this->db->select('code_saq');
		$this->db->select('date_buvable');
		$this->db->select('prix');
		$this->db->select('millesime');
		$this->db->select('bouteille.pays');
		$this->db->select('format');
		$this->db->select('note');
		$this->db->select('type.libelle AS type');
		$this->db->from('cellier__bouteille AS cb');
		$this->db->join('cellier', 'cellier.id = cb.id_cellier');
		$this->db->join('cellier__usager AS cu', 'cu.id_cellier = cellier.id');
		$this->db->join('usager', 'usager.id = cu.id_usager');
		$this->db->join('bouteille', 'bouteille.id = cb.id_bouteille');
		$this->db->join('type', 'type.id = bouteille.id_type', 'left');
		$this->db->where('cu.id_role', 1);
		$this->db->where('cellier.id', $id_cellier);
		$this->db->order_by('bouteille.libelle', 'ASC');
		$requete = $this->db->get();
		return $requete->result_array();
	}
}
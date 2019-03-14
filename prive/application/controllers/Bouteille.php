<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bouteille extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('bouteille_modele');
		// $this->load->helper('url_helper');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$donnees['bouteilles'] = $this->bouteille_modele->bouteilles_par_cellier(1);

		$this->load->view('modeles/en-tete');
		$this->load->view('cellier', $donnees);
		$this->load->view('modeles/bas-de-page');
	}
}

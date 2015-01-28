<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empresas extends CI_Controller {
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->model('empresamodel','empm');
	}
	
	/**
	 * Default view
	 */
	public function index()
	{
		$this->load->view('empresas');
	}
	
	
	/**
	 * Search on 'empresas' table
	 */
	public function search() {
		
		$searchtext = $this->input->post('searchtext');
		if (empty($searchtext)) {
			$this->load->view('empresas');
		} else {
			$empresaslist = $this->empm->listEmpresasByText($searchtext);
			$data['empresaslist'] = $empresaslist;
			$this->load->view('empresas', $data);
		}
		
	}
}
?>
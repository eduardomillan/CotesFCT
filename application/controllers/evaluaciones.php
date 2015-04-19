<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evaluaciones extends CI_Controller {
	
	const PAGE_DEFAULT = "empresas";
	const PAGE_SELF = "evaluaciones";
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	
	/**
	 * Default view
	 */
	public function index()
	{
		//Redirect to default page, because no parameters have been specified
		$this->load->view(self::PAGE_DEFAULT);
	}
	
	
	/**
	 * Show information about the 'evaluacion'
	 */
	public function info() {
		 $empresaId = $this->uri->segment(3);
		 $data['empresaId'] = $empresaId;
		
		$this->load->view(self::PAGE_SELF, $data);		
	}
	
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas extends CI_Controller {
	
	const MODE_UPDATE = 'update';
	const MODE_READ = 'read';
	const SELF_PAGE = "empresas";
	const SHEET_PAGE = "empresa_sheet";
	const PAGE_ROWS = 10;
	


	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->load->library('console');
		$this->output->enable_profiler(TRUE);
		$this->load->model('empresamodel','empm');
				
	}
	
	/**
	 * Default view
	 */
	public function index()
	{
		$this->search();
	}
	
	
	/**
	 * Search on 'empresas' table
	 */
	public function search() {
		
		$data['empresaslist'] = NULL;
		$data['total'] = -1;
		$data['advancedsearch'] = NULL;
		
		if (empty($_POST['searchtext'])) {
			$searchtext = $this->session->userdata('searchtext');
		} else {
			$searchtext = $this->input->post('searchtext');
		}
		
		if (!strlen($searchtext)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/search"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
					
			//Búsqueda			
			$results = $this->empm->listEmpresasByText($searchtext);
			
			//Total
			$total = count($results);
			$config['total_rows'] = $total;
			$data['total'] = $total;
			
			//Paginación
			$this->pagination->initialize($config); // le paso el vector con mis configuraciones al paginador
					
			//Array de resultados
			if ($total > 0) {
				$data['empresaslist'] = array_slice($results, $this->uri->segment(3), self::PAGE_ROWS);
			}
		}
		
		$data['searchtext'] = $searchtext;
		$this->session->set_userdata('searchtext', $searchtext);
		$this->load->view(self::SELF_PAGE, $data);
	}
	
	/**
	 * Perform an advanced search on 'empresas' table
	 */
	public function advancedSearch() {

		$data['empresaslist'] = NULL;
		$data['total'] = -1;
		$data['advancedsearch'] = "advanced";
		
		if (empty($_POST)) {
			$searchtext = $this->session->userdata('searchtext');
			$searchfamilia = $this->session->userdata('searchfamilia');
			$searchconcert = $this->session->userdata('searchconcert');
		} else {
			$searchtext = $this->input->post('searchtext');
			$searchfamilia = $this->input->post('searchfamilia');
			$searchconcert = $this->input->post('searchconcert');
		}
		
		//Familias
		$data['familiaslist'] = $this->empm->listFamilias();
		
		
		if (!strlen($searchtext) && !strlen($searchfamilia) && !strlen($searchconcert)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/advancedSearch"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
				
			//Búsqueda
			$param['familia'] = $searchfamilia;
			$param['concert'] = $searchconcert;
			$results = $this->empm->listEmpresasByAdvanced($searchtext, $param);
				
			//Total
			$total = count($results);
			$config['total_rows'] = $total;
			$data['total'] = $total;
				
			//Paginación
			$this->pagination->initialize($config); // le paso el vector con mis configuraciones al paginador
				
			//Array de resultados
			if ($total > 0) {
				$data['empresaslist'] = array_slice($results, $this->uri->segment(3), self::PAGE_ROWS);
			}
		}
		
		$data['searchtext'] = $searchtext;
		$data['searchfamilia'] = $searchfamilia;
		$data['searchconcert'] = $searchconcert;
		
		$this->session->set_userdata('searchtext', $searchtext);
		$this->session->set_userdata('searchfamilia', $searchfamilia);
		$this->session->set_userdata('searchconcert', $searchconcert);
		
		$this->load->view(self::SELF_PAGE, $data);
	}
	
	
	/**
	 * Show information about the 'empresa'
	 */
	public function info() {
		$this->show(self::MODE_READ);
	}
	
	
	/**
	 * 
	 */
	public function edit() {
		$this->show(self::MODE_UPDATE);
	}
	
	
	/**
	 * Show a 'empresa' and set the mode
	 * @param unknown $mode
	 */
	private function show($mode) {

		//Empresa
		$empresa = $this->empm->getEmpresaByIdOrCIF($this->uri->segment(3));
		$data['empresa'] = $empresa;
		$data['modo'] = $mode;
		
		//Familias
		$data['familiaslist'] = $this->empm->listFamilias();
		
		$this->load->view(self::SHEET_PAGE, $data);
	}
	
	
	/**
	 * Updates the data
	 */
	public function update() {
		
		/*
		$this->form_validation->set_rules('nombre', 'Nombre', 'required|trim');
		$this->form_validation->set_rules('pass', 'Clave', 'required|trim');
		$this->form_validation->set_rules('nivel', 'Nivel', 'max_length[11]');
			
		$this->form_validation->set_error_delimiters('<br /><span class="error">', '</span>');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view(self::SHEET_PAGE);
		} else {// passed validation proceed to post success logic
		*/

			// build array for the model
			/*	
			$form_data = array(
					'nombre' => set_value('nombre'),
					'pass' => set_value('pass'),
					'nivel' => set_value('nivel')
			);
			*/
			$id = $this->input->post('id');
			$data = $this->input->post(); 
			
			// run insert model to write data to db
			if ($this->empm->update($id, $data) == 1) // the information has therefore been successfully saved in the db
			{
				$this->search();   // or whatever logic needs to occur
			}
			else
			{
				echo 'An error occurred saving your information. Please try again later';
				// Or whatever error handling is necessary
			}
		//}
	}
}
?>

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas extends CI_Controller {
	
	const MODE_CREATE = "create";
	const MODE_READ = "read";
	const MODE_UPDATE = "update";
	
	const PAGE_SELF = "empresas";
	const PAGE_SHEET = "empresa_sheet";
	const PAGE_UPDATE = "empresa_update";
	const PAGE_ROWS = 20;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		//$this->load->library('console');
		//$this->output->enable_profiler(TRUE);
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
		$this->load->view(self::PAGE_SELF, $data);
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
		$data['familiaslist'] = $this->empm->listFamiliasInEmpresas();
		
		
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
		
		$this->load->view(self::PAGE_SELF, $data);
	}
	
	
	/**
	 * Show information about the 'empresa'
	 */
	public function info() {
		$this->show($this->uri->segment(3), self::MODE_READ);
	}
	
	
	/**
	 * Edit the 'empresa' data
	 */
	public function edit() {
		$this->show($this->uri->segment(3), self::MODE_UPDATE);
	}
	
	/**
	 * Shows the 'empresa' sheet to create one
	 */
	public function arise() {
		$this->show(NULL, self::MODE_CREATE);
	}
	
	
	/**
	 * Show a 'empresa' and set the mode
	 * @param unknown $mode
	 */
	private function show($id, $mode) {

		if ($mode == self::MODE_CREATE) {
			$empresaId = "";
			$empresa = array();
		} else {
			$empresaId = $id;
			$empresa = $this->empm->getEmpresaByIdOrCIF($empresaId);
		}
		
		$data['empresaId'] = $empresaId;
		$data['empresa'] = $empresa;
		$data['modo'] = $mode;		
		
		//Familias
		$data['familiaslist'] = NULL;
		
		$this->load->view(self::PAGE_SHEET, $data);
	}
	
	/**
	 * Update the 'empresa' data into the database
	 */
	public function update() {
		$this->save(self::MODE_UPDATE);
	}
	
	/**
	 * Create a new 'empresa' record into the database
	 */
	public function create() {
		$this->save(self::MODE_CREATE);
	}
	
	
	/**
	 * Updates the data
	 */
	private function save($mode) {
		
		//Build array for the model
		$userdata = $this->input->post();
				
		//Validate the data		
		if ($this->validate() == FALSE) {
			
			//Variables de página
			$empresaId = $userdata['id'];
			$data['empresaId'] = $empresaId;
			$data['empresa'] = $userdata;
			$data['modo'] = $mode;
			
			//Familias
			$data['familiaslist'] = NULL;
			$data['updateResult'] = "notValid";
			
			$this->load->view(self::PAGE_SHEET, $data);
			
		} else {// passed validation proceed to post success logic
			
			$data['updateResult'] = "";
				
			// run insert model to write data to db
			if ($mode == self::MODE_CREATE) {
				$res = $this->empm->create($userdata);
			} else if ($mode == self::MODE_UPDATE) {
				$res = $this->empm->update($userdata);
			}
			
			if ($res == 1) // the information has therefore been successfully saved in the db
			{
				$data['updateResult'] = "success";
				$this->load->view(self::PAGE_UPDATE, $data);
			}
			else
			{
				//An error occurred saving your information
				$data['updateResult'] = "error";
				$this->load->view(self::PAGE_UPDATE, $data);
			}
		}
	}
	
	
	/**
	 * Performs the data validation
	 */
	private function validate() {
		
		$this->form_validation->set_rules('empresa', 'Empresa', 'required');
		$this->form_validation->set_rules('cif', 'CIF/NIF', 'required');
		$this->form_validation->set_rules('cp', 'Código Postal', 'required');
		$this->form_validation->set_rules('ciutat', 'Población', 'required');
		$this->form_validation->set_rules('provincia', 'Provincia', 'required');
		$this->form_validation->set_rules('telf', 'Teléfono', 'required');
		
		$this->form_validation->set_error_delimiters('', '');
		
		return $this->form_validation->run();
	}
}
?>
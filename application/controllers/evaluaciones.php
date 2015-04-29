<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Evaluaciones extends CI_Controller {
	
	const PAGE_DEFAULT = "empresas";
	const PAGE_SELF = "evaluaciones";
	const PAGE_SHEET = "evaluacion_sheet";
	
	const MODE_CREATE = "create";
	const MODE_READ = "read";
	const MODE_UPDATE = "update";	
	
	const RANGE_CURSOS = 15;
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		//$this->load->library('console');
		//$this->output->enable_profiler(TRUE);
		
		$this->load->model('empresamodel','empm');
		$this->load->model('evaluamodel','evalm');
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
		$mode = self::MODE_READ;
		$this->show($empresaId, $mode);
	}
	
	
	/**
	 * Show 'evaluaciones' from a empresa and set the mode
	 * @param unknown $mode
	 */
	private function show($id, $mode) {
		
		$data = $this->loadEmpresa($id);
		$data['modo'] = $mode;
		
		//Show the page
		if ($mode == self::MODE_CREATE) {
			//Crear lista de ciclos
			$data['cicloslist'] = $this->empm->listCiclos();
			
			//Crear lista de cursos
			$data['cursoslist'] = $this->loadCursos();
			
			//Lista de valores para la evaluación
			$data['valoreslist'] = $this->loadValores();
			
			$this->load->view(self::PAGE_SHEET, $data);
			
		} else {
			$this->load->view(self::PAGE_SELF, $data);
		}
	}
	
	
	/**
	 * Shows the 'evaluaciones' sheet to create one
	 */
	public function arise() {
		$empresaId = $this->uri->segment(3);
		$mode = self::MODE_CREATE;
		$this->show($empresaId, $mode);
	}
	
	
	/**
	 * Create a new 'evaluacion' record into the database
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
		
		$empresaId = $userdata['empresaId']; 
		$evaldata = array (
			'id'=>NULL,
			'idEmpresa'=>$empresaId,
			'ciclo'=>$userdata['ciclo'],
			'curso'=>$userdata['curso'],
			'eval_ini'=>$userdata['eval_ini'],
			'eval_fin'=>$userdata['eval_fin'],
			'observaciones'=>$userdata['observaciones']
		);
		
		//Validate the data
		if ($this->validate() == FALSE) {
			//Return to the same page with errors
			$this->show($empresaId, $mode);
		} else {
			//Save the data
			$res = $this->evalm->create($evaldata);
			$this->show($empresaId, self::MODE_READ);
		}
		
	}	
	
	
	/**
	 * Loads the 'empresa' data given its $id
	 * @param unknown $id
	 * @return unknown
	 */
	private function loadEmpresa($id) {
		$empresaId = $id;
		
		//Obtain the empresa
		$empresa = $this->empm->getEmpresaByIdOrCIF($empresaId);
		
		//Set the request data
		$data['empresaId'] = $empresaId;
		$data['nombreEmpresa'] = addslashes($empresa['empresa']);
		$data['empresa'] = $empresa;
		
		//Obtain the different evaluaciones
		$data['evalualist'] = $this->evalm->listEvaluaByEmpresa($empresaId);
		
		return $data;
	}
	
	
	/**
	 * Calculates the available "cursos" for the "evaluaciones"
	 */
	private function loadCursos() {
		
		$cursos = array();
		$year = date ("Y");

		for ($i = $year-self::RANGE_CURSOS; $i <= $year+1; $i++) {
			$str = ($i-1)."-".($i);
			$cursos[$str] = $str;
		}
		
		return $cursos;
		
	}
	
	
	/**
	 * Returns the available values for 'evaluaciones'
	 * @return multitype:string
	 */
	private function loadValores() {
		
		$valores = array(''=>'', 'A'=>'A', 'B'=>'B', 'C'=>'C');
		return $valores;
		
	}
	
	
	/**
	 * Performs the data validation
	 */
	private function validate() {
	
		$this->form_validation->set_rules('curso', 'Curso', 'required');
		$this->form_validation->set_rules('ciclo', 'Ciclo', 'required');
		$this->form_validation->set_rules('eval_ini', 'Eval. Inicial', 'required');
	
		$this->form_validation->set_error_delimiters('', '');
	
		return $this->form_validation->run();
	}
	
}
?>

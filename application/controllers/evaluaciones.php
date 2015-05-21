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
		$this->show($empresaId, NULL, $mode);
	}
	
	
	/**
	 * Show 'evaluaciones' from a empresa and set the mode
	 * @param unknown $mode
	 */
	private function show($empresaId, $id, $mode) {
		
		$data = $this->loadEmpresa($empresaId);
		$data['modo'] = $mode;
		
		//Seleccionar evaluación
		if ($mode == self::MODE_CREATE) {
			//En creacion, cargar datos por defecto
			$data['evaluacion'] = $this->loadDefaultEvaluacion($empresaId);
		} else if ($mode == self::MODE_UPDATE) {
			//En edición, seleccionar la evaluación
			$data['evaluacion'] = $this->loadEvaluacion($id);
		}		
		
		//Show the page
		if ($mode == self::MODE_CREATE || $mode == self::MODE_UPDATE) {
			//Crear lista de ciclos
			$data['cicloslist'] = $this->empm->listCiclos();
			
			//Crear lista de cursos
			$data['cursoslist'] = $this->loadCursos();
			
			//Lista de valores para la evaluación
			$data['valoreslist'] = $this->loadValores();
			
			//Ir a la página de formulario
			$this->load->view(self::PAGE_SHEET, $data);
			
		} else {
			//Volver a la misma página
			$this->load->view(self::PAGE_SELF, $data);
		}
	}
	
	
	/**
	 * Shows the 'evaluaciones' sheet to create one
	 */
	public function arise() {
		$empresaId = $this->uri->segment(3);
		$mode = self::MODE_CREATE;
		$this->show($empresaId, NULL, $mode);
	}
	
	
	private function migrate() {
		$empresalist = $this->empm->listEmpresasByOldEval();
		
		foreach ($empresalist as $e) {
			
			$data = array(
				"id" => NULL,
				"idEmpresa" => $e->id,
				"ciclo" => $e->familia,
				"curso" => $e->curs,
				"eval_ini" => $e->evalua_anterior,
				"eval_fin" => $e->evaluacio,
				"observaciones" => "Migrado"
			);
			
			$res = $this->evalm->create($data);
			
		}
		
		$this->index();
	}	
	
	
	/**
	 * Edit the 'evaluaciones' data shown
	 */
	public function edit() {
		$empresaId = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		$mode = self::MODE_UPDATE;
		$this->show($empresaId, $id, $mode);
	}
	
	
	/**
	 * Create a new 'evaluacion' record into the database
	 */
	public function create() {
		$this->save(self::MODE_CREATE);
	}
	
	
	/**
	 * Update the 'evaluacion' data into the database
	 */
	public function update() {
		$this->save(self::MODE_UPDATE);
	}	
		
	
	/**
	 * Updates the data
	 */
	private function save($mode) {
		
		//Build array for the model
		$userdata = $this->input->post();
		
		$empresaId = $userdata['empresaId'];
		$id = $userdata['id'];
		
		unset($userdata['empresaId']);
		unset($userdata['nombreEmpresa']);
		
		$userdata['idEmpresa'] = $empresaId;
		
		//Validate the data
		if ($this->validate() == FALSE) {
			//Return to the same page with errors
			$this->show($empresaId, $id, $mode);
		} else {
			//Save the data
			if ($mode == self::MODE_CREATE) {
				$res = $this->evalm->create($userdata);
			} else if ($mode == self::MODE_UPDATE) {
				$res = $this->evalm->update($userdata);
			}			
			$this->show($empresaId, NULL, self::MODE_READ);
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
		//$data['nombreEmpresa'] = addslashes($empresa['empresa']);
		$data['nombreEmpresa'] = $empresa['empresa'];
		$data['empresa'] = $empresa;
		
		//Obtain the different evaluaciones
		$data['evalualist'] = $this->evalm->listEvaluaByEmpresa($empresaId);
		
		return $data;
	}
	
	
	/**
	 * Loads the 'evaluacion' data given its $id
	 * @param unknown $id the 'evaluacion' id
	 */
	private function loadEvaluacion($id) {
		$evaluacion = $this->evalm->getEvaluacionById($id);
		return $evaluacion;
	}
	
	
	private function loadDefaultEvaluacion($empresaId) {
		//Seleccionar curso actual
		$year = date ("Y");
		$cursosel = ($year-1)."-".$year;
		//Rellenar array con valores
		$evaluacion = array(
				'id'=>NULL,
				'idEmpresa'=>$empresaId,
				'curso'=>$cursosel, 
				'ciclo'=>'',
				'eval_ini'=>'',
				'eval_fin'=>'',
				'observaciones'=>''
		);
		return $evaluacion;
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
	
	
	/**
	 * Deletes some 'evaluacion'
	 */
	public function delete() {
		
		$empresaId = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		
		$this->evalm->delete($id);
		
		$mode = self::MODE_READ;
		$this->show($empresaId, NULL, $mode);
		
	}
	
}
?>

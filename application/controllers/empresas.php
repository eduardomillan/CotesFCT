<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas extends CI_Controller {
	
	const HTML_FILENAME = "listado.html";
	
	const MODE_CREATE = "create";
	const MODE_READ = "read";
	const MODE_UPDATE = "update";
	
	const PAGE_PDF_SIMPLE = "pdf/empresas_simple";
	const PAGE_PDF_ADVANCED = "pdf/empresas_advanced";
	const PAGE_SELF = "empresas";
	const PAGE_SHEET = "empresa_sheet";
	const PAGE_UPDATE = "empresa_update";
	const PAGE_ROWS = 20;
	
	const PDF_FILENAME = "listado.pdf";
	
	const SEARCH_SIMPLE = "searchSimple";
	const SEARCH_ADVANCED = "searchAdvanced";

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		/*$this->load->library('console');
		$this->output->enable_profiler(TRUE);*/
		$this->load->model('empresamodel','empm');
		$this->load->model('evaluamodel','evalm');
		
	}
	
	/**
	 * Default view
	 */
	public function index()
	{
		$searchtype = $this->session->userdata('searchtype');
		
		if ($searchtype == self::SEARCH_ADVANCED) {
			$this->advancedSearch();
		} else {
			$this->search();
		}
	}
	
	
	/**
	 * Search on 'empresas' table
	 */
	public function search() {
		
		$data['empresaslist'] = NULL;
		$data['total'] = -1;
		$data['advancedsearch'] = NULL;
		
		//Post fields
		if (empty($_POST)) {
			$searchtext = $this->session->userdata('searchtext');
			$searchall = $this->session->userdata('searchall');
			$searchconcert = $this->session->userdata('searchconcert');
		} else {
			$searchtext = $this->input->post('searchtext');
			$searchconcert = $this->input->post('searchconcert');
			$searchall = (isset($_POST['searchall']) ? "checked" : "");
		}
		
		
		//Do search
		if (!strlen($searchtext) && !is_numeric($searchconcert) && empty($searchall)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/search"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
					
			//Búsqueda
			$param['searchtext'] = $searchtext;
			$param['concert'] = $searchconcert;
			
			if (empty($searchall)) {
				$results = $this->empm->listEmpresasBySimple($param);
			} else {
				$results = $this->empm->listEmpresasAll();
			}
			
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
		$data['searchconcert'] = $searchconcert;
		$data['searchall'] = $searchall;
		$this->session->set_userdata('searchtype', self::SEARCH_SIMPLE);
		$this->session->set_userdata('searchtext', $searchtext);
		$this->session->set_userdata('searchconcert', $searchconcert);
		$this->session->set_userdata('searchall', $searchall);
		
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
			$searchconcert = $this->session->userdata('searchconcert');
			$searchfamilia = $this->session->userdata('searchfamilia');
			$searchciclo = $this->session->userdata('searchciclo');
			$searchcurso = $this->session->userdata('searchcurso');
		} else {
			$searchtext = $this->input->post('searchtext');
			$searchconcert = $this->input->post('searchconcert');
			$searchfamilia = $this->input->post('searchfamilia');
			$searchciclo = $this->input->post('searchciclo');
			$searchcurso = $this->input->post('searchcurso');
		}
		
		//Familias
		$data['familiaslist'] = $this->empm->listFamilias();
		
		//Ciclos
		$data['cicloslist'] = $this->empm->listCiclos();
		
		//Cursos
		$data['cursoslist'] = $this->empm->loadCursos();
		
		if (!strlen($searchtext) && !strlen($searchfamilia) && !strlen($searchciclo) && !strlen($searchcurso)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/advancedSearch"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
				
			//Búsqueda
			$param['searchtext'] = $searchtext;
			$param['concert'] = $searchconcert;
			$param['familia'] = $searchfamilia;
			$param['ciclo'] = $searchciclo;
			$param['curso'] = $searchcurso;

			$results = $this->empm->listEmpresasByEval($param);
				
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
		$data['searchconcert'] = $searchconcert;
		$data['searchfamilia'] = $searchfamilia;
		$data['searchciclo'] = $searchciclo;
		$data['searchcurso'] = $searchcurso;
		
		$this->session->set_userdata('searchtype', self::SEARCH_ADVANCED);
		$this->session->set_userdata('searchtext', $searchtext);
		$this->session->set_userdata('searchconcert', $searchconcert);
		$this->session->set_userdata('searchfamilia', $searchfamilia);
		$this->session->set_userdata('searchciclo', $searchciclo);
		$this->session->set_userdata('searchcurso', $searchcurso);
		
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
			$nombreEmpresa = "Empresa";
			$empresa = array();
		} else {
			$empresaId = $id;
			$empresa = $this->empm->getEmpresaByIdOrCIF($empresaId);
			$nombreEmpresa = addslashes($empresa['empresa']);
		}
		
		$data['empresaId'] = $empresaId;
		$data['nombreEmpresa'] = $nombreEmpresa;
		$data['empresa'] = $empresa;
		$data['modo'] = $mode;		
		
		//Familias (deprecated)
		$data['familiaslist'] = NULL;
		
		//Evaluaciones
		$data['evalualist'] = $this->evalm->listEvaluaByEmpresa($empresaId);
		
		//Evaluaciones message
		$evalinfo = "";
		$evals = $data['evalualist'];
		if (empty($evals)) {
			$evalinfo = "No hay registrada ninguna evaluación para esta empresa.";
		} else {
			$evalinfo = "Última evaluación realizada el curso ".$evals[0]->curso
					." para el ciclo ".$evals[0]->ciclo
					." con eval. inicial ".$evals[0]->eval_ini;
			
			if (!empty($evals[0]->eval_fin)) {
				$evalinfo = $evalinfo." y eval. final ".$evals[0]->eval_fin;
			}
		}
		$data['evalinfo'] = $evalinfo;
		
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
	 * Deletes all the 'empresa' data
	 */
	public function delete() {
		
		$empresaId = $this->uri->segment(3);
		$this->empm->delete($empresaId);
		$this->index();
		
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
			$empresaId = $userdata['empresaId'];
			$data['empresaId'] = $empresaId;
			$data['empresa'] = $userdata;
			$data['modo'] = $mode;
			$data['nombreEmpresa'] = $userdata['nombreEmpresa'];
			
			//Familias
			$data['familiaslist'] = NULL;
			$data['updateResult'] = "notValid";
			
			$this->load->view(self::PAGE_SHEET, $data);
			
		} else {// passed validation proceed to post success logic
			
			$data['updateResult'] = "";
			unset($userdata['empresaId']);
			unset($userdata['nombreEmpresa']);
				
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
	
	/**
	 * Obtains the PDF version from the list
	 */
	public function getpdf() {
		$this->getByTCPDF();		
	}
	

	/**
	 * Obtains the PDF list using the TCPDF library
	 */	
	private function getByTCPDF() {

		set_time_limit(600);
		
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
		/*
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('IES Cotes Baixes');
      */
      $pdf->SetTitle('FCT - IES Cotes Baixes');
      $pdf->SetSubject('Empresas');
      $pdf->SetKeywords('PDF, empresas, listado');
      
      // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
      $pdf->SetHeaderData('', 0, 'FCT - IES Cotes Baixes', '', array(0, 64, 255), array(255,255,255));
      $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
      
      // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', '18'));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      
      // se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetMargins('12', '20', '8'); //left, top, right
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);      
      
      // se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 

		// establecer el modo de fuente por defecto
      $pdf->setFontSubsetting(false);
 
		// Establecer el tipo de letra
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
      $pdf->SetFont('helvetica', '', 10, '', true);
 
		// set cell padding
		$pdf->setCellPaddings(1, 1, 1, 1);

		// set cell margins
		$pdf->setCellMargins(0, 0, 0, 0); 
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
      $pdf->AddPage();
 
 		
		// Establecemos el contenido para imprimir
		$results = $this->listResultsBySessionInfo();
      
      //preparamos el contenido a crear
      $data['empresaslist'] = $results;

      
	   // Obtenemos la vista y cargamos el HTML
	   $viewpdf = $this->selectPdfView();
	   
	   // Contenido HTML
      $html = $this->load->view($viewpdf, $data, TRUE);
      
		// Imprimimos el texto con writeHTMLCell()
      $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
      

		// Cerrar el documento PDF y preparamos la salida
      $nombre_archivo = self::PDF_FILENAME;
      $pdf->Output($nombre_archivo, 'I'); //I: Interactive, D: Force download
      
	}	
	
	/**
	 * Select which PDF view to use for PDF generation
	 */
	private function selectPdfView() {
		$searchtype = $this->session->userdata('searchtype');
		
		if ($searchtype == self::SEARCH_ADVANCED) {
			return self::PAGE_PDF_ADVANCED;
		} else {
			return self::PAGE_PDF_SIMPLE;
		}
	}
	
	
	/*
	 * Obtains the results depending on the session parameters
	 */	
	private function listResultsBySessionInfo() {
		
		$results = NULL;
		$searchtype = $this->session->userdata('searchtype');
		$searchtext = $this->session->userdata('searchtext');
		$searchconcert = $this->session->userdata('searchconcert');

		$param['searchtext'] = $searchtext;
		$param['concert'] = $searchconcert;
		
		if ($searchtype == self::SEARCH_ADVANCED) {
			//BÚSQUEDA AVANZADA
			
			$searchfamilia = $this->session->userdata('searchfamilia');
			$searchciclo = $this->session->userdata('searchciclo');
			$searchcurso = $this->session->userdata('searchcurso');
			
			$param['familia'] = $searchfamilia;
			$param['ciclo'] = $searchciclo;
			$param['curso'] = $searchcurso;

			$results = $this->empm->listEmpresasByEval($param);
			
		} else {
			//BÚSQUEDA SIMPLE
			
			//Obtenemos los datos para el listado
			$searchall = $this->session->userdata('searchall');
		
			//Búsqueda
			if (empty($searchall)) {
				$results = $this->empm->listEmpresasBySimple($param);
			} else {
				$results = $this->empm->listEmpresasAll();
			}		
		}
		
		return $results;
		
	}
	
	/**
	 * Removes not desired characters from any NIF
	 */
	private function fixnifs() {
		$results = $this->empm->listEmpresasAll();
		foreach ($results as $item) {
			
		}
		
	}
	

}?>
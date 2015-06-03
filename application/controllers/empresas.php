<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas extends CI_Controller {
	
	const HTML_FILENAME = "listado.html";
	
	const MODE_CREATE = "create";
	const MODE_READ = "read";
	const MODE_UPDATE = "update";
	
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
		} else {
			$searchtext = $this->input->post('searchtext');
			$searchall = (isset($_POST['searchall']) ? "checked" : "");
		}
		
		
		//Do search
		if (!strlen($searchtext) && empty($searchall)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/search"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
					
			//Búsqueda			
			if (empty($searchall)) {
				$results = $this->empm->listEmpresasByText($searchtext);
			} else {
				$results = $this->empm->listEmpresasAll($searchtext);
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
		$data['searchall'] = $searchall;
		$this->session->set_userdata('searchtype', self::SEARCH_SIMPLE);
		$this->session->set_userdata('searchtext', $searchtext);
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
			$searchfamilia = $this->session->userdata('searchfamilia');
			$searchciclo = $this->session->userdata('searchciclo');
			$searchconcert = $this->session->userdata('searchconcert');
		} else {
			$searchtext = $this->input->post('searchtext');
			$searchfamilia = $this->input->post('searchfamilia');
			$searchciclo = $this->input->post('searchciclo');
			$searchconcert = $this->input->post('searchconcert');
		}
		
		//Familias
		$data['familiaslist'] = $this->empm->listFamilias();
		
		//Ciclos
		$data['cicloslist'] = $this->empm->listCiclos();
		
		if (!strlen($searchtext) && !strlen($searchfamilia) && !strlen($searchciclo) && !strlen($searchconcert)) {
			//Do nothing
		} else {
			//Configuración de la paginación
			$config['base_url'] = site_url("empresas/advancedSearch"); //establecemos la URL para las paginas
			$config['per_page'] = self::PAGE_ROWS; //cantidad de filas a mostrar por pagina
			$config['first_link'] = '|<';
			$config['last_link'] = '>|';
				
			//Búsqueda
			$param['searchtext'] = $searchtext;
			$param['familia'] = $searchfamilia;
			$param['ciclo'] = $searchciclo;
			$param['concert'] = $searchconcert;

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
		$data['searchfamilia'] = $searchfamilia;
		$data['searchciclo'] = $searchciclo;
		$data['searchconcert'] = $searchconcert;
		
		$this->session->set_userdata('searchtype', self::SEARCH_ADVANCED);
		$this->session->set_userdata('searchtext', $searchtext);
		$this->session->set_userdata('searchfamilia', $searchfamilia);
		$this->session->set_userdata('searchciclo', $searchciclo);
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
		
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('IES Cotes Baixes');
      $pdf->SetTitle('Listado de empresas');
      $pdf->SetSubject('Empresas');
      $pdf->SetKeywords('PDF, empresas, listado');
      
      // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
      //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
      $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
      
      // datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      
      // se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);      
      
      // se pueden modificar en el archivo tcpdf_config.php de libraries/config
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
		//relación utilizada para ajustar la conversión de los píxeles
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
      $pdf->setFontSubsetting(true);
 
		// Establecer el tipo de letra
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
      $pdf->SetFont('freemono', '', 14, '', true);
 
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
      $pdf->AddPage();
 
		//fijar efecto de sombra en el texto
      $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
 
		// Establecemos el contenido para imprimir
		$results = $this->listResultsBySessionInfo();
      
      //preparamos y maquetamos el contenido a crear
      $html = '';
      $html .= "<style type=text/css>";
      $html .= "th{color: #fff; font-weight: bold; background-color: #222}";
      $html .= "td{background-color: #AAC7E3; color: #fff}";
      $html .= "</style>";
      $html .= "<h2>Empresas</h2><h4>Total: ".count($results)."</h4>";
      $html .= "<table width='100%'>";
      $html .= "<tr><th>Nº</th><th>Empresa</th></tr>";
        
      //provincias es la respuesta de la función getProvinciasSeleccionadas($provincia) del modelo
      $num = 0;
      foreach ($results as $item)
      {
			$num++;
         $html .= "<tr><td class='id'>" . $num . "</td><td class='empresa'>" . $item->empresa . "</td></tr>";
      }
      $html .= "</table>";
 
		// Imprimimos el texto con writeHTMLCell()
      $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
 
		// ---------------------------------------------------------
		// Cerrar el documento PDF y preparamos la salida
		// Este método tiene varias opciones, consulte la documentación para más información.
      $nombre_archivo = utf8_decode("listado.pdf");
      $pdf->Output($nombre_archivo, 'D');
      
	}	
	
	
	/**
	 * Obtains the PDF using the DomPDF library
	 */
	private function getByDomPDF() {
		
		//establecemos la carpeta en la que queremos guardar los pdfs,
		//si no existen las creamos y damos permisos
		$this->createDomPDFFolder();
		
		//importante el slash del final o no funcionará correctamente
		$this->html2pdf->folder('./files/pdfs/');
		
		//establecemos el nombre del archivo
		$this->html2pdf->filename(self::PDF_FILENAME);
		
		//establecemos el tipo de papel
		$this->html2pdf->paper('a4', 'portrait');
		
		//Obtenemos los datos para el listado
		$searchtext = $this->session->userdata('searchtext');
		$searchall = $this->session->userdata('searchall');
		
		//Búsqueda
		$results = $this->listResultsBySessionInfo();
		$data['empresaslist'] = $results;
		
		//hacemos que coja la vista como datos a imprimir
		//importante utf8_decode para mostrar bien las tildes, ñ y demás
		$this->html2pdf->html($this->load->view('pdf/empresas_simple', $data, TRUE));
		$this->html2pdf->create();
		
	}
	
	
	/*
	 * Obtains the results depending on the session parameters
	 */	
	private function listResultsBySessionInfo() {
		
		$results = NULL;
		$searchtype = $this->session->userdata('searchtype');
		
		if ($searchtype == self::SEARCH_ADVANCED) {
			//BÚSQUEDA AVANZADA
			
			$searchtext = $this->session->userdata('searchtext');
			$searchfamilia = $this->session->userdata('searchfamilia');
			$searchciclo = $this->session->userdata('searchciclo');
			$searchconcert = $this->session->userdata('searchconcert');
			
			$param['searchtext'] = $searchtext;
			$param['familia'] = $searchfamilia;
			$param['ciclo'] = $searchciclo;
			$param['concert'] = $searchconcert;

			$results = $this->empm->listEmpresasByEval($param);
			
		} else {
			//BÚSQUEDA SIMPLE
			
			//Obtenemos los datos para el listado
			$searchtext = $this->session->userdata('searchtext');
			$searchall = $this->session->userdata('searchall');
		
			//Búsqueda
			if (empty($searchall)) {
				$results = $this->empm->listEmpresasByText($searchtext);
			} else {
				$results = $this->empm->listEmpresasAll($searchtext);
			}		
		}
		
		return $results;
		
	}
	
	/**
	 * Creates the PDF folder needed
	 */
	private function createDomPDFFolder() {
		if(!is_dir("./files"))
		{
			mkdir("./files", 0777);
			mkdir("./files/pdfs", 0777);
		}
	}
}?>
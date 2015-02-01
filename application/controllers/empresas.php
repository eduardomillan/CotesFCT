<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Empresas extends CI_Controller {
	
	const SELF_PAGE = "empresas";
	const SITE_URI = "empresas/search";
	const PAGE_ROWS = 25;


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
		$this->load->view(self::SELF_PAGE);
	}
	
	
	/**
	 * Search on 'empresas' table
	 */
	public function search() {
		
		$this->load->model('empresamodel','empm');
		
		$data['searchtext'] = "";
		$data['empresaslist'] = NULL;
		$data['total'] = 0;
		
		$searchtext = $this->input->post('searchtext');
		if (empty($searchtext)) $searchtext = $this->session->userdata('searchtext');
		
		if (empty($searchtext)) {
			//Do nothing
		} else {
			//$this->session->set_userdata('searchtext', $searchtext);
			$data['searchtext'] = $searchtext;
			//Configuración de la paginación
			$config['base_url'] = site_url(self::SITE_URI); //establecemos la URL para las paginas
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
		
		$this->session->set_userdata('searchtext', $searchtext);
		$this->load->view(self::SELF_PAGE, $data);
	}
}
?>

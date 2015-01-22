<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	const WELCOME_PAGE = "welcome_message";
	const LOGIN_PAGE = "login";
	
	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
	}

	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/login
	 *	- or -  
	 * 		http://example.com/index.php/login/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/login/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if ($this->isUserSession() == TRUE) {
			$this->load->view(self::WELCOME_PAGE);
		} else {
			$this->load->view(self::LOGIN_PAGE);
		}
	}
	
	/**
	 * Login action
	 */
	public function doLogin() {
		
		$this->load->model('usuariomodel','usm');
		
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$user = NULL;
		
		if (!empty($username) && !empty($password)) {
			$user = $this->usm->validateUser($username,$password);
		}
		
		if (!empty($user)) {
			$this->session->set_userdata('user', $user->nombre);
			$this->session->set_userdata('nivel', $user->nivel);
			$this->load->view(self::WELCOME_PAGE);
		} else {
			$this->load->view(self::LOGIN_PAGE);
		} 
	}
	
	/**
	 * Debug the login page
	 */
	public function debugLogin() {
		$this->load->view(self::LOGIN_PAGE);
	}
	
	/**
	 * Close the session
	 */
	public function logout() {
		$this->session->sess_destroy();
		$this->load->view(self::LOGIN_PAGE);
	}
	
	
	/**
	 * Checks if there is a user session yet
	 * @return boolean
	 */
	private function isUserSession() {
		return $this->session->userdata('user');
	}
}

<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed'); 

/**
 * Home class to perform hooks operations
 * @author lliurex
 *
 */
class Home
{
	private $ci;
	public function __construct()
	{
		$this->ci =& get_instance();
		!$this->ci->load->library('session') ? $this->ci->load->library('session') : false;
		!$this->ci->load->helper('url') ? $this->ci->load->helper('url') : false;
	}	

	/**
	 * Verify that a user is "in"
	 */
	public function checkLogin() {
		$uris = $this->ci->uri->segment(1);
		if (!empty($uris) && $uris != 'login') {
			if($this->ci->session->userdata('user') == FALSE) {
				redirect(base_url());
			}
		}
	}
}
/*
/end hooks/home.php
*/
?>
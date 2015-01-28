<?php

/**
 * Database users
 * @author emillan
 *
 */
class UsuarioModel extends CI_Model {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Validate the username and password against the database
	 *
	 * @param unknown $username
	 * @param unknown $password
	 */
	public function validateUser($username,$password) {
		
		$this->db->from('usuarios'); 
		$this->db->where('nombre',$username); 
		$this->db->where( 'pass', $password); 
		$res = $this->db->get()->result();
		if ( is_array($res) && count($res) == 1) {
			return $res[0];
		} else {
			return NULL;
		}
	}

}

?>
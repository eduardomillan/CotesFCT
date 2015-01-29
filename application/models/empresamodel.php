<?php

/**
 * Database companies
 * @author emillan
 *
 */
class EmpresaModel extends CI_Model {

	const EMPRESA_TABLE = "CDE_empresas_BACK2";
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * Obtains a list of 'empresas' given a search text
	 * @param unknown $text
	 */
	function listEmpresasByText($text) {
		$param = strtolower($text); //To lowercase and then use it in the search
		
		$this->db->from(self::EMPRESA_TABLE);
		$this->db->like('lower(empresa)', $param);
		$this->db->or_like('lower(ciutat)', $param);
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
}
?>
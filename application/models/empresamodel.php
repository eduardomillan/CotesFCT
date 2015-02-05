<?php

/**
 * Database companies
 * @author emillan
 *
 */
class EmpresaModel extends CI_Model {

	const EMPRESA_TABLE = "CDE_empresas_BACK2";
	const FAMILIA_TABLE = "CDE_familias";
	
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
		$this->db->or_like('lower(responsable)', $param);
		$this->db->or_like('lower(cif)', $param);
		$this->db->order_by('empresa');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Obtains a list of 'empresas' given a search text and some extra data
	 * @param unknown $searchtext the text to search
	 * @param unknown $data some extra data
	 */
	function listEmpresasByAdvanced($searchtext, $data) {
		$param = strtolower($searchtext); //To lowercase and then use it in the search
		$familia = $data['familia'];
		$concert = $data['concert'];
		
		$this->db->from(self::EMPRESA_TABLE);
		
		$this->db->where('id >', 0);

		if (strlen($param)) {
			$this->db->where("(lower(empresa) like '%$param%'", NULL, FALSE);
			$this->db->or_where("lower(responsable) like '%$param%'", NULL, FALSE);
			$this->db->or_where("lower(ciutat) like '%$param%'", NULL, FALSE);
			$this->db->or_where("lower(cif) like '%$param%')", NULL, FALSE);
		}

		if (strlen($familia)) $this->db->where("familia", $familia);
		if (strlen($concert)) $this->db->where("concert", $concert);
		
		$this->db->order_by('familia,empresa');
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Obtains a list of 'familias' frm the database
	 * @return unknown|NULL
	 */
	function listFamilias() {
		$this->db->from(self::FAMILIA_TABLE);
		$this->db->order_by('nombre');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	/**
	* Obtains the 'empresa' row given its id or CIF
	* @param param
	* 
	*/
	function getEmpresaByIdOrCIF($param) {
		if (strlen($param)) {
			$this->db->from(self::EMPRESA_TABLE);
			$this->db->where("id", $param);
			$this->db->or_where("cif", $param);
			$res = $this->db->get()->row();
			return $res;
		} else {
			return NULL;
		}
	}
}
?>
<?php

/**
 * Companies evaluations
* @author emillan
*
*/
class EvaluaModel extends CI_Model {

	const TABLE_EVALUA = "CDE_evaluaciones";
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * Obtains the different evaluations from a company, given its 'id'
	 * @param unknown $empresaId
	 */
	public function listEvaluaByEmpresa($empresaId) {
		
		$this->db->from(self::TABLE_EVALUA);
		
		$this->db->where("idEmpresa", $empresaId);
		$this->db->order_by("curso", "desc");
		$this->db->order_by("evaluacion", "asc");
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
		
	}
	
	/**
	 * Creates the 'empresa' record in the database
	 * @param unknown $data
	 * @return boolean
	 */
	function create($data) {
		return $this->db->insert(self::TABLE_EVALUA, $data);
	}
	
}
?>
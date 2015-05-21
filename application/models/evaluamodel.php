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
		$this->db->order_by("eval_ini", "asc");
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
		
		
	/**
	 * Obtains the 'evaluacion' row array given its id
	 * @param unknown $param
	 * @return unknown|NULL
	 */
	function getEvaluacionById($id) {
		if (strlen($id)) {
			$this->db->from(self::TABLE_EVALUA);
			$this->db->where("id", $id);
			$res = $this->db->get()->row_array();
			return $res;
		} else {
			return NULL;
		}
	}		
	
	/**
	 * Creates the 'evaluacion' record in the database
	 * @param unknown $data
	 * @return boolean
	 */
	function create($data) {
		return $this->db->insert(self::TABLE_EVALUA, $data);
	}
	

	/**
	 * Updates the 'evaluacion' record in the database
	 * @param unknown $id the 'empresa' id
	 * @param unknown $data the rest of the data
	 */
	function update($data) {
		$id = $data['id'];
		unset($data['id']);
	
		$this->db->where('id', $id);
		return $this->db->update(self::TABLE_EVALUA, $data);
	}	
	
	
	/**
	 * Deletes some 'evaluacion'
	 * @param unknown $id
	 */
	function delete($id) {
		
		$this->db->where('id', $id);
		$this->db->delete(self::TABLE_EVALUA);
	}
	
	
}
?>
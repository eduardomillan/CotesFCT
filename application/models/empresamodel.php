<?php

/**
 * Database companies
 * @author emillan
 *
 */
class EmpresaModel extends CI_Model {


	const RANGE_CURSOS = 15;
	
	const TABLE_EMPRESA = "CDE_empresas";
	const TABLE_FAMILIA = "CDE_famprofesional";
	const TABLE_CICLO = "CDE_cicleform";
	const TABLE_EVALUA = "CDE_evaluaciones";
	
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
	function listEmpresasBySimple($param) {
		$stext = mysql_real_escape_string(strtolower($param['searchtext'])); //To lowercase and then use it in the search
		$concert = $param['concert'];
		
		$this->db->from(self::TABLE_EMPRESA);
		if (strlen($stext)) {
			$this->db->where("(lower(empresa) like '%$stext%'", NULL, TRUE);
			$this->db->or_where("lower(responsable) like '%$stext%'", NULL, TRUE);
			$this->db->or_where("lower(ciutat) like '%$stext%'", NULL, TRUE);
			$this->db->or_where("lower(cif) like '%$stext%')", NULL, TRUE);
		}
		if (is_numeric($concert)) $this->db->where("concert", $concert);
		
		$this->db->order_by('empresa');

		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	/**
	 * Obtains the whole list of 'empresas'
	 */
	function listEmpresasAll() {
		$this->db->from(self::TABLE_EMPRESA);
		$this->db->order_by('empresa');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
		
	
	/**
	 * @deprecated Use only to fix data
	 * Function that returns old rows with old evaluation data
	 */
	function listEmpresasByOldEval() {
		
		$this->db->from(self::TABLE_EMPRESA);

		$this->db->where("familia <> '' and evaluacio <>'' and curs <>''");
		$this->db->order_by("empresa");
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}		
	}	
	
	
	/**
	 * Obtains the list of empresas which have been evaluated and links that evaluation record
	 * @param unknown $data
	 */
	function listEmpresasByEval($data) {
		$stext = $data['searchtext'];
		$familia = $data['familia'];
		$ciclo = $data['ciclo'];
		$curso = $data['curso'];
		$concert = $data['concert'];
		
		$tbEmpresa = self::TABLE_EMPRESA;
		$tbEval = self::TABLE_EVALUA;
		$tbFamilia = self::TABLE_FAMILIA;
		$tbCiclo = self::TABLE_CICLO;
		
		$this->db->select(
				"$tbEmpresa.id,$tbEmpresa.empresa,$tbEmpresa.responsable,$tbEmpresa.ciutat,
				$tbEmpresa.cif,$tbEmpresa.telf,$tbEmpresa.email,$tbEmpresa.concert,
				$tbFamilia.codi as familia,$tbEval.ciclo,$tbEval.curso,$tbEval.eval_ini,$tbEval.eval_fin"
				);
		
		$this->db->distinct();
		$this->db->from($tbEmpresa);
		
		$this->db->join($tbEval, "$tbEmpresa.id = $tbEval.idEmpresa", "inner");
		$this->db->join($tbCiclo, "$tbEval.ciclo = $tbCiclo.codi", "inner");
		$this->db->join($tbFamilia, "$tbCiclo.idf = $tbFamilia.id", "inner");
		
		$this->db->where("$tbEmpresa.id >", 0);
		
		if (strlen($stext)) {
			$this->db->where("(lower(empresa) like '%$stext%'", NULL, FALSE);
			$this->db->or_where("lower(responsable) like '%$stext%'", NULL, FALSE);
			$this->db->or_where("lower(ciutat) like '%$stext%'", NULL, FALSE);
			$this->db->or_where("lower(cif) like '%$stext%')", NULL, FALSE);
		}
		
		if (is_numeric($concert)) $this->db->where("$tbEmpresa.concert", $concert);
		if (strlen($familia)) $this->db->where("$tbFamilia.codi", $familia);
		if (strlen($ciclo)) $this->db->where("$tbCiclo.codi", $ciclo);
		if (strlen($curso)) $this->db->where("$tbEval.curso", $curso);
		
		
		$this->db->order_by("familia,ciclo,curso desc,eval_fin,eval_ini,empresa");
		
		
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	
	/**
	 * Obtains a list of 'familias' from the database
	 * @return unknown|NULL
	 */
	function listFamilias() {
		$this->db->from(self::TABLE_FAMILIA);
		$this->db->order_by('codi');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	
	/**
	 * Obtains a list of 'ciclos' from the database (only LOE)
	 * @return unknown|NULL
	 */
	function listCiclos() {
		$this->db->from(self::TABLE_CICLO);
		//$this->db->where("tipo", "LOE");
		$this->db->order_by('codi');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}	
	

	/**
	 * Calculates the available "cursos" for the "evaluaciones"
	 */
	public function loadCursos() {
	
		$cursos = array();
		$year = date ("Y");
	
		for ($i = $year-self::RANGE_CURSOS; $i <= $year+1; $i++) {
			$str = ($i-1)."-".($i);
			$cursos[$str] = $str;
		}
	
		return $cursos;
	}
	
	/**
	 * Obtains a list of disctinct familias existing in the 'empresas' table
	 */
	function listFamiliasInEmpresas() {
		$this->db->select('familia as nombre');
		$this->db->distinct();
		$this->db->from(self::TABLE_EMPRESA);
		$this->db->order_by('nombre');
		$res = $this->db->get()->result();
		if (is_array($res) && count($res) >= 1) {
			return $res;
		} else {
			return NULL;
		}
	}
	
	
	
	/**
	* Obtains the 'empresa' row array given its id or CIF
	* @param param the id or CIF
	* 
	*/
	function getEmpresaByIdOrCIF($param) {
		if (strlen($param)) {
			$this->db->from(self::TABLE_EMPRESA);
			$this->db->where("id", $param);
			$this->db->or_where("cif", $param);
			$res = $this->db->get()->row_array();
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
		return $this->db->insert(self::TABLE_EMPRESA, $data);
	}
	
	/**
	 * Updates the 'empresa' record in the database
	 * @param unknown $data the rest of the data
	 */
	function update($data) {
		$id = $data['id'];
		unset($data['id']);
		
		$this->db->where('id', $id);
		return $this->db->update(self::TABLE_EMPRESA, $data);
	}
	
	
	/**
	 * Deletes the 'empresa' record and associated 'evaluaciones'
	 * @param unknown $id
	 */
	function delete($id) {
		
		//Delete the empresa record
		$this->db->where('id', $id);
		$this->db->delete(self::TABLE_EMPRESA);
		
		//Delete the evaluaciones records
		$this->db->where('idEmpresa', $id);
		$this->db->delete(self::TABLE_EVALUA);
		
	}
	
}
?>

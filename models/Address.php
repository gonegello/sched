<?php
require_once('Models.php');
class Address extends Models
{
	private static $instance = null;
    protected $db;
    private $table;
    public function __construct($table = 'refprovince')
	{
		require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = $table;
	}

	public function getWhere($where = '', $sortBy = 'provDesc ASC')
	{
		$sql = "SELECT * FROM $this->table ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";
        $rows = $this->db->select($sql);
        return $rows;
	}
}
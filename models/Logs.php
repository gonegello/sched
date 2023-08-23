<?php
require_once('Models.php');
class Logs extends Models {
    protected $db;
    private $table;
    public function __construct() {
		require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'logs';
	}

	public function getWhere($where = '', $sortBy = 'name ASC') {
		$sql = "SELECT * FROM $this->table WHERE 1 ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql);
        return $rows;
	}

	public function insertData($data) {
        $sql = "INSERT INTO $this->table (";
        $sql .= implode(",", array_keys($data)) . ') VALUES ';            
        $sql .= "('" . implode("','", array_values($data)) . "')";
		$this->db->exec($sql);
		return $this->db->lastInsertId($sql);
	}

    public function updateData($data, $where) {
        $set = [];
        foreach($data as $key => $value) {
            $set[] = "$key='$value'";
        }
        
        $sql = "UPDATE $this->table SET ". implode(', ', $set);
        $sql .= " WHERE $where";
		return $this->db->exec($sql);
	}

	public function delete($id) {
		$sql = "DELETE FROM $this->table WHERE id=" . $id;
		return $this->db->exec($sql);
	}

	public function getJoinWhere($where = '', $sortBy = 'l.id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT l.*, 
                (CASE WHEN (userid = 0) THEN 'Unknown' ELSE u.first_name END) AS first_name, 
                (CASE WHEN (userid = 0) THEN 'Unknown' ELSE u.last_name END) AS last_name 
                FROM logs l
                LEFT JOIN users u ON u.id = l.userid
                WHERE 1
                ";

        if(!empty($where)) {
            $sql .= " $where";
        }

        $sql .= " ORDER BY $sortBy ";

        if($enableLimit == 'Y') {
            $sql .= " LIMIT $startFrom, $pageNo";
        }

        $rows = $this->db->select($sql);
        return $rows;
	}

    public function getTotal($where = '', $sortBy = 'l.id DESC') {
        
		$sql = "SELECT COUNT(*) AS total_count
                FROM logs l
                LEFT JOIN users u ON u.id = l.userid
                WHERE 1 ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";
		$rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
	}

    public function getlogs($where = '', $sortBy = 'l.id ASC') {
		$sql = "SELECT l.*, 
        (CASE WHEN (userid = 0) THEN 'Uknown' ELSE u.first_name END) AS first_name, 
        (CASE WHEN (userid = 0) THEN 'Uknown' ELSE u.last_name END) AS last_name 
        FROM logs l
        LEFT JOIN users u ON u.id = l.userid
        WHERE 1 ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql, 'assoc');
        return $rows;
	}
}
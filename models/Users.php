<?php
require_once('Models.php');
class Users extends Models {
	private static $instance = null;
    protected $db;
    private $table;
    public function __construct() {
		require_once($this->getDocumentRoot() . '/inc/conn.php');
        $this->db = DB::getInstance();
        $this->table = 'users';
	}

	public function getWhere($where = '', $sortBy = 'username ASC') {
		$sql = "SELECT * FROM $this->table WHERE status != 'D'";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql);
        return $rows;
	}

	public function getUser($where = '', $sortBy = 'username ASC') {
		$sql = "SELECT * FROM $this->table WHERE status != 'D'";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";

        $rows = $this->db->select($sql,'assoc');
        return $rows;
	}

    public function getJoinWhere($where = '', $sortBy = 'first_name ASC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		// $db = DB::getInstance();
		$sql = "SELECT u.*, ur.name AS user_role_name, d.name AS department_name
                FROM $this->table u
				LEFT JOIN user_roles ur ON ur.id = u.user_role_id 
				LEFT JOIN departments d ON d.id = u.department_id
                WHERE u.status != 'D'
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

    public function getTotal($where = '', $sortBy = 'first_name ASC') {
        
		$sql = "SELECT COUNT(*) total_count
				FROM $this->table
				WHERE status != 'D' ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";
		$rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
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
}
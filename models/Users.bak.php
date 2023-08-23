<?php
require_once('Models.php');
class Users extends Models  
{
	private static $instance = null;

	public function __construct()
	{
		require_once($this->getDocumentRoot() . '/inc/conn.php');
	}

	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function listUsers()
	{
		$db = DB::getInstance();
		$rows = $db->select('SELECT * FROM `users`');
        return $rows;
	}

    /**
     * CheckUserEmail
     * 
     * @param   $emailAdd string 
     */

    public function checkUserEmail(string $emailAdd) : array
	{
		$db = DB::getInstance();
		$rows = $db->select('SELECT * FROM `users` WHERE email = \''. addSlashes($emailAdd) .'\' ');
        return $rows;
	}

    /**
     * checkUser
     * 
     * @param   $emailAdd string 
     * @param   $password string 
     */

    public function checkUser(string $userName, string $password) {
        $db = DB::getInstance();
        // $sql = 'SELECT * FROM `users` WHERE username = \''. addSlashes($userName) .'\' AND password = \''. addSlashes($password) .'\' ';
        $sql = "SELECT u.*, ur.name AS user_role_name, d.name AS department_name
                FROM users u 
                LEFT JOIN user_roles ur ON ur.id = u.user_role_id
				LEFT JOIN departments d ON d.id = u.department_id
                WHERE u.status = 'Y'
                AND u.username = '" . addSlashes($userName) . "'
                AND u.password = '" . addSlashes($password) . "'";
		$rows = $db->select($sql, 'assoc');
        return $rows;
	}

	public function addUser($emailAdd, $password, $firstName, $lastName)
	{
		$db = DB::getInstance();
		$sql = "INSERT INTO `users` 
                (`email`, `password`, `first_name`, `last_name`, `created_at`, `updated_at`) 
                    VALUES
                ('". $emailAdd . "','" . $password . "','" . $firstName . "','" . $lastName . "','" . date('Y-m-d H:i:s') . "','" . date('Y-m-d H:i:s')  . "')";
		$db->exec($sql);
		return $db->lastInsertId($sql);
	}

	public function deleteComment($id)
	{
		$db = DB::getInstance();
		$sql = "DELETE FROM `comment` WHERE `id`=" . $id;
		return $db->exec($sql);
	}

	public function getWhere($where = '', $sortBy = 'first_name ASC') {
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

        $setData = implode(', ', $set);        
        $sql = "UPDATE $this->table SET ". $setData;
        $sql .= " WHERE $where";
		return $this->db->exec($sql);
	}

	public function delete($id) {
		$sql = "DELETE FROM $this->table WHERE id=" . $id;
		return $this->db->exec($sql);
	}

	public function getJoinWhere($where = '', $sortBy = 'id DESC', $startFrom = 0, $pageNo = 20, $enableLimit = 'Y') {
		$sql = "SELECT *
                FROM $this->table
                WHERE status != 'D'
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

    public function getTotal($where = '', $sortBy = 'id DESC') {
        
		$sql = "SELECT COUNT(*) total_count
                FROM $this->table WHERE 1 ";
		
		if(!empty($where)) {
			$sql .= " $where";
		}

		$sql .= " ORDER BY $sortBy ";
		$rows = $this->db->select($sql, 'assoc');
        return $rows['total_count'];
	}
}
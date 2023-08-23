<?php

class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = 'mysql:dbname=sched;host=127.0.0.1';
		$user = 'root';
		$password = '';
		if(gethostname() == 'GONEGELLO') {
			$password = 'Godknowsme@1810039-2';
		}

		$this->pdo = new \PDO($dsn, $user, $password);
	}

	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function select($sql, $action = 'all')
	{
		$sth = $this->pdo->query($sql);
        
        if($action == 'assoc') {
            return $sth->fetch(PDO::FETCH_ASSOC);
        }

		return $sth->fetchAll();
	}

	public function exec($sql)
	{
		return $this->pdo->exec($sql);
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}
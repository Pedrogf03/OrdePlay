<?php

class Db {

	private $host;
	private $db;
	private $user;
	private $pass;
	public $connection;

	public function __construct(){

		$this->host = constant('DB_HOST');
		$this->db = constant('DB');
		$this->user = constant('DB_USER');
		$this->pass = constant('DB_PASS');

		$this->connection = new mysqli($this->host, $this->user, $this->pass, $this->db);

		if ($this->connection->connect_error) {
			die("Fallo en la conexión " . $this->connection->connect_error);
		}
	}
  
}
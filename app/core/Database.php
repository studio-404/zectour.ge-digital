<?php 
class Database
{
	public $HANDLER;
	public $output;

	public function __construct($class, $args = []){
		$require = 'app/database/' . $class . '.php';
		if(file_exists($require))
		{
			$conn = $this->conn();
			require_once $require;
			$requestedClass = new $class();
			$this->setter($requestedClass->index($conn, $args));
		}
	}

	public function conn(){
		try{
			$host = sprintf(
				'mysql:host=%s;dbname=%s;charset=utf8',
				Config::DB_HOST,
				Config::DB
			); 
			$this->HANDLER = new PDO($host, Config::DB_USER, Config::DB_PASS); 
			$this->HANDLER->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			$this->HANDLER->exec("set names utf8"); 
		}catch(PDOException $e){
			die("Sorry, Database connection problem.."); 
		}
		return $this->HANDLER; 
	}

	public function setter($output){
		$this->output = $output;
	}

	public function getter(){
		return $this->output;
	}

	
}
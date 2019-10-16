<?php

class Database {

	//Les informations de connexion sont privées
	private $host = "localhost";
    private $db_name = "sport_univ";
    private $username = "root";
    private $password = "";
    /*L'objet permettant d'accéder à la base est public
    pour permettre d'accéder directement à ses méthodes.*/
    public $conn;

    public function connect(){
    	$this->conn = null;

    	try {
    		$this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
    		$this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    	} catch(PDOException $e) {
    		echo "Erreur de connexion: " . $e->getMessage();
    	}

    	return $this->conn;
    }
 
}
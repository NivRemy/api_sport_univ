<?php
class University {
	public $_id;
	public $_name;
	public $_street;
	public $_city;
	public $_zipcode;
	public $_country;

	//Accès à la BDD
	private $_conn;

	public function __construct($bdd){
		$this->_conn = $bdd->connect();
	}

	public function get(){
		$request = $this->_conn->query('SELECT * FROM universities JOIN addresses ON addresses.id = universities.id_address');

		if($request->rowCount() <=0){
			return false;
		}else{
			while($university = $request->fetch(PDO::FETCH_ASSOC)){
				$this->_id = $university['id'];
				$this->_name = utf8_encode($university['university_name']);
				$this->_street = utf8_encode($university['street']);
				$this->_city = utf8_encode($university['city']);
				$this->_zipcode = utf8_encode($university['zipcode']);
				$this->_country = utf8_encode($university['country']);
				yield $this;
			}
		}

	}

	public function getOne(){
		//Requête qui récupère toutes les informations d'une université
		$request = $this->_conn->prepare('SELECT * FROM universities JOIN addresses ON addresses.id = universities.id_address WHERE universities.id = :id LIMIT 1');

		//Place dans la requête l'id de l'instance de l'objet université
		$request->bindParam(':id',$this->_id);

		$request->execute();


		if($request->rowCount() <=0){
			return false;
		}else {
			$university = $request->fetch(PDO::FETCH_ASSOC);
			//associe le résultat de la requête aux attribut de l'instance d'université
			$this->_name = utf8_encode($university['university_name']);
			$this->_street = utf8_encode($university['street']);
			$this->_city = utf8_encode($university['city']);
			$this->_zipcode = utf8_encode($university['zipcode']);
			$this->_country = utf8_encode($university['country']);
			return true;
		}
	}

	public function create(){
		//d'abord on insert l'adresse
		$sql = 'INSERT INTO addresses VALUES (NULL,:street,:zipcode,:city,:country)';

		$request = $this->_conn->prepare($sql);

		//Je remplace les variables par les éléments de la requête
		$request->bindValue(':street',htmlentities($this->_street));
		$request->bindValue(':zipcode',htmlentities($this->_zipcode));
		$request->bindValue(':city',htmlentities($this->_city));
		$request->bindValue(':country',htmlentities($this->_country));

		//J'insert mon adresse
		$request->execute();

		//Deuxième requête sql, la variable sql n'est plus utile, donc je peux la réutiliser.
		$sql = 'INSERT INTO universities VALUES (NULL,LAST_INSERT_ID(),:university_name)';

		$request = $this->_conn->prepare($sql);

		$request->bindValue(':university_name',htmlentities($this->_name));
		//J'insère mon université.
		if($request->execute()){
        	return true;
    	}
    	// Ecrire l'erreur si il y en a une
    	printf('Erreur:' . $request->error . '. \n');
    	return false;
	}
}
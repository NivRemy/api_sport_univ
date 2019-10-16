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


}
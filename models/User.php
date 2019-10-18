<?php
class User{
	//Mettre les attributs d'un utilisateurs
	public $_id;
	public $_user_type;
	public $_name;
	public $_last_name;
	public $_phone;
	public $_email;
	public $_login;
	public $_street;
	public $_city;
	public $_zipcode;
	public $_country;

	//Mettre un attribut BDD
	private $_conn;

	//Surcharger la méthode __construct pour qu'elle prennet une BDD
	public function __construct($bdd){
		$this->_conn = $bdd->connect();
	}

	//Créer la méthode getOne()
	public function getOne(){
		//Requête pour récupérer un utilisateur (avec les informations des tables associées)
		$sql = 
		'SELECT * FROM users as u
		 JOIN user_types as ut ON u.id_user_type = ut.id
		 JOIN addresses as a ON u.id_address = a.id
		 WHERE u.id = :id';

		 $request = $this->_conn->prepare($sql);

		 $request->bindParam(':id',$this->_id);

		 $request->execute();


		//On compte le nombre de résultat de la requête, et si il y en a au moins 1, on stock les valeurs.
		 if($request->rowCount() ==0){
			return false;
		}else{
			$user = $request->fetch(PDO::FETCH_ASSOC);

			$this->_user_type = utf8_encode($user['user_type']);
			$this->_name = utf8_encode($user['user_name']);
			$this->_last_name = utf8_encode($user['user_lastname']);
			$this->_phone = utf8_encode($user['user_phone']);
			$this->_email = utf8_encode($user['user_email']);
			$this->_login = utf8_encode($user['user_id_connection']);
			$this->_street = utf8_encode($user['street']);
			$this->_city = utf8_encode($user['city']);
			$this->_zipcode = utf8_encode($user['zipcode']);
			$this->_country = utf8_encode($user['country']);
			return true;
		}

	}

}
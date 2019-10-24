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
	public $_password;
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


	public function get(){
		$sql = ' SELECT * FROM users as u
		JOIN user_types as ut ON u.id_user_type = ut.id
		JOIN addresses as a ON u.id_address = a.id ';

		//query fait office à la fois de prepare et de execute
		$request = $this->_conn->query($sql);


		if($request->rowCount() ==0){
			return false;
		}else{
			while($user= $request->fetch(PDO::FETCH_ASSOC)){

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

				//instance de l'objet ($this)
				yield $this;

			}
		}

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

	public function create(){
		$sql= 'INSERT INTO addresses VALUES(NULL, :street, :zipcode, :city, :country)';
		$request=$this->_conn->prepare($sql);
		$request->bindValue(':street', htmlentities($this->_street));
		$request->bindValue(':zipcode', htmlentities($this->_zipcode));
		$request->bindValue(':city', htmlentities($this->_city));
		$request->bindValue(':country', htmlentities($this->_country));
		$request->execute();

		$sql = 'INSERT INTO users VALUES (NULL, 1, LAST_INSERT_ID(), :user_name, :user_lastname, :user_phone, :user_email, :user_id_connection, :user_password, NULL)';
		$request=$this->_conn->prepare($sql);
		$request->bindValue(':user_name', htmlentities($this->_name));
		$request->bindValue(':user_lastname', htmlentities($this->_last_name));
		$request->bindValue(':user_phone', htmlentities($this->_phone));
		$request->bindValue(':user_email', htmlentities($this->_email));
		$request->bindValue(':user_id_connection', htmlentities($this->_login));
		$request->bindValue(':user_password', password_hash($this->_password,PASSWORD_DEFAULT));

		if($request->execute()){
			return true;
		}
    	// Ecrire l'erreur si il y en a une
		printf('Erreur:' . $request->error . '. \n');
		return false;


	}
}
<?php
//Indiquer que l'on envoie des informations au format JSON
header('Content-Type: application/json');


//Instanciation d'une base de données
require '../../config/Database.php';

$bdd = new Database();


//Instanciation d'un User(avec un accès à une bdd)
require '../../models/User.php';

$user = new User($bdd);

if(isset($_GET['id'])){
	$user->_id = $_GET['id'];

	if($user->getOne()){

		$userArray =[];

		$userArray['Data']=[
			'user_type' => $user->_user_type,
			'name' => $user->_name,
			'last_name' => $user->_last_name,
			'phone' => $user->_phone,
			'email' => $user->_email,
			'login' => $user->_login,
			'street' => $user->_street,
			'city' => $user->_city,
			'zipcode' => $user->_zipcode,
			'country' => $user->_country
		];
		
		echo json_encode($userArray);
	}else{
		http_response_code(404);
		echo json_encode(["message" => "User introuvable"]);
	}
}else{
	http_response_code(400);
	echo json_encode(["message" => "Pas d'id fourni"]);
}

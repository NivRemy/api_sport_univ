<?php

//header('Content-Type: application/json');

require '../../config/Database.php';
require '../../models/University.php';

//Instanciation d'une base de données
$bdd = new Database();

//Instanciation d'une université (avec un accès à une bdd)
$university = new University($bdd);

$data = json_decode(file_get_contents("php://input"),true);

if ($data){
	//Tester la présence de tous les indexs
	if(isset($data['name']) && isset($data['street']) && isset($data['zipcode']) && isset($data['city']) && isset($data['country'])){

		//Je place dans mon objet les valeurs transimes dans la requête.
	 	$university->_name = $data['name'];
		$university->_street = $data['street'];
		$university->_zipcode = $data['zipcode'];
		$university->_city = $data['city'];
		$university->_country = $data['country'];

		//J'appelle la méthode de la classe université pour qu'elle insère les données

		if($university->create()){
			http_response_code(201);
			echo json_encode(['message' => 'Ajout de l\'université OK']);
		} else{
			http_response_code(403);
			echo json_encode(['message' => '`\'université n\'a pas pu être créée']);
		}		
	}else{
		http_response_code(403);
		echo json_encode(['message' => 'données manquantes']);
	}



}else {
	http_response_code(415);
	echo json_encode(['message' => 'Aucune donnee recu en POST']);
}
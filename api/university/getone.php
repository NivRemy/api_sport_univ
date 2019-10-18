<?php
//Indiquer que l'on envoie des informations au format JSON
header('Content-Type: application/json');
require '../../config/Database.php';
require '../../models/University.php';

//Instanciation d'une base de données
$bdd = new Database();

//Instanciation d'une université (avec un accès à une bdd)
$university = new University($bdd);







if(isset($_GET['id'])){
	//Définir l'id de l'université.
	$university->_id = $_GET['id'];
	//Récupérer les informations de l'université.
	if($university->getOne()){


		$university_array = [];

		$university_array['data'] = [
			'id' => $university->_id,
			'name' => $university->_name,
			'street'=> $university->_street,
			'zipcode'=> $university->_zipcode,
			'city'=> $university->_city,
			'country'=>$university->_country
		];

		echo json_encode($university_array);
	}else{
		http_response_code(404);
		echo json_encode(["message" => "Université introuvable"]);
	}
}else{
	http_response_code(400);
	echo json_encode(["message" => "Pas d'id fourni"]);
}
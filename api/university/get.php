<?php
//Indiquer que l'on envoie des informations au format JSON
header('Content-Type: application/json');
require '../../config/Database.php';
require '../../models/University.php';

//Instanciation d'une base de données
$bdd = new Database();

//Instanciation d'une université (avec un accès à une bdd)
$university = new University($bdd);


$universityArray = [];
foreach ($university->get() as $univ) {
	$universityArray[] = [
		'id' => $univ->_id,
		'name' => $univ->_name,
		'street'=> $univ->_street,
		'zipcode'=> $univ->_zipcode,
		'city'=> $univ->_city,
		'country'=>$univ->_country
	];

}

if ($universityArray){
	$resultArray=['Data' => $universityArray];
	echo json_encode($resultArray);
}else{
	http_response_code(404);
	echo json_encode(["message" => "Pas d'universités"]);
}
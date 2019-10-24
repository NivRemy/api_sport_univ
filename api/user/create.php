<?php
header('Content-Type: application/json');
require '../../config/Database.php';
require '../../models/User.php';

$bdd = new Database();
$user = new User($bdd);

$data = json_decode(file_get_contents("php://input"),true);

if ($data){

		//Je place dans mon objet les valeurs transimes dans la requête.
	$user->_name = $data['name'];
	$user->_last_name = $data['last_name'];
	$user->_phone = $data['phone'];
	$user->_email = $data['email'];
	$user->_login = $data['login'];
	$user->_password = $data['password'];
	$user->_street = $data['street'];
	$user->_city = $data['city'];
	$user->_zipcode = $data['zipcode'];
	$user->_country = $data['country'];

		//J'appelle la méthode de la classe université pour qu'elle insère les données

	if($user->create()){
		http_response_code(201);
		echo json_encode(['message' => 'Ajout de l\'utilisateur OK']);
	} else{
		http_response_code(403);
		echo json_encode(['message' => '`\'utilisateur n\'a pas pu être créé']);
	}		


}else {
	http_response_code(415);
	echo json_encode(['message' => 'Aucune donnee recu en POST']);
}


?>
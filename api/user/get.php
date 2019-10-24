<?php

header('Content-Type: application/json');
require '../../config/Database.php';
require '../../models/User.php';

$bdd = new Database();

$user = new User($bdd);

$userArray = [];

// $user->get() = un tableau $user construit grace à la fonction get 



foreach($user->get() as $user){
	//$userArray est un tableau 
	$userArray[]=[
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
}

if ($userArray){
	$result = [
	'Data'=>$userArray,
	'Message'=>'Utilisateurs bien récupérés.'];

	echo json_encode($result);
}else{
	http_response_code(404);
	echo json_encode(["message" => "Pas d'users !"]);
}



?>
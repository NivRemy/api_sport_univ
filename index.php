<?php
require 'config/Database.php';
require 'models/University.php';

//Instanciation d'une base de données
$bdd = new Database();

//Instanciation d'une université (avec un accès à une bdd)
$university = new University($bdd);

//Définir l'id de l'université.
$university->_id = 1;

//Récupérer les informations de l'université.
$university->getOne();

var_dump($university);
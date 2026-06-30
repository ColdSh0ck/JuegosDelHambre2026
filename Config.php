<?php
require_once "Medoo.php";

require_once "Personaje.php";
require_once "Guerrero.php";
require_once "Mago.php";
require_once "Arquero.php";
require_once "Arma.php";
require_once "Arena.php";
require_once "Duelo.php";
require_once "Torneo.php";


use Medoo\Medoo;

$db = new Medoo([
    'type' => 'mysql',
    'host' => 'localhost',
    'database' => 'torneo_duelos',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4' //Esto me permite usar o trabajar con caracteres especiales como ñ,ó,etc...
]);



?>
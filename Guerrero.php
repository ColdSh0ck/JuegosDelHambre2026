<?php
include_once 'Personaje.php';
class Guerrero extends Personaje {
    private $fuerza;
    private $armadura;

    public function __construct($nombre, $nivel, $puntosVida, $energia, $fuerza, $armadura, $estado = "disponible",$id=null) {
         // Invocamos al constructor de Personaje
        parent::__construct(  $nombre, $nivel, $puntosVida, $energia, $estado,$id);
        $this->fuerza = $fuerza;
        $this->armadura = $armadura;
    }

    public function __toString() {
        return parent::__toString() .
               "Clase: Guerrero\n" .
               "Fuerza: " . $this->fuerza . "\n" .
               "Armadura: " . $this->armadura . "\n";
    }

//Getters y Setters especificos
    public function getFuerza() { return $this->fuerza; }
    public function setFuerza($fuerza) { $this->fuerza = $fuerza; }
    public function getArmadura() { return $this->armadura; }
    public function setArmadura($armadura) { $this->armadura = $armadura; }

//Implementacion de metodos abstractos  
    public function calcularPoderBase() {
        return $this->getNivel()* 15;
    }

    public function calcularPoderEspecial() {
        return ($this->fuerza * 2) + $this->armadura;
    }
}

?>

<?php
include_once 'Personaje.php';

class Mago extends Personaje {
    private $mana;
    private $inteligencia;

    public function __construct($nombre, $nivel, $puntosVida, $energia, $mana, $inteligencia, $estado = "disponible",$id=null) {
        parent::__construct($nombre, $nivel, $puntosVida, $energia, $estado,$id);
        $this->mana = $mana;
        $this->inteligencia = $inteligencia;
    }
    
    public function getMana(){return $this->mana;}
    public function setMana($mana){$this->mana=$mana;}
    public function getInteligencia(){return $this->inteligencia;}
    public function setInteligencia($inteligencia){$this->inteligencia=$inteligencia;}
    
    public function __toString() {
        return parent::__toString() .
               "Clase: Mago\n" .
               "Maná: " . $this->mana . "\n" .
               "Inteligencia: " . $this->inteligencia . "\n";
    }

    public function calcularPoderBase() {
        return ($this->getNivel() * 10) + $this->mana;
    }

    public function calcularPoderEspecial() {
        return $this->mana + ($this->inteligencia * 3);
    }
}
?>

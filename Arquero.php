<?php
include_once 'Personaje.php';

class Arquero extends Personaje {
    private $precision;
    private $velocidad;

    public function __construct($nombre, $nivel, $puntosVida, $energia, $precision, $velocidad, $estado = "disponible",$id=null) {
        parent::__construct($nombre, $nivel, $puntosVida, $energia, $estado,$id);
        $this->precision = $precision;
        $this->velocidad = $velocidad;
    }
    public function getPrecision(){return $this->precision;}
    public function setPrecision($precision){$this->precision=$precision;}
    public function getVelocidad(){return $this->velocidad;}
    public function setVelocidad($velocidad){$this->velocidad=$velocidad;}
    public function __toString() {
        return parent::__toString() .
               "Clase: Arquero\n" .
               "Precisión: " . $this->precision . "\n" .
               "Velocidad: " . $this->velocidad . "\n";
    }

    public function calcularPoderBase() {
        return ($this->getNivel() * 12) + $this->precision;
    }

    public function calcularPoderEspecial() {
        return ($this->precision * 2) + $this->velocidad;
    }
}
?>

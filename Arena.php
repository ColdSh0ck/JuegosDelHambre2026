<?php
Class Arena{
    private $idArena; //Int
    private $nombre; //String
    private $dificultad; //String
    private $capacidadPublico; //Int
    private $clima;// String

    public function __construct($idSand,$name,$difficult,$capacityPublic,$weather){
        $this->idArena=$idSand;
        $this->nombre=$name;
        $this->dificultad=$difficult;
        $this->capacidadPublico=$capacityPublic;
        $this->clima=$weather;
    }
//Metodos de acceso getters y setters
    public function getIdArena(){
        return $this->idArena;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getDificultad(){
        return $this->dificultad;
    }
    public function getCapacidadPublico(){
        return $this->capacidadPublico;
    }
    public function getClima(){
        return $this->clima;
    }
    public function setIdArena($id){
        $this->idArena=$id;
    }
    public function setNombre($nombre1){
        $this->nombre=$nombre1;
    }
    public function setDificultad($dificultad1){
        $this->dificultad=$dificultad1;
    }
    public function setCapacidadPublico($capacidad1){
        $this->capacidadPublico=$capacidad1;
    }
    public function setClima($clima1){
        $this->clima=$clima1;
    }
//Metodo publico __toString()
    public function __toString(){
        return "Id_Arena: ".$this->getIdArena()."\n".
                "Nombre_De_La_Arena: ".$this->getNombre()."\n".
                "Dificultad: ".$this->getDificultad()."\n".
                "Capacidad_De_La_Arena: ".$this->getCapacidadPublico()."\n".
                "Clima: ".$this->getClima()."\n";
    }
//Metodo que evalua que tipo de clase es
    public function tipoDeClase($personaje1){
        $tipo="";
        if($personaje1 instanceof Guerrero){
            $tipo="Guerrero";
        }elseif ($personaje1 instanceof Mago) {
            $tipo="Mago";
        }elseif ($personaje1 instanceof Arquero) {
            $tipo="Arquero";
        }
    return $tipo;
    }

    public function calcularModificadorArena($personaje1){//$personaje1 OBJ 
        $bonificacion=0;
        // Nos limpia el text y lo guarda en la variable climaActual y tipoPersonaje ; 
        //trim(borra espacios ocultos en las puntas)
        //strolower(covierto todo a minusculas)
        $climaActual=trim(strtolower($this->getClima()));
        $tipoPersonaje=trim(strtolower($this->tipoDeClase($personaje1)));
        if($climaActual== "normal"){
            $bonificacion=0;
        }elseif ($climaActual == "lluvia"){
            if($tipoPersonaje == "guerrero"){
                $bonificacion=0;
            }elseif ($tipoPersonaje == "arquero" ) {
                $bonificacion= -10;
            }elseif ($tipoPersonaje == "mago") {
                $bonificacion= 5;
            }
        }elseif ($climaActual =="tormenta") {
            if($tipoPersonaje == "guerrero"){
                $bonificacion=-5;
            }elseif ($tipoPersonaje == "arquero" ) {
                $bonificacion= -5;
            }elseif ($tipoPersonaje == "mago") {
                $bonificacion= 15;
            }
        }elseif ($climaActual == "niebla") {
            if($tipoPersonaje == "guerrero"){
                $bonificacion=5;
            }elseif ($tipoPersonaje == "arquero" ) {
                $bonificacion= -15;
            }elseif ($tipoPersonaje == "mago") {
                $bonificacion= 0;
            }
        }
    return $bonificacion;
    }
    


}

?>
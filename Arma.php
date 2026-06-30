<?php


Class Arma{
    private $idArma; //Int
    private $nombre; //String
    private $tipo; //String
    private $danioBase; //Int
    private $nivelMinimo; //Int
    private $estado; //String


    public function __construct($idWeapon,$name,$type,$damageBase,$minLevel,$status){
        $this->idArma=$idWeapon;
        $this->nombre=$name;
        $this->tipo=$type;
        $this->danioBase=$damageBase;
        $this->nivelMinimo=$minLevel;
        $this->estado=$status;
    }

    public function getIdArma(){
        return $this->idArma;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getTipo(){
        return $this->tipo;
    }
    public function getDanioBase(){
        return $this->danioBase;
    }
    public function getNivelMinimo(){
        return $this->nivelMinimo;
    }
    public function getEstado(){
        return $this->estado;
    }

    public function setIdArma($id){
        $this->idArma=$id;
    }
    public function setNombre($nombre1){
        $this->nombre=$nombre1;
    }
    public function setTipo($tipo1){
        $this->tipo=$tipo1;
    }
    public function setDanioBase($danioBase1){
        $this->danioBase=$danioBase1;
    }
    public function setNivelMinimo($nivelmin){
        $this->nivelMinimo=$nivelmin;
    }
    public function setEstado($estado1){
        $this->estado=$estado1;
    }

    public function __toString(){
        return "ID_Arma: ".$this->getIdArma()."\n".
                "Nombre_Del_Arma: ".$this->getNombre()."\n".
                "Tipo: ".$this->getTipo()."\n".
                "Daño_Base: ".$this->getDanioBase()."\n".
                "Nivel_Minimo_Para_Equipar: ".$this->getNivelMinimo()."\n".
                "Estado_Del_Arma: ".$this->getEstado()."\n";
    }

    public function calcularDanio(){
        $danioArma=$this->getDanioBase();
        return $danioArma;
    }

    public function puedeSerEquipadoPor($personaje){//$personaje es obj
        $equipacion=false;
        if($this->getEstado()!="rota" && $personaje->getNivel()>= $this->getNivelMinimo() && $this->getEstado()!= "equipada"){
            $equipacion=true;
        }
    return $equipacion;
    }





}




?>
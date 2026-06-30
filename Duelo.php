<?php

Class Duelo{
    private $idDuelo; //Int
    private $personaje1; // obj
    private $personaje2; // obj
    private $arena; //obj
    private $fecha; //String
    private $estado; //String
    private $ganador; //Obtengo al objeto ganador

    public function __construct($idDuel,$legend1,$legend2,$sand,$date,$status){
        $this->idDuelo=$idDuel;
        $this->personaje1=$legend1;
        $this->personaje2=$legend2;
        $this->arena=$sand;
        $this->fecha=$date;
        $this->estado=$status;
        $this->ganador=null;
    }

    public function getIdDuelo(){
        return $this->idDuelo;
    }
    public function getPersonaje1(){
        return $this->personaje1;
    }
    public function getPersonaje2(){
        return $this->personaje2;
    }
    public function getArena(){
        return $this->arena;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getEstado(){
        return $this->estado;
    }
    public function getGanador(){
        return $this->ganador;
    }
    
    public function setIdDuelo($id){
        $this->idDuelo=$id;
    }
    public function setPersonaje1($champion1){
        $this->personaje1=$champion1;
    }
    public function setPersonaje2($champion2){
        $this->personaje2=$champion2;
    }
    public function setArena($sand1){
        $this->arena=$sand1;
    }
    public function setFecha($date1){
        $this->fecha=$date1;
    }
    public function setEstado($status1){
        $this->estado=$status1;
    }
    public function setGanador($winner1){
        $this->ganador=$winner1;
    }

    public function __toString(){
        $textoGanador = "Sin ganador";
            if($this->getGanador()!=null){
                $textoGanador = $this->getGanador();
            }
        return "ID_Del_Duelo: ".$this->getIdDuelo()."\n".
                "Jugador 1: ".$this->getPersonaje1()->getNombre()."\n".
                "Jugador 2: ".$this->getPersonaje2()->getNombre()."\n".
                "Arena: ".$this->getArena()->getNombre()."\n".
                "Fecha_Del_Duelo: ".$this->getFecha()."\n".
                "Estado_Del_Duelo: ".$this->getEstado()."\n".
                "Ganador: ".$textoGanador."\n";          
    }

    public function puedeRealizarse(){
        $sePuede=true;
        if($this->getPersonaje1()->equals($this->getPersonaje2())){
            $sePuede=false;
        }elseif($this->getPersonaje1()->getEstado() =="lesionado" || $this->getPersonaje2()->getEstado()=="lesionado"){
            $sePuede=false;
        }elseif($this->getPersonaje1()->getEstado() =="retirado" || $this->getPersonaje2()->getEstado()=="retirado"){
            $sePuede=false;
        }
    return $sePuede;
    }

        
    public function realizarDuelo(){

        if($this->puedeRealizarse()){
                $player1=$this->getPersonaje1();
                $player2=$this->getPersonaje2();
                $sand=$this->getArena();
                $ganador=null;
                //Poder del primer jugador
                $poderPersonaje1= $player1->calcularPoderTotal() +
                $sand->calcularModificadorArena($player1);

                //Poder del segundo jugador
                $poderPersonaje2= $player2->calcularPoderTotal() +
                $sand->calcularModificadorArena($player2);

                //Ganador
                if($poderPersonaje1>$poderPersonaje2){
                    $unNivel=$player1->getNivel() + 1;
                    $unDueloMas=$player1->getDuelosGanados() +1 ;
                    $player1->setNivel($unNivel);
                    $player1->recuperarEnergia(5);
                    $player1->setDuelosGanados($unDueloMas);
                    $ganador=$player1;
                //Perdedor
                    $danioPerdedor=$poderPersonaje1-$poderPersonaje2;
                    $player2->recibirDanio($danioPerdedor);
                    $unDueloMenos=$player2->getDuelosPerdidos() +1;
                    $menosEnergia=$player2->getEnergia() -5;
                    $player2->setDuelosPerdidos($unDueloMenos);
                    $player2->setEnergia($menosEnergia);
                    $this->setEstado("realizado");
                    $this->setGanador($ganador);
                }elseif($poderPersonaje2>$poderPersonaje1){
                //Ganador
                    $unNivel=$player2->getNivel() + 1;
                    $unDueloMas=$player2->getDuelosGanados() +1 ;
                    $player2->setNivel($unNivel);
                    $player2->recuperarEnergia(5);
                    $player2->setDuelosGanados($unDueloMas);
                    $ganador=$player2;
                    //Perdedor
                    $danioPerdedor=$poderPersonaje2-$poderPersonaje1;
                    $player1->recibirDanio($danioPerdedor);
                    $unDueloMenos=$player1->getDuelosPerdidos() +1;
                    $menosEnergia=$player1->getEnergia() -5;
                    $player1->setDuelosPerdidos($unDueloMenos);
                    $player1->setEnergia($menosEnergia);
                    $this->setEstado("realizado");
                    $this->setGanador($ganador);
                }elseif($poderPersonaje1==$poderPersonaje2){
                    //Si empatan no pasa nada.
                    $this->setEstado("realizado");
                }
        }else{
            $this->setEstado("cancelado");
        }
    }

    public function obtenerGanador(){
        return $this->getGanador();
    }

}

/*Consulta, que pasa con la energia en negativo? como deberiamos pensarlo o es algo que nosotros podemos modificar o usar a gusto ? */




?>
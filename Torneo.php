 <?php

Class Torneo{
    private $personajes;
    private $armas;
    private $arenas;
    private $duelos;

    private $db;

    
    public function __construct($db){
        $this->personajes=[];
        $this->armas=[];
        $this->arenas=[];
        $this->duelos=[];

        $this->db=$db;
    }

    public function getPersonajes(){
        return $this->personajes;
    }
    public function getArmas(){
        return $this->armas;
    }
    public function getArenas(){
        return $this->arenas;
    }
    public function getDuelos(){
        return $this->duelos;
    }
    public function setPersonajes($characters){
        $this->personajes=$characters;
    }
    public function setArmas($weapons){
        $this->armas=$weapons;
    }
    public function setArenas($sands){
        $this->arenas=$sands;
    }
    public function setDuelos($duels){
        $this->duelos=$duels;
    }

    public function __toString(){
        $leyends="";
        $weapons="";
        $sands="";
        $duels="";
        foreach ($this->getPersonajes() as $personaje1) {
            $leyends .= $personaje1 ."\n";
        }
        foreach ($this->getArmas() as $arma1) {
            $weapons .= $arma1 ."\n";
        }
        foreach ($this->getArenas() as $arena1) {
            $sands .= $arena1 ."\n";
        }
        foreach ($this->getDuelos() as $duelo1) {
            $duels .= $duelo1 . "\n";
        }
        if($leyends=="" && $weapons=="" && $sands=="" && $duels==""){
            $mensaje="No se ah agregado nada aun"  ;  
            }else{
            $mensaje="Personajes: ".$leyends."\n".
            "Armas: ".$weapons."\n".
            "Arenas: ".$sands."\n".
            "Duelos: ".$duels."\n";
            }
    return $mensaje;       
    }
    
    public function agregarPersonaje($personaje1){
        $colPersonajes=$this->getPersonajes();
        $colPersonajes[]=$personaje1;
        $this->setPersonajes($colPersonajes);
    }

    public function agregarArma($arma1){
        $colArmas=$this->getArmas();
        $colArmas[]=$arma1;
        $this->setArmas($colArmas);
    }

    public function agregarArena($arena1){
        $colArenas=$this->getArenas();
        $colArenas[]=$arena1;
        $this->setArenas($colArenas);
    }

    /*Metodo que equipa un arma y devuelve si se pudo */
    /*@param obj obj */
    /*@return booleano*/
    public function equiparArma($personaje1,$arma1){
        $armaEquipada=false;
        if($arma1->puedeSerEquipadoPor($personaje1)){
            $personaje1->setArma($arma1);
            $arma1->setEstado("equipada");
            $armaEquipada=true;
        }
    return $armaEquipada;
    }

public function registrarDuelo($duelo1){
        $colDuelos= $this->getDuelos();
        $registroExitoso=false;
        $idIgual=false;
        foreach($colDuelos as $duel1){
            if($duel1->getIdDuelo()==$duelo1->getIdDuelo()){
            $idIgual=true;
            }
        }
        if($idIgual==false){
            $duelo1->setEstado("pendiente");
            $colDuelos[]=$duelo1;
            $this->setDuelos($colDuelos);
            $registroExitoso=true;
        }

    return $registroExitoso;
    }

    public function realizarDuelo($dueloEnEspera){
        $dueloExitoso=false;
        if($dueloEnEspera->puedeRealizarse()){
            $dueloEnEspera->realizarDuelo();
            $dueloExitoso=true;
        }else{
            $dueloEnEspera->setEstado("cancelado");
        }
    $this->guardarCambios();
    return $dueloExitoso;
    }

/*Metodo que me muestra todos los personajes de mi coleccionPersonajes en Torneo ya cargado (LLamar al programa principal)*/
/*@return Objeto */
public function listarPersonajes(){
return $this->personajes;
}

/*Metodo que que devuelve los personajes DISPONIBLES para duelar */
/*@return Array */
public function listarPersonajesDisponibleParaDuelar(){
    $listoParaDuelar=[];
    $coleccionPersonajes=$this->getPersonajes();
    foreach($coleccionPersonajes as $unPerson){
        if($unPerson->puedeDuelar()){
            $listoParaDuelar[]=$unPerson;
        }
    }
return $listoParaDuelar;
}

/*Metodo que devuelve los personajes lesionados en un array */
/*@return Array */
public function listarPersonajesLesionados(){
    $lesionados=[];
    $coleccionPersonajes=$this->getPersonajes();
    foreach($coleccionPersonajes as $unPerson){
        if($unPerson->getEstado()=="lesionado"){
            $lesionados[]=$unPerson;
        }
    }
return $lesionados;
}


/*Metodo que devuelve los personajes retirados en un array */
/*@return Array */
public function listarPersonajesRetirados(){
    $retirados=[];
    $coleccionPersonajes=$this->getPersonajes();
    foreach($coleccionPersonajes as $unPerson){
        if($unPerson->getEstado()=="retirado"){
            $retirados[]=$unPerson;
        }
    }
return $retirados;
}


/*Metodo que devuelve las armas DISPONIBLES en un array */
/*@return Array */
public function listarArmasDisponibles(){
    $armasDis=[];
    $coleccionArmas=$this->getArmas();
    foreach($coleccionArmas as $unArma){
        if($unArma->getEstado()=="disponible"){
            $armasDis[]=$unArma;
        }
    }
return $armasDis;
}

/*Metodo que me devuelve el nombres las armas equipadas o no y de sus respectivos dueños */
/*@return String */
public function mostrarArmaPersonajes(){
    $lista="";
    $coleccionPersonajes=$this->getPersonajes();
    foreach($coleccionPersonajes as $unPerson ){
        $lista .= "Nombre Personaje: ".$unPerson->getNombre();
        if($unPerson->getArma() !=null){
            $lista .= " - Arma: ".$unPerson->getArma()->getNombre();
        }else{
            $lista .= " - Arma: Ninguna";
        }
    $lista .= "\n";
    }
return $lista;
}

/*Metodo que me devuelve los duelos en estado realizado */
/*@return Array */
public function mostrarDuelosRealizados(){
    $duelosEchos=[];
    $coleccionDuelos=$this->getDuelos();
    foreach($coleccionDuelos as $unDuelo){
        if($unDuelo->getEstado()=="realizado"){
            $duelosEchos[]=$unDuelo;
        }
    }
return $duelosEchos;
}

//Metodo auxliar para objetos
/*Metodo que devuelve la lista de personajes con estado Diposnible desde la base de datos*/
/*@return Array */
public function mostrarDuelosRealizadosDB(){
    $duelosRealizados=[];
    $datos=$this->db->select("duelos","*",
        ["estado"=> "realizado"]);
    foreach($datos as $fila){
        $personaje1=$this->buscarPersonajePorId($fila["idPersonaje1"]);
        $personaje2=$this->buscarPersonajePorId($fila["idPersonaje2"]);
        $arena= $this->buscarArenaPorId($fila["idArena"]);
        $duelo= new Duelo(
            $fila["id"],
            $personaje1,
            $personaje2,
            $arena,
            $fila["fecha"],
            $fila["estado"],
        );
        if($fila["idGanador"] != null){
            $ganador=$this->buscarPersonajePorId($fila["idGanador"]);
            $duelo->setGanador($ganador);
        }
    $duelosRealizados[]=$duelo;    
    }
return $duelosRealizados ;
}

/*Metodo que devuelve un string con los resultados de la consulta en la base de datos JOIN */ 
/*@return string */
public function consultaDuelosRealizados(){
    $duelosRealizados="";
    $datos=$this->db->select(
        "duelos (d)", ["[>]personajes (p1)" => ["idPersonaje1" => "id"],
        "[>]personajes (p2)" => ["idPersonaje2" => "id"],
        "[>]arenas (a)" => ["idArena" => "id"],
        "[>]personajes (g)" => ["idGanador" => "id"]
        ],
        [
        "d.id",
        "p1.nombre(personaje1)",
        "p2.nombre(personaje2)",
        "a.nombre(arena)",
        "g.nombre(ganador)",
        "d.fecha",
        "d.estado"
        ],
        ["d.estado" => "realizado"]
    );
    foreach($datos as $fila){
    $duelosRealizados .=
    "Id: ".$fila["id"]."\n"."Personaje1: ".$fila["personaje1"]."\n".
    "Personaje2: ".$fila["personaje2"]."\n"."Arena: ".$fila["arena"]."\n".
    "Ganador: ".$fila["ganador"]."\n"."Fecha: ".$fila["fecha"]."\n".
    "Estado: ".$fila["estado"]."\n"."=========================="."\n";
}
return $duelosRealizados;
}


/*Metodo que me devuelve los duelos en estado pendiente */
/*@return Array */
public function mostrarDuelosPendientes(){
    $duelosEnEspera=[];
    $coleccionDuelos=$this->getDuelos();
    foreach($coleccionDuelos as $unDuelo){
        if($unDuelo->getEstado()=="pendiente"){
            $duelosEnEspera[]=$unDuelo;
        }
    }
return $duelosEnEspera;
}

/*Metodo que me muestra el historial de duelos de un personaje */
/*@param INT  */
/*@return Array */
public function historialDeDuelosdeUnPersonaje($id){
    $historial=[];
    $coleccionDuelos=$this->getDuelos();
    foreach($coleccionDuelos as $unDuelo){
        $idP1=$unDuelo->getPersonaje1()->getID();
        $idP2=$unDuelo->getPersonaje2()->getID();
        if($idP1==$id || $idP2==$id){
            $historial[]= $unDuelo;
        }
    }
return $historial;
}


/*
public function listarArmas(){
    return $this->armas;
}

public function listarArenas(){
    return $this->arenas;
}

public function listarDuelos(){
    return $this->duelos;
}
*/

/*Bucle por ambos lados de comparacion */
public function rankingPersonajes(){
    $ranking = $this->getPersonajes();
    $n=count($ranking);
    for($i=0;$i<$n-1;$i++){
        for($j=0;$j<$n-$i-1;$j++){
            if($ranking[$j]->getDuelosGanados()<$ranking[$j+1]->getDuelosGanados()){
        $varAuxiliar= $ranking[$j];
        $ranking[$j]= $ranking[$j + 1];
        $ranking[$j + 1] = $varAuxiliar;
            }
        }
    }
return $ranking;
}

/*Metodo que devuelve al personaje con maximas victorias */
/*@return Objeto */
public function personajeConMaximasVictorias(){
    $coleccionPersonajes=$this->getPersonajes();
    $maxPersonaje="";
    if(count($coleccionPersonajes)==0){
        $maxPersonaje=null;
    }else{
        $maxPersonaje=$coleccionPersonajes[0];
        foreach($coleccionPersonajes as $unPersonaje){
            if($unPersonaje->getDuelosGanados()> $maxPersonaje->getDuelosGanados()){
                $maxPersonaje=$unPersonaje;
            }
        }
    }
return $maxPersonaje;
}

/*Metodo que muestra el porcentaje de victorias de cada personaje */
/*@return String */ 
public function mostrarPorcentajeDeVictorias(){
    $listaPorcentanjes="";
    $coleccionPersonajes=$this->getPersonajes();
    foreach($coleccionPersonajes as $unPersonaje){
        $ganados=$unPersonaje->getDuelosGanados();
        $perdidos=$unPersonaje->getDuelosPerdidos();
        $total=$ganados + $perdidos;
        if($total>0){
            $porcentaje=($ganados/$total) * 100;
        }else{
            $porcentaje=0;
        }
        $listaPorcentanjes .= "Nombre: ".$unPersonaje->getNombre();
        $listaPorcentanjes .= "- Victorias: ".round($porcentaje,2)." % ";
        $listaPorcentanjes .= "\n";
    }
return $listaPorcentanjes;
}

/*Metodo que me devuelve la arena en donde se realizaron mas duelos */
/*@return Objeto */
public function mostrarArenaConMaximosDuelos(){
    $coleccionArenas=$this->getArenas();
    $coleccionDuelos=$this->getDuelos();
    $arenaMaxima=null;
    $maxDuelos=0;
    foreach($coleccionArenas as $unArena){
        $cantidad=0;
        foreach ($coleccionDuelos as $unDuelo) {
            if($unDuelo->getArena()->getIdArena()==$unArena->getIdArena()){
                $cantidad= $cantidad +1;
            }
        }
        if($cantidad>$maxDuelos){
            $maxDuelos=$cantidad;
            $arenaMaxima=$unArena;
        }
    }
return $arenaMaxima;
}

//Metodos con Bases de datos

public function cargarPersonajes(){
    $datos= $this->db->select("personajes","*");
    $personajes=[];

    foreach($datos as $fila){
    $personaje = null;

        if($fila["tipoPersonaje"]=="guerrero"){
            $personaje= new Guerrero(
            $fila["nombre"],
            $fila["nivel"],
            $fila["puntosVida"],
            $fila["energia"],
            $fila["fuerza"],
            $fila["armadura"],
            $fila["estado"],
            $fila["id"]);
        }elseif($fila["tipoPersonaje"]=="mago"){

            $personaje= new Mago(
            $fila["nombre"],
            $fila["nivel"],
            $fila["puntosVida"],
            $fila["energia"],
            $fila["mana"],
            $fila["inteligencia"],
            $fila["estado"],
            $fila["id"]);
            
        }elseif($fila["tipoPersonaje"]=="arquero"){

            $personaje= new Arquero(
            $fila["nombre"],
            $fila["nivel"],
            $fila["puntosVida"],
            $fila["energia"],
            $fila["precisionPersonaje"],
            $fila["velocidad"],
            $fila["estado"],
            $fila["id"]);
        }
        if($personaje !=null){
            //Esto lo parche ya que inicializamos las clases en 0 en dichos atributos XD
            $personaje->setDuelosGanados($fila["duelosGanados"]);
            $personaje->setDuelosPerdidos($fila["duelosPerdidos"]);
            
              if($fila["idArmaEquipada"] != null){
                $arma= $this->buscarArmaPorId($fila["idArmaEquipada"]);
                if($arma != null){
                    $personaje->setArma($arma);
                }
            }
            $personajes[]=$personaje;
        }
    }
    $this->setPersonajes($personajes);
}


public function cargarArmas(){
    $datos=$this->db->select("armas", "*");
    $armas=[];

    foreach ($datos as $fila) {
        $arma= new Arma($fila["id"],
            $fila["nombre"],
            $fila["tipo"],
            $fila["danioBase"],
            $fila["nivelMinimo"],
            $fila["estado"]
        );
        $armas[]= $arma;
    }
    $this->setArmas($armas);
}


public function cargarArenas(){
    $datos= $this->db->select("arenas", "*");
    $arenas=[];

    foreach($datos as $fila) {

        $arena= new Arena($fila["id"],
            $fila["nombre"],
            $fila["dificultad"],
            $fila["capacidadPublico"],
            $fila["clima"]);
        $arenas[]= $arena;
    }
    $this->setArenas($arenas);
}

//Metodos para buscar personajes mediante su id
public function buscarPersonajePorId($id){
    $personaje=null;
    foreach($this->getPersonajes() as $per){
        if($per->getID()== $id && $personaje== null){
            $personaje= $per;
        }
    }
    return $personaje;
}


//Metodos para buscar Arena mediante su id
public function buscarArenaPorId($id){
    $arena= null;

    foreach($this->getArenas() as $are){
        if($are->getIdArena()== $id && $arena == null){
            $arena= $are;
        }
    }

    return $arena;
}

public function buscarArmaPorId($id){
    $arma= null;
    foreach($this->getArmas() as $arm){
        if($arm->getIdArma()== $id && $arma == null){
            $arma= $arm;
        }
    }
    return $arma;
}

public function cargarDuelos(){

    $datos= $this->db->select("duelos", "*");
    $duelos= [];
    foreach($datos as $fila){

        $personaje1= $this->buscarPersonajePorId($fila["idPersonaje1"]);
        $personaje2= $this->buscarPersonajePorId($fila["idPersonaje2"]);
        $arena= $this->buscarArenaPorId($fila["idArena"]);
        $ganador= null;

        if($fila["idGanador"] != null){
            $ganador= $this->buscarPersonajePorId($fila["idGanador"]);
        }
        $duelo= new Duelo(
            $fila["id"],
            $personaje1,
            $personaje2,
            $arena,
            $fila["fecha"],
            $fila["estado"]
        );

        $duelo->setGanador($ganador);
        $duelos[] = $duelo;
    }

    $this->setDuelos($duelos);
}


public function registrarNuevoPersonaje($personaje) {
    $tipo= "";
    if($personaje instanceof Guerrero){
        $tipo= "guerrero";
    }
    if($personaje instanceof Mago){
        $tipo= "mago";
    }
    if($personaje instanceof Arquero){
        $tipo= "arquero";
    }
 
    $datos=["nombre"=> $personaje->getNombre(),
        "tipoPersonaje"=> $tipo,
        "nivel"=> $personaje->getNivel(),
        "puntosVida"=>$personaje->getPuntosVida(),
        "energia"=>$personaje->getEnergia(),
        "estado"=>$personaje->getEstado(),
        "duelosGanados"=> $personaje->getDuelosGanados(),
        "duelosPerdidos"=>$personaje->getDuelosPerdidos()];

    if ($personaje instanceof Guerrero) {
        $datos["fuerza"]= $personaje->getFuerza();
        $datos["armadura"]= $personaje->getArmadura();
    } elseif ($personaje instanceof Mago) {
        $datos["mana"]= $personaje->getMana();
        $datos["inteligencia"]= $personaje->getInteligencia();
    } elseif ($personaje instanceof Arquero) {
        $datos["precisionPersonaje"]= $personaje->getPrecision();
        $datos["velocidad"]= $personaje->getVelocidad();
    }
    $this->db->insert("personajes", $datos);
    $nuevoId=$this->db->id();
    $personaje->setID($nuevoId);
    $this->agregarPersonaje($personaje);
}

public function registrarNuevaArma($arma){
    $this->db->insert("armas",[
        "nombre"=>$arma->getNombre(),
        "tipo"=>$arma->getTipo(),
        "danioBase"=>$arma->getDanioBase(),
        "nivelMinimo"=>$arma->getNivelMinimo(),
        "estado"=>$arma->getEstado()]);

    $nuevoId=$this->db->id();
    $arma->setIdArma($nuevoId);
    $this->agregarArma($arma);
}


public function registrarNuevaArena($arena){
    $this->db->insert("arenas",[
        "nombre"=>$arena->getNombre(),
        "dificultad"=>$arena->getDificultad(),
        "capacidadPublico"=>$arena->getCapacidadPublico(),
        "clima"=>$arena->getClima()]);
    $nuevoId = $this->db->id();
    $arena->setIdArena($nuevoId);

    $this->agregarArena($arena);
}


public function registrarNuevoDuelo($duelo){
    $this->db->insert("duelos", ["idPersonaje1"=> $duelo->getPersonaje1()->getID(),
        "idPersonaje2"=> $duelo->getPersonaje2()->getID(),
        "idArena"=> $duelo->getArena()->getIdArena(),
        "fecha"=> $duelo->getFecha(),
        "estado"=> "pendiente",
        "idGanador"=> null]);
    
    $nuevoId = $this->db->id();
    $duelo->setIdDuelo($nuevoId);
    
    $this->registrarDuelo($duelo); 
}

public function guardarCambios(){
    // Actualiza y sincroniza
    foreach($this->getPersonajes() as $per) {
        $idArma= null;
        if($per->getArma() !== null){
            $idArma=$per->getArma()->getIdArma();
        }

        $this->db->update("personajes", ["nivel"=> $per->getNivel(),
            "puntosVida"=> $per->getPuntosVida(),
            "energia"=> $per->getEnergia(),
            "estado"=> $per->getEstado(),
            "duelosGanados"=> $per->getDuelosGanados(),
            "duelosPerdidos"=> $per->getDuelosPerdidos(),
            "idArmaEquipada"=> $idArma
        ], ["id"=> $per->getID()]);
    }
    foreach ($this->getDuelos() as $due) {
       
        $idGanador = null;
        if ($due->getGanador() !== null) {
            $idGanador= $due->getGanador()->getID();
        }
        $this->db->update("duelos", [
            "estado"=> $due->getEstado(),
            "idGanador"=> $idGanador
        ], ["id"=> $due->getIdDuelo()]);
    }
}

/*
 Metodo auxiliar para eliminar un personaj por su id (brian)
 */
public function eliminarPersonajePorId($id) {
     
    $this->db->delete("personajes", ["id" => $id]);
    $coleccion = $this->getPersonajes();
    foreach ($coleccion as $index => $per) {
        if ($per->getID()== $id) {
            unset($coleccion[$index]);
            break;
        }
    }
    $this->setPersonajes(array_values($coleccion));
}

}

?>
 

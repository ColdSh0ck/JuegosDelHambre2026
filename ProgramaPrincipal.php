<?php
include_once "Config.php";// 1. INCLUSIONES OBLIGATORIAS (Conexion)
// YO DIRECTAMENTE USO TODAS LAS CLASES PERO FUNCIONA TAMBIEN CON CONFIGURACION BRAIAN
 
//2 . INSTANCIA DEL CONTROLADOR Y CARGA AUTOMÁTICA
$torneo = new Torneo($db);

$torneo->cargarArmas();
$torneo->cargarArenas();
$torneo->cargarPersonajes();
$torneo->cargarDuelos();

// Arrancamos en 0  
$opcion = 0; 

do {
    echo "\n/////////////////////////////////////////\n";
    echo "|    MENÚ PRINCIPAL - JUEGOS DEL HAMBRE   |\n";
    echo "/////////////////////////////////////////\n";
    echo "1* | REGISTRAR PERSONAJES\n";
    echo "2* | REGISTRAR ARMA\n";
    echo "3* | REGISTRAR ARENA\n";
    echo "4* | EQUIPAR ARMA A PERSONAJE\n";
    echo "5* | REGISTRAR DUELO (CREAR PENDIENTE...)\n";
    echo "6* | EJECUTAR DUELO PENDIENTE\n"; 
    echo "7* | RECUPERAR PERSONAJE LESIONADO\n"; 
    echo "8* | CONSULTAS Y RANKINGS (SUBMENU DEL PUNTO 8)\n";//Actuaria como un Historial en vez de Consultar rankings y Consultar historial de personajes por separado 
    echo "9* | SALIR DEL PROGRAMA\n";                        //Direcatemnete se implementó un único submenú que reúne todas las consultas.
    echo"10*| MOSTRAR PERSONAJE POR ID \n";
    echo "\n=========================================\n";
    
    
    echo "Seleccione una opción (1-10): ";
$opcion = (int) trim(fgets(STDIN));

    switch($opcion){
         case 1:
    echo "//////_ [1. Registrar Personaje] _//////\n";
   
    echo "Nombre: ";
    $nombre = trim(fgets(STDIN));

    echo "Nivel: ";
    $nivel = (int)trim(fgets(STDIN));

    echo "Puntos de Vida: ";
    $vida = (int)trim(fgets(STDIN));

    echo "Energía: ";
    $energia = (int)trim(fgets(STDIN));

    echo "Tipo de personaje:\n";
    echo "1 - Guerrero\n";
    echo "2 - Mago\n";
    echo "3 - Arquero\n";
    echo "Opción: ";
    $tipo = (int)trim(fgets(STDIN));

    $personaje = null;

    switch($tipo){

        case 1:
            echo "Fuerza: ";
            $fuerza = (int)trim(fgets(STDIN));

            echo "Armadura: ";
            $armadura = (int)trim(fgets(STDIN));

            $personaje = new Guerrero(
                $nombre,
                $nivel,
                $vida,
                $energia,
                $fuerza,
                $armadura,
                "disponible"
            );
        break;

        case 2:
            echo "Mana: ";
            $mana = (int)trim(fgets(STDIN));

            echo "Inteligencia: ";
            $inteligencia = (int)trim(fgets(STDIN));

            $personaje = new Mago(
                $nombre,
                $nivel,
                $vida,
                $energia,
                $mana,
                $inteligencia,
                "disponible"
            );
        break;

        case 3:
            echo "Precisión: ";
            $precision = (int)trim(fgets(STDIN));

            echo "Velocidad: ";
            $velocidad = (int)trim(fgets(STDIN));

            $personaje = new Arquero(
                $nombre,
                $nivel,
                $vida,
                $energia,
                $precision,
                $velocidad,
                "disponible"
            );
        break;

        default:
            echo "Tipo inválido.\n";
        break;
    }

    if($personaje != null){
        $torneo->registrarNuevoPersonaje($personaje);
        echo "Personaje registrado correctamente.\n";
    }
break;

case 2:
    echo "////// [2. Registrar Arma] //////\n\n";
           echo "Nombre del arma: ";
    $nombre=trim(fgets(STDIN));

    echo "Tipo: ";
    $tipo=trim(fgets(STDIN));

    echo "Daño Base: ";
    $danio=trim(fgets(STDIN));

    echo "Nivel mínimo: ";
    $nivel=trim(fgets(STDIN));

    echo "Estado del arma (disponible,equipada,rota): ";
    $estado=trim(fgets(STDIN));
    if($estado=="equipada"){
        echo "No se puede crear un arma ya equipada, primero cree un arma y luego la equipa"."\n";
    }else{
    //Correcion: Ahora se puede agregar el arma con el atributo $estado, ya sea disponible o rota.
    $arma = new Arma(
        null,
        $nombre,
        $tipo,
        $danio,
        $nivel,
        $estado);

        $torneo->registrarNuevaArma($arma);

        echo "Arma registrada correctamente.\n";
    }
break;

case 3:
    echo "//////_ [3. Registar Arenas] _//////\n\n";

     echo "Nombre: ";
    $nombre = trim(fgets(STDIN));

    echo "Dificultad: ";
    $dificultad = trim(fgets(STDIN));

    echo "Capacidad de público: ";
    $capacidad = (int)trim(fgets(STDIN));

    echo "Clima: ";
    $clima = trim(fgets(STDIN));

    $arena = new Arena(
        null,
        $nombre,
        $dificultad,
        $capacidad,
        $clima
    );

    $torneo->registrarNuevaArena($arena);

    echo "Arena registrada correctamente.\n";
break;

case 4:
    echo "//////_ [4. Equipar Arma a Personaje] _//////\n";

    echo "ID del personaje: ";
    $idPersonaje = (int)trim(fgets(STDIN));

    echo "ID del arma: ";
    $idArma = (int)trim(fgets(STDIN));

    $personaje = $torneo->buscarPersonajePorId($idPersonaje);
    $arma = $torneo->buscarArmaPorId($idArma);

    if($personaje != null && $arma != null){

        if($torneo->equiparArma($personaje,$arma)){
            $torneo->guardarCambios();
            echo "Arma equipada correctamente.\n";
        }else{
            echo "No fue posible equipar el arma.\n";
        }

    }else{
        echo "Personaje o arma inexistente.\n";
    }
break;
//MODIFICACION PARA VER QUE PERSONAJES PUEDEN ESTAN DISPONIBLES
case 5:
    echo "//////_ [5. Registrar Duelos] _//////\n";

    
      echo "\nPersonajes disponibles para duelar:\n";

    $disponibles = $torneo->listarPersonajesDisponibleParaDuelar();

    if(count($disponibles) < 2){
        echo "No hay suficientes personajes disponibles para realizar un duelo.\n";
        break;
    }

    foreach($disponibles as $p){
        echo "ID: ".$p->getID()." - ".$p->getNombre()."\n";
    }

    echo "\nID del Personaje 1: ";
    $idP1 = (int)trim(fgets(STDIN));

    echo "ID del Personaje 2: ";
    $idP2 = (int)trim(fgets(STDIN));

    if($idP1 == $idP2){
        echo "Los personajes deben ser distintos.\n";
        break;
    }

    echo "\nArenas disponibles:\n";

    foreach($torneo->getArenas() as $arena){
        echo "ID: ".$arena->getIdArena()." - ".$arena->getNombre()."\n";
    }

    echo "\nID de la Arena: ";
    $idArena = (int)trim(fgets(STDIN));

    $personaje1 = $torneo->buscarPersonajePorId($idP1);
    $personaje2 = $torneo->buscarPersonajePorId($idP2);
    $arena = $torneo->buscarArenaPorId($idArena);

    if($personaje1 != null && $personaje2 != null && $arena != null){

        $duelo = new Duelo(
            null,
            $personaje1,
            $personaje2,
            $arena,
            date("Y-m-d"),
            "pendiente"
        );

        $torneo->registrarNuevoDuelo($duelo);

        echo "Duelo registrado correctamente.\n";

    }else{
        echo "Datos inválidos.\n";
    }

break;
//MENSAJE MENSAJE FINALIZAR DUELO EXTENDIDO Y CORREGIDO
case 6:
    echo "//////_ [6. Ejecutar Duelo Pendiente] _//////\n";
 $pendientes = $torneo->mostrarDuelosPendientes();

    if(count($pendientes)==0){

        echo "No existen duelos pendientes.\n";

    }else{

        foreach($pendientes as $duelo){
            echo "ID: ".$duelo->getIdDuelo().
                 " - ".$duelo->getPersonaje1()->getNombre().
                 " vs ".$duelo->getPersonaje2()->getNombre()."\n";
        }

        echo "ID del duelo: ";
        $idDuelo = (int)trim(fgets(STDIN));

        $encontrado = false;

        foreach($pendientes as $duelo){

            if($duelo->getIdDuelo() == $idDuelo){

                $encontrado = true;

                if($torneo->realizarDuelo($duelo)){
                    echo "///_RESULATDO DEL DUELO_///\n";

                    if($duelo->getGanador() != null){
                        echo "Ganador: ".$duelo->getGanador()->getNombre()."\n";
                        
                    }else{
                        echo "El duelo terminó empatado.\n";
                    }
                   echo "\n--- ".$duelo->getPersonaje1()->getNombre()." ---\n";
                   echo "Vida: ".$duelo->getPersonaje1()->getPuntosVida()."\n";
                   echo "Energía: ".$duelo->getPersonaje1()->getEnergia()."\n";
                   echo "Ganados: ".$duelo->getPersonaje1()->getDuelosGanados()."\n";
                   echo "Perdidos: ".$duelo->getPersonaje1()->getDuelosPerdidos()."\n";
                   echo "\n--- ".$duelo->getPersonaje2()->getNombre()." ---\n";
                   echo "Vida: ".$duelo->getPersonaje2()->getPuntosVida()."\n";
                   echo "Energía: ".$duelo->getPersonaje2()->getEnergia()."\n";
                   echo "Ganados: ".$duelo->getPersonaje2()->getDuelosGanados()."\n";
                   echo "Perdidos: ".$duelo->getPersonaje2()->getDuelosPerdidos()."\n";   

                }else{
                    echo "El duelo no pudo realizarse y fue cancelado.\n";
                }

                break;
            }
        }

        if(!$encontrado){
            echo "No existe un duelo pendiente con ese ID.\n";
        }

    }
break;
 

case 7:
    echo "//////_ [7. Recuperar Personaje Lesionado] _//////\n";

    echo "ID del personaje: ";
    $id=(int)trim(fgets(STDIN));

    $personaje=$torneo->buscarPersonajePorId($id);

    if($personaje!=null){

        if($personaje->getEstado()=="lesionado"){

            $personaje->recuperarVida(100);
            $torneo->guardarCambios();

            echo "Personaje recuperado correctamente.\n";

        }else{

            echo "El personaje no se encuentra lesionado.\n";
        }

    }else{

        echo "Personaje inexistente.\n";
    }
break;

case 8:
    echo "//////_ [8. Consultas y Rankings] _//////\n";
    mostrarSubmenuConsultas($torneo);
break;

case 9:
    echo "Gracias por utilizar el sistema.\n";
break;
//OPCION != BUSCAR PERSONAJE POR ID
case 10:
    echo "//////_[10. Buscar Personaje por ID]_//////\n";

    echo "Personajes registrados:\n";

    foreach($torneo->getPersonajes() as $p){
        echo "ID: ".$p->getID()." - ".$p->getNombre()."\n";
    }

    echo "\nIngrese el ID del personaje: ";
    $id = (int)trim(fgets(STDIN));

    $personaje = $torneo->buscarPersonajePorId($id);

    if($personaje != null){
        echo "\n".$personaje;
    }else{
        echo "No existe un personaje con ese ID.\n";
    }

break;
    }

} while ($opcion != 9); //Sale del bucle una vez ingresas 9(imprimes)

 
function mostrarSubmenuConsultas($torneo) {
    $subOpcion = 0;
    do {
        echo "\n////////////////////////////////////////\n";
        echo "        SUBMENÚ DE CONSULTAS (Pto 8)      \n";
        echo "//////////////////////////////////////////\n";
        echo "1. Listar todos los personajes\n";
        echo "2. Listar personajes disponibles para duelar\n";
        echo "3. Listar personajes lesionados\n";
        echo "4. Listar personajes retirados\n";
        echo "5. Listar armas disponibles\n";
        echo "6. Mostrar el arma equipada por cada personaje\n";
        echo "7. Mostrar todos los duelos realizados\n";
        echo "8. Mostrar todos los duelos pendientes\n";
        echo "9. Mostrar el historial de duelos de un personaje\n";
        echo "10. Mostrar ranking por victorias\n";
        echo "11. Mostrar personaje con más victorias\n";
        echo "12. Mostrar porcentaje de victorias\n";
        echo "13. Mostrar arena más utilizada\n";
        echo "14. << Volver al Menú Principal\n";
        echo "-----------------------------------------\n";
        
          echo "Seleccione una consulta (1-14): ";
        $subOpcion = (int)trim(fgets(STDIN));

        echo "\n";

        switch ($subOpcion) {

            case 1:
                echo "///_[Listado de Todos los Personajes]_///\n";
                foreach ($torneo->getPersonajes() as $p) {
                    echo $p . "\n";
                }
                break;

            case 2:
                echo "///_[Personajes Disponibles]_///\n";
                foreach ($torneo->getPersonajes() as $p) {
                    if ($p->getEstado() == "disponible") {
                        echo "- " . $p->getNombre() . "\n";
                    }
                }
                break;

            case 3:
                echo "///_[Personajes Lesionados]_///\n";
                foreach ($torneo->getPersonajes() as $p) {
                    if ($p->getEstado() == "lesionado") {
                        echo "- " . $p->getNombre() . "\n";
                    }
                }
                break;

            case 4:
                echo "///_[Personajes Retirados]_///\n";
                foreach ($torneo->listarPersonajesRetirados() as $p) {
                    echo $p . "\n";
                }
                break;

            case 5:
                echo "///_[Armas Disponibles]_///\n";
                foreach ($torneo->getArmas() as $a) {
                    if ($a->getEstado() == "disponible") {
                        echo "- " . $a->getNombre() . "\n";
                    }
                }
                break;

            case 6:
                echo "///_[Armas Equipadas]_///\n";
                echo $torneo->mostrarArmaPersonajes();
                break;

            case 7:
                echo "///_[Duelos Realizados]_///\n";
                 $resultado = $torneo->consultaDuelosRealizados();

                if($resultado != ""){
                echo $resultado;
                }else{
                echo "No existen duelos realizados.\n";
                }
                break;

            case 8:
                echo "///_[Duelos Pendientes]_///\n";
                foreach ($torneo->mostrarDuelosPendientes() as $d) {
                    echo $d . "\n";
                }
                break;

            case 9:
                echo "///_[Historial De Duelos De Un Personaje]_///\n";
                echo "Ingrese ID del personaje: ";
                $id = (int)trim(fgets(STDIN));

                $historial = $torneo->historialDeDuelosdeUnPersonaje($id);

                foreach ($historial as $d) {
                    echo $d . "\n";
                }
                break;

            case 10:
                echo "///_[ Mostrar el ranking de personajes ordenado por cantidad de victorias]_///\n";
                echo "--- Ranking ---\n";
                foreach ($torneo->rankingPersonajes() as $p) {
                    echo $p->getNombre() . " - " . $p->getDuelosGanados() . " victorias\n";
                }
                break;

            case 11:
                echo "///_[ Mostrar el ranking de personajes ordenado por cantidad de victorias]_///\n";
                echo "--- Máximo ganador ---\n";
                $ganador = $torneo->personajeConMaximasVictorias();

                if ($ganador != null) {
                    echo $ganador->getNombre() . " - " . $ganador->getDuelosGanados() . " victorias\n";
                }
                break;

            case 12:
                echo "///_[ porcentaje de victorias de cada personaje]_///\n";
                echo "--- Porcentaje de victorias ---\n";
                echo $torneo->mostrarPorcentajeDeVictorias();
                break;

            case 13:
                echo "///_[Arena donde más duelos se realizaron]_///\n";
                echo "--- Arena más utilizada ---\n";
                $arena = $torneo->mostrarArenaConMaximosDuelos();

                if ($arena != null) {
                    echo $arena;
                } else {
                    echo "Todavía no hay duelos registrados.\n";
                }
                break;

            case 14:
                echo "Volviendo al Menú Principal...\n";
                break;

            default:
                echo "Opción inválida.\n";
                break;
        }

    } while ($subOpcion != 14);
}

 
?>

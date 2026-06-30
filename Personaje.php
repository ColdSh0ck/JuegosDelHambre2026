  <?php
abstract class Personaje {
//protected para poder usarlos de manera directa.
    protected $id;
    protected $nombre;
    protected $nivel;
    protected $puntosVida;
    protected $energia;
    protected $duelosGanados;
    protected $duelosPerdidos;
    protected $estado; 
    protected $arma;  

    //inicializarse en 0 por defecto 
    public function __construct($nombre, $nivel, $puntosVida, $energia, $estado = "disponible",$id=null)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->nivel = $nivel;
        $this->puntosVida = $puntosVida;
        $this->energia = $energia;
        $this->duelosGanados = 0; 
        $this->duelosPerdidos = 0;
        $this->estado = $estado;
        $this->arma = null; // Inicializa sin arma al crearse
    }

    public function __toString(){
        return "ID: " . $this->id . "\n" .
               "Nombre: " . $this->nombre . "\n" .
               "Nivel: " . $this->nivel . "\n" .
               "Puntos De Vida: " . $this->puntosVida . "\n" .
               "Energia: " . $this->energia . "\n" .
               "Duelos Ganados: " . $this->duelosGanados . "\n" .
               "Duelos Perdidos: " . $this->duelosPerdidos . "\n" .
               "Estado: " . $this->estado . "\n" .
               "Arma: " . ($this->arma ? $this->arma->getNombre() : "Ninguna") . "\n";
    }

    //Metodo que verifica si 2 objetos son iguales por su id.
    public function equals($otroPersonaje){
        $esIgual=false;
        $idOtroPer=$otroPersonaje->getID();
        if($this->getID()==$idOtroPer){
            $esIgual=true;
        }
    return $esIgual;
    }

    //Metodos  getter y setters.
    public function getID(){ return $this->id; }
    public function setID($id){ $this->id = $id; }
    public function getNombre(){ return $this->nombre; }
    public function setNombre($name){ $this->nombre = $name; }
    public function getNivel(){ return $this->nivel; }
    public function setNivel($level){ $this->nivel = $level; }
    public function getPuntosVida(){ return $this->puntosVida; }
    public function setPuntosVida($point){ $this->puntosVida = $point; }
    public function getEnergia(){ return $this->energia; }
    public function setEnergia($energy){ $this->energia = $energy; }
    public function getDuelosGanados(){ return $this->duelosGanados; }
    public function setDuelosGanados($ganados){ $this->duelosGanados = $ganados; }
    public function getDuelosPerdidos(){ return $this->duelosPerdidos; }
    public function setDuelosPerdidos($perdidos){ $this->duelosPerdidos = $perdidos; }
    public function getEstado(){return $this->estado; }
    public function setEstado($status){ $this->estado = $status; }
    public function getArma(){ return $this->arma; }
    public function setArma($arma){ $this->arma = $arma; }

 
 
    public function recibirDanio($cantidad) {
        $this->puntosVida -= $cantidad;
        if ($this->puntosVida <= 0) {
            $this->puntosVida = 0;
            $this->estado = "retirado";
        } elseif ($this->puntosVida > 0 && $this->puntosVida <= 30) {
            $this->estado = "lesionado";
        }
    }

    public function recuperarVida($cantidad) {
        if ($this->estado !== "retirado") {
            $this->puntosVida += $cantidad;
            if ($this->puntosVida > 30 && $this->estado === "lesionado") {
                $this->estado = "disponible";
            }
        }
    }

    public function recuperarEnergia($cantidad) {
        $this->energia += $cantidad;
    }
    //Aca SE podria haber usado esta funcion
    public function puedeDuelar() {
        return $this->estado === "disponible";
    }

    public function calcularPoderTotal() {
        $danioArma = 0;
       
        if ($this->arma !== null) {
            $danioArma = $this->arma->calcularDanio();
        }
        return $this->calcularPoderBase() + $this->calcularPoderEspecial() + $danioArma;
    }
 
    abstract public function calcularPoderBase();
    abstract public function calcularPoderEspecial();
}
?>
 
 

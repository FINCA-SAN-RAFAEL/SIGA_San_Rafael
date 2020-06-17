<?php


namespace app\modelos;
require('BasicModel.php');

class tipo_alimento
{
    private $id_tipo_alimento;
    private $nombre;
    private $observaciones;


    /**
     * Usuarios constructor.
     * @param $id_tipo_alimento
     * @param $nombre
     * @param $observaciones

     */
    public function __construct($tipo_alimento = array())
{
    parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
    $this->id_tipo_alimento = $tipo_alimento['id_tipo_alimento'] ?? null;
    $this->nombre = $tipo_alimento['nombre'] ?? null;
    $this->observaciones = $tipo_alimento['observaciones'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_tipo_alimento() : int
    {
        return $this->id_tipo_alimento;
    }

    /**
     * @param int $id_tipo_alimento
     */
    public function setid_tipo_alimento(int $id_tipo_alimento): void
    {
        $this->id_tipo_alimento = $id_tipo_alimento;
    }

    /**
     * @return string
     */
    public function getnombre() : string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setnombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return string
     */
    public function getobservaciones() : string
    {
        return $this->observaciones;
    }

    /**
     * @param string $observaciones
     */
    public function setobservaciones(string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.tipo_alimento VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->observaciones

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael-1803586.tipo_alimento SET nombre = ?, observaciones = ? WHERE id_tipo_alimento = ?", array(
                $this->nombre,
                $this->observacioness,
                $this->id_tipo_alimento
            )
        );
        $this->Disconnect();
        return $result;
    }
    public function deleted($id) : void
    {
        // TODO: Implement deleted() method.
    }
    public static function search($query) : array
{
    $arrtipo_alimento = array();
    $tmp = new tipo_alimento();
    $getrows = $tmp->getRows($query);

    foreach ($getrows as $valor) {
        $tipo_alimento = new tipo_alimento();
        $tipo_alimento->id_tipo_alimento = $valor['id_tipo_alimento'];
        $tipo_alimento->nombre = $valor['nombre'];
        $tipo_alimento->observaciones = $valor['observaciones'];
        $tipo_alimento->Disconnect();
        array_push($arrtipo_alimento, $tipo_alimento);
    }
    $tmp->Disconnect();
    return $arrtipo_alimento;
}
    public static function searchForid_tipo_alimento($id_tipo_alimento) : tipo_alimento
    {
        $tipo_alimento = null;
        if ($id_tipo_alimento > 0){
            $tipo_alimento = new tipo_alimento();
            $getrow = $tipo_alimento->getRow("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.tipo_alimento WHERE id_tipo_alimento =?", array($id_tipo_alimento));
            $tipo_alimento->id_tipo_alimento = $getrow['id_tipo_alimento'];
            $tipo_alimento->nombre = $getrow['nombre'];
            $tipo_alimento->observacionesnes = $getrow['obsevaciones'];

        }
        $tipo_alimento->Disconnect();
        return $tipo_alimento;
    }

    public static function getAll() : array
    {
        return tipo_alimento::search("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.tipo_alimento");
    }

    public static function tipo_alimentoRegistrado ($nombre) : bool
    {
        $result = tipo_alimento::search("SELECT id FROM Proyecto-Finca-San-Rafael-1803586.tipo_alimento where nombre = ".$nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
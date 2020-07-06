<?php


namespace app\models;
require('BasicModel.php');

class





TipoAlimento
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
    $this->nombre = $TipoAlimento['nombre'] ?? null;
    $this->observaciones = $TipoAlimento['observaciones'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_TipoAlimento() : int
    {
        return $this->id_tipo_alimento;
    }

    /**
     * @param int $id_tipo_alimento
     */
    public function setid_TipoAlimento(int $id_tipo_alimento): void
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
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.TipoAlimento VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->observaciones

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael-1803586.TipoAlimento SET nombre = ?, observaciones = ? WHERE id_tipo_alimento = ?", array(
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
    $arrTipoAlimento = array();
    $tmp = new TipoAlimento();
    $getrows = $tmp->getRows($query);

    foreach ($getrows as $valor) {
        $TipoAlimento = new TipoAlimento();
        $TipoAlimento->id_tipo_alimento = $valor['id_tipo_alimento'];
        $TipoAlimento->nombre = $valor['nombre'];
        $TipoAlimento->observaciones = $valor['observaciones'];
        $TipoAlimento->Disconnect();
        array_push($arrTipoAlimento, $TipoAlimento);
    }
    $tmp->Disconnect();
    return $arrTipoAlimento;
}
    public static function searchForid_TipoAlimento($id_tipo_alimento) : TipoAlimento
    {
        $TipoAlimento = null;
        if ($id_tipo_alimento > 0){
            $TipoAlimento = new TipoAlimento();
            $getrow = $TipoAlimento->getRow("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.TipoAlimento WHERE id_tipo_alimento =?", array($id_tipo_alimento));
            $TipoAlimento->id_tipo_alimento = $getrow['id_tipo_alimento'];
            $TipoAlimento->nombre = $getrow['nombre'];
            $TipoAlimento->observaciones = $getrow['obsevaciones'];

        }
        $TipoAlimento->Disconnect();
        return $TipoAlimento;
    }

    public static function getAll() : array
    {
        return TipoAlimento::search("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.TipoAlimento");
    }

    public static function TipoAlimentoRegistrado ($nombre) : bool
    {
        $result = TipoAlimento::search("SELECT id FROM Proyecto-Finca-San-Rafael-1803586.TipoAlimento where nombre = ".$nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
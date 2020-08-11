<?php


namespace App\models;

require('BasicModel.php');

class TipoAlimento extends BasicModel
{
    private $id_tipo_alimlimento;
    private $nombre;
    private $observaciones;


    public function __construct($TipoAlimento = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_tipo_alimlimento = $TipoAlimento['id_tipo_alimento'] ?? null;
        $this->nombre = $TipoAlimento['nombre'] ?? null;
        $this->observaciones = $TipoAlimento['observaciones'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return mixed|null
     */
    public function getId(): ? int
    {
        return $this->id_tipo_alimlimento;
    }

    /**
     * @param mixed|null $id_tipo_alimlimento
     */
    public function setIdTipoalimlimento(?mixed $id_tipo_alimlimento): void
    {
        $this->id_tipo_alimlimento = $id_tipo_alimlimento;
    }

    /**
     * @return mixed|null
     */
    public function getNombre(): ? String
    {
        return $this->nombre;
    }

    /**
     * @param mixed|null $nombre
     */
    public function setNombre(?mixed $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed|null
     */
    public function getObservaciones(): ?String
    {
        return $this->observaciones;
    }

    /**
     * @param mixed|null $observaciones
     */
    public function setObservaciones(?mixed $observaciones): void
    {
        $this->observaciones = $observaciones;
    }




    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.tipo_alimento VALUES (NULL, ?, ?)", array(
                $this->nombre,
                $this->observaciones
            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.tipo_alimento SET nombre = ?, observaciones = ? WHERE id_tipo_alimento = ?", array(
                $this->nombre,
                $this->observaciones,
                $this->id_tipo_alimlimento


            )
        );
        $this->Disconnect();
        return $result;
    }
    public function deleted($id) : void    {
        // TODO: Implement deleted() method.
    }
    public static function search($query) : array
    {
        $arrTipoAlimento = array();
        $tmp = new TipoAlimento();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $TipoAlimento = new TipoAlimento();
            $TipoAlimento->id_tipo_alimlimento  = $valor['id_tipo_alimento'];
            $TipoAlimento->nombre = $valor['nombre'];
            $TipoAlimento->observaciones = $valor['observaciones'];
            $TipoAlimento->Disconnect();
            array_push($arrTipoAlimento, $TipoAlimento);
        }
        $tmp->Disconnect();
        return $arrTipoAlimento;
    }
    public static function searchForId($id_tipo_alimento) : TipoAlimento
    {
        $TipoAlimento = null;
        if ($id_tipo_alimento > 0){
            $TipoAlimento= new TipoAlimento();
            $getrow = $TipoAlimento->getRow("SELECT * FROM fincasanrafael1.tipo_alimento WHERE id_tipo_alimento =?", array($id_tipo_alimento));
            $TipoAlimento->id_tipo_alimlimento = $getrow['id_tipo_alimento'];
            $TipoAlimento->nombre = $getrow['nombre'];
            $TipoAlimento->observaciones = $getrow['observaciones'];

        }
        $TipoAlimento->Disconnect();
        return $TipoAlimento;
    }

    public static function getAll() : array
    {
        return TipoAlimento::search("SELECT * FROM fincasanrafael1.tipo_alimento");
    }

    public static function TipoAlimentoRegistrado($nombre) : bool
    {
        $result = TipoAlimento::search("SELECT nombre FROM fincasanrafael1.tipo_alimento where nombre = ' ".$nombre."'");
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
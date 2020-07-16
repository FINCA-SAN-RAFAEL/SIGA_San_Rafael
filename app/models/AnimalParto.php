<?php


namespace app\models;
require('BasicModel.php');

class AnimalParto
{
    private $id_animales_parto;
    private $estado_nacimiento;
    private $fecha_parto;
    private $observaciones;

    /**
     * Usuarios constructor.
     * @param $id_animales_parto
     * @param $estado_nacimiento
     * @param $fecha_parto
     * @param $observaciones

     */
    public function __construct($AnimalParto = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_animales_parto = $AnimalParto['id_animales_parto'] ?? null;
        $this->estado_nacimiento = $AnimalParto['estado_nacimiento'] ?? null;
        $this->fecha_parto = $AnimalParto['fecha_parto'] ?? null;
        $this->observaciones = $AnimalParto['observaciones'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_animales_parto() : int
    {
        return $this->id_animales_parto;
    }

    /**
     * @param int $id_animales_parto
     */
    public function setid_animales_parto(int $id_animales_parto): void
    {
        $this->id_animales_parto = $id_animales_parto;
    }

    /**
     * @return string
     */
    public function getestado_nacimiento() : string
    {
        return $this->estado_nacimiento;
    }

    /**
     * @param string $estado_nacimiento
     */
    public function setestado_nacimiento(string $estado_nacimiento): void
    {
        $this->estado_nacimiento = $estado_nacimiento;
    }


    /**
     * @return string
     */
    public function getfecha_parto() : string
    {
        return $this->fecha_parto;
    }

    /**
     * @param string $fecha_parto
     */
    public function setfecha_parto(string $fecha_parto): void
    {
        $this->fecha_parto = $fecha_parto;
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
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.AnimalParto VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->estado_nacimiento,
                $this->fecha_parto,
                $this->observaciones

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael.AnimalParto SET estado_nacimiento = ?, fecha_parto = ?, observaciones = ? WHERE id_animales_parto = ?", array(
                $this->estado_nacimiento,
                $this->fecha_parto,
                $this->observaciones,
                $this->id_animales_parto
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
        $arrAnimalParto = array();
        $tmp = new AnimalParto();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $AnimalParto = new AnimalParto();
            $AnimalParto->id_animales_parto = $valor['id_animales_parto'];
            $AnimalParto->Estado_Nacimiento = $valor['Estado Nacimiento'];
            $AnimalParto->Fecha_Parto = $valor['Fecha Parto'];
            $AnimalParto->observaciones = $valor['observaciones'];
            $AnimalParto>Disconnect();
            array_push($arrAnimalParto, $AnimalParto);
        }
        $tmp->Disconnect();
        return $arrAnimalParto;
    }
    public static function searchForid_animales_parto($id_animales_parto) : AnimalParto
    {
        $AnimalParto = null;
        if ($id_animales_parto > 0){
            $AnimalParto = new AnimalParto();
            $getrow = $AnimalParto->getRow("SELECT * FROM Proyecto-Finca-San-Rafael.AnimalParto WHERE id_animales_parto =?", array($id_animales_parto));
            $AnimalParto->id_animales_parto = $getrow['id_animales_parto'];
            $AnimalParto->estado_nacimiento = $getrow['Estado Nacimiento'];
            $AnimalParto->fecha_parto = $getrow['Fecha Parto'];
            $AnimalParto->observaciones = $getrow['obsevaciones'];

        }
        $AnimalParto->Disconnect();
        return $AnimalParto;
    }

    public static function getAll() : array
    {
        return AnimalParto::search("SELECT * FROM Proyecto-Finca-San-Rafael.AnimalParto");
    }

    public static function AnimalPartoRegistrado ($EstadoNacimiento) : bool
    {
        $result = AnimalParto::search("SELECT id FROM Proyecto-Finca-San-Rafael.AnimalParto where EstadoNacimiento = ".$EstadoNacimiento);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}
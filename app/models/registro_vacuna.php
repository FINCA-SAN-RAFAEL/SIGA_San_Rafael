<?php

namespace app\models;

require('BasicModel.php');

class registro_vacuna extends BasicModel
{
    private $id_registro_vacuna;
    private $dosis;
    private $fecha;
    private $observaciones;

    /* Relaciones */
    private $animal;
    private $lote_vacuna;

    /**
     * registro_vacuna constructor.
     * @param $id_registro_vacuna
     * @param $dosis
     * @param $fecha
     * @param $observaciones

     */
    public function __construct($registro_vacuna = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_registro_vacuna = $registro_vacuna['id_regidtro_vacunao'] ?? null;
        $this->dosis = $registro_vacuna['nombre'] ?? null;
        $this->fecha = $registro_vacuna['fecha'] ?? null;
        $this->observaciones = $registro_vacuna['observaciones'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_registro_vacuna() : int
    {
        return $this->id_registro_vacuna;
    }

    /**
     * @param int $id_registro_vacuna
     */
    public function setid_registro_vacuna(int $id_registro_vacuna): void
    {
        $this->id_registro_vacuna = $id_registro_vacuna;
    }

    /**
     * @return string
     */
    public function getdosis() : string
    {
        return $this->dosis;
    }

    /**
     * @param string $dosis
     */
    public function setdosis(string $dosis): void
    {
        $this->dosis = $dosis;
    }

    /**
     * @return string
     */
    public function getfecha() : string
    {
        return $this->fecha;
    }

    /**
     * @param string $fecha
     */
    public function setfecha(string $fecha): void
    {
        $this->fecha = $fecha;
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

    /**
     * @return mixed
     */
    public function getanimal()
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     */
    public function setanimal($animal): void
    {
        $this->animal = $animal;
    }

    /**
     * @return mixed
     */
    public function lote_vacuna()
    {
        return $this->lote_vacuna;
    }

    /**
     * @param mixed $lote_vacuna
     */
    public function setlote_vacuna($lote_vacuna): void
    {
        $this->lote_vacuna = $lote_vacuna;
    }


    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO SIGA_San_Rafael.registro_vacuna VALUES (NULL, ?, ?, ?)", array(
                $this->dosis,
                $this->fecha,
                $this->observaciones

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE SIGA_San_Rafael.registro_vacuna SET dosis = ?, fecha = ?, observaciones = ? WHERE id_registro_vacuna = ?", array(
                $this->dosis,
                $this->fecha,
                $this->observaciones,
                $this->id_registro_vacuna
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
        $arrregistro_vacuna = array();
        $tmp = new registro_vacuna();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $registro_vacuna = new registro_vacuna();
            $registro_vacuna->id_tipo_alimento = $valor['id_registro_vacuna'];
            $registro_vacuna->dosis = $valor['dosis'];
            $registro_vacuna->fecha = $valor['fecha'];
            $registro_vacuna->observaciones = $valor['observaciones'];
            $registro_vacuna->Disconnect();
            array_push($arrregistro_vacuna, $registro_vacuna);
        }
        $tmp->Disconnect();
        return $arrregistro_vacuna;
    }
    public static function searchForid_registro_vacuna($id_registro_vacuna) : registro_vacuna
    {
        $registro_vacuna = null;
        if ($id_registro_vacuna > 0){
            $registro_vacuna = new tipoAlimento();
            $getrow = $registro_vacuna->getRow("SELECT * FROM SIGA_San_Rafael.registro_vacuna WHERE id_registro_vacuna =?", array($id_registro_vacuna));
            $registro_vacuna->id_registro_vacuna = $getrow['id_registro_vacuna'];
            $registro_vacuna->dosis = $getrow['dosis'];
            $registro_vacuna->fecha = $getrow['fecha'];
            $registro_vacuna->observacionesnes = $getrow['obsevaciones'];

        }
        $registro_vacuna->Disconnect();
        return $registro_vacuna;
    }

    public static function getAll() : array
    {
        return registro_vacuna::search("SELECT * FROM SIGA_San_Rafael.registro_vacuna");
    }

    public static function registro_vacunaRegistrado ($id_registro_vacuna) : bool
    {
        $result = registro_vacuna::search("SELECT id_registro_vacuna FROM SIGA_San_Rafael.registro_vacuna where id_registro_vacuna = ".$id_registro_vacuna);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}

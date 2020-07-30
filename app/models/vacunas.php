<?php


namespace app\models;
require('BasicModel.php');

class vacunas
{
    private $id_vacunas;
    private $nombre;
    private $descripcion;
    private $periosidad;

    /**
     * Usuarios constructor.
     * @param $id_vacunas
     * @param $nombre
     * @param $descripcion
     * @param $periosidad

     */
    public function __construct($vacunas = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_vacunas = $vacunas['id_vacunas'] ?? null;
        $this->nombre = $vacunas['nombre'] ?? null;
        $this->descripcion = $vacunas['descripcion'] ?? null;
        $this->periosidad = $vacunas['periosidad'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_vacunas() : int
    {
        return $this->id_vacunas;
    }

    /**
     * @param int $id_vacunas
     */
    public function setid_vacunas(int $id_vacunas): void
    {
        $this->id_vacunas = $id_vacunas;
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
    public function getdescripcion() : string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setdescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }
    /**
     * @return string
     */
    public function getperiosidad() : string
    {
        return $this->periosidad;
    }

    /**
     * @param string $periosidad
     */
    public function setperiosidad(string $periosidad): void
    {
        $this->periosidad = $periosidad;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.vacunas VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->descripcion,
                $this->periosidad,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael.vacunas SET nombre = ?, descripcion = ?, periosidad = ? WHERE id_vacunas = ?", array(
                $this->nombre,
                $this->descripcion,
                $this->periosidad,
                $this->id_vacunas
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
        $arrvacunas = array();
        $tmp = new vacunas();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $vacunas = new vacunas();
            $vacunas->id_vacunas = $valor['id_vacunas'];
            $vacunas->nombre = $valor['nombre'];
            $vacunas->descripcion = $valor['descripcion'];
            $vacunas->periosidad = $valor['periosidad'];
            $vacunas->Disconnect();
            array_push($arrvacunas, $vacunas);
        }
        $tmp->Disconnect();
        return $arrvacunas;
    }
    public static function searchForid_vacunas($id_vacunas) : vacunas
    {
        $vacunas = null;
        if ($id_vacunas > 0){
            $vacunas = new vacunas();
            $getrow = $vacunas->getRow("SELECT * FROM SIGA_San_Rafael.vacunas WHERE id_vacunas =?", array($id_vacunas));
            $vacunas->id_vacunas = $getrow['id_vacunas'];
            $vacunas->nombre = $getrow['nombre'];
            $vacunas->descripcion = $getrow['descripcion'];
            $vacunas->periosidad = $getrow['periosidad'];

        }
        $vacunas->Disconnect();
        return $vacunas;
    }

    public static function getAll() : array
    {
        return vacunas::search("SELECT * FROM SIGA_San_Rafael.vacunas");
    }

    public static function vacunasRegistrado ($nombre) : bool
    {
        $result = vacunas::search("SELECT id FROM SIGA_San_Rafaell.vacunas where nombre = ".$nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

}
<?php

namespace app\models;

require('BasicModel.php');

class Especie
{
    private $id_especie;
    private $nombre;
    private $especie;

    /**
     * Usuarios constructor.
     * @param $id_especie
     * @param $nombre
     * @param $especie

     */
    public function __construct($Especie = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_especie = $Especie['id_especie'] ?? null;
        $this->nombre = $Especie['nombre'] ?? null;
        $this->especie = $Especie['especie'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_especie() : int
    {
        return $this->id_especie;
    }

    /**
     * @param int $id_especie
     */
    public function setid_especie(int $id_especie): void
    {
        $this->id_especie = $id_especie;
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
    public function getespecie() : string
    {
        return $this->especie;
    }

    /**
     * @param string $especie
     */
    public function setespecie(string $especie): void
    {
        $this->especie = $especie;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.especie VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->especie,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael-1803586.especie SET nombre = ?, especie = ? WHERE id_especie = ?", array(
                $this->nombre,
                $this->especie,
                $this->id_especie
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
        $arrEspecie = array();
        $tmp = new Especie();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Especie = new Especie();
            $Especie->id_especie = $valor['id_especie'];
            $Especie->nombre = $valor['nombre'];
            $Especie->especie = $valor['especie'];
            $Especie->Disconnect();
            array_push($arrEspecie, $Especie);
        }
        $tmp->Disconnect();
        return $arrEspecie;
    }
    public static function searchForid_especie($id_especie) : Especie
    {
        $Especie = null;
        if ($id_especie > 0){
            $Especie = new Especie();
            $getrow = $Especie->getRow("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.especie WHERE id_especie =?", array($id_especie));
            $Especie->id_especie = $getrow['id_especie'];
            $Especie->nombre = $getrow['nombre'];
            $Especie->especie = $getrow['especie'];

        }
        $Especie->Disconnect();
        return $Especie;
    }

    public static function getAll() : array
    {
        return Especie::search("SELECT * FROM Proyecto-Finca-San-Rafael-1803586.especie");
    }

    public static function especieRegistrado ($nombre) : bool
    {
        $result = Especie::search("SELECT id FROM Proyecto-Finca-San-Rafael-1803586.especie where nombre = ".$nombre);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }
}

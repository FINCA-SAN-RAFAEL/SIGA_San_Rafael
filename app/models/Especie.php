<?php

namespace app\models;

require('BasicModel.php');

class Especie extends BasicModel
{
    private $id;
    private $animal;
    private $Alimentacion;
    private $vacunas;
    private $nombre;
    private $especie;

    /**
     * DetalleVentas constructor.
     * @param $id
     * @param $animal
     * @param $Alimentacion
     * @param $vacunas
     * @param $nombre
     * @param $especie
     */
    public function __construct($animal = array())
    {
        parent::__construct();
        $this->id = $animal['id'] ?? null;
        $this->peso = $animal['peso'] ?? null;
        $this->genero = $animal['genero'] ?? null;
        $this->fecha_nacimiento = $animal['fecha_nacimiento'] ?? null;
        $this->habitos_alimenticios = $animal['habitas_alimenticios'] ?? null;
        $this->observaciones = $animal['observaciones'] ?? null;
    }

    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return mixed|null
     */
    public function getId(): ?mixed
    {
        return $this->id;
    }

    /**
     * @param mixed|null $id
     */
    public function setId(?mixed $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getanimal() : animal
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     */
    public function setanimal(animal $animal): void
    {
        $this->animal = $animal;
    }

    /**
     * @return mixed
     */
    public function getAlimentacion() : Alimentacion
    {
        return $this->Alimentacion;
    }

    /**
     * @param mixed $Alimentacion
     */
    public function setAlimentacion(Alimentacion $Alimentacion): void
    {
        $this->Alimentacion = $Alimentacion;
    }
    /**
     * @return mixed
     */
    public function getvacunas() : vacunas
    {
        return $this->vacunas;
    }

    /**
     * @param mixed $vacunas
     */
    public function setvacunas(vacunas $vacunas): void
    {
        $this->vacunas = $vacunas;
    }

    /**
     * @return mixed
     */
    public function getnombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setnombre($nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getespecie()
    {
        return $this->especie;
    }

    /**
     * @param mixed $especie
     */
    public function setespecie($especie): void
    {
        $this->especie = $especie;
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query)
    {
        $arrEspecie = array();
        $tmp = new Especie();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Especie = new Especie();
            $Especie->id = $valor['id'];
            $Especie->animal = animal::searchForId($valor['animal']);
            $Especie->Alimentacion = Alimentacion::searchForId($valor['Alimentacion']);
            $Especie->vacunas = vacunas::searchForId($valor['vacunas']);
            $Especie->nombre = $valor['nombre'];
            $Especie->especie = $valor['especie'];
            $Especie->Disconnect();
            if(count($getrows) == 1){ // Si solamente hay un registro encontrado devuelve este objeto y no un array
                return $Especie;
            }
            array_push($arrEspecie, $Especie);
        }
        $tmp->Disconnect();
        return $arrEspecie;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return Especie::search("SELECT * FROM fincasanrafael1.Especie");
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id)
    {
        $Especie = null;
        if ($id > 0) {
            $Especie = new Especie();
            $getrow = $Especie->getRow("SELECT * FROM fincasanrafael1.Especie WHERE id =?", array($id));
            $Especie->id = $getrow['id'];
            $Especie->animal = animal::searchForId($getrow['animal']);
            $Especie->Alimentacion = Alimentacion::searchForId($getrow['Alimentacion']);
            $Especie->vacunas = vacunas::searchForId($getrow['vacunas']);
            $Especie->nombre = $getrow['nombre'];
            $Especie->especie = $getrow['especie'];
        }
        $Especie->Disconnect();
        return $Especie;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.Especie VALUES (NULL, ?, ?, ?, ?,?)", array(
                $this->animal->getId(),
                $this->Alimetacion->getId(),
                $this->vacunas,
                $this->nombre,
                $this->especie,
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.Especie SET animal = ?, Alimentacion = ?, vacunas = ?, nombre = ?, especie = ? WHERE id = ?", array(
                $this->animal->getId(),
                $this->Alimentacion->getId(),
                $this->vacunas,
                $this->nombre,
                $this->especie,
                $this->id
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleted($id)
    {
        $Especie = Especie::searchForId($id); //Buscando un usuario por el ID
        $deleterow = $Especie->deleteRow("DELETE FROM Especie WHERE id = ?", array($id));
        return $deleterow;                    //Guarda los cambios..
    }

    /**
     * @param $nombre
     * @return bool
     * @throws \Exception
     */
    public static function EspecieRegistrado($nombre): bool
    {
        $result = Especie::search("SELECT * FROM fincasanrafael1.Especie where nombre =  '" . $nombre."'");
        if ( count ($result) > 0 ) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @param $nombre
     * @return bool
     */
    public static function vacunasEnFactura($vacunas): bool
    {
        $result = vacunas::search("SELECT id FROM fincasanrafael1.Especie where vacunas = '" . $vacunas. "'");
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "animal: $this->animal->getpeso(), Alimentacion: $this->Alimentacion->getnombre(), vacunas: $this->vacunas, Precio Venta: $this->precio_venta";
    }
}
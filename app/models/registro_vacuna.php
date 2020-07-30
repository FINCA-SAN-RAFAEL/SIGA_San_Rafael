<?php

namespace app\models;

require('BasicModel.php');

class registro_vacuna extends BasicModel
{
    private $id;
    private $animal;
    private $lote_vacuna;
    private $dosis;
    private $fecha;
    private $observaciones;

    /**
     * DetalleVentas constructor.
     * @param $id
     * @param $animal
     * @param $lote_vacuna
     * @param $dosis
     * @param $fecha
     * @param $observaciones
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
    public function getlote_vacuna() : lote_vacuna
    {
        return $this->lote_vacuna;
    }

    /**
     * @param mixed $lote_vacuna
     */
    public function setlote_vacuna(lote_vacuna $lote_vacuna): void
    {
        $this->lote_vacuna = $lote_vacuna;
    }

    /**
     * @return mixed
     */
    public function getdosis()
    {
        return $this->dosis;
    }

    /**
     * @param mixed $dosis
     */
    public function setdosis($dosis): void
    {
        $this->dosis = $dosis;
    }

    /**
     * @return mixed
     */
    public function getfecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setfecha($fecha): void
    {
        $this->fecha = $fecha;
    }
    /**
     * @return mixed
     */
    public function getobservaciones()
    {
        return $this->observaciones;
    }

    /**
     * @param mixed $observaciones
     */
    public function setobservaciones($observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query)
    {
        $arrregistro_vacuna = array();
        $tmp = new registro_vacuna();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $registro_vacuna = new registro_vacuna();
            $registro_vacuna->id = $valor['id'];
            $registro_vacuna->animal = animal::searchForId($valor['animal']);
            $registro_vacuna->lote_vacuna = lote_vacuna::searchForId($valor['lote_vacuna']);
            $registro_vacuna->dosis = $valor['dosis'];
            $registro_vacuna->fecha = $valor['fecha'];
            $registro_vacuna->observaciones = $valor['observaciones'];
            $registro_vacuna->Disconnect();
            if(count($getrows) == 1){ // Si solamente hay un registro encontrado devuelve este objeto y no un array
                return $registro_vacuna;
            }
            array_push($arrregistro_vacuna, $registro_vacuna);
        }
        $tmp->Disconnect();
        return $arrregistro_vacuna;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return registro_vacuna::search("SELECT * FROM fincasanrafael1.registro_vacuna");
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id)
    {
        $registro_vacuna = null;
        if ($id > 0) {
            $registro_vacuna = new registro_vacuna();
            $getrow = $registro_vacuna->getRow("SELECT * FROM fincasanrafael1.registro_vacuna WHERE id =?", array($id));
            $registro_vacuna->id = $getrow['id'];
            $registro_vacuna->animal = animal::searchForId($getrow['animal']);
            $registro_vacuna->lote_vacuna = lote_vacuna::searchForId($getrow['lote_vacuna']);
            $registro_vacuna->dosis = $getrow['dosis'];
            $registro_vacuna->fecha = $getrow['fecha'];
            $registro_vacuna->observaciones = $getrow['observaciones'];
        }
        $registro_vacuna->Disconnect();
        return $registro_vacuna;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.registro_vacuna VALUES (NULL, ?, ?, ?, ?,?)", array(
                $this->animal->getId(),
                $this->lote_vacuna->getId(),
                $this->dosis,
                $this->fecha,
                $this->observaciones,
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
        $result = $this->updateRow("UPDATE fincasanrafael1.registro_vacuna SET animal = ?, lote_vacuna = ?, dosis = ?, fecha = ?, observaciones = ? WHERE id = ?", array(
                $this->animal->getId(),
                $this->lote_vacuna->getId(),
                $this->dosis,
                $this->fecha,
                $this->observaciones,
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
        $registro_vacuna = registro_vacuna::searchForId($id); //Buscando un usuario por el ID
        $deleterow = $registro_vacuna->deleteRow("DELETE FROM registro_vacuna WHERE id = ?", array($id));
        return $deleterow;                    //Guarda los cambios..
    }

    /**
     * @param $nombres
     * @return bool
     */
    public static function lote_vacaunaEnFactura($lote_vacuna): bool
    {
        $result = registro_vacuna::search("SELECT id FROM fincasanrafael1.registro_vacuna where lote_vacuna = '" . $lote_vacuna. "'");
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
        return "animal: $this->animal->getpeso(), lote_vacuna: $this->lote_vacuna->getNfecha_compra(), Cantidad: $this->cantidad, Precio Venta: $this->precio_venta";
    }
}

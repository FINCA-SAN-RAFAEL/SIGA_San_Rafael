<?php


namespace app\models;

require('BasicModel.php');

class Lotevacuna
{
    private $id;
    private $fecha_compra;
    private $fecha_vencimiento;
    private $laboratorio;
    private $cantidad;
    private $costo;

    /**
     * LoteVacuna constructor.
     * @param $id_lote_vacuna
     * @param $fecha_compra
     * @param $fecha_vencimiento
     * @param $laboratorio
     * * @param $cantidad
     * @param $costo
     */
    public function __construct($registro_vacuna = array())
    {
        parent::__construct();
        $this->id = $registro_vacuna['id'] ?? null;
        $this->dosis = $registro_vacuna['dosis'] ?? null;
        $this->fecha = $registro_vacuna['fecha'] ?? null;
        $this->observaciones = $registro_vacuna['observaciones'] ?? null;
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
    public function getregistro_vacuna() : registro_vacuna
    {
        return $this->registro_vacuna;
    }

    public static function search($query)
    {
        $arrLoteVacuna = array();
        $tmp = new LoteVacuna();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $LoteVacuna= new LoteVacuna();
            $LoteVacuna->id = $valor['id'];
            $LoteVacuna->fecha_compra = nombre::searchForId($valor['fecha_compra']);
            $LoteVacuna->fecha_vencimiento = LoteVacuna::searchForId($valor['fecha_vencimiento']);
            $LoteVacuna->laboratorio = nombre::searchForId($valor['laboratorio']);
            $LoteVacuna->cantidad = LoteVacuna::searchForId($valor['cantidad']);
            $LoteVacuna->costo = LoteVacuna::searchForId($valor['costo']);
            $LoteVacuna->Disconnect();
            if(count($getrows) == 1){ // Si solamente hay un registro encontrado devuelve este objeto y no un array
                return $LoteVacuna;
            }
            array_push($arrLoteVacuna, $LoteVacuna);
        }
        $tmp->Disconnect();
        return $LoteVacuna;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return LoteVacuna::search("SELECT * FROM fincasanrafael1.LoteVacuna");
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id)
    {
        $LoteVacuna = null;
        if ($id > 0) {
            $LoteVacuna = new LoteVacuna();
            $getrow = $LoteVacuna->getRow("SELECT * FROM fincasanrafael1.LoteVacuna WHERE id =?", array($id));
            $LoteVacuna->id = $getrow['id'];
            $LoteVacuna->fecha_compra = fecha_compra::searchForId($getrow['fecha_compra']);
            $LoteVacuna->fecha_vencimiento = fecha_vencimiento::searchForId($getrow['fecha_vencimiento']);
            $LoteVacuna->laboratorio = laboratorio::searchForId($getrow['laboratorio']);
            $LoteVacuna->cantidad = cantidad::searchForId($getrow['cantidad']);
            $LoteVacuna->costo = costo::searchForId($getrow['costo']);
        }
        $LoteVacuna->Disconnect();
        return $LoteVacuna;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.LoteVacuna VALUES (NULL, ?, ?, ?, ?,?)", array(
                $this->fecha_compra->getId(),
                $this->fecha_vencimiento->getId(),
                $this->laboratorio->getId(),
                $this->cantidad->getId(),
                $this->costo>getId(),
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
        $result = $this->updateRow("UPDATE fincasanrafael1.LoteVacuna SET fecha_compra = ?, fecha_vencimiento = ?, laboratorio = ?, cantidad = ?, costo = ? WHERE id = ?", array(
                $this->fecha_compra->getId(),
                $this->fecha_vencimiento->getId(),
                $this->laboratorio->getId(),
                $this->cantidad->getId(),
                $this->costo>getId(),
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
        $LoteVacuna = LoteVacuna::searchForId($id); //Buscando un usuario por el ID
        $deleterow = $LoteVacuna->deleteRow("DELETE FROM LoteVacuna WHERE id = ?", array($id));
        return $deleterow;                    //Guarda los cambios..
    }

    /**
     * @param $fecha_compra
     * @return bool
     */
    public static function registro_vacunaEnFactura($registro_vacuna): bool
    {
        $result =registro_vacuna ::search("SELECT id FROM fincasanrafael1.LoteVacuna where registro_vacuna = '" . $registro_vacuna. "'");
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
        return "peso: $this->dosis->getdosis(), registro_vacunas: $this->registro_vacuna->getfecha(), observaciones: $this->observaciones";
    }

}
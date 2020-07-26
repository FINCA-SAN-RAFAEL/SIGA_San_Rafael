<?php


namespace app\models;
require('BasicModel.php');

class lotevacuna
{
    private $id_lote_vacuna;
    private $fecha_compra;
    private $fecha_vencimiento;
    private $laboratorio;
    private $cantidad;
    private $costo;

    /**
     * Usuarios constructor.
     * @param $id_lote_vacuna
     * @param $fecha_compra
     * @param $fecha_vencimiento
     * @param $laboratorio
     * @param $cantidad
     * @param $costo

     */
    public function __construct($lotevacuna = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_lote_vacuna = $lotevacuna['id_lote_vacuna'] ?? null;
        $this->fecha_compra = $lotevacuna['fecha_compra'] ?? null;
        $this->fecha_vencimiento = $lotevacuna['fecha_vencimiento'] ?? null;
        $this->laboratorio = $lotevacuna['laboratorio'] ?? null;
        $this->cantidad = $lotevacuna['cantidad'] ?? null;
        $this->costo = $lotevacuna['costo'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct() {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_lote_vacuna() : int
    {
        return $this->id_lote_vacuna;
    }

    /**
     * @param int $id_lote_vacuna
     */
    public function setid_lote_vacuna(int $id_lote_vacuna): void
    {
        $this->id_lote_vacuna = $id_lote_vacuna;
    }

    /**
     * @return string
     */
    public function getfecha_compra() : string
    {
        return $this->fecha_compra;
    }

    /**
     * @param string $fecha_compra
     */
    public function setfecha_compra(string $fecha_compra): void
    {
        $this->fecha_compra = $fecha_compra;
    }

    /**
     * @return string
     */
    public function getfecha_vencimiento() : string
    {
        return $this->fecha_vencimiento;
    }

    /**
     * @param string $fecha_vencimiento
     */
    public function setfecha_vencimiento(string $fecha_vencimiento): void
    {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }
    /**
     * @return string
     */
    public function getlaboratorio() : string
    {
        return $this->laboratorio;
    }

    /**
     * @param string $laboratorio
     */
    public function setlaboratorio(string $laboratorio): void
    {
        $this->laboratorio = $laboratorio;
    }
    /**
     * @return string
     */
    public function getcantidad() : string
    {
        return $this->cantidad;
    }

    /**
     * @param string $cantidad
     */
    public function setcantidad(string $cantidad): void
    {
        $this->cantidad = $cantidad;
    }
    /**
     * @return string
     */
    public function getcosto() : string
    {
        return $this->costo;
    }

    /**
     * @param string $costo
     */
    public function setcosto(string $costo): void
    {
        $this->costo = $costo;
    }

    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.lotevacuna VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->fecha_compra,
                $this->fecha_vencimiento,
                $this->laboratorio,
                $this->cantidad,
                $this->costo,

            )
        );
        $this->Disconnect();
        return $result;
    }
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael.lotevacuna SET fecha_compra = ?, fecha_vencimiento = ?, laboratorio = ?, cantidad = ?, costo = ? WHERE id_lote_vacuna = ?", array(
                $this->fecha_compra,
                $this->fecha_vencimiento,
                $this->laboratorio,
                $this->cantidad,
                $this->costo,
                $this->id_lote_vacuna
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
        $arrlotevacuna = array();
        $tmp = new lotevacuna();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $lotevacuna = new lotevacuna();
            $lotevacuna->id_lote_vacuna = $valor['id_lote_vacuna'];
            $lotevacuna->fecha_compra = $valor['fecha_compra'];
            $lotevacuna->fecha_vencimiento = $valor['fecha_vencimiento'];
            $lotevacuna->laboratorio = $valor['laboratorio'];
            $lotevacuna->cantidad = $valor['cantidad'];
            $lotevacuna->costo = $valor['costo'];
            $lotevacuna->Disconnect();
            array_push($arrlotevacuna, $lotevacuna);
        }
        $tmp->Disconnect();
        return $arrlotevacuna;
    }
    public static function searchForid_lote_vacuna($id_lote_vacuna) : lotevacuna
    {
        $vacunas = null;
        if ($id_lote_vacuna > 0){
            $lotevacuna = new vacunas();
            $getrow = $vacunas->getRow("SELECT * FROM Proyecto-Finca-San-Rafael.lotevacuna WHERE id_lote_vacuna =?", array($id_lote_vacuna));
            $lotevacuna->id_lote_vacuna = $getrow['id_lote_vacuna'];
            $lotevacuna->fecha_compra = $getrow['fecha_compra'];
            $lotevacuna->fecha_vencimiento = $getrow['fecha_vencimiento'];
            $lotevacuna->laboratorio = $getrow['laboratorio'];
            $lotevacuna->cantidad = $getrow['cantidad'];
            $lotevacuna->costo = $getrow['costo'];

        }
        $lotevacuna->Disconnect();
        return $lotevacuna;
    }

    public static function getAll() : array
    {
        return lotevacuna::search("SELECT * FROM Proyecto-Finca-San-Rafael.lotevacuna");
    }

    public static function lotevacunaRegistrado ($fecha_compra) : bool
    {
        $result = lotevacuna::search("SELECT id FROM Proyecto-Finca-San-Rafael.lotevacuna where fecha_compra = ".$fecha_compra);
        if (count($result) > 0){
            return true;
        }else{
            return false;
        }
    }

}
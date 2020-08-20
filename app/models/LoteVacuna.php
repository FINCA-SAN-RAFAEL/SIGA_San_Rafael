<?php


namespace app\models;

require('BasicModel.php');

class LoteVacuna extends BasicModel
{
    private $id_lote_vacuna;
    private $vacunas;
    private $fecha_compra;
    private $fecha_vencimiento;
    private $laboratorio;
    private $cantidad;
    private $costo;

    /**
     * DetalleVentas constructor.
     * @param $id_lote_vacunua
     * @param $vacunas
     * @param $fecha_compra
     * @param $fecha_vencimiento
     * @param $laboratorio
     * @param $cantidad
     * @param $costo
     */
    public function __construct($vacunas = array())
    {
        parent::__construct();
        $this->id_vacunas = $vacunas['id_vacunas'] ?? null;
        $this->nombre = $vacunas['nombre'] ?? null;
        $this->descripcion = $vacunas['descripcion'] ?? null;
        $this->periocidad = $vacunas['periocidad'] ?? null;
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
    public function getid_lote_vacuna(): ?mixed
    {
        return $this->id_lote_vacuna;
    }

    /**
     * @param mixed|null $id_lote_vacuna
     */
    public function setid_lote_vacuna(?mixed $id_lote_vacuna): void
    {
        $this->id_lote_vacuna = $id_lote_vacuna;
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
    public function getfecha_compra()
    {
        return $this->dfecha_compra;
    }

    /**
     * @param mixed $fecha_compra
     */
    public function setfecha_compra($fecha_compra): void
    {
        $this->fecha_compra = $fecha_compra;
    }

    /**
     * @return mixed
     */
    public function getfecha_vencimiento()
    {
        return $this->fecha_vencimiento;
    }

    /**
     * @param mixed $fecha_vencimiento
     */
    public function setfecha_vencimiento($fecha_vencimiento): void
    {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    /**
 * @return mixed
 */
    public function getlaboratorio()
    {
        return $this->laboratorio;
    }

    /**
     * @param mixed $laboratorio
     */
    public function setlaboratorio($laboratorio): void
    {
        $this->canridad = $laboratorio;
    }
    /**
     * @return mixed
     */
    public function getcantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setcantidad($cantidad): void
    {
        $this->canridad = $cantidad;
    }
    /**
     * @return mixed
     */
    public function getcosto()
    {
        return $this->costo;
    }

    /**
     * @param mixed $costo
     */
    public function setcosto($costo): void
    {
        $this->costo = $costo;
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query)
    {
        $arrlote_vacuna = array();
        $tmp = new LoteVacuna();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $LoteVacuna = new LoteVacuna();
            $LoteVacuna->id_lote_vacuna = $valor['id_lote_vacuna'];
            $LoteVacuna->vacunas = vacunas::searchForId($valor['vacunas']);
            $LoteVacuna->fecha_compra = $valor['fecha_compra'];
            $LoteVacuna->fecha_vencimiento = $valor['fecha_vencimiento'];
            $LoteVacuna->laboratorio = $valor['laboratorio'];
            $LoteVacuna->cantidad = $valor['cantidad'];
            $LoteVacuna->costo = $valor['costo'];
            $LoteVacuna->Disconnect();
            if(count($getrows) == 1){ // Si solamente hay un registro encontrado devuelve este objeto y no un array
                return $LoteVacuna;
            }
            array_push($arrlote_vacuna, $LoteVacuna);
        }
        $tmp->Disconnect();
        return $arrlote_vacuna;
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        return lote_vacuna::search("SELECT * FROM fincasanrafael1.lote_vacuna");
    }

    /**
     * @param $id_lote_vacuna
     * @return mixed
     */
    public static function searchForId($id_lote_vacuna)
    {
        $lote_vacuna = null;
        if ($id_lote_vacuna > 0) {
            $lote_vacuna = new lote_vacuna();
            $getrow = $lote_vacuna->getRow("SELECT * FROM fincasanrafael1.lote_vacuna WHERE id_lote_vacuna =?", array($id_lote_vacuna));
            $lote_vacuna->id_lote_vacuna = $getrow['id_lote_vacuna'];
            $lote_vacuna->vacunas = vacunas::searchForId($getrow['vacunas']);
            $lote_vacuna->fecha_compra = $getrow['fecha_compra'];
            $lote_vacuna->fecha_vencimiento = $getrow['fecha_vencimiento'];
            $lote_vacuna->laboratorio = $getrow['laboratorio'];
            $lote_vacuna->cantidad = $getrow['cantidad'];
            $lote_vacuna->costo = $getrow['costo'];
        }
        $lote_vacuna->Disconnect();
        return $lote_vacuna;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.lote_vacuna VALUES (NULL, ?, ?, ?, ?,?)", array(
                $this->vacunas->getid_vacunas(),
                $this->fcha_compra,
                $this->fecha_vencimiento,
                $this->laboratorio,
                $this->cantidad,
                $this->costo,
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
        $result = $this->updateRow("UPDATE fincasanrafael1.lote_vacuna SET animal = ?, lote_vacuna = ?, dosis = ?, fecha = ?, observaciones = ? WHERE id = ?", array(
                $this->vacunas->getid_vacunas(),
                $this->fcha_compra,
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

    /**
     * @param $id_lote_vacuna
     * @return mixed
     */
    public function deleted($id_lote_vacuna)
    {
        $lote_vacuna = lote_vacuna::searchForid_lote_vacuna($id_lote_vacuna); //Buscando un usuario por el ID
        $deleterow = $lote_vacuna->deleteRow("DELETE FROM lote_vacuna WHERE id_lote_vacuna = ?", array($id_lote_vacuna));
        return $deleterow;                    //Guarda los cambios..
    }

    /**
     * @param $nombres
     * @return bool
     */
    public static function vacunasEnFactura($vacunas): bool
    {
        $result = lote_vacuna::search("SELECT id FROM fincasanrafael1.lote_vacuna where lote_vacuna = '" . $vacunas. "'");
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
        return "vacunas: $this->vacunas->getnombre(), lote_vacuna: $this->lote_vacuna->getNfecha_compra(), Cantidad: $this->cantidad, Precio Venta: $this->precio_venta";
    }
}

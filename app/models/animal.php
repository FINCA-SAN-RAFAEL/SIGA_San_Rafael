<?php


namespace app\models;

require_once (__DIR__ .'/../../vendor/autoload.php');
require_once('BasicModel.php');
use Carbon\Carbon;

class animal extends BasicModel
{

    private int $id;
    private int $peso;
    private int $genero;
    private int $fecha_nacimiento;
    private int $habitos_alimenticios;
    private int $observaciones;
    private ?persona $persona;
    private ?especie $especie;


    /**
     * animal constructor.
     * @param int $id
     * @param int $peso
     * @param int $genero
     * @param int $fecha_nacimiento
     * @param int $habitos_alimenticios
     * @param int $observaciones
     * @param persona $persona
     * @param especie $especie
     */
    public function __construct($animal = array())
    {
        parent::__construct();
        $this->id = $animal['id'] ?? 0;
        $this->peso = $animal['peso'] ?? null;
        $this->genero = $animal['genero'] ?? null;
        $this->fecha_nacimiento = $animal['fecha_nacimiento'] ?? null;
        $this->habitos_alimenticios = $animal['habitos_alimenticios'] ?? null;
        $this->observaciones = $animal['observaciones'] ?? null;
        $this->persona = $animal['persona'] ?? null;
        $this->especie = $animal['especie'] ?? null;

    }

    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int|mixed
     * @return int|mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int|mixed $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed|string
     */
    public function getpeso() : string
    {
        return $this->peso;
    }

    /**
     * @param mixed|string $peso
     */
    public function setpeso(string $peso): void
    {
        $this->peso = $peso;
    }



    /**
     * @return mixed|string
     */
    public function getgenero() : string
    {
        return $this->genero;
    }

    /**
     * @param mixed|string $genero
     */
    public function setgenero(string $genero): void
    {
        $this->genero = $genero;
    }


    /**
     * @return mixed|string
     */
    public function getfecha_nacimiento() : string
    {
        return $this->fecha_nacimiento;
    }

    /**
     * @param mixed|string $fecha_nacimiento
     */
    public function setfecha_nacimiento(float $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento;
    }

    /**
     * @return mixed|string
     */
    public function gethabitos_alimenticios() : string
    {
        return $this->habitos_alimenticios;
    }

    /**
     * @param mixed|string $habitos_alimenticios
     */
    public function sethabitos_alimenticios(float $habitos_alimenticios): void
    {
        $this->habitos_alimenticios = $habitos_alimenticios;
    }

    /**
     * @return mixed|string
     */
    public function getobservaciones : string
    {
        return $this->observaciones;
    }

    /**
     * @param mixed|string $observaciones
     */
    public function setobservaciones(float $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    /**
     * @return persona|mixed|null
     */
    public function getpersona() : persona
    {
        return $this->persona;
    }

    /**
     * @param persona|mixed|null $persona
     */
    public function setpersona(persona $persona): void
    {
        $this->persona = $persona;
    }

    /**
     * @return especie|mixed|null
     */
    public function getespecie() : especie
    {
        return $this->especie;
    }

    /**
     * @param especie|mixed|null $especie
     */
    public function setespecie(especie $especie): void
    {
        $this->especie = $especie;
    }

    /**
     * @return mixed
     */
    public function create() : bool
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.animal VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->peso,
                $this->genero,
                $this->fecha_nacimiento,
                $this->habitos_alimenticios,
                $this->observaciones,
                $this->persona->getId(),
                $this->especie->getId(),
            )
        );
        $this->setId(($result) ? $this->getLastId() : null);
        $this->Disconnect();
        return $result;
    }

    /**
     * @return mixed
     */
    public function update() : bool
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.aniaml SET peso = ?, genero = ?, fecha_nacimiento = ?, habitos_alimenticios = ?, observaciones = ?, persona = ?, especie = ? WHERE id = ?", array(
                $this->peso,
                $this->genero,
                $this->fecha_nacimiento,
                $this->habitos_alimenticios,
                $this->observaciones,
                $this->persona->getId(),
                $this->especie->getId(),
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
    public function deleted($id) : bool
    {
        $Venta = Ventas::searchForId($id); //Buscando un usuario por el ID
        $Venta->setEstado("Inactivo"); //Cambia el estado del Usuario
        return $Venta->update();                    //Guarda los cambios..
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function search($query) : array
    {
        $arrVentas = array();
        $tmp = new Ventas();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Venta = new Ventas();
            $Venta->id = $valor['id'];
            $Venta->numero_serie = $valor['numero_serie'];
            $Venta->cliente_id = Usuarios::searchForId($valor['cliente_id']);
            $Venta->empleado_id = Usuarios::searchForId($valor['empleado_id']);
            $Venta->fecha_venta = Carbon::parse($valor['fecha_venta']);
            $Venta->monto = $valor['monto'];
            $Venta->estado = $valor['estado'];
            $Venta->Disconnect();
            array_push($arrVentas, $Venta);
        }

        $tmp->Disconnect();
        return $arrVentas;
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function searchForId($id) : Ventas
    {
        $Venta = null;
        if ($id > 0) {
            $Venta = new Ventas();
            $getrow = $Venta->getRow("SELECT * FROM weber.ventas WHERE id =?", array($id));
            $Venta->id = $getrow['id'];
            $Venta->numero_serie = $getrow['numero_serie'];
            $Venta->cliente_id = Usuarios::searchForId($getrow['cliente_id']);
            $Venta->empleado_id = Usuarios::searchForId($getrow['empleado_id']);
            $Venta->fecha_venta = Carbon::parse($getrow['fecha_venta']);
            $Venta->monto = $getrow['monto'];
            $Venta->estado = $getrow['estado'];
        }
        $Venta->Disconnect();
        return $Venta;
    }

    /**
     * @return mixed
     */
    public static function getAll() : array
    {
        return Ventas::search("SELECT * FROM weber.ventas");
    }

    /**
     * @return string
     */
    public function __toString() : string
    {
        return "Numero Serie: $this->numero_serie, Cliente: $this->cliente_id->nombresCompletos(), Empleado: $this->empleado_id->nombresCompletos(), Fecha Venta: $this->fecha_venta->toDateTimeString(), Monto: $this->monto, Estado: $this->estado";
    }
}
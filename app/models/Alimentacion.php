<?php


namespace app\models;
require('BasicModel.php');

class Alimentacion
{
    private $id_alimentacion;
    private $nombre;
    private $cantidad;
    private $marca;
    private $presentacion;
    private $peso;

    /**
     * Usuarios constructor.
     * @param $id_alimentacion
     * @param $nombre
     * @param $cantidad
     * @param $marca
     * @param $presentacion
     * @param $peso
     */
    public function __construct($Alimentacion = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_alimentacion = $Alimentacion['id_alimentacion'] ?? null;
        $this->nombre = $Alimentacion['nombre'] ?? null;
        $this->cantidad = $Alimentacion['cantidad'] ?? null;
        $this->marca = $Alimentacion['marca'] ?? null;
        $this->presentacion = $Alimentacion['presentacion'] ?? null;
        $this->peso = $Alimentacion['peso'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getid_alimentacion(): int
    {
        return $this->id_alimentacion;
    }

    /**
     * @param int $id_alimentacion
     */
    public function setid_alimentacion(int $id_alimentacion): void
    {
        $this->id_alimentacion = $id_alimentacion;
    }

    /**
     * @return string
     */
    public function getnombre(): string
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
    public function getcantidad(): string
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
    public function getmarca(): string
    {
        return $this->marca;
    }

    /**
     * @param string $marca
     */
    public function setmarca(string $marca): void
    {
        $this->marca = $marca;
    }


    /**
     * @return string
     */
    public function getpresentacion(): string
    {
        return $this->getpresentacion();
    }


    /**
     * @param string $presentacion
     */
    public function setpresentacion(string $presentacion): void
    {
        $this->presentacion = $presentacion;
    }


    /**
     * @return string
     */
    public function getpeso(): string
    {
        return $this->peso;
    }

    /**
     * @param string $peso
     */
    public function setpeso(string $peso): void
    {
        $this->peso = $peso;
    }

    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO Proyecto-Finca-San-Rafael.Alimentacion VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->cantidad,
                $this->marca,
                $this->presentacion,
                $this->peso

            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update(): bool
    {
        $result = $this->updateRow("UPDATE Proyecto-Finca-San-Rafael.Alimentacion SET nombre = ?, cantidad = ?, marca = ?, presentacion = ?, peso = ? WHERE id_alimentacion = ?", array(
                $this->nombre,
                $this->cantidad,
                $this->marca,
                $this->presentacion,
                $this->peso,
                $this->id_alimentacion
            )
        );
        $this->Disconnect();
        return $result;
    }

    public function deleted($id): void
    {
        // TODO: Implement deleted() method.
    }

    public static function search($query): array
    {
        $arrAnimalParto = array();
        $tmp = new Alimentacion();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $Alimentacion = new Alimentacion();
            $Alimentacion->id_alimentacion = $valor['id_alimentacion'];
            $Alimentacion->nombre = $valor['nombre'];
            $Alimentacion->cantidad = $valor['cantidad'];
            $Alimentacion->marca = $valor['marca'];
            $Alimentacion->presentacion = $valor['presentacion'];
            $Alimentacion->peso = $valor['peso'];
            $Alimentacion > Disconnect();
            array_push($arrAlimentacion, $Alimentacion);
        }
        $tmp->Disconnect();
        return $arrAlimentacion;
    }

    public static function searchForid_alimentacion($id_alimentacion): Alimentacion
    {
        $Alimentacion = null;
        if ($id_alimentacion > 0) {
            $Alimentacion = new Alimentacion();
            $getrow = $Alimentacion->getRow("SELECT * FROM Proyecto-Finca-San-Rafael.Alimentacion WHERE id_alimentacion =?", array($id_alimentacion));
            $Alimentacion->id_alimentacion = $getrow['id_alimentacion'];
            $Alimentacion->nombre = $getrow['nombre'];
            $Alimentacion->cantidad = $getrow['cantidad'];
            $Alimentacion->marca = $getrow['marca'];
            $Alimentacion->presentacion = $getrow['presentacion'];
            $Alimentacion->peso = $getrow['peso'];

        }
        $Alimentacion->Disconnect();
        return $Alimentacion;
    }

    public static function getAll(): array
    {
        return Alimentacion::search("SELECT * FROM Proyecto-Finca-San-Rafael.Alimentacion");
    }

    public static function AlimentacionRegistrado($nombre): bool
    {
        $result = Alimentacion::search("SELECT id FROM Proyecto-Finca-San-Rafael.Alimentacion where nombre = " . $nombre);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
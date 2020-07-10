<?php


namespace app\models;
require('BasicModel.php');

class gastos
{
    private $id_gastos;
    private $nombre;
    private $precio;
    private $descripcion;


    /*Relaciones */
    private $persona;

    /**
     * Usuarios constructor.
     * @param $id_gastos
     * @param $nombre
     * @param $precio
     * @param $descripcion
     */
    public function __construct($gastos = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_gastos = $gastos['id_gastos'] ?? null;
        $this->nombre = $gastos['nombre'] ?? null;
        $this->precio = $gastos['precio'] ?? null;
        $this->descripcion = $gastos['descripcion'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int
     */
    public function getIdGastos(): int
    {
        return $this->id_gastos;
    }

    /**
     * @param int $id_gastos
     */
    public function setIdGastos(int $id_gastos): void
    {
        $this->id_gastos = $id_gastos;
    }

    /**
     * @return string
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * @return int
     */
    public function getPrecio(): int
    {
        return $this->precio;
    }

    /**
     * @param int $precio
     */
    public function setPrecio(int $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * @return string
     */
    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getPersona()
    {
        return $this->persona;
    }

    /**
     * @param mixed $persona
     */
    public function setPersona($persona): void
    {
        $this->persona = $persona;
    }


    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.gastos VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->precio,
                $this->descripcion

            )
        );
        $this->Disconnect();
        return $result;
    }

    public function update(): bool
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.gastos SET nombre = ?, precio = ?, descripcion = ? WHERE id_gastos = ?", array(
                $this->nombre,
                $this->precio,
                $this->descripcion,
                $this->id_gastos
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
        $arrgastos = array();
        $tmp = new gastos();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $gastos = new gastos();
            $gastos->id_gastos = $valor['id_gastos'];
            $gastos->nombre = $valor['nombre'];
            $gastos->precio = $valor['precio'];
            $gastos->descripcion = $valor['descripcion'];
            $gastos->Disconnect();
            array_push($arrgastos, $gastos);
        }
        $tmp->Disconnect();
        return $arrgastos;
    }

    public static function searchForid_gastos($id_gastos): gastos
    {
        $gastos = null;
        if ($id_gastos > 0) {
            $gastos = new gastos();
            $getrow = $gastos->getRow("SELECT * FROM  fincasanrafael1.gastos WHERE id_gastos =?", array($id_gastos));
            $gastos->id_gastos = $getrow['id_gastos'];
            $gastos->nombre = $getrow['nombre'];
            $gastos->precio = $getrow['precio'];
            $gastos->descripcion = $getrow['descripcion'];

        }
        $gastos->Disconnect();
        return $gastos;
    }

    public static function getAll(): array
    {
        return gastos::search("SELECT * FROM fincasanrafael1.gastos");
    }

    public static function gastosRegistrado($nombre): bool
    {
        $result = gastos::search("SELECT id FROM fincasanrafael1.gastos where nombre = " . $nombre);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
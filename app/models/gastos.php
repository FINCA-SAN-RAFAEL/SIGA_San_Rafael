<?php


namespace app\models;

require_once('BasicModel.php');
require_once('persona.php');


class gastos extends BasicModel
{
    private $id_gastos;
    private $nombre;
    private $precio;
    private $descripcion;


    /* Relaciones */
    private $persona;

    /**
    @param $id_gastos
     * @param $nombre
     * @param $precio
     * @param $descripcion

     */
    public function __construct($persona = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id_gastos = $gastos['id_gastos'] ?? null;
        $this->nombre = $gastos['nombre'] ?? null;
        $this->precio = $gastos['precio'] ?? null;
        $this->descripcion = $gastos['descripcion'] ?? null;
        $this->persona= $gastos['persona'] ?? null;
    }

    /* Metodo destructor cierra la conexion. */

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return gastos::search("SELECT * FROM fincasanrafael1.gastos");
    }

    /**
     * @param $query
     * @return gastos|array
     * @throws \Exception
     */
    public static function search($query)
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
            $gastos->persona = persona::searchForId($valor['persona']);
            $gastos->Disconnect();
            array_push($arrgastos, $gastos);
        }
        $tmp->Disconnect();
        return $arrgastos;
    }

    public static function gastosRegistrados($nombre): bool
    {
        $result = gastos::search("SELECT id FROM fincasanrafael1.gastos where nombre = " . $nombre);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *
     */
    function __destruct()
    {
        $this->Disconnect();
    }

    /**
     * @return int
     */
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
     * @param mixed|null $nombre
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
     * @return persona
     */
    public function getPersona(): persona
    {
        return $this->persona;
    }

    /**
     * @param mixed|null $persona
     */
    public function setPersona(persona $persona): void
    {
        $this->persona = $persona;
    }



    /**
     * @return bool
     * @throws \Exception
     */
    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.gastos VALUES (NULL, ?, ?, ?, ?)", array(
                $this->nombre,
                $this->precio,
                $this->descripcion,
                $this->persona->getId(),

            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleted($id_gastos)
    {
        $gastos = gastos::searchForId($id_gastos); //Buscando una persona por el ID
        $gastos->setEstado("Inactivo"); //Cambia el estado de la persona
        return $gastos->update();                    //Guarda los cambios..
    }

    /**
     * @param $id
     * @return persona
     * @throws \Exception
     */
    public static function searchForId($id_gastos)
    {
        $gastos = null;
        if ($id_gastos > 0) {
            $gastos = new gastos();
            $getrow = $gastos->getRow("SELECT * FROM  fincasanrafael1.gastos WHERE id_gastos =?", array($id_gastos));
            $gastos->id_gastos = $getrow['id_gastos'];
            $gastos->nombre = $getrow['nombre'];
            $gastos->precio = $getrow['precio'];
            $gastos->descripcion = $getrow['descripcion'];
            $gastos->persona = persona::searchForId($getrow['persona']);

        }
        $gastos->Disconnect();
        return $gastos;
    }

    /**
     * @return bool
     */
    public function update()
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.gastos SET nombre = ?, precio = ?, descripcion = ? persona = ? WHERE id_gastos = ?", array(
                $this->nombre,
                $this->precio,
                $this->descripcion,
                $this->persona->getId(),
                $this->id_gastos
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Nombre: $this->nombre, precio: $this->precio, Descripcion : $this->descripcion, Persona: $this->persona";
    }
}
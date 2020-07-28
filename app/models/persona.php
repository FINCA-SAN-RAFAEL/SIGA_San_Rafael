<?php


namespace app\models;

require('BasicModel.php');

class persona extends BasicModel
{
    private $id;
    private $tipo_documento;
    private $documento;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $direccion;
    private $correo;
    private $estado;
    private $user;
    private $password;


    /* Relaciones */
    private $animal;
    private $gastos;

    /**
     * Usuarios constructor.
     * @param $id
     * @param $tipo_documento
     * @param $documento
     * @param $nombres
     * @param $apellidos
     * @param $telefono
     * @param $direccion
     * @param $correo
     * @param $estado
     * @param $user
     * @param $passwordl

     */
    public function __construct($persona = array())
    {
        parent::__construct(); //Llama al contructor padre "la clase conexion" para conectarme a la BD
        $this->id = $persona['id'] ?? null;
        $this->tipo_documento = $persona['tipo_documento'] ?? null;
        $this->documento = $persona['documento'] ?? null;
        $this->nombres = $persona['nombres'] ?? null;
        $this->apellidos = $persona['apellidos'] ?? null;
        $this->telefono = $persona['telefono'] ?? null;
        $this->direccion = $persona['direccion'] ?? null;
        $this->correo = $persona['correo'] ?? null;
        $this->estado = $persona['estado'] ?? null;
        $this->user = $persona['user'] ?? null;
        $this->password = $persona['password'] ?? null;

    }

    /* Metodo destructor cierra la conexion. */

    /**
     * @return array
     */
    public static function getAll(): array
    {
        return persona::search("SELECT * FROM fincasanrafael1.persona");
    }

    /**
     * @param $query
     * @return persona|array
     * @throws \Exception
     */
    public static function search($query)
    {
        $arrpersona = array();
        $tmp = new persona();
        $getrows = $tmp->getRows($query);

        foreach ($getrows as $valor) {
            $persona = new persona();
            $persona->id = $valor['id'];
            $persona->tipo_documento = $valor['tipo_documento'];
            $persona->documento = $valor['documento'];
            $persona->nombres = $valor['nombres'];
            $persona->apellidos = $valor['apellidos'];
            $persona->telefono = $valor['telefono'];
            $persona->direccion = $valor['direccion'];
            $persona->correo = $valor['correo'];
            $persona->estado = $valor['estado'];
            $persona->user = $valor['user'];
            $persona->password = $valor['password'];
            $persona->Disconnect();
            array_push($arrpersona, $persona);
        }
        $tmp->Disconnect();
        return $arrpersona;
    }

    /**
     * @param $documento
     * @return bool
     * @throws \Exception
     */
    public static function personaRegistrada($documento): bool
    {
        $result = persona::search("SELECT * FROM fincasanrafael1.persona where documento = " . $documento);
        if ( count ($result) > 0 ) {
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNombres(): string
    {
        return $this->nombres;
    }

    /**
     * @param string $nombres
     */
    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    /**
     * @return string
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * @param string $apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    /**
     * @return string
     */
    public function getTipoDocumento(): string
    {
        return $this->tipo_documento;
    }

    /**
     * @param string $tipo_documento
     */
    public function setTipoDocumento(string $tipo_documento): void
    {
        $this->tipo_documento = $tipo_documento;
    }

    /**
     * @return int
     */
    public function getDocumento(): int
    {
        return $this->documento;
    }

    /**
     * @param int $documento
     */
    public function setDocumento(int $documento): void
    {
        $this->documento = $documento;
    }

    /**
     * @return int
     */
    public function getTelefono(): int
    {
        return $this->telefono;
    }

    /**
     * @param int $telefono
     */
    public function setTelefono(int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * @return string
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * @param string $direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }
    /**
     * @return string
     */
    public function getCorreo(): string
    {
        return $this->correo;
    }

    /**
     * @param string $correo
     */
    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    /**
     * @return string
     */
    public function getEstado(): string
    {
        return $this->estado;
    }

    /**
     * @param string $estado
     */
    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }



    /**
     * @return mixed
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    /**
     * @param mixed $animal
     */
    public function setAnimal($animal): void
    {
        $this->animal = $animal;
    }

    /**
     * @return mixed
     */
    public function getGastos()
    {
        return $this->gastos;
    }

    /**
     * @param mixed $gastos
     */
    public function setGastos($gastos): void
    {
        $this->gastos = $gastos;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function create(): bool
    {
        $result = $this->insertRow("INSERT INTO fincasanrafael1.persona VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array(

                $this->documento,
                $this->tipo_documento,
                $this->nombres,
                $this->apellidos,
                $this->telefono,
                $this->direccion,
                $this->correo,
                $this->estado,
                $this->user,
                $this->password,

            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleted($id): bool
    {
        $User = persona::searchForId($id); //Buscando una persona por el ID
        $User->setEstado("Inactivo"); //Cambia el estado de la persona
        return $User->update();                    //Guarda los cambios..
    }

    /**
     * @param $id
     * @return persona
     * @throws \Exception
     */
    public static function searchForId($id): persona
    {
        $persona = null;
        if ($id > 0) {
            $persona = new persona();
            $getrow = $persona->getRow("SELECT * FROM fincasanrafael1.persona WHERE id =?", array($id));
            $persona->id = $getrow['id'];
            $persona->documento = $getrow['documento'];
            $persona->tipo_documento = $getrow['tipo_documento'];
            $persona->nombres = $getrow['nombres'];
            $persona->apellidos = $getrow['apellidos'];
            $persona->telefono = $getrow['telefono'];
            $persona->direccion = $getrow['direccion'];
            $persona->correo = $getrow['correo'];
            $persona->estado = $getrow['estado'];
            $persona->user = $getrow['user'];
            $persona->password = $getrow['password'];

        }
        $persona->Disconnect();
        return $persona;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $result = $this->updateRow("UPDATE fincasanrafael1.persona SET  documento = ?,tipo_documento = ?, nombres = ?, apellidos = ?, telefono = ?, direccion = ?, estado = ? , user = ?, password = ?WHERE id = ?", array(

                $this->documento,
                $this->tipo_documento,
                $this->nombres,
                $this->apellidos,
                $this->telefono,
                $this->direccion,
                $this->estado,
                $this->user,
                $this->password,
                $this->id
            )
        );
        $this->Disconnect();
        return $result;
    }

    /**
     * @return string
     */
    public function nombresCompletos()
    {
        return $this->nombres . " " . $this->apellidos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "nombres: $this->nombres, apellidos: $this->nombres, tipo_documento: $this->tipo_documento, documento: $this->documento, telefono: $this->telefono, ireccion: $this->direccion";
    }
}
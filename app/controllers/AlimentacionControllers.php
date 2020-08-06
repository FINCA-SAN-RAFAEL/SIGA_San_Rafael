<?php


namespace app\controllers;
require(__DIR__.'/../models/Alimentacion.php');
require(__DIR__.'/../models/GeneralFunctions.php');

use app\models\Alimentacion;

if(!empty($_GET['action'])){
    AlimentacionControllers::main($_GET['action']);
}

class AlimentacionControllers
{

    static function main($action)
    {
        if ($action == "create") {
            AlimentacionController::create();
        } else if ($action == "edit") {
            AlimentacionController::edit();
        } else if ($action == "searchForID") {
            AlimentacionController::searchForID($_REQUEST['idalimentacion']);
        } else if ($action == "searchAll") {
            AlimentacionController::getAll();
        } else if ($action == "activate") {
            AlimentacionController::activate();
        } else if ($action == "inactivate") {
            AlimentacionController::inactivate();
        }/*else if ($action == "login"){
            UsuariosController::login();
        }else if($action == "cerrarSession"){
            UsuariosController::cerrarSession();
        }*/
    }

    static public function create()
    {
        try {
            $arrayAlimentacion = array();
            $arrayAlimentacion['nombre'] = $_POST['nombre'];
            $arrayAlimentacion['cantidad'] = $_POST['cantidad'];
            $arrayAlimentacion['marca'] = $_POST['marca'];
            $arrayAlimentacion['presentacion'] = $_POST['presentacion'];
            $arrayAlimentacion['peso'] = $_POST['peso'];

            if (!Alimentacion::AlimentacionRegistrado($arrayAlimentacion['nombre'])) {
                $Alimentacion = new Alimentacion($arrayAlimentacion);
                if ($Alimentacion->create()) {
                    header("Location: ../../views/modules/Alimentacion/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/Alimentacion/create.php?respuesta=error&mensaje=Producto ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            header("Location: ../../views/modules/Alimentacion/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayAlimentacion = array();
            $arrayAlimentacion['nombre'] = $_POST['nombre'];
            $arrayAlimentacion['cantidad'] = $_POST['cantidad'];
            $arrayAlimentacion['marca'] = $_POST['marca'];
            $arrayAlimentacion['presentacion'] = $_POST['presentacion'];
            $arrayAlimentacion['peso'] = $_POST['peso'];
            $arrayAlimentacion['id'] = $_POST['id'];

            $Alimentacion = new Alimentacion($arrayAlimentacion);
            $Alimentacion->update();

            header("Location: ../../views/modules/Alimentacion/show.php?id=" . $Alimentacion->getId() . "&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            header("Location: ../../views/modules/Alimentacion/edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }


    static public function activate()
    {
        try {
            $ObjAlimentacion = Alimentacion::searchForId($_GET['Id']);
            $ObjAlimentacion->setEstado("Activo");
            if ($ObjAlimentacion->update()) {
                header("Location: ../../views/modules/Alimentacion/index.php");
            } else {
                header("Location: ../../views/modules/Alimentacion/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            header("Location: ../../views/modules/Alimentacion/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }


    static public function inactivate()
    {
        try {
            $ObjAlimentacion = Alimentacion::searchForId($_GET['Id']);
            $ObjAlimentacion->setEstado("Inactivo");
            if ($ObjAlimentacion->update()) {
                header("Location: ../../views/modules/Alimentacion/index.php");
            } else {
                header("Location: ../../views/modules/Alimentacion/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            header("Location: ../../views/modules/Alimentacion/index.php?respuesta=error");
        }
    }

    static public function searchForID($id)
    {
        try {
            return Alimentacion::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'error', 'errorStack');
            header("Location: ../../views/modules/Alimentacion/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Alimentacion::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console($e, 'log', 'errorStack');
            header("Location: ../Vista/modules/Alimentacion/manager.php?respuesta=error");
        }
    }

    public static function AlimentacionIsInArray($idalimentacion, $ArrAlimentacion)
    {
        if (count($ArrAlimentacion) > 0) {
            foreach ($ArrAlimentacion as $Alimentacion) {
                if ($Alimentacion->getId() == $idalimentacion) {
                    return true;
                }
            }
        }

        return false;
    }

    static public function selectProducto($isMultiple = false,
                                          $isRequired = true,
                                          $id = "idalimentacion",
                                          $nombre = "idalimentacion",
                                          $defaultValue = "",
                                          $class = "",
                                          $where = "",
                                          $arrExcluir = array())
    {
        $arrAlimentacion = array();
        if ($where != "") {
            $base = "SELECT * FROM alimentacion WHERE ";
            $arrAlimentacion = Alimentacion::search($base . $where);
        } else {
            $arrAlimentacion = Productos::getAll();
        }

        $htmlSelect = "<select " . (($isMultiple) ? "multiple" : "") . " " . (($isRequired) ? "required" : "") . " id= '" . $id . "' name='" . $nombre . "' class='" . $class . "'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if (count($arrAlimentacion) > 0) {
            foreach ($arrAlimentacion as $alimentacion)
                if (!AlimentacionController::alimentacionIsInArray($alimentacion->getId(), $arrExcluir))
                    $htmlSelect .= "<option " . (($alimentacion != "") ? (($defaultValue == $alimentacion->getId()) ? "selected" : "") : "") . " value='" . $alimentacion->getId() . "'>" . $alimentacion->getStock() . " - " . $alimentacion->getNombre() . " - " . $alimentacion->getCantidad() . ".$alimentacion->getMarca()." - ".$alimentacion->getPresentacion()." - " $alimentacion->getPeso().</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

    /*public static function personaIsInArray($idPersona, $ArrPersonas){
        if(count($ArrPersonas) > 0){
            foreach ($ArrPersonas as $Persona){
                if($Persona->getIdPersona() == $idPersona){
                    return true;
                }
            }
        }
        return false;
    }

    static public function selectPersona ($isMultiple=false,
                                          $isRequired=true,
                                          $id="idConsultorio",
                                          $nombre="idConsultorio",
                                          $defaultValue="",
                                          $class="",
                                          $where="",
                                          $arrExcluir = array()){
        $arrPersonas = array();
        if($where != ""){
            $base = "SELECT * FROM persona WHERE ";
            $arrPersonas = Persona::buscar($base.$where);
        }else{
            $arrPersonas = Persona::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrPersonas) > 0){
            foreach ($arrPersonas as $persona)
                if (!UsuariosController::personaIsInArray($persona->getIdPersona(),$arrExcluir))
                    $htmlSelect .= "<option ".(($persona != "") ? (($defaultValue == $persona->getIdPersona()) ? "selected" : "" ) : "")." value='".$persona->getIdPersona()."'>".$persona->getNombres()." ".$persona->getApellidos()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }*/

    /*
    public function buscar ($Query){
        try {
            return Persona::buscar($Query);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function asociarEspecialidad (){
        try {
            $Persona = new Persona();
            $Persona->asociarEspecialidad($_POST['Persona'],$_POST['Especialidad']);
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=correcto&id=".$_POST['Persona']);
        } catch (Exception $e) {
            header("Location: ../Vista/modules/persona/managerSpeciality.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function eliminarEspecialidad (){
        try {
            $ObjPersona = new Persona();
            if(!empty($_GET['Persona']) && !empty($_GET['Especialidad'])){
                $ObjPersona->eliminarEspecialidad($_GET['Persona'],$_GET['Especialidad']);
            }else{
                throw new Exception('No se recibio la informacion necesaria.');
            }
            header("Location: ../Vista/modules/persona/managerSpeciality.php?id=".$_GET['Persona']);
        } catch (Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    public static function login (){
        try {
            if(!empty($_POST['Usuario']) && !empty($_POST['Contrasena'])){
                $tmpPerson = new Persona();
                $respuesta = $tmpPerson->Login($_POST['Usuario'], $_POST['Contrasena']);
                if (is_a($respuesta,"Persona")) {
                    $hydrator = new ReflectionHydrator(); //Instancia de la clase para convertir objetos
                    $ArrDataPersona = $hydrator->extract($respuesta); //Convertimos el objeto persona en un array
                    unset($ArrDataPersona["datab"],$ArrDataPersona["isConnected"],$ArrDataPersona["relEspecialidades"]); //Limpiamos Campos no Necesarios
                    $_SESSION['UserInSession'] = $ArrDataPersona;
                    echo json_encode(array('type' => 'success', 'title' => 'Ingreso Correcto', 'text' => 'Sera redireccionado en un momento...'));
                }else{
                    echo json_encode(array('type' => 'error', 'title' => 'Error al ingresar', 'text' => $respuesta)); //Si la llamda es por Ajax
                }
                return $respuesta; //Si la llamada es por funcion
            }else{
                echo json_encode(array('type' => 'error', 'title' => 'Datos Vacios', 'text' => 'Debe ingresar la informacion del usuario y contraseña'));
                return "Datos Vacios"; //Si la llamada es por funcion
            }
        } catch (Exception $e) {
            var_dump($e);
            header("Location: ../login.php?respuesta=error");
        }
    }

    public static function cerrarSession (){
        session_unset();
        session_destroy();
        header("Location: ../Vista/modules/persona/login.php");
    }*/
}
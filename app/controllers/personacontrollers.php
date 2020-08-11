<?php

namespace app\controllers;
require(__DIR__.'/../models/persona.php');
require_once (__DIR__ . '/../models/GeneralFunctions.php');

use App\Models\generalFunctions;
use app\models\persona;
use App\Models\Usuarios;

if(!empty($_GET['action'])){
    personacontrollers::main($_GET['action']);
}

class personacontrollers
{
    static function main($action)
    {
        if ($action == "create") {
            personacontrollers::create();
        } else if ($action == "edit") {
            personacontrollers::edit();
        } else if ($action == "searchForID") {
            personacontrollers::searchForID($_REQUEST['idPersona']);
        } else if ($action == "searchAll") {
            personacontrollers::getAll();
        } else if ($action == "activate") {
            personacontrollers::activate();
        } else if ($action == "inactivate") {
            personacontrollers::inactivate();
        }/*else if ($action == "login"){
            personacontrollers::login();
        }else if($action == "cerrarSession"){
            personacontrollers::cerrarSession();
        }*/

    }

    static public function create()
    {
        try {
            $arraypersona = array();

            $arraypersona['documento'] = $_POST['documento'];
            $arraypersona['tipo_documento'] = $_POST['tipo_documento'];
            $arraypersona['nombres'] = $_POST['nombres'];
            $arraypersona['apellidos'] = $_POST['apellidos'];
            $arraypersona['telefono'] = $_POST['telefono'];
            $arraypersona['direccion'] = $_POST['direccion'];
            $arraypersona['correo'] = $_POST['correo'];
            $arraypersona['estado'] = 'Activo';
            if(!persona::personaRegistrada($arraypersona['documento'])){
                $persona = new persona($arraypersona);
                if($persona->create()){
                    header("Location: ../../views/modules/persona/index.php?respuesta=correcto");
                }
            }else{
                header("Location: ../../views/modules/persona/create.php?respuesta=error&mensaje=persona ya registrada");
            }
        } catch (Exception $e) {
            generalFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arraypersona = array();

            $arraypersona['documento'] = $_POST['documento'];
            $arraypersona['tipo_documento'] = $_POST['tipo_documento'];
            $arraypersona['nombres'] = $_POST['nombres'];
            $arraypersona['apellidos'] = $_POST['apellidos'];
            $arraypersona['telefono'] = $_POST['telefono'];
            $arraypersona['direccion'] = $_POST['direccion'];
            $arraypersona['correo'] = $_POST['correo'];
            $arraypersona['estado'] = $_POST['estado'];
            $arraypersona['id'] = $_POST['id'];

            $user = new persona($arraypersona);
            $user->update();

            header("Location: ../../views/modules/persona/show.php?id=".$user->getId()."&respuesta=correcto");
        } catch (\Exception $e) {
            generalFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function activate (){
        try {
            $Objpersona = persona::searchForId($_GET['Id']);
            $Objpersona->setEstado("Activo");
            if($Objpersona->update()){
                header("Location: ../../views/modules/persona/index.php");
            }else{
                header("Location: ../../views/modules/persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            generalFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate (){
        try {
            $Objpersona = persona::searchForId($_GET['Id']);
            $Objpersona->setEstado("Inactivo");
            if($Objpersona->update()){
                header("Location: ../../views/modules/persona/index.php");
            }else{
                header("Location: ../../views/modules/persona/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            generalFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/index.php?respuesta=error");
        }
    }

    static public function searchForID ($id){
        try {
            return persona::searchForId($id);
        } catch (\Exception $e) {
            generalFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/persona/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return persona::getAll();
        } catch (\Exception $e) {
            generalFunctions::console( $e, 'log', 'errorStack');
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

    private static function personaIsInArray($idpersona, $Arrpersonas){
        if(count($Arrpersonas) > 0){
            foreach ($Arrpersonas as $persona){
                if($persona->getId() == $idpersona){
                    return true;
                }
            }
        }
        return false;
    }

    static public function selectpersona ($isMultiple=false,
                                          $isRequired=true,
                                          $id="idpersona",
                                          $nombre="idpersona",
                                          $defaultValue="",
                                          $class="form-control",
                                          $where="",
                                          $arrExcluir = array()){
        $arrpersona = array();
        if($where != ""){
            $base = "SELECT * FROM persona WHERE ";
            $arrpersona = persona::search($base.' '.$where);
        }else{
            $arrpersona = persona::getAll();
        }

        $htmlSelect = "<select ".(($isMultiple) ? "multiple" : "")." ".(($isRequired) ? "required" : "")." id= '".$id."' name='".$nombre."' class='".$class."' style='width: 100%;'>";
        $htmlSelect .= "<option value='' >Seleccione</option>";
        if(count($arrpersona) > 0){
            foreach ($arrpersona as $persona)
                if (!personacontrollers::personaIsInArray($persona->getId(),$arrExcluir))
                    $htmlSelect .= "<option ".(($persona != "") ? (($defaultValue == $persona->getId()) ? "selected" : "" ) : "")." value='".$persona->getId_persona()."'>\" . $persona->getdocumento() ." -".$persona->gettipo_documento().\" - ".$persona->getnombre()." - ".$persona->getapellido()." - ".$persona->gettelefono()." - ".$persona->getdireccion()." - ".$persona->getcorreo()." - ".$persona->getestado()."</option>";
        }
        $htmlSelect .= "</select>";
        return $htmlSelect;
    }

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
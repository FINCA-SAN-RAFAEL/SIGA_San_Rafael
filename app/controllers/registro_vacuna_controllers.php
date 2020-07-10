<?php

namespace app\controllers;
require(__DIR__.'/../models/registro_vacuna.php');
use app\models\registro_vacuna;

if(!empty($_GET['action'])){
    registro_vacuna_controllers::main($_GET['action']);
}

class registro_vacuna_controllers
{
    static function main($action)
    {
        if ($action == "create") {
            \app\controllers\registro_vacuna_controllers::create();
        } else if ($action == "edit") {
            registro_vacuna_controllers::edit();
        } else if ($action == "searchForid_registro_vacuna") {
            registro_vacuna_controllers::searchForID($_REQUEST['id_registro_vacuna']);
        } else if ($action == "searchAll") {
            registro_vacuna_controllers::getAll();
        }/*else if ($action == "login"){
            registro_vacuna_controllers::login();
        }else if($action == "cerrarSession"){
            registro_vacuna_controllers::cerrarSession();
        }*/

    }

    static public function create()
    {
        try {
            $arrayregistro_vacuna = array();
            $arrayregistro_vacuna['dosis'] = $_POST['dosis'];
            $arrayregistro_vacuna['fecha'] = $_POST['fecha'];
            $arrayregistro_vacuna['observaciones'] = $_POST['observaciones'];
            $arrayregistro_vacuna['id_registro_vacuna'] = $_POST['id_registro_vacuna'];
            if (!registro_vacuna::registro_vacunaRegistrado($arrayregistro_vacuna['id_registro_vacuna'])) {
                $registro_vacuna = new registro_vacuna ($arrayregistro_vacuna);
                if ($registro_vacuna->create()) {
                    header("Location: ../../views/modules/registro_vacuna/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/registro_vacuna/create.php?respuesta=error&mensaje=registro_vacuna ya registrado");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/registro_vacuna/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayregistro_vacuna = array();
            $arrayregistro_vacuna['dosis'] = $_POST['dosis'];
            $arrayregistro_vacuna['fecha'] = $_POST['fecha'];
            $arrayregistro_vacuna['observaciones'] = $_POST['observaciones'];
            $arrayregistro_vacuna['id_registro_vacuna'] = $_POST['id_registro_vacuna'];

            $user = new registro_vacuna($arrayregistro_vacuna);
            $user->update();

            header("Location: ../../views/modules/registro_vacuna/show.php?id=" . $user->getid_registro_vacuna() . "&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/registro_vacuna/edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }


    static public function searchForID($id_registro_vacuna)
    {
        try {
            return registro_vacuna::searchForid_registro_vacuna($id_registro_vacuna);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/registro_vacuna/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return registro_vacuna::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
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


<?php

namespace App\Controllers;
require(__DIR__.'/../Models/gastos.php');
use App\Models\gastos;

if(!empty($_GET['action'])){
    gastoscontroller::main($_GET['action']);
}

class gastoscontroller
{

    static function main($action)
    {
        if ($action == "create") {
            gastoscontroller::create();
        } else if ($action == "edit") {
            gastoscontroller::edit();
        } else if ($action == "searchForId") {
            gastoscontroller::searchForId($_REQUEST['idgastos']);
        } else if ($action == "searchAll") {
            gastoscontroller::getAll();
        } else if ($action == "activate") {
            gastoscontroller::activate();
        } else if ($action == "inactivate") {
            gastoscontroller::inactivate();
        }/*else if ($action == "login"){
            UsuariosController::login();
        }else if($action == "cerrarSession"){
            UsuariosController::cerrarSession();
        }*/

    }

    static public function Create()
    {
        try {
            $arraygastos = array();
            $arraygastos['id_gastos'] = $_POST['id_gastos'];
            $arraygastos['nombre'] = $_POST['nombre'];
            $arraygastos['precio'] = $_POST['precio'];
            $arraygastos['descripcion'] = $_POST['descripcion'];
            if (!gastos::gastosRegistrado($arraygastos['id_gastos'])) {
                $gastos = new gastos ($arraygastos);
                if ($gastos->create()) {
                    header("Location: ../../views/Modules/gastos/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/Modules/gastos/create.php?respuesta=error&mensaje=gastos ya registrados");
            }
        } catch (Exception $e) {
            header("Location: ../../views/Modules/gastos/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function Edit()
    {
        try {
            $arraygastos = array();
            $arraygastos['id_gastos'] = $_POST['id_gastos'];
            $arraygastos['nombre'] = $_POST['nombre'];
            $arraygastos['precio'] = $_POST['precio'];
            $arraygastos['descripcion'] = $_POST['descripcion'];


            $user = new gastos($arraygastos);
            $user->update();

            header("Location: ../../views/Modules/gastos/Show.php?id=" . $user->getIdgastos() . "&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/Modules/gastos/Edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function activate()
    {
        try {
            $Objgastos = gastos::searchForId($_GET['idgastos']);
            $Objgastos->setestado("Activo");
            if ($Objgastos->update()) {
                header("Location: ../../views/Modules/gastos/index.php");
            } else {
                header("Location: ../../views/Modules/gastos/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/Modules/gastos/index.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function inactivate()
    {
        try {
            $ObjCategoria = Categoria::searchForId($_GET['idCategoria']);
            $ObjCategoria->setestado("Inactivo");
            if ($ObjCategoria->update()) {
                header("Location: ../../views/modules/Categoria/index.php");
            } else {
                header("Location: ../../views/Modules/Categoria/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/Modules/Categoria/index.php?respuesta=error");
        }
    }

    static public function searchForId($id_categoria)
    {
        try {
            return Categoria::searchForId($id_categoria);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/Modules/Categoria/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return Categoria::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/Modules/Categoria/Categoria.php?respuesta=error");
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
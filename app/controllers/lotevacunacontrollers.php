<?php


namespace App\Controllers;
require(__DIR__.'/../models/lotevacuna.php');
use app\models\lotevacuna;
use app\models\vacunas;

if(!empty($_GET['action'])) {
    lotevacunacontrollers::main($_GET['action']);
}

class lotevacunacontrollers
{

    static function main($action)
    {
        if ($action == "create") {
            \app\controllers\lotevacunacontrollers::create();
        } else if ($action == "edit") {
            vacunas::edit();
        } else if ($action == "searchForid_lote_vacuna") {
            lotevacunacontrollers::searchForID($_REQUEST['id_lote_vacuna']);
        } else if ($action == "searchAll") {
            lotevacunacontrollers::getAll();
        }/*else if ($action == "login"){
            lotevacunacontrollers::login();
        }else if($action == "cerrarSession"){
            lotevacunacontrollers::cerrarSession();
        }*/

    }

    static public function create()
    {
        try {
            $arraylotevacuna = array();
            $arraylotevacuna['fecha_compra'] = $_POST['fecha_compra'];
            $arraylotevacuna['fecha_vencimiento'] = $_POST['fecha_vencimiento'];
            $arraylotevacuna['laboratori'] = $_POST['laboratori'];
            $arraylotevacuna['cantidad'] = $_POST['cantidad'];
            $arraylotevacuna['costo'] = $_POST['costo'];
            $arraylotevacuna['id_lote_vacuna'] = $_POST['id_lote_vacuna'];
            if (!lotevacuna::lotevacunaRegistrado($arraylotevacuna['id_lote_vacuna'])) {
                $lotevacuna = new vacunas ($arraylotevacuna);
                if ($lotevacuna->create()) {
                    header("Location: ../../views/modules/lotevacuna/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/lotevacuna/create.php?respuesta=error&mensaje=registro_vacuna ya registrado");
            }
        } catch (Exception $e) {
            header("Location: ../../views/modules/lotevacuna/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arraylotevacuna = array();
            $arraylotevacuna['fecha_compra'] = $_POST['fecha_compra'];
            $arraylotevacuna['fecha_vencimiento'] = $_POST['fecha_vencimiento'];
            $arraylotevacuna['laboratori'] = $_POST['laboratori'];
            $arraylotevacuna['cantidad'] = $_POST['cantidad'];
            $arraylotevacuna['costo'] = $_POST['costo'];
            $arraylotevacuna['id_lote_vacuna'] = $_POST['id_lote_vacuna'];

            $user = new vacunas($arraylotevacuna);
            $user->update();

            header("Location: ../../views/modules/lotevacuna/show.php?id=" . $user->getid_lote_vacuna() . "&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/lotevacuna/edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }


    static public function searchForID($id_lote_vacuna)
    {
        try {
            return lotevacuna::searchForid_lote_vacuna($id_lote_vacuna);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/lotevacuna/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return lotevacuna::getAll();
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
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
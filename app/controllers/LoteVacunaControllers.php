<?php


namespace App\Controllers;
require(__DIR__ . '/../models/LoteVacuna.php');

use app\models\LoteVacuna;

if(!empty($_GET['action'])) {
    LoteVacunaControllers::main($_GET['action']);
}

class LoteVacunaControllers
{

    static function main($action)
    {
        if ($action == "create") {
            \app\controllers\LoteVacunaControllers::create();
        } else if ($action == "edit") {
            Lotevacuna::edit();
        } else if ($action == "searchForid_lote_vacuna") {
            LoteVacunaControllers::searchForID($_REQUEST['id_lote_vacuna']);
        } else if ($action == "searchAll") {
            LoteVacunaControllers::getAll();
        }/*else if ($action == "login"){
            LoteVacunaControllers::login();
        }else if($action == "cerrarSession"){
            LoteVacunaControllers::cerrarSession();
        }*/

    }

    static public function create()
    {
        try {
            $arrayLoteVacuna = array();
            $arrayLoteVacuna['fecha_compra'] = $_POST['fecha_compra'];
            $arrayLoteVacuna['fecha_vencimiento'] = $_POST['fecha_vencimiento'];
            $arrayLoteVacuna['laboratorio'] = $_POST['laboratorio'];
            $arrayLoteVacuna['cantidad'] = $_POST['cantidad'];
            $arrayLoteVacuna['costo'] = $_POST['costo'];
            $arrayLoteVacuna['id_lote_vacuna'] = $_POST['id_lote_vacuna'];
            if (!LoteVacuna::lotevacunaRegistrado($arrayLoteVacuna['id_lote_vacuna'])) {
                $LoteVacuna = new LoteVacuna ($arrayLoteVacuna);
                if ($LoteVacuna->create()) {
                    header("Location: ../../views/modules/LoteVacuna/index.php?respuesta=correcto");
                }
            } else {
                header("Location: ../../views/modules/LoteVacuna/create.php?respuesta=error&mensaje=LoteVacuna ya registrado");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/LoteVacuna/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit()
    {
        try {
            $arrayLoteVacuna = array();
            $arrayLoteVacuna['fecha_compta'] = $_POST['fecha_compta'];
            $arrayLoteVacuna['fecha_vencimiento'] = $_POST['fecha_vencimiento'];
            $arrayLoteVacuna['laboratorio'] = $_POST['laboratorio'];
            $arrayLoteVacuna['cantidad'] = $_POST['cantidad'];
            $arrayLoteVacuna['costo'] = $_POST['costo'];
            $arrayLoteVacuna['id_lote_vacuna'] = $_POST['id_lote_vacuna'];

            $user = new LoteVacuna($arrayLoteVacuna);
            $user->update();

            header("Location: ../../views/modules/LoteVacuna/show.php?id=" . $user->getid_lote_vacuna() . "&respuesta=correcto");
        } catch (\Exception $e) {
            //var_dump($e);
            header("Location: ../../views/modules/LoteVacuna/edit.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }



    static public function searchForID($id_lote_vacuna)
    {
        try {
            return LoteVacuna::searchForid_lote_vacuna($id_lote_vacuna);
        } catch (\Exception $e) {
            var_dump($e);
            //header("Location: ../../views/modules/LoteVacuna/manager.php?respuesta=error");
        }
    }

    static public function getAll()
    {
        try {
            return LoteVacuna::getAll();
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
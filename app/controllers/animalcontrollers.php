<?php


namespace app\controllers;
require_once(__DIR__.'/../Models/animal.php');
require_once(__DIR__.'/../Models/persona.php');
require_once(__DIR__.'/../Models/especie');

use app\models\animal;
use App\Models\GeneralFunctions;
use app\models\persona;
use App\Models\Usuarios;
use App\Models\Ventas;

if(!empty($_GET['action'])){
    animalcontrollers::main($_GET['action']);
}

class animalcontrollers
{

    static function main($action)
    {
        if ($action == "create") {
            animalcontrollers::create();
        } else if ($action == "edit") {
            animalcontrollers::edit();
        } else if ($action == "searchForID") {
            animalcontrollers::searchForID($_REQUEST['idanimal']);
        } else if ($action == "searchAll") {
            animalcontrollers::getAll();
        } else if ($action == "activate") {
            animalcontrollers::activate();
        } else if ($action == "inactivate") {
            animalcontrollers::inactivate();
        }
    }

    static public function create()
    {
        try {
            $arrayanimal = array();
            $arrayanimal['peso'] = 'peso';
            $arrayanimal['genero'] = 'genero';
            $arrayanimal['fecha_nacimiento'] = 'fecha_nacimiento';
            $arrayanimal['habitos_alimenticios'] = 'habitos_alimenticios';
            $arrayanimal['observaciones'] = 'observaciones';
            $arrayanimal['persona'] = persona::searchForId($_POST['persona']);
            $arrayanimal['raza'] = especie::searchForId($_POST['raza']);
            $animal = new animal($arrayanimal);
            if($animal->create()){
                header("Location: ../../views/modules/animal/create.php?id=".$animal->getId());
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/animal/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayanimal = array();
            $arrayanimal['peso'] = $_POST['peso'];
            $arrayanimal['genero'] = $_POST['genero'];
            $arrayanimal['fecha_nacimiento'] = $_POST['fecha_nacimiento'];
            $arrayanimal['habitos_alimenticios'] = $_POST['habitos_alimenticios'];
            $arrayanimal['observaciones'] = $_POST['observaciones'];
            $arrayanimal['persona'] = persona::searchForId($_POST['persona']);
            $arrayanimal['raza'] = especie::searchForId($_POST['raza']);
            $arrayanimal['id'] = $_POST['id'];

            $animal = new animal($arrayanimal);
            $animal->update();

            header("Location: ../../views/modules/animal/show.php?id=".$animal->getId()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/animal/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function activate (){
        try {
            $Objanimal = animal::searchForId($_GET['Id']);
            $Objanimal->setEstado("Activo");
            if($Objanimal->update()){
                header("Location: ../../views/modules/animal/index.php");
            }else{
                header("Location: ../../views/modules/animal/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/animal/index.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function inactivate (){
        try {
            $Objanimal = animal::searchForId($_GET['Id']);
            $Objanimal->setEstado("Inactivo");
            if($Objanimal->update()){
                header("Location: ../../views/modules/animal/index.php");
            }else{
                header("Location: ../../views/modules/animal/index.php?respuesta=error&mensaje=Error al guardar");
            }
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/animal/index.php?respuesta=error");
        }
    }

    static public function searchForID ($id){
        try {
            return animal::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            //header("Location: ../../views/modules/animal/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return animal::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'log', 'errorStack');
            header("Location: ../Vista/modules/persona/manager.php?respuesta=error");
        }
    }

}
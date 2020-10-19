<?php

namespace app\controllers;
require(__DIR__.'/../models/registro_vacuna.php');
require_once(__DIR__.'/../models/GeneralFunctions.php');

use App\Models\GeneralFunctions;
use App\Models\DetalleVentas;
use App\Models\Productos;
use App\Models\Ventas;

if(!empty($_GET['action'])){
    registro_vacuna_controllers::main($_GET['action']);
}

class registro_vacuna_controllers{

    static function main($action)
    {
        if ($action == "create") {
            registro_vacuna_controllers::create();
        } else if ($action == "edit") {
            registro_vacuna_controllers::edit();
        } else if ($action == "searchForID") {
            registro_vacuna_controllers::searchForID($_REQUEST['idregistro_vacuna']);
        } else if ($action == "searchAll") {
            registro_vacuna_controllers::getAll();
        } else if ($action == "activate") {
            registro_vacuna_controllers::activate();
        } else if ($action == "inactivate") {
            registro_vacuna_controllers::inactivate();
        }
    }

    static public function create()
    {
        try {
            $arrayregistro_vacuna = array();
            $arrayregistro_vacuna['animal_id'] = animal::searchForId($_POST['animal']);
            $arrayregistro_vacuna['vacuna'] = lotevacuna:searchForIdvacuna($_POST['lote_vacuna']);
            $arrayregistro_vacuna['dosis'] = $_POST['dosis'];
            $arrayregistro_vacuna['fecha'] = $_POST['fecha'];
            $arrayregistro_vacuna['observaciones'] = $_POST['observaciones'];
            $registro_vacuna = new registro_vacuna($arrayregistro_vacuna);
            if($registro_vacuna->create()){
                header("Location: ../../views/modules/registro_vacuna/index.php?respuesta=correcto");
            }
        } catch (Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/registro_vacuna/create.php?respuesta=error&mensaje=" . $e->getMessage());
        }
    }

    static public function edit (){
        try {
            $arrayregistro_vacuna = array();
            $arrayregistro_vacuna['ventas_id'] = animal::searchForId($_POST['animal']);
            $arrayregistro_vacuna['producto_id'] = lotevacuna::searchForId($_POST['lotevacuna']);
            $arrayregistro_vacuna['cantidad'] = $_POST['cantidad'];
            $arrayregistro_vacuna['precio_venta'] = $_POST['fecha_venta'];
            $arrayregistro_vacuna['id'] = $_POST['id'];
            $registro_vacuna = new animal($arrayregistro_vacuna);
            $registro_vacuna->update();
            header("Location: ../../views/modules/registro_vacuna/show.php?id=".$registro_vacuna->getId()."&respuesta=correcto");
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/registro_vacunas/edit.php?respuesta=error&mensaje=".$e->getMessage());
        }
    }

    static public function searchForID ($id){
        try {
            return registro_vacuna::searchForId($id);
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'error', 'errorStack');
            header("Location: ../../views/modules/registro_vacuna/manager.php?respuesta=error");
        }
    }

    static public function getAll (){
        try {
            return registro_vacuna::getAll();
        } catch (\Exception $e) {
            GeneralFunctions::console( $e, 'log', 'errorStack');
            header("Location: ../Vista/modules/registro_vacuna/manager.php?respuesta=error");
        }
    }

}


<?php
require("../../partials/routes.php");
require("../../../app/Controllers/EspecieControllers.php");

use App\Controllers\EspecieControllers; ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Editar Especie</title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Nueva Especie</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">SIGA_San_Rafael</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta'])){ ?>
                <?php if ($_GET['respuesta'] == "error"){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al crear la Especie: <?= ($_GET['mensaje']) ?? "" ?>
                    </div>
                <?php } ?>
            <?php } else if (empty($_GET['id'])) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    Faltan criterios de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                </div>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Horizontal Form</h3>
                </div>
                <!-- /.card-header -->
                <?php if(!empty($_GET["id"]) && isset($_GET["id"])){ ?>
                    <p>
                    <?php
                    $DataEspecie = EspecieControllers::searchForID($_GET["id"]);
                    if(!empty($DataEspecie)){
                        ?>
                        <!-- form start -->
                        <form class="form-horizontal" method="post" id="frmEditTipoAlimento" name="frmEditEspecie" action="../../../app/Controllers/EspecieController.php?action=edit">
                            <input id="id" name="id" value="<?php echo $DataEspecie->getId(); ?>" hidden required="required" type="text">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="nombre" name="nombre" value="<?= $DataEspecie->getNombre(); ?>" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo Documento</label>
                                    <div class="col-sm-10">
                                        <select id="tipo_documento" name="tipo_documento" class="custom-select">
                                            <option <?= ($DataEspecie->getTipoDocumento() == "C.C") ? "selected":""; ?> value="C.C">Cedula de Ciudadania</option>
                                            <option <?= ($DataEspecie->getTipoDocumento() == "T.I") ? "selected":""; ?> value="T.I">Tarjeta de Identidad</option>
                                            <option <?= ($DataEspecie->getTipoDocumento() == "R.C") ? "selected":""; ?> value="R.C">Registro Civil</option>
                                            <option <?= ($DataEspecie->getTipoDocumento() == "Pasaporte") ? "selected":""; ?> value="Pasaporte">Pasaporte</option>
                                            <option <?= ($DataEspecie->getTipoDocumento() == "C.E") ? "selected":""; ?> value="C.E">Cedula de Extranjeria</option>
                                        </select>
                                    </div>
                                </div>-->
                                <div class="form-group row">
                                    <label for="nombre" class="col-sm-2 col-form-label">nombre</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="nombre" name="nombre" value="<?= $DataEspecie->getnombre(); ?>" placeholder="Ingrese el nombre">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="especie" class="col-sm-2 col-form-label">especie</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="especei" name="especie" value="<?= $DataEspecie->getespecie(); ?>" placeholder="Ingrese la especie">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="id_especie" class="col-sm-2 col-form-label">id especie</label>
                                    <div class="col-sm-10">
                                        <input required type="text" class="form-control" id="id_especie" name="id_especie" value="<?= $DataEspecie->getid_tipo_alimento(); ?>" placeholder="Ingrese id de especie">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rol" class="col-sm-2 col-form-label">Rol</label>
                                    <div class="col-sm-10">
                                        <select id="rol" name="rol" class="custom-select">
                                            <option <?= ($DataEspecie->getRol() == "Empleado") ? "selected":""; ?> value="Empleado">Empleado</option>
                                            <option <?= ($DataEspecie->getRol() == "Cliente") ? "selected":""; ?> value="Cliente">Cliente</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="estado" class="col-sm-2 col-form-label">Estado</label>
                                    <div class="col-sm-10">
                                        <select id="estado" name="estado" class="custom-select">
                                            <option <?= ($DataEspecie->getEstado() == "Activo") ? "selected":""; ?> value="Activo">Activo</option>
                                            <option <?= ($DataEspecie->getEstado() == "Inactivo") ? "selected":""; ?> value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Enviar</button>
                                <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    <?php }else{ ?>
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            No se encontro ningun registro con estos parametros de busqueda <?= ($_GET['mensaje']) ?? "" ?>
                        </div>
                    <?php } ?>
                    </p>
                <?php } ?>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require ('../../partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('../../partials/scripts.php');?>
</body>
</html>
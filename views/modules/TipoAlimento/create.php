<?php require("../../partials/routes.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title><?= getenv('TITLE_SITE') ?> | Crear Tipo Alimento</title>
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
                        <h1>Crear un Tipo de Alimento</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/">WebER</a></li>
                            <li class="breadcrumb-item active">Inicio</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <?php if(!empty($_GET['respuesta'])){ ?>
                <?php if ($_GET['respuesta'] != "correcto"){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        Error al crear tipo alimento: <?= $_GET['mensaje'] ?>
                    </div>
                <?php } ?>
            <?php } ?>

            <!-- Horizontal Form -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Horizontal Form</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form class="form-horizontal" method="post" id="frmCreateTipoAlimento" name="frmCreateTipoAlimento" action="../../../app/Controllers/TipoAlimentoController.php?action=create">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
                            <div class="col-sm-10">
                                <input required type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese sus nombre">
                            </div>
                        </div>

                       <!-- <div class="form-group row">
                            <label for="tipo_documento" class="col-sm-2 col-form-label">Tipo Documento</label>
                            <div class="col-sm-10">
                                <select id="tipo_documento" name="tipo_documento" class="custom-select">
                                    <option value="C.C">Cedula de Ciudadania</option>
                                    <option value="T.I">Tarjeta de Identidad</option>
                                    <option value="R.C">Registro Civil</option>
                                    <option value="Pasaporte">Pasaporte</option>
                                    <option value="C.E">Cedula de Extranjeria</option>
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group row">
                            <label for="observaciones" class="col-sm-2 col-form-label">observaciones</label>
                            <div class="col-sm-10">
                                <input required type="text" minlength="10000" class="form-control" id="observaciones" name="observaciones" placeholder="Ingrese las observaciones">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_tipo_alimento" class="col-sm-2 col-form-label">id_tipo_alimento</label>
                            <div class="col-sm-10">
                                <input required type="text" minlength="10000" class="form-control" id="id_tipo_alimento" name="id tipo alimento" placeholder="Ingrese su id del tipo de alimento">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">nombre</label>
                            <div class="col-sm-10">
                                <input required type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre">
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
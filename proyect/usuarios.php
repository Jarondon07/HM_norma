<!DOCTYPE html>
<?php
session_start();
$id = $_SESSION['id'];
$acceso = $_SESSION['acceso'];

if(!empty($id) && !empty($acceso) && $acceso === 'diegoESTUDIO')
{
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <!-- llamado desde inicial -->
        <title id="titulo_pes"></title>
        <!-- favicon -->
        <link id="icon" rel="icon" type="image/png">
        <!-- llamado desde inicial -->

        <!-- Bootstrap Core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="../css/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="../css/startmin.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- nuevos estilos -->
        <link rel="stylesheet" type="text/css" href="../css/new/estilo_new.css">

    </head>
    <body>
        <div align="center" class="loader" id="loader"></div>
        <div id="wrapper">

            <!-- Navigation -->
            <?php
                include 'menu.php';
            ?>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Usuarios - Gestionar</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-right">
                                    <button type="button" class="btn btn-success btn-circle" title="Crear Usuario" data-toggle="modal" data-target="#crear_usuario">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <div id="mensaje"></div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="input-group  custom-search-form">
                                                <input type="text" id="buscar_campo" class="form-control" placeholder="Buscar Registros...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-primary" id="boton_buscar" type="button">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                                                    <thead>
                                                        <tr>
                                                            <th>N° Documento</th>
                                                            <th>Nombre Apellido</th>
                                                            <th>Rol</th>
                                                            <th>Actividad</th>
                                                            <th>Ultimo Ingreso</th>
                                                            <th>Estatus</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="registros_usuarios">
                                                        <!-- aqui van los registros -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                                <div class="panel-footer text-center">
                                    HM
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->


        <!--modal-->
        <div class="modal fade" id="crear_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Crear Usuario</h5>
                    </div>
                    <div class="modal-body" id="from_crear_user">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="mensaje_modal_crear"></div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="documento_error">
                                <label for="documento">N° de Cedula</label>
                                <input type="text" class="form-control solo-numero" id="documento" placeholder="Cedula" maxlength="8"  autofocus>
                            </div>
                            <!--<div class="form-group col-md-6">
                                <label for="password">Contraseña</label>
                                <input type="text" class="form-control" id="password" placeholder="Contraseña">
                            </div>-->
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="primer_nombre_error">
                                <label for="primer_nombre">Primer Nombre</label>
                                <input type="text" class="form-control" id="primer_nombre" maxlength="25" placeholder="Primer Nombre">
                            </div>
                            <div class="form-group col-md-6" id="segundo_nombre_error">
                                <label for="segundo_nombre">Segundo Nombre</label>
                                <input type="text" class="form-control" id="segundo_nombre" maxlength="25" placeholder="Segundo Nombre">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="primer_apellido_error">
                                <label for="primer_apellido">Primer Apellido</label>
                                <input type="text" class="form-control" id="primer_apellido" maxlength="25" placeholder="Primer Apellido">
                            </div>
                            <div class="form-group col-md-6" id="segundo_apellido_error">
                                <label for="segundo_apellido">Segundo Apellido</label>
                                <input type="text" class="form-control" id="segundo_apellido" maxlength="25" placeholder="Segundo Apellido">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_usuario" type="button" class="btn btn-primary">Guardar Usuario</button>
                    </div>
                </div>
            </div>
        </div>
        <!--modal FIN-->

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="../js/bootstrap.min.js"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../js/metisMenu.min.js"></script>

        <!-- Custom Theme JavaScript -->
        <script src="../js/startmin.js"></script>

        <!-- Inicial -->
        <script type="text/javascript" src="js/inicial.js"></script>
        <script type="text/javascript" src="js/funciones.js"></script>
        <script type="text/javascript" src="js/loginOut.js"></script>
        <script type="text/javascript" src="js/usuarios.js"></script>
       
    </body>
</html>
<?php
}
else
{
    header('Location: index.php');
}
?>
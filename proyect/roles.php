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
                            <h3 class="page-header">Roles - Gestionar</h3>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row" id="roles">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-right">
                                    <button type="button" class="btn btn-success btn-circle" title="Crear Rol" data-toggle="modal" data-target="#crear_rol">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <div id="mensaje"></div>
                                    <div class="row">
                                        <div class=" col-lg-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover" style="margin-top: 20px;">
                                                    <thead>
                                                        <tr>
                                                            <th>Rol</th>
                                                            <th>Estatus</th>
                                                            <th>Accion</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="registros_roles">
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
        <div class="modal fade" id="crear_rol" tabindex="-1" role="dialog" aria-labelledby="modal_crear_rol" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_crear_rol">Crear Rol</h5>
                    </div>
                    <div class="modal-body" id="from_crear_rol">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="mensaje_modal_crear"></div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="nombre_rol_error">
                                <label for="nombre_rol">Nombre Rol</label>
                                <input type="text" class="form-control" id="nombre_rol" placeholder="Nombre" maxlength="25"  autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="guardar_rol" type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editar_modulo" tabindex="-1" role="dialog" aria-labelledby="modal_editar_modulo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_editar_modulo">Editar Modulo</h5>
                    </div>
                    <div class="modal-body" id="from_editar_modulo">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="mensaje_modal_editar"></div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="nombre_editar_modulo_error">
                                <label for="editar_nombre_modulo">Nombre Modulo</label>
                                <input type="text" class="form-control" id="editar_nombre_modulo" placeholder="Nombre" maxlength="25"  autofocus>
                            </div>
                            <div class="form-group col-md-6" id="icono_editar_modulo_error">
                                <label for="editar_icono_modulo">icono</label>
                                <input type="text" class="form-control" id="editar_icono_modulo" placeholder="fa fa-ejemplo" maxlength="25">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" id="descripcion_editar_modulo_error">
                                <label for="editar_descripcion_modulo">Descripción</label>
                                <input type="text" class="form-control" id="editar_descripcion_modulo" placeholder="Descripción" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="boton_editar_modulo" type="button" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="crear_sesion" tabindex="-1" role="dialog" aria-labelledby="modal_crear_sesion" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_crear_sesion">Crear Sesion</h5>
                    </div>
                    <div class="modal-body" id="from_crear_sesion">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="mensaje_modal_sesion_crear"></div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="nombre_sesion_error">
                                <label for="nombre_sesion">Nombre</label>
                                <input type="text" class="form-control" id="nombre_sesion" placeholder="Descripcion" maxlength="25" autofocus>
                            </div>
                            <div class="form-group col-md-6" id="icono_sesion_error">
                                <label for="icono_sesion">icono</label>
                                <input type="text" class="form-control" id="icono_sesion" placeholder="fa fa-ejemplo" maxlength="25">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6" id="archivo_sesion_error">
                                <label for="archivo_sesion">Link Archivo</label>
                                <input type="text" class="form-control" id="archivo_sesion" placeholder="Archivo Ejemplo: index.php" maxlength="30">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12" id="descripcion_sesion_error">
                                <label for="descripcion_sesion">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_sesion" placeholder="Descripción" maxlength="100">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="guardar_sesion">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONFIRMAR -->
        <div class="modal fade" id="confirmar_modal" tabindex="-1" role="dialog" aria-labelledby="modal_crear_sesion" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_confirmar">Confirmar Accion</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label id="detalle_mensaje"></label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="aceptar_confirmar">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="editar_sesion" tabindex="-1" role="dialog" aria-labelledby="modal_editar_sesion" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_editar_sesion">Editar Sesion</h5>
                    </div>
                    <div class="modal-body" id="from_editar_sesion">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div id="mensaje_modal_editar_sesion"></div>
                            </div>   
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6" id="nombre_editar_sesion_error">
                                <label for="editar_nombre_sesion">Nombre Sesion</label>
                                <input type="text" class="form-control" id="editar_nombre_sesion" placeholder="Nombre" maxlength="25"  autofocus>
                            </div>
                            <div class="form-group col-md-6" id="icono_editar_sesion_error">
                                <label for="icono_editar_sesion">icono</label>
                                <input type="text" class="form-control" id="icono_editar_sesion" placeholder="fa fa-ejemplo" maxlength="25">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12" id="descripcion_editar_sesion_error">
                                <label for="editar_descripcion_sesion">Descripción</label>
                                <input type="text" class="form-control" id="editar_descripcion_sesion" placeholder="Descripción" maxlength="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button id="boton_editar_sesion" type="button" class="btn btn-primary">Actualizar</button>
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
        <script type="text/javascript" src="js/roles.js"></script>
       
    </body>
</html>
<?php
}
else
{
    header('Location: index.php');
}
?>
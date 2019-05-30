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
                            <h1 class="page-header">Consulta - Archivos</h1>
                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Buscar Archivos
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
                                                            <th>N° Expediente</th>
                                                            <th>Rif</th>
                                                            <th>Tomo</th>
                                                            <th>Folio</th>
                                                            <th>Ubicacion</th>
                                                            <th>Funcionario</th>
                                                            <th>Sujeto Aplicacion</th>
                                                            <th>Direccion</th>
                                                            <th>Fecha Registo</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="registros_archivo">
                                                        <!-- aqui van los registros -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                                <div class="panel-footer text-center">
                                    SDA-SUNDDE
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
        <script type="text/javascript" src="js/archivos.js"></script>
        <script type="text/javascript">
            buscarRegistros();
        </script>

    </body>
</html>
<?php
}
else
{
    header('Location: index.php');
}
?>
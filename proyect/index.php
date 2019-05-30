<!DOCTYPE html>
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

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="fondo">
        <header class="header-area">
            <div class="header-top">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="top-menu">
                                <p class="welcome-msg">Bienvenidos: HM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4">
                    <div class="img_center">
                        <img src="#" alt="logo">
                    </div>
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Iniciar Sesion</h3>
                        </div>
                        <div class="panel-body">
                            <div id="mensaje"></div>
                            <form role="form">
                                <fieldset>
                                    <div class="form-group" id="documento_error">
                                        <input class="form-control" placeholder="Documento" name="documento" maxlength="8" id="documento" type="documento" autofocus>
                                    </div>
                                    <div class="form-group" id="contra_error">
                                        <input class="form-control" placeholder="Contraseña" name="password" id="password" type="password" value="">
                                    </div>
                                    <!--<div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>-->
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="button" class="btn btn-success btn-lg btn-block" id="login">Iniciar Sesion</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer-area">
            <div class="copyright-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="copyright">
                                <p>Derechos de autor &copy;  SUNDDE - 2019.</p>
                                <div class="payment">
                                    <p>Diseño web por <a href="#"> GRUPO UNEXCA</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

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
        <script type="text/javascript" src="js/login.js"></script>

    </body>
</html>

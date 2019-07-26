<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="inicio.php">HM</a>
    </div>

    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <ul class="nav navbar-right navbar-top-links">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido'];?> <b class="caret"></b>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <!--<li>
                    <a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                </li>
                <li class="divider"></li>-->
                <li>
                    <a id="login_out" style="cursor: pointer;" onclick="<?php echo "cerrar_seccion(".$id.",'".$acceso."')";?>"><i class="fa fa-sign-out fa-fw"></i> Cerrar Sesion</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="usuarios.php">
                        <i class="fa fa-user fa-fw"></i> 
                        Usuarios
                    </a>
                </li>
                <li>
                    <a href="modulos.php">
                        <i class="fa fa-random"></i> 
                        Modulos Secciones
                    </a>
                </li>
                <li>
                    <a href="roles.php">
                        <i class="fa fa-random"></i> 
                        Roles
                    </a>
                </li>
                <li class="">
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Archivos<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li>
                            <a href="#"> Registrar</a>
                        </li>
                        <li>
                            <a href="consulta.php"> Consulta</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li> 
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>


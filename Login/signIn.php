<!DOCTYPE html>
<?php
//@author: Oscar Gonzalez Martinez
//@date: 22/11/2021
//@version: 1.0

//Página de Login.
include_once "../Class/Persona.class.php";
include_once "../Class/Usuario.class.php";
include_once "../Class/Admin.class.php";
include_once "../Class/Validacion.class.php";
include_once "../Class/Erro.class.php";
include_once "../DAO/DAO.class.php";
include_once "../Class/Log.class.php";
//Comento el inicio de Sesión. Se inicia Sesión desde el Menú para poder mostrar el enlace a cerrar sesión si hay una sesion iniciada.
session_status() === PHP_SESSION_ACTIVE ?: session_start();
if (isset($_SESSION['userLogged'])) {
    header('Location: ../index.php');
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../css/custom.css">
    <?php
    include '../head.php';
    ?>
</head>

<body>
    <?php
    include '../menu.php';
    ?>
    <div class="fondo alto">
        <div class="container">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="col-12 pt-3 pb-1">
                    <h1 class="text-primary">Iniciar sesión</h1>
                </div>
                <div class="container border border-5 border border-primary border rounded-3 bg-light">
                    <div class="col-12 col-lg-12">
                        <div class="row">
                            <div class="col-12 col-lg-12 px-3 mt-3">
                                <label for="loginUserName">Nome de Usuario</label>
                                <input type="text" name="loginUserName" class="input-group-text" value="" placeholder="Introduce un nombre de usuario" />
                            </div>
                            <div class="col-12 col-lg-12 px-3 mt-3">
                                <label>Contraseña</label>
                                <input type="password" class="input-group-text" name="loginPassWord" />
                            </div>
                            <div class="col-12 col-lg-12 px-3 mt-3 mb-3">
                                <input type="submit" value="Enviar" class="btn btn-primary" name="loginSend" />
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
        <?php

        $login = $passWord = "";

        if (isset($_POST['loginSend'])) {
            //Almacenamos en las variables los datos, después de estar validados.
            $login = $_POST['loginUserName'];
            $passWord = $_POST['loginPassWord'];

            if (empty($login) || empty($passWord)) {
                Erro::addError("EmptyField", "Introduzca Login y contraseña");
                echo Erro::showErrors();

                registrarLogIn(3);
            } else {
                $user = DAO::authenticateUser($login, $passWord);
                if ($user != null) {
                    $_SESSION['userLogged'] = $user;
                    //$visitas = new Visitas($username->getLogin(), $ip, $fecha, $serveName, $browser, $so, $requestTime);
                    //DAO::insertVisit($visitas);

                    registrarLogIn(1, $login);
                } else {
                    Erro::addError("UserAuthenticateError", "No parece haber ningún usuario con ese nombre");
                    echo Erro::showErrors();

                    registrarLogIn(2, $login);
                }
            }
        }

        /**
         * Empleado para llevar registro de visitas y del log.
         * 
         * - case 1: Login correcto
         * - case 2: Login incorrecto, usuario o contraseña no son válidos
         * - case 3: Login incorrecto, alguno de los campos está vacío
         */
        function registrarLogIn($tipo, $login = null)
        {
            $ip = Visitas::guessIP();
            $location = Visitas::locateIP($ip);

            switch ($tipo) {
                case 1:
                    // Login correcto
                    DAO::writeLog(new Log("se ha logueado en la aplicación desde " . $ip . "(" . $location . ")", $login));
                    break;
                case 2:
                    // Login incorrecto, usuario o contraseña no son válidos
                    DAO::writeLog(new Log("se ha intentado loguear como " . strtoupper($login) . " en la aplicación desde " . $ip . "(" . $location . ") - " . Erro::showErrorsLog()));
                    break;
                case 3:
                    // Login incorrecto, alguno de los campos está vacío
                    DAO::writeLog(new Log("se ha intentado loguear en la aplicación desde " . $ip . "(" . $location . ") - " . Erro::showErrorsLog()));
                    break;
            }
        }
        ?>
    </div>
    </div>
    <?php include_once "../cookieAlert.php" ?>
</body>

</html>
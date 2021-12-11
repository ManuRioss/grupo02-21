<!DOCTYPE html>
<?php
//@author: Oscar Gonzalez Martinez
//@date: 22/11/2021
//@version: 0.9
//include "validaciones.php";
//Página de Login.
include_once "../Class/Persona.class.php";
include_once "../Class/Usuario.class.php";
include_once "../Class/Admin.class.php";
include_once "../Class/Validacion.class.php";
include_once "../Class/Erro.class.php";
include_once "../DAO/DAO.class.php";
include_once "../Class/Log.class.php";
session_start();
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
                                <input type="text" name="loginUserName" class="input-group-text" value="" placeholder="Introduce un nombre de usuario"/>
                            </div>
                            <div class="col-12 col-lg-12 px-3 mt-3">
                                <label>Contraseña</label>
                                <input type="password" class="input-group-text" name="loginPassWord"/>
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

            // LOGIN INCORRECTO - Añade un registro al LOG
            DAO::writeLog(new Log("se ha intentado loguear en la aplicación desde " . $_SERVER['REMOTE_ADDR'] . " - " . Erro::showErrorsLog()));
        } else {
            $user = DAO::authenticateUser($login, $passWord);            
            if ($user != null) {
                $_SESSION['userLogged'] = $user;  
                $visitas = new Visitas($username->getLogin(),$ip,$fecha,$serveName,$browser,$so,$requestTime);
                DAO::insertVisit($visitas);
                // LOGIN CORRECTO - Añade un registro al LOG
                DAO::writeLog(new Log("se ha logueado en la aplicación desde " . $_SERVER['REMOTE_ADDR'], $login));
            } else {
                Erro::addError("UserAuthenticateError", "No parece haber ningún usuario con ese nombre");
                echo Erro::showErrors();

                // LOGIN INCORRECTO - Añade un registro al LOG
                DAO::writeLog(new Log("se ha intentado loguear como " . strtoupper($login) . " en la aplicación desde " . $_SERVER['REMOTE_ADDR'] . " - " . Erro::showErrorsLog()));
            }
        }
    }

    ?>
        </div>
    </div>
</body>

</html>
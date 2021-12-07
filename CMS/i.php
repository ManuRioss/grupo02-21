<?php
/*
 * Author: Jorge Carreño Miranda
 * Version:1.0.0
 * Last modified: 02/12/2021
 */
//HACER COMO LA GESTIÓN DE USUARIOS PERO CON ENTRADAS(DOCUMENTOS);
require_once '../Class/CMS.class.php';
require_once '../DAO/DAO.class.php';
require_once '../Class/Validacion.class.php';
require_once '../Class/Erro.class.php';
$datosCorrectos = true;
$datos = array();
?>
<html>
    <head>
        <meta charset="utf-8">
        <link type="text/css" href="ckeditor/sample/css/sample.css" rel="stylesheet" media="screen" />
        <title>Indice</title>
    </head>
    <body><br>

        <?php
        $titulo = ""; //hay q pasarle validacion de solo letras
        $cuerpo = "";
        $errorTitulo = "";
        $errorCuerpo = "";
        ?>

    </table>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="formulario" id="formulario">
        <div class="centered">
            <h1>Titulo</h1><br>
            <input type="text" name="titulo" maxlength="150" value="<?php echo $titulo; ?>" size="107">
            <br>
            <?php echo validaTitulo(); ?>
            <br>
            <textarea name="cuerpo" id="editor"><?php echo $cuerpo; ?></textarea>
            <br>
            <?php validaCuerpo(); ?>
            <input type="submit" value="publicar" name="enviar" />
            <input type="submit" value="borrar todo" name="borrar"/><br></br>
        </div>
    </form>
    <script src="ckeditor/ckeditor.js"></script>
    <script>
        ClassicEditor
                .create(document.querySelector('#editor'), {
                    //toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
                })
                .then(editor => {
                    window.editor = editor;
                })
                .catch(err => {
                    console.error(err.stack);
                });
    </script>

    <?php

    function validaTitulo() {
        global $titulo;
        if (isset($_POST['enviar'])) {
            // Validar que el titulo solo contenga letras
            if (Validacion::campoVacio($_POST['titulo'])) {
                Erro::addError('EmptyFieldErrorTitle', 'El campo titulo esta vacío');
            } else {
                $titulo = $_POST['titulo'];
            }
        }
    }

    function validaCuerpo() {
        global $cuerpo;
        if (isset($_POST['enviar'])) {
            if (Validacion::campoVacio($_POST['cuerpo'])) {
                Erro::addError('EmptyFieldErrorBody', 'El campo cuerpo esta vacío');
            } else {
                $cuerpo = $_POST['cuerpo'];
            }
        }
    }

    if (isset($_POST['enviar']) && Erro::countErros() == 0) {
        if (DAO::existsArticle($titulo)) {
            Erro::addError('existsTitle', 'El titulo ya existe');
            echo Erro::showErrors();
        } else {
            $nuevo = new Publicacion($titulo, $cuerpo);
            DAO::insertArticle($nuevo);
        }
    } else {
        echo Erro::showErrors();
    }

    if (isset($_POST['borrar'])) {
        $titulo = "";
        $cuerpo = "";
    }
    $articulos = DAO::getArticles();
    if ($articulos != null) {
        ?>
        <table border="1">
            <tr>
                <th>Titulo</th>
                <th>Cuerpo </th>
                <th>Eliminacion</th>
                <!--<th>Edicion</th>-->
            </tr>
            <?php
            foreach ($articulos as $novas) {
                ?>
                <tr>
                    <td><?php echo $novas->getTitulo() ?></td>
                    <td><?php echo $novas->getCuerpo() ?></td>
                    <td><a href='./elimArticle.php?titulo=<?php echo $novas->getTitulo() ?>'>Eliminar</a></td>
                    <!--<td><a href="elimArticle.php?titulo=<?php //$novas->getTitulo()    ?>">Editar</a></td>-->
                </tr>
                <?php
            }
        }
        ?>
    </table>
</body>
</html>
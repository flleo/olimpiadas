<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario Deportistas_FedericoLleó</title>
        <meta name="description" content="
              Formulario para recoger datos de la tabla deportistas: El dni deberá cumplir que solo admita números donde son
              números y letras donde corresponda, deberá tener el formato
              44.555.666-K, usar funciones como preg_match, ctype_alpa, ctype_digit , ....">
        <link rel="stylesheet" type="text/css"	href="estilo.css">
    </head>
    <body>



        <?php
        require_once 'Session.php';



//Tabla deportistas//////////////////////////////////////////////////////////////////////////// 

        echo' <h2 class="listado">Listado de Deportistas</h2>
            <table title="Listado de Deportistas">
                <tr>
                    <th>Nombre del Deportista</th><th>Dni del Deportista</th><th>Pais del Deportista</th>
                </tr>';

        Session::conectaDb();
        $array = Session::lee();

        echo'</table> ';

//Ejecucion de la baja/////////////////////////////////////////////////////////////////////////////

        if (isset($_GET['Id']) && $_GET['Id'] != '') {
            Session::conectaDb();
            Session::baja($_GET['Id']);
            echo'<script>location.href = "Listado.php";</script>';
        }
        ?>

    </body>
</html>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario Deportistas_FedericoLleó</title>
        <meta name="description" content="Alta y modificacion de deportistas">

        <link rel="stylesheet" type="text/css"	href="estilo.css">
    </head>
    <body>

        <?php
        require_once 'Session.php';

        //Seleccionar//////////////////////////////////////////////////////////////////////

        $codDeportista = '';
        $nombreDeportista = '';
        $dniDeportista = '';
        $paisDeportista = '';

        if (isset($_POST['seleccionar'])) {

            $codigoDeportista = $_POST['codigoDeportista'];
            $nombreDeportista = $_POST['nombreDeportista'];
            $dniDeportista = $_POST['dniDeportista'];
            $paisDeportista = $_POST['paisDeportista'];
        }


        //Alta_Modificar////////////////////////////////////////////////////////////////////////////


        echo' 
        <h2 class="alta">Formulario Nuevo Deportista</h2>';
        echo' 
            <table title="Nuevo Deportista" >
                <tr>
                    <th>Nombre del Deportista</th><th>Dni del Deportista</th><th>Pais del Deportista</th>
                </tr>
                <form action="' . alta_modificar() . '" method="post" enctype="multipart/form-data">
                <tr> 
                    <td><input name="nombreAM" value="' . $nombreDeportista . '"></td><td><input title="11.111.111-A" name="dniAM" value="' . $dniDeportista . '"></td>
                        <td>';
        //Combo paises////////////////////////////////////////////////////////////////////////////////////////
         echo'            <select name="paisAM" >';
        Session::conectadB();
        $paises = Session::paises();

        for ($i = 0; $i < count($paises); $i++) {
            if ($paisDeportista === $paises[$i])
                echo'<option value="' . $paises[$i] . '" selected>' . $paises[$i] . '</option>';
            else
                echo'<option value="' . $paises[$i] . '" >' . $paises[$i] . '</option>';
        }
        echo' 
                        </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////////
        echo '          </td>
                    <td><input  name="alta" type="submit" value="alta"></td>
                    <td><input  name="modificar" type="submit" value="modificar"></td>
                </tr>
                </form>
    
            </table> ';

        //Ventana emergen de confirmacion de la baja////////////////////////////////////////////////////////////////////////////////

        if (isset($_POST['baja'])) {
            // echo $_POST['codigoDeportista'];
            echo'
            <script languaje="JavaScript">
                if (window.confirm("¿Está seguro que desea eliminar el registro seleccionado?")) {
	   	   location.href = "Listado.php?&Id=' . $_POST['codigoDeportista'] . '";
                }
                else{
                    location.href = "Listado.php";
                }
            </script>';
        }

        //Funciones////////////////////////////////////////////////////////////////////

        function alta_modificar() {
            $nombre = 'null';
            $pais = 'null';

            if (isset($_POST['dniAM']) && $_POST['dniAM'] != '') {
                if (isset($_POST['nombreAM']) && $_POST['nombreAM']) {
                    $nombre = $_POST['nombreAM'];
                }
                if (isset($_POST['paisAM']) && $_POST['paisAM']) {
                    $pais = $_POST['paisAM'];
                }

                //DNI :comprobación////////////////////////////////////////////////////////////////////
                
                $nif = $_POST['dniAM'];
                //Captura de warning y notice y los manda a una función que los confierte en true para el sistema//////////////////////////////////////////
                set_error_handler("myFunctionErrorHandler", E_WARNING);
                set_error_handler("myFunctionErrorHandler", E_NOTICE);
                ////////////////////////////////////////////////////////////////////
                    $partes = explode('-', $nif);

                    $numerosP = $partes[0];

                    $numeros = substr($numerosP, -10, 2) . substr($numerosP, -7, 3) . substr($numerosP, -3, 3);
                    if (is_numeric($numeros)) {

                        $letra = strtoupper($partes[1]);

                        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra) {
                            if (substr($numerosP, -8, 1) === '.' && substr($numerosP, -4, 1) === '.') {
                                if (isset($_POST['alta'])) {
                                    Session::conectaDb();
                                    Session::inserta($nombre, $nif, $pais);
                                    echo '<script>location.href = "http://localhost/FormularioDeportistas1/Listado.php";</script>';
                                } else {
                                    if (isset($_POST['modificar'])) {
                                        Session::conectaDb();
                                        Session::modifica($nombre, $nif, $pais);
                                        echo '<script>location.href = "http://localhost/FormularioDeportistas1/Listado.php";</script>';
                                    }
                                }
                            } else {
                                echo '<p>Formato incorrecto debe ser : 11.111.111-a</p>';
                            }
                        } else {
                            echo '<p>La letra introducida no es corrrecta!</p>';
                        }
                    } else {
                        echo '<p>Formato incorrecto debe ser : 11.111.111-a</p>';
                    }
            } else {
                if (isset($_POST['alta']) && $_POST['dniAM'] === '')
                    echo'Debes introducir un D.N.I.';
            }
        }

// función de gestión de errores//////////////////////////////////////////////////////////////////////////
        
        function myFunctionErrorHandler($errno, $errstr, $errfile, $errline) {
            /* Según el típo de error, lo procesamos */
            switch ($errno) {
                case E_WARNING:
                    //   echo "Hay un WARNING.<br />\n";
                    //   echo "El warning es: ". $errstr ."<br />\n";
                    //   echo "El fichero donde se ha producido el warning es: ". $errfile ."<br />\n";
                    //   echo "La línea donde se ha producido el warning es: ". $errline ."<br />\n";
                    /* No ejecutar el gestor de errores interno de PHP, hacemos que lo pueda procesar un try catch */
                    return true;
                    break;

                case E_NOTICE:
                    //echo "Hay un NOTICE:<br />\n";
                    /* No ejecutar el gestor de errores interno de PHP, hacemos que lo pueda procesar un try catch */
                    return true;
                    break;

                default:
                    /* Ejecuta el gestor de errores interno de PHP */
                    return false;
                    break;
            }
        }
        ?>

    </body>
</html>
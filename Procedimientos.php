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
    <body class="procedimientos">
<?php


include_once 'Session.php';
/* 
 * Procedimientos y función.
 */

$fecha='';$v1='';$v2='';$v3='';$paisP2='';$paisP3='';$paisP4='';

/* PROCEDIMIENTO1:
 * Procedimiento almacenado pInserteMedalla que inserte un registro
en la tabla medallas que le pasemos por parámetro el dni del deportista, el
código de la prueba , la fecha y el puesto. Habrá que buscar en la tabla
deportista cual es el código del deportista por el dni introducido. 
*/

echo'<h2 class="procedimientos">Nueva Medalla</h2>
        <table class="proce1">
            <tr><th>DEPORTISTA</th><th>PRUEBA</th><th>FECHA</th><th>PUESTO</th></tr>
            <form action="'.pInserteMedalla().'"  method="post" enctype="multipart/form-data"
                  <tr><td>';
        //Combo dni////////////////////////////////////////////////////////////////////////////////////////
         echo'            <select name="dniP" >';
        Session::conectadB();
        $dni = Session::dni();
        if(isset($_GET['dniP1']) && $_GET['dniP1']!='') 
            echo'<option value="' . $_GET['dniP1'] . '" selected>' .$_GET['dniP1'] . '</option>';
        for ($i = 0; $i < count($dni); $i++) {
            if (isset($_GET['dniP1']) && $_GET['dniP1']!=$dni[$i])
                        echo'<option value="' . $dni[$i] . '" >' . $dni[$i] . '</option>';
            else if(!isset($_GET['dniP1']))echo'<option value="' . $dni[$i] . '" >' . $dni[$i] . '</option>';
        }
        echo' 
                        </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        echo '        </td>
                      <td>';
        //Combo codigoPrueba////////////////////////////////////////////////////////////////////////////////////////
        echo'            <select name="codigoPruebaP" >';
        Session::conectadB();
        $cod = Session::codigoPrueba();
        if(isset($_GET['codigoPruebaP1']) && $_GET['codigoPruebaP1']!='') 
            echo'<option value="' . $_GET['codigoPruebaP1'] . '" selected>' .$_GET['codigoPruebaP1'] . '</option>';
        for ($i = 0; $i < count($cod); $i++) {
            if(isset($_GET['codigoPruebaP1']) && $_GET['codigoPruebaP1']!=$cod[$i]) 
                        echo'<option value="' . $cod[$i] . '">' . $cod[$i] . '</option>';
            else  if(!isset($_GET['codigoPruebaP1']))echo'<option value="' . $cod[$i] . '">' . $cod[$i] . '</option>';
        }
        echo' 
                        </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
         if(isset($_GET['fechaP1']) && $_GET['fechaP1']!='') $fecha=$_GET['fechaP1'];
         echo         '</td><td><input type="date" name="fechaP" value="'.$fecha.'"></input></td>'
                    . '<td>';
        //Combo puesto////////////////////////////////////////////////////////////////////////////////////////
        if(isset($_GET['puestoP1']))
                switch($_GET['puestoP1']){
                    case 1:$v1='selected';                        break;
                    case 2:$v2='selected';                        break;
                    case 3:$v3='selected';                        break;
                }
        echo'            <select name="puestoP" >
                            <option value="1" '.$v1.'>1</option>
                            <option value="2" '.$v2.'>2</option>
                            <option value="3" '.$v3.'>3</option>
                        </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
                echo'  </td><td><input  name="añadir" type="submit" value="Añadir"></td>
                    </tr>
            </form>
        </table>  ';
//PROCEDIMIENTO2 pListaDeportistas/////////////////////////////////////////////////////////////////////////////
echo'   <h2 class="procedimientos">Listado Deportistas por Pais</h2>
        <table class="proce2">
            <tr><th>PAIS</th></tr>
            <form action="'.pListaDeportistas().'"  method="post" enctype="multipart/form-data"
                  <tr><td>';
        //Combo PAIS////////////////////////////////////////////////////////////////////////////////////////
         echo'            <select name="pais" >';
        Session::conectadB();
        $pais = Session::pais();
        for ($i = 0; $i < count($pais); $i++) {
            if($paisP2===$pais[$i]) 
                echo'<option value="' . $pais[$i] . '" selected>' . $pais[$i] . '</option>';
            else  echo'<option value="' . $pais[$i] . '" >' . $pais[$i] . '</option>';
        }
        echo' 
                        </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        echo '        </td><td><input name="acceder" type="submit" value="Acceder"></td>
                </form>
            </table>';
          
   //PROCEDIMIENTO3 pCantidadMedallas/////////////////////////////////////////////////////////////////////////////
echo'<div class="proce3"><h2 class="procedimientos">Medallero por Pais</h2>
        <table >
            <tr><th>PAIS</th></tr>
                <form action="'.pCantidadMedallas().'"  method="post" enctype="multipart/form-data">
                      <tr><td>';
        //Combo PAIS////////////////////////////////////////////////////////////////////////////////////////
         echo'                  <select name="paisM" >';
        Session::conectadB();
        $pais = Session::pais();
        for ($i = 0; $i < count($pais); $i++) {
            if($paisP3===$pais[$i]) 
                echo'<option value="' . $pais[$i] . '" selected>' . $pais[$i] . '</option>';
            else  echo'<option value="' . $pais[$i] . '" >' . $pais[$i] . '</option>';
              }
        echo' 
                                </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        echo '              </td>
                            <td><input name="acceder" type="submit" value="Acceder"></td>
                      </tr>
                </form>
        </table>
    </div>
    ';   
     //FINCION fDeportistaPais/////////////////////////////////////////////////////////////////////////////
echo'<div class="funcion"><h2 class="procedimientos">Cantidad de Deportistas por Pais</h2>
        <table >
            <tr><th>PAIS</th></tr>
                <form action="'.fDeportistaPais().'"  method="post" enctype="multipart/form-data">
                      <tr><td>';
        //Combo PAIS////////////////////////////////////////////////////////////////////////////////////////
         echo'                  <select name="paisD" >';
        Session::conectadB();
        $pais = Session::pais();
        for ($i = 0; $i < count($pais); $i++) {
            if($paisP4===$pais[$i]) 
                echo'<option value="' . $pais[$i] . '" selected>' . $pais[$i] . '</option>';
            else  echo'<option value="' . $pais[$i] . '" >' . $pais[$i] . '</option>';
              }
        echo' 
                                </select>';
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        echo '              </td>
                            <td><input name="acceder" type="submit" value="Acceder"></td>
                      </tr>
                </form>
        </table>
    </div>
    ';        
        
        
        
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//FUNCIONES PARA LOS Procedimientos//////////////////////////////////////////////////////////////////////////////////
       
    function pInserteMedalla(){
    if(isset($_POST['dniP']) && $_POST['dniP']!='' && isset($_POST['codigoPruebaP']) && $_POST['codigoPruebaP']!=''
            && isset($_POST['fechaP']) && $_POST['fechaP']!=''){
       Session:: conectaDb();
       Session::pInserteMedalla($_POST['dniP'],$_POST['codigoPruebaP'],$_POST['fechaP'],$_POST['puestoP']);
       echo '<script>location.href = "Procedimientos.php?'
               . '&dniP1=' . $_POST['dniP'] . ''
               . '&codigoPruebaP1='.$_POST['codigoPruebaP'].''
               . '&fechaP1='.$_POST['fechaP'].''
               . '&puestoP1='.$_POST['puestoP']
          . '"</script>';
      
    }

    function pListaDeportistas(){
         if(isset($_POST['pais']) && $_POST['pais']!=''){
                Session::conectaDb();
                $nombres=Session::pListaDeportistas($_POST['pais']);
                echo'<table class="proce2_1" ><tr><th>DEPORTISTAS</th></tr>';
                for ($i = 0; $i < count($nombres); $i++) 
                   echo' <tr><td><input value="' . $nombres[$i] . '" readonly ></input></td></tr>';
                echo'</table>  ';  
                global $paisP2;
                $paisP2=$_POST['pais'];
            } 
    }
    
    function pCantidadMedallas(){
         if(isset($_POST['paisM']) && $_POST['paisM']!=''){
                Session::conectaDb();
                $medallero=Session::pCantidadMedallas($_POST['paisM']);
                echo'<table class="proce3_1">'
                . '     <tr><td><input value="Oros: '.$medallero['oro'].', Platas: '.$medallero['plata'].','
                        . ' Bronces: '.$medallero['bronce'].'"/> </td>'
                      . '</tr>'
                   . '</table>';  
                global $paisP3;
                $paisP3=$_POST['paisM'];
            } 
    }
    
    function fDeportistaPais(){
        if(isset($_POST['paisD']) && $_POST['paisD']!=''){
                Session::conectaDb();
                $can=Session::fDeportistaPais($_POST['paisD']);
                echo'<table class="funcion_">'
                . '     <tr><td><input value="'.$can.' deportistas."/> </td></tr>'
                   . '</table>';  
                global $paisP4;
                $paisP4=$_POST['paisD'];
            } 
    }
    
}
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

require_once 'index.php';
// FUNCIÓN DE CONEXIÓN CON LA BASE DE DATOS MYSQL
class Session {

    static $pdo;


    function conectaDb() {
        
        $host = 'localhost';
        $dbname = 'bdOlimpiadas';
        $user = 'root';
        $pass = '';
     
        try {   # MySQL con PDO_MYSQL
                # Para que la conexion al mysql utilice las collation UTF-8 añadir charset=utf8 al string
                #de la conexion .
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user ,$pass);
                # Para que genere excepciones a la hora de reportar errores.
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
        } catch (PDOException $e) {
            echo $e->getMessage();
            
        }
    }
    
    function  lee() {
        
        try {
            $stmt = self::$pdo->query('SELECT * from deportistas');

            # Ajustamos el modo de obtención de datos, los resultados los tendremos en objetos
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            
            while ($row = $stmt->fetch()) {
                
              $codigoDeportista=  $row->codDeportista;
              $nombreDeportista = $row->nombreDeportista;
              $dniDeportista = $row->dniDeportista;
              $paisDeportista = $row->paisDeportista;
              
              echo '<form  action="Alta.php?codigoDeportista='.$codigoDeportista.'" method="post" enctype="multipart/form-data">';
              echo '<tr><input class="codDeportista" name="codigoDeportista" readonly=""  value="'.$codigoDeportista.'"><td><input name="nombreDeportista" readonly="" value="'.$nombreDeportista.'"></td><td><input readonly="" name="dniDeportista" value="'.$dniDeportista.'"></td><td><input   readonly="" name="paisDeportista"  value="' . $paisDeportista . '"></td><td><input class="seleccionar" name="seleccionar" type="submit" value="Seleccionar"></td><td><input class="baja" name="baja" type="submit" value="Baja"></td></tr>';
              echo' </form> '; 
            

            }
            # Liberamos los recursos utilizados por $stmt
            $stmt = null;
           
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }
    }
    
    function dni(){
        $array=[];$i=0;
        try {
            $stmt = self::$pdo->query('SELECT dniDeportista from deportistas');
  
            while ($row = $stmt->fetch()) {
                $array[$i]=$row['dniDeportista'];
                $i++;
            }
            $stmt = null;   # Liberamos los recursos utilizados por $stmt
            if(count($array)!=0)
            return $array;
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }
    }
    
    function pais(){
        $array=[];$i=0;
        try {
            $stmt = self::$pdo->query('SELECT nombrePais from paises');
  
            while ($row = $stmt->fetch()) {
                $array[$i]=$row['nombrePais'];
                $i++;
            }
            $stmt = null;   # Liberamos los recursos utilizados por $stmt
            if(count($array)!=0)
            return $array;
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }
    }
    
    function deportistaConId($codDep){
        
        try {
            $stmt = self::$pdo->prepare("SELECT * FROM deportistas WHERE codDeportista=?");
            $stmt->bindParam(1, $codDep);
            # Ajustamos el modo de obtención de datos, los resultados los tendremos en objetos
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $objeto = $stmt->fetch();// echo $objeto->nombreDeportista;
            # Liberamos los recursos utilizados por $stmt
            $stmt = null;
            
            return $objeto;
            
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo $err;//"Error: El deportista no se localiza.";
        }
    }
    
    function paises(){
         $array=[];$i=0;
        try {
            $stmt = self::$pdo->query('SELECT codPais from paises');
  
            while ($row = $stmt->fetch()) {
                $array[$i]=$row['codPais'];
                $i++;
            }
            $stmt = null;   # Liberamos los recursos utilizados por $stmt
            if(count($array)!=0)
            return $array;
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }
    }            
    
    function codigoPrueba(){
        $array=[];$i=0;
        try {
            $stmt = self::$pdo->query('SELECT codPrueba from pruebas');
  
            while ($row = $stmt->fetch()) {
                $array[$i]=$row['codPrueba'];
                $i++;
            }
            $stmt = null;   # Liberamos los recursos utilizados por $stmt
            if(count($array)!=0)
            return $array;
        } catch (PDOException $err) {
            // Mostramos un mensaje genérico de error.
            echo "Error: ejecutando consulta SQL.";
        }
    }
    
    function inserta($nombre, $dni, $pais) {
        $stmt = self::$pdo->prepare("INSERT INTO deportistas (nombreDeportista,dniDeportista,paisDeportista) values (?,?,?)");
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $dni);
        $stmt->bindParam(3, $pais);
      try{
        $stmt->execute();
        $stmt=null;
      } catch (PDOException $err){
          //if($dni!=null)
          echo '<script>alert("Error: el Dni introducido ya existe.")</script>';
          echo '<script>location.href = "Alta.php";</script>';
      }
    }
    
    function modifica($nombre,$dni, $pais){
        
        $stmt = self::$pdo->prepare("UPDATE deportistas SET  nombreDeportista=?,paisDeportista=? WHERE dniDeportista=?");     
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $pais);
        $stmt->bindParam(3, $dni);
      try{
        $stmt->execute();
        $stmt=null;
      } catch (PDOException $err){
          echo $err;
      }
    }

    function baja($id){
        $stmt = self::$pdo->prepare("DELETE FROM deportistas WHERE codDeportista=?");     
        $stmt->bindParam(1, $id);
      try{
        $stmt->execute();
        $stmt=null;
      } catch (PDOException $err){
          echo'<script>alert("El deportista no puede ser eliminado, posee medallas.")</script>';
      }
    }
    
    function pInserteMedalla($dni,$codPrueba,$fecha,$puesto){
        
        $stmt = self::$pdo->prepare("CALL pInserteMedalla (:dni,:codPrueba,:fecha,:puesto)");
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':codPrueba', $codPrueba);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':puesto', $puesto);
      try{
        $stmt->execute();
        echo '<script>alert("La medalla ha sido añadida.")</script>';
        $stmt=null;
      } catch (PDOException $err){
          echo "<script>alert('.$err.' )</script>";
         
      }
    }
    
    function pListaDeportistas($nombrePais){
        $array=[];$i=0;
        $stmt = self::$pdo->prepare("CALL pListaDeportistas (:nombrePais)");
        $stmt->bindParam(':nombrePais', $nombrePais);
      try{
        $stmt->execute();
        while ($row = $stmt->fetch()) {
                $array[$i]=$row['nombreDeportista'];
                $i++;
        }
        $stmt=null;
        if(count($array)!=0)  return $array;
      } catch (PDOException $err){
          //if($dni!=null)
          echo "<script>alert('.$err.' )</script>";
      }
    }
    
    function pCantidadMedallas($nombrePais){
        $stmt= self::$pdo->prepare("CALL pCantidadMedallas (:pais,@o,@p,@b)");
        $stmt->bindParam(':pais',$nombrePais);
        try{
            $stmt->execute();
            $stmt=self::$pdo->query('select @o as oro, @p as plata, @b as bronce');
            $row = $stmt->fetch();
            $stmt=null;
            return $row;
        } catch (PDOException $err){
            echo'<script>alert('.$err.')</script>';
        }
    }
    
    function fDeportistaPais($pais) {
        $stmt = self::$pdo->prepare("SELECT fDeportistaPais (:pais)");
        $stmt->bindParam(':pais', $pais);
        try {
            $stmt->execute();
            $row = $stmt->fetch();
            return $row[0];
            $stmt = null;
        } catch (PDOException $err) {
            echo "<script>alert('.$err.' )</script>";
        }
    }

}   
?>
   </body>
</html>
<?php

$host="localhost";
$db="sitiowebphp";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
    //if($conexion){echo "conectado al sistema";}
} catch ( Exception $ex) {
    echo $ex ->getMessage();
}

?>
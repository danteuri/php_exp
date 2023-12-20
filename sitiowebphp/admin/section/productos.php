<?php include "../template/header.php"?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$action=(isset($_POST['action']))?$_POST['action']:"";
echo $txtID."<br/>";
echo $txtNombre."<br/>";
echo $txtImagen."<br/>";
echo $action."<br/>";

$host="localhost";
$db="sitiowebphp";
$usuario="root";
$contrasenia="";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$db",$usuario,$contrasenia);
    if($conexion){echo "conectado al sistema";}
} catch ( Exception $ex) {
    echo $ex ->getMessage();
}

switch($action){
    case"Agregar":
        //INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');
        $sentenciasql=$conexion->prepare("INSERT INTO `libros` (`id`, `nombre`, `imagen`) VALUES (NULL, 'Libro de php', 'imagen.jpg');");
        echo "presionado boton agregar";
        break;
    case"Modificar":
        echo "presionado boton Modificar";
        break;
    case"Cancelar":
        echo "presionado boton Cancelar";
        break;
    
}
?>
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
 
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data" >
                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" class="form-control" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class = "form-group">
                    <label for="">Imagen</label>
                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="ESOOOOO">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="action" value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="action" value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>


    
    
    
</div>
<div class="col-md-7">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2</td>
                <td>Aprende PHP</td>
                <td>Imagen.jpg</td>
                <td>Seleccionar o Borrar</td>
            </tr>
        </tbody>
    </table>
</div>
<?php include "../template/footer.php"?>
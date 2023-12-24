<?php include "../template/header.php"?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$action=(isset($_POST['action']))?$_POST['action']:"";

include "../config/db.php";

switch($action){
    case"Agregar":
        $sentenciasql=$conexion->prepare("INSERT INTO libros (nombre, imagen) VALUES (:nombre, :imagen);");
        $sentenciasql->bindParam(':nombre', $txtNombre);
        $sentenciasql->bindParam(':imagen', $txtImagen);
        $sentenciasql->execute();
        //echo "presionado boton agregar";
        break;
    case"Modificar":
        //echo "presionado boton Modificar";
        break;
    case"Cancelar":
        //echo "presionado boton Cancelar";
        break;
    case"Seleccionar":
        //echo "presionado boton Seleccionar";
        $sentenciasql=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciasql->bindParam(':id',$txtID);
        $sentenciasql->execute();
        $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);
        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];
        break;
    case"Borrar":
        //echo "presionado boton Borrar";
        $sentenciasql=$conexion->prepare("DELETE FROM libros WHERE id=:id");
        $sentenciasql->bindParam(':id',$txtID);
        $sentenciasql->execute();
        break;
}
$sentenciasql=$conexion->prepare("SELECT * FROM libros");
$sentenciasql->execute();
$ListaLibros=$sentenciasql->fetchAll(PDO::FETCH_ASSOC);
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
                    <input type="text" class="form-control" value="<?php echo $txtID?>" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" class="form-control" value="<?php echo $txtNombre?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class = "form-group">
                    <label for="">Imagen</label>
                    <?php echo $txtImagen;?>
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
            <?php foreach($ListaLibros as $libro){?>
            <tr>
                <td><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                <td><?php echo $libro['imagen'];?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>">
                        <input type="submit" name="action" value="Seleccionar" class="btn btn-primary">
                        <input type="submit" name="action" value="Borrar" class="btn btn-danger"/>
                    </form>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php include "../template/footer.php"?>
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

        $fecha= new DateTime() ;
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]['name']:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
        if($tmpImagen!=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        } 

        $sentenciasql->bindParam(':imagen',$nombreArchivo);
        $sentenciasql->execute();
        //echo "presionado boton agregar";
        break;
    case"Modificar":
        $sentenciasql=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
        $sentenciasql->bindParam(':nombre',$txtNombre);
        $sentenciasql->bindParam(':id',$txtID);
        $sentenciasql->execute();
        //echo "presionado boton Modificar";
        if($txtImagen!=""){
            $fecha= new DateTime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]['name']:"imagen.jpg";
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            $sentenciasql=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
            $sentenciasql->bindParam(':id',$txtID);
            $sentenciasql->execute();
            $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);
            if (isset($libro['imagen']) && ($libro['imagen']!="imagen.jpg")) {
                if (file_exists("../../img/".$libro['imagen'])) {
                    unlink("../../img/".$libro['imagen']);
                }
            }

            $sentenciasql=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
            $sentenciasql->bindParam(':imagen',$nombreArchivo);
            $sentenciasql->bindParam(':id',$txtID);
            $sentenciasql->execute();
            
        }
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
        $sentenciasql=$conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciasql->bindParam(':id',$txtID);
        $sentenciasql->execute();
        $libro=$sentenciasql->fetch(PDO::FETCH_LAZY);
        if (isset($libro['imagen']) && ($libro['imagen']!="imagen.jpg")) {
            if (file_exists("../../img/".$libro['imagen'])) {
                unlink("../../img/".$libro['imagen']);
            }
        }
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
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID?>" name="txtID" id="txtID" placeholder="ID">
                </div>
                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
                </div>
                <div class = "form-group">
                    <label for="">Imagen</label>
                    <br>
                    <?php echo $txtImagen;?>
                    <?php if($txtImagen!=""){ ?>
                        <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen?>" width="50" alt="">
                    <?php } ?>

                    <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="ESOOOOO">
                </div>
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" <?php echo ($action=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
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
                <td>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $libro ['imagen'];?>" width="50" alt="">
                
                </td>
                <td>
                    <form method="POST">
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
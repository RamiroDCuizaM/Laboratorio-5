<?php session_start();

require("verificarsesion.php");

?>
<a href="cerrar.php">Cerrar Sesion</a>

<?php
include("conexion.php");
$sql="SELECT id,nombre,correo,rol FROM usuarios";
$_SESSION['rol']=

$resultado=$con->query($sql);

?>
<table style="border-collapse: collapse" border="1">
    <thead>
        <tr>
            <th width="100px">Cuenta</th>
            <th width="100px">Propietario</th>
            <th width="100px">Operaciones</th>
        </tr>
    </thead>
    
 <?php 
 while($row=mysqli_fetch_array($resultado)){
    ?>
    <tr>
        <td><?php echo $row['correo'];?></td>
        <td><?php  echo $row['nombre']?></td>
        <td><button><a href="formeditaruser.php?id=<?php echo $row['id'];?>">Actualizar</a></button>  
            <button><a href="deleteuser.php?id=<?php echo $row['id'];?>">Eliminar</a></button></td>
    </tr>
    <?php } ?>
 </table>
<?php  if($_SESSION['nivel']==1){?>
 <a href="forminsertarprofesiones.php"> Insertar</a>
 <?php } ?>
 
<?php include("conexion.php"); 
$sql="SELECT id,nombre  FROM tipohabitacion";

$resultado=$con->query($sql);

while($row=mysqli_fetch_array($resultado)){
    ?>
    <option value="<?php echo $row['id'] ?>"> <?php echo $row['nombre'];?></option>
    
    <?php } ?>	

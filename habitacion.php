<?php include("conexion.php");
$id = $_GET['id'];
$sql="SELECT id,numero  FROM habitacion where tipohabitacion_id=$id";

$resultado=$con->query($sql);

while($row=mysqli_fetch_array($resultado)){
    ?>
    <option value="<?php echo $row['id'] ?>"> <?php echo $row['numero'];?></option>
    
    <?php } ?>	



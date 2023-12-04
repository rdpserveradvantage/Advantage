<?php include('config.php');

$id = $_REQUEST['id'];

if($id>0){

    $sql = "update vendorMaterialSend set isDelivered=1 where id='".$id."'" ; 
    if(mysqli_query($con,$sql)){
        echo '<script>
        alert("Material Received Succesfully !");
        window.location.href="materialRecived.php"
        </script>';


        mysqli_query($con,"insert into inventorytracker(material,serial_no,type,created_at,created_by) values()");

    }else{
        echo '<script>
        alert("Material Received Error !");
        window.location.href="materialRecived.php"
        </script>';
    }

}


?>
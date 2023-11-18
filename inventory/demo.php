<? include('config.php');


return ; 
$sql = mysqli_query($con, "select * from material_send where vendorId=2");
while ($sqlResult = mysqli_fetch_assoc($sql)) {

    $id = $sqlResult['id'];

    echo $id;

    $selectMaterial = mysqli_query($con, "select * from inventory where material='BIG GPS ANTENNA' and status=1");
    if ($selectMaterialResult = mysqli_fetch_assoc($selectMaterial)) {
        $matId = $selectMaterialResult['id'];


        $sqlDetail = mysqli_query($con, "select * from material_send_details where materialSendId='" . $id . "' and attribute='Router'");
        $sqlDetailResult = mysqli_fetch_assoc($sqlDetail);

        $routerSerialNumber = $sqlDetailResult['value'];
        $reqSerialNumber = $routerSerialNumber . '_BIG_GPS_ANTENNA';

        if(mysqli_query($con,"insert into material_send_details(materialSendId,attribute,value,serialNumber,material_qty,invID) 
        values('".$id."','4G ANTENNA 5MTR','".$reqSerialNumber."','".$reqSerialNumber."','2','".$matId."')")){
            mysqli_query($con,"update inventory set status=0 where id='".$matId."'");
        }



    }



    echo '<br>';

}
?>
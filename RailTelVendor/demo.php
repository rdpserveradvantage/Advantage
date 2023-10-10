<? include('config.php');


return ; 
$sql = mysqli_query($con,"select * from material_send");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $id = $sql_result['id'];
    $atmid = $sql_result['atmid'];
    $siteid = $sql_result['siteid'];
    
    
    mysqli_query($con,"update vendorMaterialSend set materialSendId='".$id."' where atmid='".$atmid."' and siteid='".$siteid."'");
    
    
    
}

?>
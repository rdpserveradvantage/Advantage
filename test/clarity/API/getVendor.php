<? include('config.php');


$sql = mysqli_query($con,"select * from vendor where status=1");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $id = $sql_result['id'];
    $vendor = $sql_result['vendorName'];
    $response[] = ['id'=>$id,'vendorName'=>$vendor];
}

$data = ['status'=>200,'response'=>$response];
echo json_encode($data);

?>
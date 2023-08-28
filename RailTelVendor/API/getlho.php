<? include('config.php'); 

$sql = mysqli_query($con,"select * from lho where status=1");
while($sql_result = mysqli_fetch_assoc($sql)){
    
    $id = $sql_result['id'];
    $lho = $sql_result['lho'];
    
    $data[] = ['id'=>$id,'lho'=>$lho];
}
$data = ['data'=>$data];
echo json_encode($data);

?>

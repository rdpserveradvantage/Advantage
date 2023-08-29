<? include('config.php');

$id = $_REQUEST['id'];
if(isset($id) && !empty($id)){

    $sql = mysqli_query($con,"select * from vendor where id='".$id."' and status=1");
    while($sql_result = mysqli_fetch_assoc($sql)){
        
        $id = $sql_result['id'];
        $vendor = $sql_result['vendorName'];
        $response[] = ['id'=>$id,'vendorName'=>$vendor];
    }
    
    $data = ['status'=>200,'response'=>$response];
    echo json_encode($data);
    
}else{
    $data = ['status'=>500,'response'=>'ID cannot be Blank or NULL'];
    echo json_encode($data);
}

?>
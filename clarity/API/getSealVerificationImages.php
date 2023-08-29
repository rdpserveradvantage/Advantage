<? include('config.php');

$path = 'http://103.216.208.241:8080/clarity/';
$siteid = $_REQUEST['siteid'];
$atmid = $_REQUEST['atmid'];

$sealSql = mysqli_query($con,"select * from sealVerificationImages where siteid='".$siteid."' and atmid='".$atmid."' and status=1");

if (mysqli_num_rows($sealSql) > 0) {
    while ($row = mysqli_fetch_assoc($sealSql)) {
        $imagePath[] = $path . $row['imageUrl'];
        
    }
    $data = ['status'=>200,'response'=>$imagePath];
    echo json_encode($data);
}else{
    
    $data = ['status'=>404,'response'=>'No Images Found'];
    echo json_encode($data);
}
?>
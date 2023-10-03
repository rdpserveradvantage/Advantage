<? include('config.php');

$siteId = $_REQUEST['siteId'];
$userid = $_REQUEST['userid'];

$givenDatetime = $_REQUEST['datetime'];
$givenDatetime = new DateTime($givenDatetime);
$givenDatetime = $givenDatetime->format("Y-m-d H:i:s");
$givenDatetime;
$type = $_REQUEST['type'];

if($type=='ESD'){
    $update = "update sites set ESD='".$givenDatetime."' where id='".$siteId."'" ; 
    if(mysqli_query($con,$update)){
        $data = ['statusCode'=>200,'response'=>'ESD Updated Successfully !'] ; 
    }else{
        $data = ['statusCode'=>500,'response'=>'ESD Updated Error !'] ;
    }
}else if($type=="ASD"){
    $update = "update sites set ASD='".$givenDatetime."' where id='".$siteId."'" ; 
    if(mysqli_query($con,$update)){
        $data = ['statusCode'=>200,'response'=>'ASD Updated Successfully !'] ; 
    }else{
        $data = ['statusCode'=>500,'response'=>'ASD Updated Error !'] ;
    }
}


echo json_encode($data);



?>
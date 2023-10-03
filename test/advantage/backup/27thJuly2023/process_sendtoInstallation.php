<? include('config.php');


$id = $_REQUEST['siteid'];
$atmid = $_REQUEST['atmid'];
$vendor = $_REQUEST['vendor'];


$sql = "insert into projectInstallation(siteid,atmid,status,created_by,created_at,isDone,vendor,portal) 
        values('".$id."','".$atmid."',1,'".$userid."','".$datetime."',0,'".$vendor."','Advantage')";
        
        if(mysqli_query($con,$sql)){
            echo json_encode(202);
            installationProceed($id,$atmid,'');
        }


?>
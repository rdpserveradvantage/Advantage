<? include('config.php');
$siteid = $_REQUEST['siteid'];

$sealVerificationSql = mysqli_query($con,"select * from sealVerification where siteid='".$siteid."' and status=1 order by id desc") ;
if($sealVerificationSqlResult = mysqli_fetch_assoc($sealVerificationSql)){
    $isVerify = $sealVerificationSqlResult['isVerify'];
    if($isVerify==1){
        $isVerifyRemark = 'Approved';
    }else if($isVerify==2){
        $isVerifyRemark = 'Reject';
    }else if($isVerify==0){
        $isVerifyRemark = 'Pending';
    }
    $data = ['status'=>200,'response'=>$isVerifyRemark];
    
}else{
    $data = ['status'=>500,'response'=>'No Data Found with Site Id !'];
}



echo json_encode($data);


?>
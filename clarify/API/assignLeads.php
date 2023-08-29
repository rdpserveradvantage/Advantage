<? include('config.php');


    $userid = $_REQUEST['userid'];
    
    $statement = "select distinct(siteid) as siteid from delegation where engineerId='".$userid."' and status=1" ; 
    $sql = mysqli_query($con,$statement);
        while($sql_result = mysqli_fetch_assoc($sql)){    
                $atm[] = $sql_result['siteid'];
            }
            
            $i = 1;
            foreach ($atm as $atmkey => $atmvalue) {
                $siteid = $atmvalue;
                $getAtmInfoSql = mysqli_query($con, "select * from sites where status=1 and id='" . $siteid . "'");
                        if ($getAtmInfoSqlResult = mysqli_fetch_assoc($getAtmInfoSql)) {
                            $atmid = $getAtmInfoSqlResult['atmid'];
                            $address = $getAtmInfoSqlResult['address'];
                            $esd = $getAtmInfoSqlResult['ESD'];
                            $asd = $getAtmInfoSqlResult['ASD'];
                            
                            $data[] = ['siteid'=>$siteid,'atmid'=>$atmid,'address'=>$address,'esd'=>$esd,'asd'=>$asd] ; 
                
                                    
                    }
                $i++;
            }
            
            if($data){
                $data = ['statusCode'=>200,'response'=>$data];
                echo json_encode($data);                
            }else{
            $data = ['statusCode'=>500,'response'=>'No records Found'];
            echo json_encode($data);
            }

            

?>
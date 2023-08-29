<? include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $id = $_REQUEST['id'];
    $statement = "select id,noOfAtm,ATMID1,ATMID2,ATMID3,address,city,location,LHO,state,atm1Status,atm2Status,atm3Status,operator,signalStatus,
    backroomNetworkRemark,backroomNetworkSnap,AntennaRoutingdetail,EMLockPassword,EMlockAvailable,NoOfUps,PasswordReceived,Remarks,UPSAvailable,UPSBateryBackup,
    UPSWorking1,UPSWorking2,UPSWorking3,backroomDisturbingMaterial,backroomDisturbingMaterialRemark,backroomKeyName,backroomKeyNumber,backroomKeyStatus,earthing,
    earthingVltg,frequentPowerCut,frequentPowerCutFrom,frequentPowerCutRemark,frequentPowerCutTo,nearestShopDistance,nearestShopName,nearestShopNumber,
    powerFluctuationEN,powerFluctuationPE,powerFluctuationPN,powerSocketAvailability,routerAntenaPosition,routerAntenaSnap,AntennaRoutingSnap,UPSAvailableSnap,
    NoOfUpsSnap,upsWorkingSnap,powerSocketAvailabilitySnap,earthingSnap,powerFluctuationSnap,remarksSnap,
    created_at from feasibilityCheck where id='".$id."' status=1";
    
    $sql = mysqli_query($con,$statement);
    if($sql_result = mysqli_fetch_assoc($sql)){
        
        $noOfAtm = $sql_result['noOfAtm'];
        $ATMID1 = $sql_result['ATMID1'];
        $ATMID2 = $sql_result['ATMID2'];
        $ATMID3 = $sql_result['ATMID3'];
        $address = $sql_result['address'];
        $city = $sql_result['city'];
        $location = $sql_result['location'];
        $LHO = $sql_result['LHO'];
        $state = $sql_result['state'];
        $atm1Status = $sql_result['atm1Status'];
        $atm2Status = $sql_result['atm2Status'];
        $atm3Status = $sql_result['atm3Status'];
        $operator = $sql_result['operator'];
        $signalStatus = $sql_result['signalStatus'];
        $backroomNetworkRemark = $sql_result['backroomNetworkRemark'];
        $backroomNetworkSnap = $sql_result['backroomNetworkSnap'];
        $AntennaRoutingdetail = $sql_result['AntennaRoutingdetail'];
        $EMLockPassword = $sql_result['EMLockPassword'];
        $EMlockAvailable = $sql_result['EMlockAvailable'];
        $NoOfUps = $sql_result['NoOfUps'];
        $PasswordReceived = $sql_result['PasswordReceived'];
        $Remarks = $sql_result['Remarks'];
        $UPSAvailable = $sql_result['UPSAvailable'];
        $UPSBateryBackup = $sql_result['UPSBateryBackup'];
        $UPSWorking1 = $sql_result['UPSWorking1'];
        $UPSWorking2 = $sql_result['UPSWorking2'];
        $UPSWorking3 = $sql_result['UPSWorking3'];
        $backroomDisturbingMaterial = $sql_result['backroomDisturbingMaterial'];
        $backroomDisturbingMaterialRemark = $sql_result['backroomDisturbingMaterialRemark'];
        $backroomKeyName = $sql_result['backroomKeyName'];
        $backroomKeyNumber = $sql_result['backroomKeyNumber'];
        $backroomKeyStatus = $sql_result['backroomKeyStatus'];
        $earthing = $sql_result['earthing'];
        $earthingVltg = $sql_result['earthingVltg'];
        $frequentPowerCut = $sql_result['frequentPowerCut'];
        $frequentPowerCutFrom = $sql_result['frequentPowerCutFrom'];
        $frequentPowerCutRemark = $sql_result['frequentPowerCutRemark'];
        $frequentPowerCutTo = $sql_result['frequentPowerCutTo'];
        $nearestShopDistance = $sql_result['nearestShopDistance'];
        $nearestShopName = $sql_result['nearestShopName'];
        $nearestShopNumber = $sql_result['nearestShopNumber'];
        $powerFluctuationEN = $sql_result['powerFluctuationEN'];
        $powerFluctuationPE = $sql_result['powerFluctuationPE'];
        $powerFluctuationPN = $sql_result['powerFluctuationPN'];
        $powerSocketAvailability = $sql_result['powerSocketAvailability'];
        $routerAntenaPosition = $sql_result['routerAntenaPosition'];
        $routerAntenaSnap = $sql_result['routerAntenaSnap'];
        $AntennaRoutingSnap = $sql_result['AntennaRoutingSnap'];
        $UPSAvailableSnap = $sql_result['UPSAvailableSnap'];
        $NoOfUpsSnap = $sql_result['NoOfUpsSnap'];
        $upsWorkingSnap = $sql_result['upsWorkingSnap'];
        $powerSocketAvailabilitySnap = $sql_result['powerSocketAvailabilitySnap'];
        $earthingSnap = $sql_result['earthingSnap'];
        $powerFluctuationSnap = $sql_result['powerFluctuationSnap'];
        $remarksSnap = $sql_result['remarksSnap'];
        $created_at = $sql_result['created_at'];
        
        $data[] = ['id'=>$id,'noOfAtm'=>$noOfAtm,'ATMID1'=>$ATMID1,'ATMID2'=>$ATMID2,'ATMID3'=>$ATMID3,'address'=>$address,'city'=>$city,'location'=>$location,
        'LHO'=>$LHO,'state'=>$state,'atm1Status'=>$atm1Status,'atm2Status'=>$atm2Status,'atm3Status'=>$atm3Status,'operator'=>$operator,
        'signalStatus'=>$signalStatus,'backroomNetworkRemark'=>$backroomNetworkRemark,'backroomNetworkSnap'=>$backroomNetworkSnap,
        'AntennaRoutingdetail'=>$AntennaRoutingdetail,'EMLockPassword'=>$EMLockPassword,'EMlockAvailable'=>$EMlockAvailable,'NoOfUps'=>$NoOfUps,
        'PasswordReceived'=>$PasswordReceived,'Remarks'=>$Remarks,'UPSAvailable'=>$UPSAvailable,'UPSBateryBackup'=>$UPSBateryBackup,'UPSWorking1'=>$UPSWorking1,
        'UPSWorking2'=>$UPSWorking2,'UPSWorking3'=>$UPSWorking3,'backroomDisturbingMaterial'=>$backroomDisturbingMaterial,
        'backroomDisturbingMaterialRemark'=>$backroomDisturbingMaterialRemark,'backroomKeyName'=>$backroomKeyName,'backroomKeyNumber'=>$backroomKeyNumber,
        'backroomKeyStatus'=>$backroomKeyStatus,'earthing'=>$earthing,'earthingVltg'=>$earthingVltg,'frequentPowerCut'=>$frequentPowerCut,
        'frequentPowerCutFrom'=>$frequentPowerCutFrom,'frequentPowerCutRemark'=>$frequentPowerCutRemark,'frequentPowerCutTo'=>$frequentPowerCutTo,
        'nearestShopDistance'=>$nearestShopDistance,'nearestShopName'=>$nearestShopName,'nearestShopNumber'=>$nearestShopNumber,
        'powerFluctuationEN'=>$powerFluctuationEN,'powerFluctuationPE'=>$powerFluctuationPE,'powerFluctuationPN'=>$powerFluctuationPN,
        'powerSocketAvailability'=>$powerSocketAvailability,'routerAntenaPosition'=>$routerAntenaPosition,'routerAntenaSnap'=>$routerAntenaSnap,
        'AntennaRoutingSnap'=>$AntennaRoutingSnap,'UPSAvailableSnap'=>$UPSAvailableSnap,'NoOfUpsSnap'=>$NoOfUpsSnap,'upsWorkingSnap'=>$upsWorkingSnap,
        'powerSocketAvailabilitySnap'=>$powerSocketAvailabilitySnap,'earthingSnap'=>$earthingSnap,'powerFluctuationSnap'=>$powerFluctuationSnap,
        'remarksSnap'=>$remarksSnap,'created_at'=>$created_at] ; 
                
    }
    $data = ['data'=>$data];
    echo json_encode($data) ;
    
}else{
        $response = array(
            "code" => 405,
            "response" => "Method Not Allowed !"
        );
        echo json_encode($response);
}


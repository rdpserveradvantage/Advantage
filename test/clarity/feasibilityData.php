<? session_start();
include('config.php');

if($_SESSION['PROJECT_username']){ 

include('header.php');
?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <div class="card-body" style="overflow:auto;">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer">
                                            <thead>
                                                <tr>
                                                    <td>id</td>
                                                    <td>No Of Atm</td>
                                                    <td>ATMID1</td>
                                                    <td>ATMID2</td>
                                                    <td>ATMID3</td>
                                                    <td>Address</td>
                                                    <td>City</td>
                                                    <td>Location</td>
                                                    <td>LHO</td>
                                                    <td>state</td>
                                                    <td>atm1 Status</td>
                                                    <td>atm2 Status</td>
                                                    <td>atm3 Status</td>
                                                    <td>operator</td>
                                                    <td>signal Status</td>
                                                    <td>backroom Network Remark</td>
                                                    <td>backroom Network Snap</td>
                                                    <td>Antenna Routing detail</td>
                                                    <td>EM Lock Password</td>
                                                    <td>EM lock Available</td>
                                                    <td>No Of Ups</td>
                                                    <td>Password Received</td>
                                                    <td>Remarks</td>
                                                    <td>UPS Available</td>
                                                    <td>UPS Batery Backup</td>
                                                    <td>UPS Working1</td>
                                                    <td>UPS Working2</td>
                                                    <td>UPS Working3</td>
                                                    <td>backroom Disturbing Material</td>
                                                    <td>backroom Disturbing Material Remark</td>
                                                    <td>backroom Key Name</td>
                                                    <td>backroom Key Number</td>
                                                    <td>backroom Key Status</td>
                                                    <td>earthing</td>
                                                    <td>earthing Vltg</td>
                                                    <td>frequent Power Cut</td>
                                                    <td>frequent Power Cut From</td>
                                                    <td>frequent Power Cut Remark</td>
                                                    <td>frequent Power Cut To</td>
                                                    <td>nearest Shop Distance</td>
                                                    <td>nearest Shop Name</td>
                                                    <td>nearest Shop Number</td>
                                                    <td>power Fluctuation EN</td>
                                                    <td>power Fluctuation PE</td>
                                                    <td>power Fluctuation PN</td>
                                                    <td>power Socket Availability</td>
                                                    <td>router Antena Position</td>
                                                    <td>router Antena Snap</td>
                                                    <td>Antenna Routing Snap</td>
                                                    <td>UPS Available Snap</td>
                                                    <td>No Of Ups Snap</td>
                                                    <td>ups Working Snap</td>
                                                    <td>power Socket Availability Snap</td>
                                                    <td>earthing Snap</td>
                                                    <td>power Fluctuation Snap</td>
                                                    <td>remarks Snap</td>
                                                    <td>created at</td>
                                                    <td>Created By</td>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                
                                                $statement = "select id,noOfAtm,ATMID1,ATMID2,ATMID3,address,city,location,LHO,state,atm1Status,atm2Status,atm3Status,operator,signalStatus,backroomNetworkRemark,backroomNetworkSnap,AntennaRoutingdetail,EMLockPassword,EMlockAvailable,NoOfUps,PasswordReceived,Remarks,UPSAvailable,UPSBateryBackup,UPSWorking1,UPSWorking2,UPSWorking3,backroomDisturbingMaterial,backroomDisturbingMaterialRemark,backroomKeyName,backroomKeyNumber,backroomKeyStatus,earthing,earthingVltg,frequentPowerCut,frequentPowerCutFrom,frequentPowerCutRemark,frequentPowerCutTo,nearestShopDistance,nearestShopName,nearestShopNumber,powerFluctuationEN,powerFluctuationPE,powerFluctuationPN,powerSocketAvailability,routerAntenaPosition,routerAntenaSnap,AntennaRoutingSnap,UPSAvailableSnap,NoOfUpsSnap,upsWorkingSnap,powerSocketAvailabilitySnap,earthingSnap,powerFluctuationSnap,remarksSnap,
                                                created_at,created_by from feasibilityCheck where status=1 order by id desc";
                                                
                                                $counter = 1 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){ ?>


                                                <tr>
                                                    <td><? echo $counter ;?></td>
                                                    <td><? echo $sql_result['noOfAtm'];?></td>
                                                    <td><? echo $sql_result['ATMID1'];?></td>
                                                    <td><? echo $sql_result['ATMID2'];?></td>
                                                    <td><? echo $sql_result['ATMID3'];?></td>
                                                    <td><? echo $sql_result['address'];?></td>
                                                    <td><? echo $sql_result['city'];?></td>
                                                    <td><? echo $sql_result['location'];?></td>
                                                    <td><? echo $sql_result['LHO'];?></td>
                                                    <td><? echo $sql_result['state'];?></td>
                                                    <td><? echo $sql_result['atm1Status'];?></td>
                                                    <td><? echo $sql_result['atm2Status'];?></td>
                                                    <td><? echo $sql_result['atm3Status'];?></td>
                                                    <td><? echo $sql_result['operator'];?></td>
                                                    <td><? echo $sql_result['signalStatus'];?></td>
                                                    <td><? echo $sql_result['backroomNetworkRemark'];?></td>
                                                    <td><a href="advantage/<? echo $sql_result['backroomNetworkSnap'];?>" target="_blank">View</a></td>
                                                    <td><? echo $sql_result['AntennaRoutingdetail'];?></td>
                                                    <td><? echo $sql_result['EMLockPassword'];?></td>
                                                    <td><? echo $sql_result['EMlockAvailable'];?></td>
                                                    <td><? echo $sql_result['NoOfUps'];?></td>
                                                    <td><? echo $sql_result['PasswordReceived'];?></td>
                                                    <td><? echo $sql_result['Remarks'];?></td>
                                                    <td><? echo $sql_result['UPSAvailable'];?></td>
                                                    <td><? echo $sql_result['UPSBateryBackup'];?></td>
                                                    <td><? echo $sql_result['UPSWorking1'];?></td>
                                                    <td><? echo $sql_result['UPSWorking2'];?></td>
                                                    <td><? echo $sql_result['UPSWorking3'];?></td>
                                                    <td><? echo $sql_result['backroomDisturbingMaterial'];?></td>
                                                    <td><? echo $sql_result['backroomDisturbingMaterialRemark'];?></td>
                                                    <td><? echo $sql_result['backroomKeyName'];?></td>
                                                    <td><? echo $sql_result['backroomKeyNumber'];?></td>
                                                    <td><? echo $sql_result['backroomKeyStatus'];?></td>
                                                    <td><? echo $sql_result['earthing'];?></td>
                                                    <td><? echo $sql_result['earthingVltg'];?></td>
                                                    <td><? echo $sql_result['frequentPowerCut'];?></td>
                                                    <td><? echo $sql_result['frequentPowerCutFrom'];?></td>
                                                    <td><? echo $sql_result['frequentPowerCutRemark'];?></td>
                                                    <td><? echo $sql_result['frequentPowerCutTo'];?></td>
                                                    <td><? echo $sql_result['nearestShopDistance'];?></td>
                                                    <td><? echo $sql_result['nearestShopName'];?></td>
                                                    <td><? echo $sql_result['nearestShopNumber'];?></td>
                                                    <td><? echo $sql_result['powerFluctuationEN'];?></td>
                                                    <td><? echo $sql_result['powerFluctuationPE'];?></td>
                                                    <td><? echo $sql_result['powerFluctuationPN'];?></td>
                                                    <td><? echo $sql_result['powerSocketAvailability'];?></td>
                                                    <td><? echo $sql_result['routerAntenaPosition'];?></td>
                                                    <td><a href="advantage/<? echo  $sql_result['routerAntenaSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['AntennaRoutingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['UPSAvailableSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['NoOfUpsSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['upsWorkingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['powerSocketAvailabilitySnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['earthingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['powerFluctuationSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="advantage/<? echo  $sql_result['remarksSnap'];?>" target="_blank">View</a></td>
                                                    <td><? echo $sql_result['created_at'];?></td>
                                                    <td><? echo getUsername($sql_result['created_by']); ?></td>
                                                </tr>
                                                
                                                <? $counter++ ;  } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>

</body>

</html>
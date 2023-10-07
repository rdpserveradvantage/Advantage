<? session_start();
include('config.php');

if($_SESSION['username']){ 

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
                                                    <th>id</th>
                                                    <th>Feasibility Done</th>
                                                    <th>Action</th>
                                                    <th>No Of Atm</th>
                                                    <th>ATMID1</th>
                                                    <th>ATMID2</th>
                                                    <th>ATMID3</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>Location</th>
                                                    <th>LHO</th>
                                                    <th>state</th>
                                                    <th>atm1 Status</th>
                                                    <th>atm2 Status</th>
                                                    <th>atm3 Status</th>
                                                    <th>operator</th>
                                                    <th>signal Status</th>
                                                    <th>backroom Network Remark</th>
                                                    <th>backroom Network Snap</th>
                                                    <th>Antenna Routing detail</th>
                                                    <th>EM Lock Password</th>
                                                    <th>EM lock Available</th>
                                                    <th>No Of Ups</th>
                                                    <th>Password Received</th>
                                                    <th>Remarks</th>
                                                    <th>UPS Available</th>
                                                    <th>UPS Batery Backup</th>
                                                    <th>UPS Working1</th>
                                                    <th>UPS Working2</th>
                                                    <th>UPS Working3</th>
                                                    <th>backroom Disturbing Material</th>
                                                    <th>backroom Disturbing Material Remark</th>
                                                    <th>backroom Key Name</th>
                                                    <th>backroom Key Number</th>
                                                    <th>backroom Key Status</th>
                                                    <th>earthing</th>
                                                    <th>earthing Vltg</th>
                                                    <th>frequent Power Cut</th>
                                                    <th>frequent Power Cut From</th>
                                                    <th>frequent Power Cut Remark</th>
                                                    <th>frequent Power Cut To</th>
                                                    <th>nearest Shop Distance</th>
                                                    <th>nearest Shop Name</th>
                                                    <th>nearest Shop Number</th>
                                                    <th>power Fluctuation EN</th>
                                                    <th>power Fluctuation PE</th>
                                                    <th>power Fluctuation PN</th>
                                                    <th>power Socket Availability</th>
                                                    <th>router Antena Position</th>
                                                    <th>router Antena Snap</th>
                                                    <th>Antenna Routing Snap</th>
                                                    <th>UPS Available Snap</th>
                                                    <th>No Of Ups Snap</th>
                                                    <th>ups Working Snap</th>
                                                    <th>power Socket Availability Snap</th>
                                                    <th>earthing Snap</th>
                                                    <th>power Fluctuation Snap</th>
                                                    <th>remarks Snap</th>
                                                    <th>created at</th>
                                                    <th>Created By</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                
                                                $statement = "select id,noOfAtm,ATMID1,ATMID2,ATMID3,address,city,location,LHO,state,atm1Status,atm2Status,atm3Status,operator,signalStatus,
                                                backroomNetworkRemark,backroomNetworkSnap,AntennaRoutingdetail,EMLockPassword,EMlockAvailable,NoOfUps,PasswordReceived,Remarks,
                                                UPSAvailable,UPSBateryBackup,UPSWorking1,UPSWorking2,UPSWorking3,backroomDisturbingMaterial,backroomDisturbingMaterialRemark,backroomKeyName,
                                                backroomKeyNumber,backroomKeyStatus,earthing,earthingVltg,frequentPowerCut,frequentPowerCutFrom,frequentPowerCutRemark,frequentPowerCutTo,
                                                nearestShopDistance,nearestShopName,nearestShopNumber,powerFluctuationEN,powerFluctuationPE,powerFluctuationPN,powerSocketAvailability,
                                                routerAntenaPosition,routerAntenaSnap,AntennaRoutingSnap,UPSAvailableSnap,NoOfUpsSnap,upsWorkingSnap,powerSocketAvailabilitySnap,earthingSnap,
                                                powerFluctuationSnap,remarksSnap,created_at,created_by,feasibilityDone,isVendor from feasibilityCheck where status=1 order by id desc";
                                                
                                                $counter = 1 ; 
                                                $sql = mysqli_query($con,$statement);
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                $isVendor = $sql_result['isVendor'];
                                                if($isVendor){
                                                    $baseurl = 'http://vendor.advantagesb.com/API/';
                                                }else{
                                                    $baseurl = 'http://advantage.advantagesb.com/API/';
                                                }
                                                
                                                ?>


                                                <tr>
                                                    <td><? echo $counter ; ?></td>
                                                    <td><? echo $sql_result['feasibilityDone'];?></td>
                                                    <td><a href="" target="_blank">Update PO To Bank</a></td>
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
                                                    <td><a href="<? echo  $baseurl.$sql_result['routerAntenaSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['AntennaRoutingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['UPSAvailableSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['NoOfUpsSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['upsWorkingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['powerSocketAvailabilitySnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['earthingSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['powerFluctuationSnap'];?>" target="_blank">View</a></td>
                                                    <td><a href="<? echo  $baseurl.$sql_result['remarksSnap'];?>" target="_blank">View</a></td>
                                                    <td><? echo $sql_result['created_at'];?></td>
                                                    <td><? echo getUsername($sql_result['created_by'],$isVendor); ?></td>
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
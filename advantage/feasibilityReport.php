<?php include('header.php'); 

        $atmid = $_REQUEST['atmid'];
                                
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Feasibility Report for ATMID : <span style="color:red;display: inline-block;"><? echo $atmid ; ?></span></h5>
                                </div>
                                <div class="card-block accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <?php
                                        
                                        
                                        if(isset($_POST['rejectsubmit'])){
                                            $status = 'Reject';
                                            
                                            $feasibilityRemark = $_REQUEST['feasibilityRemark'];
                                            $feasibiltyId = $_REQUEST['feasibiltyId'];
                                            $atm_id = $_REQUEST['atmid'];
                                            $getsiteIdSql = mysqli_query($con,"select * from sites where atmid='".$atm_id."'");
                                            $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                                            $siteid = $getsiteIdSql_result['id'];
                                            
                                            mysqli_query($con,"update sites set verificationStatus='".$status."' where id='".$siteid."'") ;
                                            mysqli_query($con,"update feasibilityCheck set verificationStatus='".$status."' where id='".$feasibiltyId."'") ;
                                            
                                            feasibilityApprovalReject($siteid,$atm_id,'',$feasibilityRemark) ; 
                                            
                                            
                                            
                                        }else if(isset($_POST['verifysubmit'])){
                                            $status = 'Verify';
                                            $feasibiltyId = $_REQUEST['feasibiltyId'];
                                            $atm_id = $_REQUEST['atmid'];
                                            $getsiteIdSql = mysqli_query($con,"select * from sites where atmid='".$atm_id."'");
                                            $getsiteIdSql_result = mysqli_fetch_assoc($getsiteIdSql);
                                            $siteid = $getsiteIdSql_result['id'];
                                            
                                            mysqli_query($con,"update sites set verificationStatus='".$status."' where id='".$siteid."'") ;
                                            mysqli_query($con,"update feasibilityCheck set verificationStatus='".$status."' where id='".$feasibiltyId."'") ;
                                            
                                            
                                            feasibilityApprovalVerify($siteid,$atm_id,'') ; 
                                            // Initiate Material Request here
                                            
                                            $materialQuantities = [];
                                            $sql = "SELECT value, count FROM boq";
                                            $result = $con->query($sql);
                                            
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $materialName = $row['value'];
                                                    $quantity = $row['count'];
                                                    $materialQuantities[$materialName] = $quantity;
                                                }
                                            }
                                            
                                            
                                            
                                            $feasSql = mysqli_query($con,"select * from feasibilityCheck where id='".$feasibiltyId."'");
                                            $feasSql_result = mysqli_fetch_assoc($feasSql);
                                            $isVendor = $feasSql_result['isVendor'] ; 
                                            
                                            if($isVendor==0){
                                                $type = 'Internal' ;
                                                $vendorId = 0 ; 
                                            }else if($isVendor == 1 ){
                                                $type = 'External' ;
                                                $feasibiltyCreatedBy = $feasSql_result['created_by'] ;
                                                
                                                $vendorsql = mysqli_query($con,"select * from vendorUsers where id='".$feasibiltyCreatedBy."'");
                                                $vendorsql_result = mysqli_fetch_assoc($vendorsql);
                                                $vendorId = $vendorsql_result['vendorId'];
                                                
                                            }
                                            
                                             
                                            
                                             
                                            
                                            // Generate material requests
                                            
                                            
                                            foreach ($materialQuantities as $materialName => $quantity) {
                                                // Insert the material request into the table
                                                
                                                $checkMaterialRequstSql = mysqli_query($con,"select * from material_requests where siteid='".$siteid."' and material_name='".$materialName."'");
                                                if($checkMaterialRequstSql_result = mysqli_fetch_assoc($checkMaterialRequstSql)){
                                                    
                                                    mysqli_query($con,"update material_requests set feasibility_id='".$feasibiltyId."' where 
                                                    siteid='".$siteid."' and material_name='".$materialName."'");
                                                    
                                                    $manualSendFound=1;
                                                }else{
                                                    $sql = "INSERT INTO material_requests (siteid, feasibility_id, material_name, quantity, status, created_by,created_at,type,vendorId)
                                                            VALUES ('$siteid', '$feasibiltyId', '$materialName', '$quantity', 'pending', '".$userid."','".$datetime."','".$type."',$vendorId)";
                                                    if ($con->query($sql) === false) {
                                                        echo "Error: " . $sql . "<br>" . $con->error;
                                                    }                                                    
                                                }
                                                

                                            }

                                            if($manualSendFound==0){
                                                generatesAutoMaterialRequest($siteid,$atm_id,'') ;                                                 
                                            }

                                            
                                            
                                            
                                            
                                            
                                            // End Material Request
                                            
                                            
                                            
                                        }
                                        
                                
                                        $query = "SELECT * FROM feasibilityCheck where ATMID1='".$atmid."'";

                                        $result = $con->query($query);

                                        if ($result->num_rows > 0) {
                                            $i=1 ; 
                                            while ($row = $result->fetch_assoc()) {
                                                $id = $row['id'];
                                                
                                                $noOfAtm = $row['noOfAtm'];
                                                $ATMID1 = $row['ATMID1'];
                                                $ATMID2 = $row['ATMID2'];
                                                $ATMID3 = $row['ATMID3'];
                                                $address = $row['address'];
                                                $city = $row['city'];
                                                $location = $row['location'];
                                                $LHO = $row['LHO'];
                                                $state = $row['state'];
                                                $atm1Status = $row['atm1Status'];
                                                $atm2Status = $row['atm2Status'];
                                                $atm3Status = $row['atm3Status'];
                                                $operator = $row['operator'];
                                                $signalStatus = $row['signalStatus'];
                                                $backroomNetworkRemark = $row['backroomNetworkRemark'];
                                                $backroomNetworkSnap = $row['backroomNetworkSnap'];
                                                $AntennaRoutingdetail = $row['AntennaRoutingdetail'];
                                                $EMLockPassword = $row['EMLockPassword'];
                                                $EMlockAvailable = $row['EMlockAvailable'];
                                                $NoOfUps = $row['NoOfUps'];
                                                $PasswordReceived = $row['PasswordReceived'];
                                                $Remarks = $row['Remarks'];
                                                $UPSAvailable = $row['UPSAvailable'];
                                                $UPSBateryBackup = $row['UPSBateryBackup'];
                                                $UPSWorking1 = $row['UPSWorking1'];
                                                $UPSWorking2 = $row['UPSWorking2'];
                                                $UPSWorking3 = $row['UPSWorking3'];
                                                $backroomDisturbingMaterial = $row['backroomDisturbingMaterial'];
                                                $backroomDisturbingMaterialRemark = $row['backroomDisturbingMaterialRemark'];
                                                $backroomKeyName = $row['backroomKeyName'];
                                                $backroomKeyNumber = $row['backroomKeyNumber'];
                                                $backroomKeyStatus = $row['backroomKeyStatus'];
                                                $earthing = $row['earthing'];
                                                $earthingVltg = $row['earthingVltg'];
                                                $frequentPowerCut = $row['frequentPowerCut'];
                                                $frequentPowerCutFrom = $row['frequentPowerCutFrom'];
                                                $frequentPowerCutRemark = $row['frequentPowerCutRemark'];
                                                $frequentPowerCutTo = $row['frequentPowerCutTo'];
                                                $nearestShopDistance = $row['nearestShopDistance'];
                                                $nearestShopName = $row['nearestShopName'];
                                                $nearestShopNumber = $row['nearestShopNumber'];
                                                $powerFluctuationEN = $row['powerFluctuationEN'];
                                                $powerFluctuationPE = $row['powerFluctuationPE'];
                                                $powerFluctuationPN = $row['powerFluctuationPN'];
                                                $powerSocketAvailability = $row['powerSocketAvailability'];
                                                $routerAntenaPosition = $row['routerAntenaPosition'];
                                                $routerAntenaSnap = $row['routerAntenaSnap'];
                                                $AntennaRoutingSnap = $row['AntennaRoutingSnap'];
                                                $UPSAvailableSnap = $row['UPSAvailableSnap'];
                                                $NoOfUpsSnap = $row['NoOfUpsSnap'];
                                                $upsWorkingSnap = $row['upsWorkingSnap'];
                                                $powerSocketAvailabilitySnap = $row['powerSocketAvailabilitySnap'];
                                                $earthingSnap = $row['earthingSnap'];
                                                $powerFluctuationSnap = $row['powerFluctuationSnap'];
                                                $remarksSnap = $row['remarksSnap'];
                                                $status = $row['status'];
                                                $created_at = $row['created_at'];
                                                $powerSocketAvailabilityUPS = $row['powerSocketAvailabilityUPS'];
                                                $powerSocketAvailabilityUPSSnap = $row['powerSocketAvailabilityUPSSnap'];
                                                $operator2 = $row['operator2'];
                                                $signalStatus2 = $row['signalStatus2'];
                                                $backroomNetworkRemark2 = $row['backroomNetworkRemark2'];
                                                $backroomNetworkSnap2 = $row['backroomNetworkSnap2'];
                                                $created_by = $row['created_by'];
                                                $feasibilityDone = $row['feasibilityDone'];
                                                $isVendor = $row['isVendor'];
                                                $ticketid = $row['ticketid'];
                                                $verificationStatus = $row['verificationStatus'];
                                                $ATMID1Snap = $row['ATMID1Snap'];
                                                $ATMID2Snap = $row['ATMID2Snap'];
                                                $ATMID3Snap = $row['ATMID3Snap'];

                                                
                                                
                                                
                                                
                                                $isVendor = $row['isVendor'];
                                                $atm_id = $row['atmid'];
                                                $getverificationStatus = $row['verificationStatus'];
                                                
                                                $baseurl = 'https://sarmicrosystems.in/project/API/';

                                                echo '<div class="accordion-panel">';
                                                
                                                echo '<div class="accordion-heading" role="tab" id="heading' . $i . '">';
                                                echo '<h3 class="card-title accordion-title">';
                                                echo '<a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">';
                                                echo 'Feasibility Check ' . $i;
                                                echo '</a>';
                                                echo '</h3>';
                                                echo '</div>';
                                                echo '<div id="collapse' . $i . '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' . $i . '">';
                                                echo '<div class="accordion-content accordion-desc">';
                                                
                                                echo '<form action="' . $_SERVER['PHP_SELF'] . '?atmid=' . $atmid . '" method="POST">';
                                                
                                                ?>
                                                
                                                <table class="table">
                                                     <tr>
        <th> No of Atm Available</th>
        <td><?= $noOfAtm; ?></td>
    </tr>
    <tr>
        <th>A T M I D1</th>
        <td><?= $ATMID1; ?></td>
    </tr>
    <tr>
        <th>A T M I D2</th>
        <td><?= $ATMID2; ?></td>
    </tr>
    <tr>
        <th>A T M I D3</th>
        <td><?= $ATMID3; ?></td>
    </tr>
    <tr>
        <th>address</th>
        <td><?= $address; ?></td>
    </tr>
    <tr>
        <th>city</th>
        <td><?= $city; ?></td>
    </tr>
    <tr>
        <th>location</th>
        <td><?= $location; ?></td>
    </tr>
    <tr>
        <th>L H O</th>
        <td><?= $LHO; ?></td>
    </tr>
    <tr>
        <th>state</th>
        <td><?= $state; ?></td>
    </tr>
    <tr>
        <th>atm1 Status</th>
        <td><?= $atm1Status; ?></td>
    </tr>
    <tr>
        <th>atm2 Status</th>
        <td><?= $atm2Status; ?></td>
    </tr>
    <tr>
        <th>atm3 Status</th>
        <td><?= $atm3Status; ?></td>
    </tr>
    <tr>
        <th>operator</th>
        <td><?= $operator; ?></td>
    </tr>
    <tr>
        <th>signal Status</th>
        <td><?= $signalStatus; ?></td>
    </tr>
    <tr>
        <th>backroom Network Remark</th>
        <td><?= $backroomNetworkRemark; ?></td>
    </tr>
    <tr>
        <th>backroom Network Snap</th>
        <td><a href="<?= $baseurl.$backroomNetworkSnap; ?>" target="_blank">View Image</a></td>
    </tr>
    <tr>
    <th>Antenna Routingdetail</th>
    <td><?= $AntennaRoutingdetail; ?></td>
</tr>
<tr>
    <th>E M Lock Password</th>
    <td><?= $EMLockPassword; ?></td>
</tr>
<tr>
    <th>E Mlock Available</th>
    <td><?= $EMlockAvailable; ?></td>
</tr>
<tr>
    <th>No Of Ups</th>
    <td><?= $NoOfUps; ?></td>
</tr>
<tr>
    <th>Password Received</th>
    <td><?= $PasswordReceived; ?></td>
</tr>
<tr>
    <th>Remarks</th>
    <td><?= $Remarks; ?></td>
</tr>
<tr>
    <th>U P S Available</th>
    <td><?= $UPSAvailable; ?></td>
</tr>
<tr>
    <th>U P S Batery Backup</th>
    <td><?= $UPSBateryBackup; ?></td>
</tr>
<tr>
    <th>U P S Working1</th>
    <td><?= $UPSWorking1; ?></td>
</tr>
<tr>
    <th>U P S Working2</th>
    <td><?= $UPSWorking2; ?></td>
</tr>
<tr>
    <th>U P S Working3</th>
    <td><?= $UPSWorking3; ?></td>
</tr>
<tr>
    <th>backroom Disturbing Material</th>
    <td><?= $backroomDisturbingMaterial; ?></td>
</tr>
<tr>
    <th>backroom Disturbing Material Remark</th>
    <td><?= $backroomDisturbingMaterialRemark; ?></td>
</tr>
<tr>
    <th>backroom Key Name</th>
    <td><?= $backroomKeyName; ?></td>
</tr>
<tr>
    <th>backroom Key Number</th>
    <td><?= $backroomKeyNumber; ?></td>
</tr>
<tr>
    <th>backroom Key Status</th>
    <td><?= $backroomKeyStatus; ?></td>
</tr>

    <tr>
    <th>earthing</th>
    <td><?= $earthing; ?></td>
</tr>
<tr>
    <th>earthing Vltg</th>
    <td><?= $earthingVltg; ?></td>
</tr>
<tr>
    <th>frequent Power Cut</th>
    <td><?= $frequentPowerCut; ?></td>
</tr>
<tr>
    <th>frequent Power Cut From</th>
    <td><?= $frequentPowerCutFrom; ?></td>
</tr>
<tr>
    <th>frequent Power Cut Remark</th>
    <td><?= $frequentPowerCutRemark; ?></td>
</tr>
<tr>
    <th>frequent Power Cut To</th>
    <td><?= $frequentPowerCutTo; ?></td>
</tr>
<tr>
    <th>nearest Shop Distance</th>
    <td><?= $nearestShopDistance; ?></td>
</tr>
<tr>
    <th>nearest Shop Name</th>
    <td><?= $nearestShopName; ?></td>
</tr>
<tr>
    <th>nearest Shop Number</th>
    <td><?= $nearestShopNumber; ?></td>
</tr>
<tr>
    <th>power Fluctuation E N</th>
    <td><?= $powerFluctuationEN; ?></td>
</tr>
<tr>
    <th>power Fluctuation P E</th>
    <td><?= $powerFluctuationPE; ?></td>
</tr>
<tr>
    <th>power Fluctuation P N</th>
    <td><?= $powerFluctuationPN; ?></td>
</tr>
<tr>
    <th>power Socket Availability</th>
    <td><?= $powerSocketAvailability; ?></td>
</tr>
<tr>
    <th>router Antena Position</th>
    <td><?= $routerAntenaPosition; ?></td>
</tr>
<tr>
    <th>router Antena Snap</th>
    <td><a href="<?= $baseurl.$routerAntenaSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>Antenna Routing Snap</th>
    <td><a href="<?= $baseurl.$AntennaRoutingSnap; ?>" target="_blank">View Image</a></td>
</tr>


<tr>
    <th>U P S Available Snap</th>
    <td><a href="<?= $baseurl.$UPSAvailableSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>No Of Ups Snap</th>
    <td><a href="<?= $baseurl.$NoOfUpsSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>ups Working Snap</th>
    <td><a href="<?= $baseurl.$upsWorkingSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>power Socket Availability Snap</th>
    <td><a href="<?= $baseurl.$powerSocketAvailabilitySnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>earthing Snap</th>
    <td><a href="<?= $baseurl.$earthingSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>power Fluctuation Snap</th>
    <td><a href="<?= $baseurl.$powerFluctuationSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>remarks Snap</th>
    <td><a href="<?= $baseurl.$remarksSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>created_at</th>
    <td><?= $created_at; ?></td>
</tr>
<tr>
    <th>power Socket Availability U P S</th>
    <td><?= $powerSocketAvailabilityUPS; ?></td>
</tr>
<tr>
    <th>power Socket Availability U P S Snap</th>
    <td><a href="<?= $baseurl.$powerSocketAvailabilityUPSSnap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>operator2</th>
    <td><?= $operator2; ?></td>
</tr>
<tr>
    <th>signal Status2</th>
    <td><?= $signalStatus2; ?></td>
</tr>


<tr>
    <th>backroom Network Remark2</th>
    <td><?= $backroomNetworkRemark2; ?></td>
</tr>
<tr>
    <th>backroom Network Snap2</th>
    <td><a href="<?= $baseurl.$backroomNetworkSnap2; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>created_by</th>
    <td><?= getUsername($created_by,true); ?></td>
</tr>
<tr>
    <th>feasibility Done</th>
    <td><?= $feasibilityDone; ?></td>
</tr>
<tr>
    <th>is Vendor</th>
    <td><?= getVendorName($isVendor); ?></td>
</tr>
<tr>
    <th>ticketid</th>
    <td><?= $ticketid; ?></td>
</tr>
<tr>
    <th>verification Status</th>
    <td><?= $verificationStatus; ?></td>
</tr>
<tr>
    <th>A T M I D1 Snap</th>
    <td><a href="<?= $baseurl.$ATMID1Snap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>A T M I D2 Snap</th>
    <td><a href="<?= $baseurl.$ATMID2Snap; ?>" target="_blank">View Image</a></td>
</tr>
<tr>
    <th>A T M I D3 Snap</th>
    <td><a href="<?= $baseurl.$ATMID3Snap; ?>" target="_blank">View Image</a></td>
</tr>

        
        
                                                </table>
                                                <?

                                                if(isset($getverificationStatus) && !empty($getverificationStatus)){
                                                    if($getverificationStatus=='Reject'){
                                                        echo '<h4>Rejected !</h4>' ; 
                                                    }else if($getverificationStatus=='Verify'){
                                                        echo '<h4>Verified !</h4>' ; 
                                                    }
                                                }else{
                                                
                                                echo '<input type="text" name="feasibilityRemark" class="form-control" placeholder="Enter Remarks !" required />';
                                                echo '<input type="hidden" name="atm_id" value="'.$atm_id.'" />';
                                                echo '<input type="hidden" name="feasibiltyId" value="'.$id.'" />';
                                                echo '<input type="submit" name="verifysubmit" value="Verify" class="btn btn-primary" onclick="return confirm(\'Are you sure you want to verify ?\');">';
                                                echo '<input type="submit" name="rejectsubmit" value="Reject" class="btn btn-danger" onclick="return confirm(\'Are you sure you want to reject ?\');">';
                                                
                                                }
                                                
                                                
                                                echo '</form>';
                                                
                                                
                                                echo '</div>';

                                                echo '</div>';
                                                


                                                echo '</div>';

                                                $i++ ; 
                                            }
                                        } else {
                                            echo "No records found.";
                                        }

                                        $con->close();
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="files/assets/pages/accordion/accordion.js"></script>

<?php include('footer.php'); ?>

<?php
// Function to break down column name
function formatColumnName($columnName) {
    return implode(' ', preg_split('/(?=[A-Z])/', $columnName));
}
// Function to check if a URL-like value represents a valid image URL
function isValidImageUrl($url) {
    $url1 = 'https://sarmicrosystems.in/RailTailVendor/feasibiltyData/API/';
    $url2 = 'https://sarmicrosystems.in/advantages/feasibiltyData/API/';
    
    return (strpos($url, $url1) === 0 || strpos($url, $url2) === 0);
}

// Function to check if a URL-like value represents a valid image URL
// function isValidImageUrl($url) {
//     // Add your custom validation logic here
//     return filter_var($url, FILTER_VALIDATE_URL) !== false;
// }

?>

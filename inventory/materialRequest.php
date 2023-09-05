<? include('header.php'); 

function getMaterialRequestInitiatorName($siteid){
    global $con;
    $sql = mysqli_query($con,"select * from material_requests where siteid='".$siteid."' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    $vendorId = $sql_result['vendorId'];
    return getVendorName($vendorId);
}

function getMaterialRequestStatus($siteid){
    global $con;
    $sql = mysqli_query($con,"select status from material_requests where siteid='".$siteid."' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['status'];
}

?>


     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style="overflow:auto;">
                                        
                                        <?
                                        $siteidsql = mysqli_query($con,"SELECT siteid FROM `material_requests` where status='pending' group by siteid");
                                        while($siteidsql_result = mysqli_fetch_assoc($siteidsql)){
                                            $siteids[] = $siteidsql_result['siteid'];
                                        }
                                        $siteids_ar = $siteids ; 
                                        $siteids=json_encode($siteids);
                                        $siteids=str_replace( array('[',']','"') , ''  , $siteids);
                                        $siteids=explode(',',$siteids);
                                        $siteids = "'" . implode ( "', '", $siteids )."'";
                                        
                                        
                                        if($siteids_ar){ ?>
                                        <h5>All Material Request</h5>
                                        <hr />

                                         <table class="table table-hover table-styling table-xs">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Srno</th>
                                                    <th>ATMID</th>
                                                    <th>Address</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Vendor</th>
                                                    <th>Action</th>
                                                    <th>Current Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i=1;
                                                $sql = mysqli_query($con,"select * from sites where id in($siteids)");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $atmid = $sql_result['atmid'];
                                                    $siteid = $sql_result['id'];
                                                    $city = $sql_result['city'];
                                                    $state = $sql_result['state'];
                                                    $address = $sql_result['address'];
                                                    ?>
                                                    
                                                   <tr>
                                                       <td><?= $i ; ?></td>
                                                       <td><?= $atmid; ?></td>
                                                       <td><?= $address; ?></td>
                                                       <td><?= $city; ?></td>
                                                       <td><?= $state; ?></td>
                                                       <td><?= getMaterialRequestInitiatorName($siteid); ?></td>
                                                       
                                                       <td>
                                                           <a href="sendMaterial.php?siteid=<?= $siteid; ?>">Send Material</a>
                                                       </td>
                                                       <td>
                                                           <?= getMaterialRequestStatus($siteid) ; ?>
                                                       </td>
                                                   </tr>
                                                    
                                                    <? $i++;  } ?>

                                            </tbody>
                                        </table>                                        
                                    

                                        <? }else{


                                            echo '
                                            
                                            <div class="noRecordsContainer">
                                                <img src="assets/no_records.jpg">
                                            </div>';

                                            
                                        } ?>
                                    
                                    
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
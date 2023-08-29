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
                                        <h5>All Material Request</h5>
                                        <hr />
                                        
                                        <?
                                        $siteidsql = mysqli_query($con,"SELECT siteid FROM `material_requests` where status='pending' group by siteid");
                                        while($siteidsql_result = mysqli_fetch_assoc($siteidsql)){
                                            $siteids[] = $siteidsql_result['siteid'];
                                        }
                                        $siteids=json_encode($siteids);
                                        $siteids=str_replace( array('[',']','"') , ''  , $siteids);
                                        $siteids=explode(',',$siteids);
                                        $siteids = "'" . implode ( "', '", $siteids )."'";
                                        
                                        
                                        ?>
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
                                                       <td><? echo $i ; ?></td>
                                                       <td><? echo $atmid; ?></td>
                                                       <td><? echo $address; ?></td>
                                                       <td><? echo $city; ?></td>
                                                       <td><? echo $state; ?></td>
                                                       <td><? echo getMaterialRequestInitiatorName($siteid); ?></td>
                                                       
                                                       <td>
                                                           <a href="sendMaterial.php?siteid=<? echo $siteid; ?>">Send Material</a>
                                                       </td>
                                                       <td>
                                                           <? echo getMaterialRequestStatus($siteid) ; ?>
                                                       </td>
                                                   </tr>
                                                    
                                                    <? $i++;  } ?>

                                            </tbody>
                                        </table>                                        
                                    
                                    
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
<? include('header.php');

function getMaterialRequestInitiatorName($siteid)
{
    global $con;
    $sql = mysqli_query($con, "select * from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    $vendorId = $sql_result['vendorId'];
    return getVendorName($vendorId);
}

function getMaterialRequestStatus($siteid)
{
    global $con;
    $sql = mysqli_query($con, "select status from material_requests where siteid='" . $siteid . "' and isProject=1");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['status'];
}

function getMaterial_requestData($siteid, $parameter)
{
    global $con;
    $sql = mysqli_query($con, "select $parameter from material_requests where siteid='" . $siteid . "' order by id desc");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

?>



<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-header" style="overflow:auto;">

                            <?
                            $siteidsql = mysqli_query($con, "SELECT siteid FROM `material_requests` where status='pending' group by siteid");
                            while ($siteidsql_result = mysqli_fetch_assoc($siteidsql)) {
                                $siteids[] = $siteidsql_result['siteid'];
                            }
                            $siteids_ar = $siteids;
                            $siteids = json_encode($siteids);
                            $siteids = str_replace(array('[', ']', '"'), '', $siteids);
                            $siteids = explode(',', $siteids);
                            $siteids = "'" . implode("', '", $siteids) . "'";


                            if ($siteids_ar) { ?>
                                <h5>All Material Request</h5>
                                <hr />
                        </div>
                        <div class="card-body" style="overflow:auto;">

                            <table class="table table-hover table-styling table-xs">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Srno</th>
                                        <th>ATMID</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Vendor</th>

                                        <th>IP Configuration</th>
                                        <th>Router Configuration</th>

                                        <th>Action</th>
                                        <th>Current Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $i = 1;
                                    $sql = mysqli_query($con, "select * from sites where id in($siteids)");
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {

                                        $ipRemark = '';
                                        $error = 0;

                                        $configurationRemark = '';
                                        $configurationError = 0;

                                        $atmid = $sql_result['atmid'];
                                        $siteid = $sql_result['id'];
                                        $city = $sql_result['city'];
                                        $state = $sql_result['state'];
                                        $address = $sql_result['address'];

                                        $networkIP = $sql_result['networkIP'];
                                        $routerIP = $sql_result['routerIP'];
                                        $atmIP = $sql_result['atmIP'];
                                        
                                        if ($networkIP) {
                                            $ipRemark .= ' Network IP <i class="fas fa-check" style="color:green;"></i>';
                                        } else {
                                            $ipRemark .= ' Network IP <i class="fas fa-window-close" style="color:red;"></i>';
                                            $error++;
                                        }
                                        if ($routerIP) {
                                            $ipRemark .= ' Router IP <i class="fas fa-check" style="color:green;"></i>';
                                        } else {
                                            $ipRemark .= ' Router IP <i class="fas fa-window-close"  style="color:red;"></i>';
                                            $error++;
                                        }
                                        if ($atmIP) {
                                            $ipRemark .= ' ATM IP <i class="fas fa-check" style="color:green;"></i>';
                                        } else {
                                            $error++;
                                            $ipRemark .= ' ATM IP <i class="fas fa-window-close"  style="color:red;"></i>';
                                        }
                                        

                                        $routerConfiguration = mysqli_query($con, "select * from routerConfiguration where atmid='" . $atmid . "' and status=1");
                                        $routerConfigurationResult = mysqli_fetch_assoc($routerConfiguration);

                                        $serialNumber = $routerConfigurationResult['serialNumber'];
                                        
                                        if ($serialNumber) {
                                            $configurationRemark .= ' Serial Number <i class="fas fa-check" style="color:green;"></i>';
                                        } else {
                                            $configurationRemark .= ' Serial Number <i class="fas fa-window-close" style="color:red;"></i>';
                                            $configurationError++;
                                        }


                                    ?>

                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $atmid; ?></td>
                                            <td><?= $address; ?></td>
                                            <td><?= $city; ?></td>
                                            <td><?= $state; ?></td>
                                            <td><?= getMaterialRequestInitiatorName($siteid); ?></td>


                                            <td><?= $ipRemark; ?></td>
                                            <td><?= $configurationRemark; ?></td>
                                            <td>
                                                <?
                                                if ($configurationError + $error > 0) {
                                                    echo '<label style="color:red;">Pending Details !</label>';
                                                } else { ?>
                                                    <a href="sendMaterial.php?siteid=<?= $siteid; ?>">Send Material</a>
                                                <? } ?>
                                            </td>
                                            <td>
                                                <?= getMaterialRequestStatus($siteid); ?>
                                            </td>
                                            <td>
                                                <?= getMaterial_requestData($siteid, 'created_at'); ?>
                                            </td>
                                        </tr>
                                    <? $i++;
                                    } ?>

                                </tbody>
                            </table>
                        <? } else {
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
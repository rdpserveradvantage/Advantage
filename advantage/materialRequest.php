<?php include('header.php'); 

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

<style>
    .error {
        border: 1px solid red;
    }
    .nav-tabs .slide{
        width: calc(100% / 2) !important;
    }
    

.md-tabs .nav-item {
    width: calc(100% / 2) !important;
}
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">

                        <?php
                        $siteidsql = mysqli_query($con, "SELECT siteid FROM `material_requests` where status='pending' group by siteid");
                        while ($siteidsql_result = mysqli_fetch_assoc($siteidsql)) {
                            $siteids[] = $siteidsql_result['siteid'];
                        }
                        $siteids_ar = $siteids;
                        $siteids = json_encode($siteids);
                        $siteids = str_replace(array('[', ']', '"'), '', $siteids);
                        $siteids = explode(',', $siteids);
                        $siteids = "'" . implode("', '", $siteids) . "'";
                        $recordsPerPage = 10; // Number of records per page
                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $recordsPerPage;
                        ?>

                        <ul class="nav nav-tabs md-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#fresh-requests" role="tab" aria-selected="true">Installation Requests</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#service-requests" role="tab" aria-selected="false">Service Requests</a>
                                <div class="slide"></div>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <!-- Fresh Requests Tab -->
                            <div class="tab-pane fade show active" id="fresh-requests" role="tabpanel" aria-labelledby="fresh-requests-tab">

                                <div class="card-body" style="overflow:auto;">
                                    <?

                                    $siteids = array();
                                    $siteidsql = mysqli_query($con, "SELECT siteid FROM `material_requests` where status='pending' group by siteid");
                                    while ($siteidsql_result = mysqli_fetch_assoc($siteidsql)) {
                                        $siteids[] = $siteidsql_result['siteid'];
                                    }
                                    $siteids_ar = $siteids;
                                    $siteids = json_encode($siteids);
                                    $siteids = str_replace(array('[', ']', '"'), '', $siteids);
                                    $siteids = explode(',', $siteids);
                                    $siteids = "'" . implode("', '", $siteids) . "'";

                                    $recordsPerPage = 10; // Number of records per page
                                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                                    $offset = ($currentPage - 1) * $recordsPerPage;

                                    if ($siteids_ar) { ?>
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
                                                <?php
                                                $counter = ($currentPage - 1) * $recordsPerPage + 1;
                                                $sql = mysqli_query($con, "SELECT * FROM sites WHERE id IN ($siteids) LIMIT $offset, $recordsPerPage");
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
                                                        <td><?= $counter; ?></td>
                                                        <td><?= $atmid; ?></td>
                                                        <td><?= $address; ?></td>
                                                        <td><?= $city; ?></td>
                                                        <td><?= $state; ?></td>
                                                        <td><?= getMaterialRequestInitiatorName($siteid); ?></td>
                                                        <td><?= $ipRemark; ?></td>
                                                        <td><?= $configurationRemark; ?></td>
                                                        <td>
                                                            <?php
                                                            if ($configurationError + $error > 0) {
                                                                echo '<label style="color:red;">Pending Details !</label>';
                                                            } else { ?>
                                                                <a href="sendMaterial.php?siteid=<?= $siteid; ?>">Send Material</a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= getMaterialRequestStatus($siteid); ?></td>
                                                        <td><?= getMaterial_requestData($siteid, 'created_at'); ?></td>
                                                    </tr>
                                                <?php
                                                    $counter++;
                                                } ?>
                                            </tbody>
                                        </table>

                                        <?php
                                        $totalRecords = count($siteids_ar);
                                        $totalPages = ceil($totalRecords / $recordsPerPage);
                                        ?>
                                        <div class="pagination">
                                            <ul>
                                                <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                                    <li class="<?php if ($page == $currentPage) echo 'active'; ?>">
                                                        <a href="?page=<?= $page; ?>"><?= $page; ?></a>
                                                    </li>
                                                <?php endfor; ?>
                                            </ul>
                                        </div>

                                    <?php
                                    } else {
                                        echo '<div class="noRecordsContainer">
                                        <img src="assets/no_records.jpg">
                                    </div>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Service Requests Tab -->
                            <div class="tab-pane fade" id="service-requests" role="tabpanel" aria-labelledby="service-requests-tab">

                                <div class="card-body" style="overflow:auto;">

                                    <?
                                    echo "select * from vendormaterialrequest where status=0 and requestToInventory=1" ; 
                                    
                                    $serviceRequest = mysqli_query($con, "select * from vendormaterialrequest where status=0 and requestToInventory=1");
                                    if (mysqli_num_rows($serviceRequest) > 0) {

                                        echo "<table class='table table-hover table-styling table-xs'>
                                        <thead>
                                            <tr class='table-primary'>
                                            <th>Sr No</th>
                                            <th>Action</th>
                                            <th>Vendor</th>
                                            <th>ATMID</th>
                                            <th>Material</th>
                                            <th>Condition</th>
                                            <th>Requested At</th>
                                            <th>Availabilty</th>
                                        </tr>
                                        </thead>
                                        <tbody> ";

                                        $srno = 1;
                                        while ($serviceRequestResult = mysqli_fetch_assoc($serviceRequest)) {

                                            $id = $serviceRequestResult['id'];
                                            $siteid = $serviceRequestResult['siteid'];
                                            $vendorId = $serviceRequestResult['vendorId'];
                                            $vendorName = $serviceRequestResult['vendorName'];
                                            $atmid = $serviceRequestResult['atmid'];
                                            $materialName = $serviceRequestResult['materialName'];
                                            $materialCondition = $serviceRequestResult['materialCondition'];
                                            $requestToInventoryDate = $serviceRequestResult['requestToInventoryDate'];

                                            $checkInventory = mysqli_query($con, "select material,count(1) as materialCount from inventory where material like '" . trim($materialName) . "' and status=1 group by material having count(1) > 0");
                                            if ($checkInventoryResult = mysqli_fetch_assoc($checkInventory)) {
                                                $matName = $checkInventoryResult['material'];
                                                $matCount = $checkInventoryResult['materialCount'];
                                                $availability = $matCount . ' In Stock ';
                                                $availabilityStatus=1;
                                            }else{
                                                $availability = 'Not Available';
                                                $availabilityStatus=0;
                                            }
                                            echo "<tr>
                                                    <td>$srno</td>
                                                    <td>
                                                    <button class='send-material btn btn-primary' data-materialName='$materialName'
                                                    data-id='$id' data-siteid='$siteid' data-atmid='$atmid' data-vendorid='$vendorId'>Send Material</button> 
                                                |   <button class='btn btn-danger'>Request Reject</button>
                                                    </td>
                                                    <td>$vendorName</td>
                                                    <td>$atmid</td>
                                                    <td>$materialName</td>
                                                    <td>$materialCondition</td>
                                                    <td>$requestToInventoryDate</td>
                                                    <td>$availability</td>
                                                </tr>";

                                            $srno++;
                                        }



                                        echo "</tbody>
                                        </table>";
                                    } else {
                                        echo '
                                            <div class="noRecordsContainer">
                                                <img src="assets/noRecords.png">
                                            </div>';
                                    }
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



<div class="modal fade" id="sendFromStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send From Stock</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <form id="vendorForm">
                    <input type="hidden" name="id">
                    <input type="hidden" name="atmid" value="<?php echo $atmid; ?>">
                    <input type="hidden" name="siteid" value="<?php echo $siteid; ?>">
                    <input type="hidden" name="vendorId" value="<?php echo $vendorId; ?>">
                    <input type="hidden" name="attribute" value="<?php echo htmlentities(serialize($attributes)); ?>">
                    <input type="hidden" name="values" value="<?php echo htmlentities(serialize($values)); ?>">
                    <input type="hidden" name="serialNumbers" value="<?php echo htmlentities(serialize($serialNumbers)); ?>">


                    <div class="row">
                        <div class="col-sm-6">
                            <label for="">Material</label>
                            <input type="text" name="attribute" id="material" class="form-control" value="" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Serial Number</label>
                            <input type="text" name="serialNumbers" id="serialNumbers" class="form-control" value="" required>
                        </div>

                    </div>
                    <hr />

                    <div class="row">
                        <div class="col-sm-6">
                            <label>Contact Person Name</label>
                            <input type="text" name="contactPersonName" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label>Contact Person Number</label>
                            <input type="text" name="contactPersonNumber" class="form-control" required>
                        </div>
                        <div class="col-sm-12">
                            <label>Address</label>
                            <textarea name="address" class="form-control" required></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label>POD</label>
                            <input type="text" name="POD" class="form-control" required />
                        </div>
                        <div class="col-sm-6">
                            <label>Courier</label>
                            <input type="text" name="courier" class="form-control" required />
                        </div>
                        <div class="col-sm-12">
                            <label>Any Other Remark</label>
                            <input type="text" name="remark" class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <input type="submit" name="submit" class="btn btn-primary" onclick="submitForm(event);" id="submitButton" value="Submit">
                        </div>
                    </div>
                </form>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('.send-material').click(function() {

            var id = $(this).data('id');
            var siteid = $(this).data('siteid');
            var atmid = $(this).data('atmid');
            var materialName = $(this).data('materialname');
            var vendorId = $(this).data('vendorid');

            $('#sendFromStockModal').find('[name="id"]').val(id);
            $('#sendFromStockModal').find('[name="atmid"]').val(atmid);
            $('#sendFromStockModal').find('[name="siteid"]').val(siteid);
            $('#sendFromStockModal').find('[name="vendorId"]').val(vendorId);
            $('#sendFromStockModal').find('[name="attribute"]').val(materialName); //attribute = material_name

            $('#sendFromStockModal').modal('show');

        });



    });

    function submitForm(event) {
        event.preventDefault();
        $('#vendorForm [required]').removeClass('error');
        if (validateForm()) {
            var formData = $('#vendorForm').serialize();
            $.ajax({
                type: 'POST',
                url: 'process_IndividualMaterialSend.php',
                data: formData,
                success: function(response) {
                    console.log(response);
                    var responseData = JSON.parse(response);
                    if (responseData.status == '200') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: responseData.message,
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: responseData.message,
                        });
                    }
                },
                error: function(error) {
                    console.log(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error submitting the form. Please try again.',
                    });
                }
            });
        } else {
            alert('Please fill in all required fields before submitting.');
        }
    }

    function validateForm() {
        var isValid = true;
        $('#vendorForm [required]').each(function() {
            if ($(this).val().trim() == '') {
                isValid = false;
                $(this).addClass('error');
            }
        });

        return isValid;
    }
</script>


<?php include('footer.php'); ?>
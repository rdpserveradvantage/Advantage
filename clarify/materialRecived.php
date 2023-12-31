<?php include('header.php'); ?>


<style>
    html {
        text-transform: inherit !important;
    }

    table {
        font-size: 14px;
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow:auto;">


                            <?
                            $counter = 1;
                            $statement = "SELECT * FROM vendorMaterialSend where contactPersonName='" . $userid . "' and status=1 order by id desc";
                            $sql = mysqli_query($con, $statement);
                            if (mysqli_num_rows($sql) > 0) {
                                echo "<table class='table table-hover table-styling table-xs'>
                                        <thead>
                                            <tr class='table-primary'>
                                                <th>Srno</th>
                                                <th>Material</th>
                                                <th>ATMID</th>
                                                <th>Status</th>
                                                <th>Update Action</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>POD</th>
                                                <th>Courier</th>
                                                <th>Remark</th>
                                                <th>Date</th>
                                                <th>Dispatch</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                    $id = $sql_result['id'];
                                    $siteid = $sql_result['siteid'];
                                    $atmid = $sql_result['atmid'];
                                    $vendorId = $sql_result['vendorId'];
                                    $vendorName = getVendorName($vendorId);
                                    $address = $sql_result['address'];
                                    $contactPerson = $sql_result['contactPersonName'];
                                    $contactNumber = $sql_result['contactPersonNumber'];
                                    $pod = $sql_result['pod'];
                                    $courier = $sql_result['courier'];
                                    $remark = $sql_result['remark'];
                                    $date = $sql_result['created_at'];
                                    $isDelivered = $sql_result['isConfirm'];
                                    $materialSendId = $sql_result['materialSendId'];


                                    $matSql = mysqli_query($con, "select * from material_send_details where materialSendId='" . $materialSendId . "'");
                                    $matSqlResult = mysqli_fetch_assoc($matSql);
                                    $attribute = $matSqlResult['attribute'];




                                    $againSend = mysqli_query($con, "select * from vendorMaterialSend where materialSendId='" . $id . "'");
                                    if ($againSendResult = mysqli_fetch_assoc($againSend)) {
                                        $isAgainSendStatus = 1;
                                        $contactPersonName = $againSendResult['contactPersonName'];
                                        $contactPersonName = vendorUsersData($contactPersonName, 'name');
                                        $status = $againSendResult['status'];

                                        if ($status == 0) {
                                            $isAgainSendStatus = 0;
                                        }
                                    } else {
                                        $isAgainSendStatus = 0;
                                    }

                                    $contactPersonName = vendorUsersData($contactPerson, 'name');


                                    $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . trim($atmid) . "' and siteid='" . $siteid . "' and materialSendId='" . $id . "' order by id desc");
                                    if (mysqli_num_rows($ifExistTrackingUpdateSql) > 0  ) {
                                        $ifExistTrackingUpdate = 1;
                                    } else {
                                        $ifExistTrackingUpdate = 0;
                                    }

                                    echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                                    echo "<td>$counter</td>";
                                    echo "<td>$attribute</td>";
                                    echo "<td>$atmid</td>";
                                    echo "<td class='strong'>" .
                                        ($isDelivered == 1 ? 'Delivered' : 'In-Transit') . "</td>";
                                    echo "<td>";

                                    if ($ifExistTrackingUpdate == 1) {
                                        // echo '<button type="button" class="view-dispatch-info btn btn-primary btn-sm" data-id=' . $id . '>View</button>';
echo 'Received' ; 
                                        if ($isDelivered == 0) {
                                            echo '| <a href="updateMaterialReceived.php?id=' . $id . '"> Update Receive </a>';
                                        }

                                    } else if($ifExistTrackingUpdate==0) {
                                        echo "<a class='btn btn-warning btn-sm' href='updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>
                                                Update Receive
                                        </a>" . "</td>";
                                    }
                                    echo "</td>";

                                    echo "<td>$contactPersonName</td>";
                                    echo "<td>$contactNumber</td>";
                                    echo "<td>$pod</td>";
                                    echo "<td>$courier</td>";
                                    echo "<td>$remark</td>";
                                    echo "<td>$date</td>";
                                    if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                                        echo "<td>
                                                        <a href='dispatchMaterial.php?siteid=$siteid&atmid=$atmid&materialSendId=$id' class='btn btn-primary'>Dispatch</a>
                                                  </td>";
                                    } else if ($isDelivered == 1 && $isAgainSendStatus == 1) {
                                        echo "<td>
                                                            Material Send to <span class='strong'>$contactPersonName <span>
                                                    </td>";
                                    } else {
                                        echo "<td>No Status</td>";
                                    }

                                    echo "</tr>";
                                    $counter++;
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


<div class="modal" id="viewdispatchinfo">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Info</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div id="getDispatchInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.view-dispatch-info').click(funct ion() {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'getDispatchInfo.php',
            data: {
                id: id
            },
            success: func tion(response) {
                $("#getDispatchInfo").html(response);
            },
            error: fun ction(error) {
                $("#getDispatchInfo").html('Nothing found here !');

            }
        });

        $('#viewdispatchinfo').modal('show');


    });
</script>
<?php include('footer.php'); ?>
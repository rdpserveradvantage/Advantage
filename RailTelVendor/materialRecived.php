<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow:auto;">


                            <?
                            $counter = 1;
                            $sql = mysqli_query($con, "SELECT * FROM material_send where vendorId='" . $RailTailVendorID ."' order by id desc");
                            if (mysqli_num_rows($sql) > 0) {
                                echo "<table class='table table-hover table-styling table-xs'>
                                        <thead>
                                            <tr class='table-primary'>
                                                <th>Srno</th>
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
                                    $isDelivered = $sql_result['isDelivered'];

                                    $againSend = mysqli_query($con, "select * from vendorMaterialSend where siteid='" . $siteid . "' and status=1");
                                    if ($againSendResult = mysqli_fetch_assoc($againSend)) {
                                        $isAgainSendStatus = 1;
                                        $contactPersonName = $againSendResult['contactPersonName'];
                                        $contactPersonName = vendorUsersData($contactPersonName, 'name');
                                    } else {
                                        $isAgainSendStatus = 0;
                                    }

                                    $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' and materialSendId='" . $id . "' order by id desc");
                                    if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
                                        $ifExistTrackingUpdate = 1;
                                    } else {
                                        $ifExistTrackingUpdate = 0;
                                    }

                                    echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                                    echo "<td>$counter</td>";
                                    echo "<td class='strong'>$atmid</td>";
                                    echo "<td class='strong'>" .
                                        ($isDelivered == 1 ? 'Delivered' : 'In-Transit') . "</td>";
                                    echo "<td>" . ($ifExistTrackingUpdate == 1 ? 'View' : "<a href='updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>Update</a>") . "</td>";
                                    echo "<td>$contactPerson</td>";
                                    echo "<td>$contactNumber</td>";
                                    // echo "<td>$contactPerson</td>";
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

<?php include('footer.php'); ?>
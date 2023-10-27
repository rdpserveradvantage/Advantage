<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card">
                        <div class="card-block">
                            <form action="<? $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>ATM ID</label>
                                        <input type="text" class="form-control" name="atmid">
                                    </div>

                                </div>
                                <br />

                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="submit" class="btn btn-primary" name="submit">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <?php
                    // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
                    

                    $sqlappCount = "SELECT count(1) as total FROM material_send where vendorId='" . $RailTailVendorID . "'";
                    $atm_sql = "SELECT * FROM material_send where vendorId='" . $RailTailVendorID . "' ";



                    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                        $atmid = $_REQUEST['atmid'];
                        $atm_sql .= "and atmid like '%" . $atmid . "%'";
                        $sqlappCount .= "and atmid like '%" . $atmid . "%'";
                    }


                    $atm_sql .= "  order by id desc";
                    $sqlappCount .= " ";

                    $page_size = 10;
                    $result = mysqli_query($con, $sqlappCount);
                    $row = mysqli_fetch_assoc($result);
                    $total_records = $row['total'];
                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $page_size;
                    $total_pages = ceil($total_records / $page_size);
                    $window_size = 10;
                    $start_window = max(1, $current_page - floor($window_size / 2));
                    $end_window = min($start_window + $window_size - 1, $total_pages);
                    $sql_query = "$atm_sql LIMIT $offset, $page_size";
                    // }
                    echo $sql_query;

                    ?>


                    <div class="card">
                        <div class="card-block" style="overflow:auto;">


                            <?
                            $counter = 1;
                            $sql = mysqli_query($con, $sql_query);
                            if (mysqli_num_rows($sql) > 0) {

                                ?>
                                <div class="card-header">

                                    <h5> Total Records:
                                        <strong class="record-count">
                                            <? echo $total_records; ?>
                                        </strong>
                                    </h5>
                                    <hr>
                                    <form action="exportMaterialReceived.php" method="POST">
                                        <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                        <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                                    </form>

                                </div>

                                <?
                                echo "<table class='table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs'>
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
                                                <th>Goods Return</th>
                                            </tr>
                                        </thead>
                                        <tbody>";


                                $i = 1;
                                $counter = ($current_page - 1) * $page_size + 1;
                                $sql_app = mysqli_query($con, $sql_query);
                                while ($sql_result = mysqli_fetch_assoc($sql_app)) {

                                    // while ($sql_result = mysqli_fetch_assoc($sql)) {
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
                                    echo "<td>" . ($ifExistTrackingUpdate == 1 ?
                                        '<button type="button" style="border:none;" class="view-dispatch-info" data-id=' . $id . '>
                                    View
                                    </button>'
                                        : "<a href='updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>Update Receive</a>") . "</td>";
                                    echo "<td>$contactPerson</td>";
                                    echo "<td>$contactNumber</td>";
                                    // echo "<td>$contactPerson</td>";
                                    echo "<td>$pod</td>";
                                    echo "<td>$courier</td>";
                                    echo "<td>$remark</td>";
                                    echo "<td>$date</td>";

                                    if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                                        echo "<td>
                                                <a href='dispatchMaterial.php?siteid=$siteid&atmid=$atmid&materialSendId=$id'>Dispatch</a>
                                            </td>";
                                        $goodsReturn = 1;

                                    } else if ($isDelivered == 1 && $isAgainSendStatus == 1) {
                                        echo "<td>
                                                            Material Send to <span class='strong'>$contactPersonName <span>
                                                    </td>";
                                        $goodsReturn = 0;

                                    } else {
                                        $goodsReturn = 0;
                                        echo "<td>No Status</td>";
                                    }

                                    if ($goodsReturn == 1) {
                                        echo "<td>
                                        <a href='./goodsReturn.php?siteid=$siteid&atmid=$atmid&materialSendId=$id' target='_blank'>Goods Return</a>
                                        </td>";
                                    } else {
                                        echo "<td>
                                        
                                        </td>";
                                    }



                                    echo "</tr>";
                                    $counter++;
                                }

                                echo "</tbody>
                                    </table>";




                                $atmid = $_REQUEST['atmid'];
                                echo '<div class="pagination"><ul>';
                                if ($start_window > 1) {

                                    echo "<li><a href='?page=1&&atmid=$atmid'>First</a></li>";
                                    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '">Prev</a></li>';
                                }

                                for ($i = $start_window; $i <= $end_window; $i++) {
                                    ?>
                                    <li class="<? if ($i == $current_page) {
                                        echo 'active';
                                    } ?>">
                                        <a href="?page=<?= $i; ?>&&atmid=<?= $atmid; ?>">
                                            <?= $i; ?>
                                        </a>
                                    </li>

                                <? }

                                if ($end_window < $total_pages) {

                                    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '">Next</a></li>';
                                    echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '">Last</a></li>';
                                }
                                echo '</ul></div>';



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
    $('.view-dispatch-info').click(function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST',
            url: 'getDispatchInfo.php',
            data: {
                id: id
            },
            success: function (response) {
                $("#getDispatchInfo").html(response);
            },
            error: function (error) {
                $("#getDispatchInfo").html('Nothing found here !');

            }
        });

        $('#viewdispatchinfo').modal('show');


    });
</script>
<?php include('footer.php'); ?>
<?php include('header.php');?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <p style="text-align:right;"><a href="#" data-toggle="modal" data-target="#myModal">All Stocks</a></p>
                    <div class="card" id="filter">
                        <div class="card-block">
                            <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>ATM ID</label>
                                        <input type="text" name="atmid" class="form-control" value="<?= $_REQUEST['atmid']; ?>" placeholder="Enter ATMID ..." />
                                    </div>
                                </div>
                                <br>
                                <div class="col" style="display:flex;justify-content:center;">
                                    <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                    <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                    $sqlappCount = "select count(1) as total from vendormaterialsend where contactPersonName='" . $userid . "' ";
                    $atm_sql = "SELECT * FROM vendormaterialsend where contactPersonName='" . $userid . "' ";

                    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                        $atmid = $_REQUEST['atmid'];
                        $atm_sql .= "and atmid like '%" . $atmid . "%'";
                        $sqlappCount .= "and atmid like '%" . $atmid . "%'";
                    }
                    $atm_sql .=  "  order by id desc";
                    $sqlappCount .=  " ";

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
                    // echo $sql_query ; 





                    ?>
                    <div class="card">
                        <div class="card-block" style="overflow:auto;">

                            <div class="card-header">

                                <h5> Total Records:
                                    <strong class="record-count"><? echo $total_records; ?></strong>
                                </h5>
                                <span style="color:red; ">( Records Received site wise )</span>

                                <hr>
                                <form action="exportInventoryRecords.php" method="POST">
                                    <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                                </form>

                            </div>
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs">
                                <thead>
                                    <tr class="table-primary">
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
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $counter = ($current_page - 1) * $page_size + 1;
                                    $sql_app = mysqli_query($con, $sql_query);
                                    while ($sql_result = mysqli_fetch_assoc($sql_app)) {

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
                                        $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
                                        if ($ifExistTrackingUpdateSqlResult = mysqli_fetch_assoc($ifExistTrackingUpdateSql)) {
                                            $ifExistTrackingUpdate = 1;
                                        } else {
                                            $ifExistTrackingUpdate = 0;
                                        }
                                        $contactPerson = vendorUsersData($contactPerson,'name') ; 
                                        echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$id'>";
                                        echo "<td>$counter</td>";
                                        echo "<td class='strong'>$atmid</td>";
                                        echo "<td class='strong'>" .
                                            ($isDelivered == 1 ? 'Delivered' : 'In-Transit') . "</td>";
                                        echo "<td>" . ($ifExistTrackingUpdate == 1 ? 'View' : "<a href='updateMaterialSentTracking.php?id={$id}&siteid={$siteid}&atmid={$atmid}'>Update</a>") . "</td>";

                                        echo "<td>$contactPersonName</td>";
                                        echo "<td>$contactNumber</td>";
                                        echo "<td>$pod</td>";
                                        echo "<td>$courier</td>";
                                        echo "<td>$remark</td>";
                                        echo "<td>$date</td>";
                                        if ($isDelivered == 1 && $isAgainSendStatus == 0) {
                                            echo "<td>
                                                    <a href='dispatchMaterial.php?siteid=$siteid&atmid=$atmid&materialSendId=$id'>Dispatch</a>
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
                                    ?>
                                </tbody>
                            </table>




                            <?

                            $material_name = $_REQUEST['material'];
                            echo '<div class="pagination"><ul>';
                            if ($start_window > 1) {

                                echo "<li><a href='?page=1&&material=$material_name'>First</a></li>";
                                echo '<li><a href="?page=' . ($start_window - 1) . '&&material=' . $material_name . '">Prev</a></li>';
                            }

                            for ($i = $start_window; $i <= $end_window; $i++) {
                            ?>
                                <li class="<? if ($i == $current_page) {
                                                echo 'active';
                                            } ?>">
                                    <a href="?page=<?= $i; ?>&&material=<?= $material_name; ?>">
                                        <?= $i;  ?>
                                    </a>
                                </li>

                            <? }

                            if ($end_window < $total_pages) {

                                echo '<li><a href="?page=' . ($end_window + 1) . '&&material=' . $material_name . '">Next</a></li>';
                                echo '<li><a href="?page=' . $total_pages . '&&material=' . $material_name . '">Last</a></li>';
                            }
                            echo '</ul></div>';


                            ?>




                        </div>
                    </div>



                    <!-- SELECT material,count(1) FROM `vendorinventory` where vendorId=1 and material<>'' group by material; -->






                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">All Stocks</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?


$allSql = mysqli_query($con,"SELECT * FROM vendormaterialsend where contactPersonName='" . $userid . "' ");
while($allSqlResult = mysqli_fetch_assoc($allSql)){
    $sendID[] = $allSqlResult['id'];
}
$sendID = "'" . implode("','", $sendID) . "'";




                    $allSql = "SELECT attribute,count(1) as total FROM `vendormaterialsenddetails` where materialSendId in($sendID) 
                    and attribute<>'' group by attribute";
                    $allSqlQuery = mysqli_query($con, $allSql);
                    $grandTotal = 0;
                    while ($allSqlQueryResult = mysqli_fetch_assoc($allSqlQuery)) {
                        $material = $allSqlQueryResult['attribute'];
                        $total = $allSqlQueryResult['total'];
                        $grandTotal = $grandTotal + $total;
                    ?>
                        <div class="col-sm-2">
                            <div class="card">
                                <div class="card-body">

                                    <span class="strong font-size-18" style="color:#7d818c;"><?= $material . ' : ';  ?></span>
                                    <span style="color:red" class="font-size-18"><?= $total; ?></span>

                                </div>
                            </div>
                        </div>

                    <?
                    }
                    ?>
                </div>
                <hr />
                <h3 style="text-align:right;"><?= 'Total Products : ' . $grandTotal; ?></h3>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
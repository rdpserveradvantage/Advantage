<?php include('header.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<style>
    html {
        /* text-transform: inherit !important; */
    }
</style>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="card" id="filter">
                        <div class="card-block">

                            <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                <div class="row">


                                    <div class="col-sm-12">
                                        <label>ATM ID</label>
                                        <input type="text" name="atmid" class="form-control" value="<?= $_REQUEST['atmid']; ?>" placeholder="Enter ATM ID ..." />
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
                    // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
                    $sqlappCount = "select count(1) as total from material_send where 1 ";
                    $atm_sql = "select * from material_send where 1 ";

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
                        <div class="card-header">
                            <h5>Total Records: <strong class="record-count"><? echo $total_records; ?></strong></h5>

                            <hr>
                            <form action="exportInventorySend.php" method="POST">
                                <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                            </form>

                        </div>



                        <div class="card-block" style="overflow:auto; ">
                            <table class="table table-hover table-styling table-xs">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Srno</th>
                                        <th>ATMID</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                        <th>Vendor</th>
                                        <th>Address</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>POD</th>
                                        <th>Courier</th>
                                        <th>Remark</th>
                                        <th>Date</th>
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

                                        $ifExistTrackingUpdateSql = mysqli_query($con, "select * from trackingDetailsUpdate where atmid='" . $atmid . "' and siteid='" . $siteid . "' order by id desc");
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

                                        echo "<td>$vendorName</td>";
                                        echo "<td>$address</td>";
                                        echo "<td>$contactPerson</td>";
                                        echo "<td>$contactNumber</td>";
                                        echo "<td>$pod</td>";
                                        echo "<td>$courier</td>";
                                        echo "<td>$remark</td>";
                                        echo "<td>$date</td>";
                                        echo "</tr>";
                                        // echo "<tr id='details-$id' class='collapse'>";
                                        // echo "<td colspan='9'>";

                                        // // Retrieve and display the material_send_details
                                        // $detailsQuery = "SELECT * FROM material_send_details WHERE materialSendId = $id";
                                        // $detailsResult = mysqli_query($con, $detailsQuery);
                                        // echo "<table class='table table-bordered'>";
                                        // echo "<thead><tr><th>Product Name</th><th>Serial Number</th></tr></thead>";
                                        // echo "<tbody>";
                                        // while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                                        //     $attribute = $detailsRow['attribute'];
                                        //     $serialNumber = $detailsRow['serialNumber'];
                                        //     echo "<tr><td>$attribute</td><td>$serialNumber</td></tr>";
                                        // }
                                        // echo "</tbody>";
                                        // echo "</table>";

                                        echo "</td>";
                                        echo "</tr>";
                                        $counter++;
                                    }
                                    ?>
                                </tbody>
                            </table>




                            <?

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
                                        <?= $i;  ?>
                                    </a>
                                </li>

                            <? }

                            if ($end_window < $total_pages) {

                                echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '">Next</a></li>';
                                echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '">Last</a></li>';
                            }
                            echo '</ul></div>';


                            ?>







                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('.clickable-row').click(function() {
    //         $(this).toggleClass('active');
    //     });
    // });
</script>

<?php include('footer.php'); ?>
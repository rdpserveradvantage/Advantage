<?php include('header.php'); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card" id="filter">
                        <div class="card-block">
                            <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                <div class="row">

                                    <div class="col-sm-3">
                                        <label>Stock</label>
                                        <select name="status" class="form-control">
                                            <option value="0" <? if ($_REQUEST['status'] == '0') {
                                                                    echo 'selected';
                                                                } ?>>ALL</option>
                                            <option value="1" <? if ($_REQUEST['status'] == '1') {
                                                                    echo 'selected';
                                                                } ?>>AVAILABLE</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Material</label>
                                        <select name="material" class="form-control">
                                            <option value="">-- Select Material --</option>
                                            <?php
                                            $i = 0;
                                            $materiallist = mysqli_query($con, "SELECT distinct(material) as material from Inventory where status=1 ");
                                            while ($fetch_data = mysqli_fetch_assoc($materiallist)) {
                                            ?>

                                                <option value="<?php echo $fetch_data['material'] ?>" <?php if ($fetch_data['material'] == $_REQUEST['material']) {
                                                                                                            echo 'selected';
                                                                                                        }  ?>>
                                                    <?php echo $fetch_data['material']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>

                                    </div>

                                    <div class="col-sm-3">
                                        <label>Serial Number</label>
                                        <input type="text" name="serialNumber" class="form-control" value="<?= $_REQUEST['serialNumber']; ?>" placeholder="Enter Serial Number ..." />
                                    </div>

                                    <div class="col-sm-3">
                                        <label>Type</label>
                                        <select name="thisInventoryType" class="form-control">
                                            <option value="">--Select--</option>
                                            <option value="Actual">Actual</option>
                                            <option value="Internal">Internal</option>
                                        </select>
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
                    $sqlappCount = "select count(1) as total from vendormaterialsend where isConfirm = 1 and contactPersonName= '".$userid."' ";
                    $atm_sql = "select * from vendormaterialsend where 1 and isConfirm = 1 and contactPersonName= '".$userid."' ";

                    if (isset($_REQUEST['material']) && $_REQUEST['material'] != '') {
                        $material = $_REQUEST['material'];
                        $atm_sql .= "and material like '" . $material . "'";
                        $sqlappCount .= "and material like '" . $material . "'";
                    }

                    if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {
                        $status = $_REQUEST['status'];
                        if ($status == '0') {
                            $atm_sql .= " and status in (0,1) ";
                            $sqlappCount .= " and status in(0,1) ";
                        } else if ($status == '1') {
                            $atm_sql .= " and status in (1) ";
                            $sqlappCount .= " and status in(1) ";
                        }
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
                    // echo $atm_sql ; 





                    ?>

                    <div class="card">
                        <div class="card-block" style="overflow:auto;">

                            <div class="card-header">
                                <h5>Total Records: <strong class="record-count"><? echo $total_records; ?></strong></h5>

                                <hr>
                                <form action="exportInventoryRecords.php" method="POST">
                                    <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                                </form>

                            </div>


                            <!-- <div style="display:flex;justify-content:space-around;">
                                <h5 style="text-align:center;">All Stocks - <p>Total Records- <?= $total_records;  ?></p>
                                </h5>

                                <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                            </div> -->



                            <table class="table table-hover table-styling table-xs">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr no</th>
                                        <th>material</th>
                                        <th>material_make</th>
                                        <th>model_no</th>
                                        <th>serial_no</th>
                                        <th>challan_no</th>
                                        <th>amount</th>
                                        <th>gst</th>
                                        <th>amount_with_gst</th>
                                        <th>courier_detail</th>
                                        <th>tracking_details</th>
                                        <th>date_of_receiving</th>
                                        <th>receiver_name</th>
                                        <th>vendor_name</th>
                                        <th>vendor_contact</th>
                                        <th>po_date</th>
                                        <th>po_number</th>
                                        <th>Type</th>

                                        <!-- Add other column headers here -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    $counter = ($current_page - 1) * $page_size + 1;
                                    $sql_app = mysqli_query($con, $sql_query);
                                    while ($row = mysqli_fetch_assoc($sql_app)) {
                                        $materialId = $row['id'];
                                        $material = $row['material'];
                                        $material_make = $row['material_make'];
                                        $model_no = $row['model_no'];
                                        $serial_no = $row['serial_no'];
                                        $challan_no = $row['challan_no'];
                                        $amount = $row['amount'];
                                        $gst = $row['gst'];
                                        $amount_witd_gst = $row['amount_witd_gst'];
                                        $courier_detail = $row['courier_detail'];
                                        $tracking_details = $row['tracking_details'];
                                        $date_of_receiving = $row['date_of_receiving'];
                                        $receiver_name = $row['receiver_name'];
                                        $vendor_name = $row['vendor_name'];
                                        $vendor_contact = $row['vendor_contact'];
                                        $po_date = $row['po_date'];
                                        $po_number = $row['po_number'];
                                        $inventoryType = $row['inventoryType'];
                                        $invstatus = $row['status'];
                                        echo '<tr>';
                                    ?>
                                        <td><?= $counter; ?></td>
                                      
                                        <td><?= $material; ?></td>
                                        <td><?= $material_make; ?></td>
                                        <td><?= $model_no; ?></td>
                                        <td><?= $serial_no; ?></td>
                                        <td><?= $challan_no; ?></td>
                                        <td><?= $amount; ?></td>
                                        <td><?= $gst; ?></td>
                                        <td><?= $amount_witd_gst; ?></td>
                                        <td><?= $courier_detail; ?></td>
                                        <td><?= $tracking_details; ?></td>
                                        <td><?= $date_of_receiving; ?></td>
                                        <td><?= $receiver_name; ?></td>
                                        <td><?= $vendor_name; ?></td>
                                        <td><?= $vendor_contact; ?></td>
                                        <td><?= $po_date; ?></td>
                                        <td><?= $po_number; ?></td>
                                        <td><?= $inventoryType; ?></td>


                                    <?

                                        // Display other record fields as table cells
                                        echo '</tr>';
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
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#show_filter").css('display', 'none');

    $("#hide_filter").on('click', function() {
        $("#filter").css('display', 'none');
        $("#show_filter").css('display', 'block');
    });
    $("#show_filter").on('click', function() {
        $("#filter").css('display', 'block');
        $("#show_filter").css('display', 'none');
    });
</script>
<?php include('footer.php'); ?>
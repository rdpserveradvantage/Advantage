<? include('header.php'); ?>


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
                                        <label>Serial Number</label>
                                        <input type="text" name="serial_no" class="form-control" value="<?= $_REQUEST['serial_no']; ?>" placeholder="Enter Serial Number ..." />
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
                    $sqlappCount = "select count(1) as total from ipconfuration where 1 ";
                    $atm_sql = "select id,serial_no,router_ip,network_ip,atm_ip,subnet_ip,created_at,created_by,status
                                from ipconfuration where 1 ";

                    if (isset($_REQUEST['serial_no']) && $_REQUEST['serial_no'] != '') {
                        $serial_no = $_REQUEST['serial_no'];
                        $atm_sql .= "and serial_no like '" . $serial_no . "'";
                        $sqlappCount .= "and serial_no like '" . $serial_no . "'";
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

                            <hr />
                            <form action="exportdoneConfigured.php" method="POST">
                                <input type="hidden" name="exportSql" value="<? echo $atm_sql; ?>">
                                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                            </form>

                        </div>
                        <div class="card-body" style="overflow: auto;">
<hr>
                            <?
                            $i = 1;
                            $sql = mysqli_query($con, "select * from ipconfuration order by id desc");
                            if (mysqli_num_rows($sql) > 0) {

                                echo '
                                <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Serial Number</th>
                                        <th>Network IP</th>
                                        <th>Router IP</th>
                                        <th>ATM IP</th>
                                        <th>Subnet IP</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $i = 1;
                                $counter = ($current_page - 1) * $page_size + 1;
                                $sql_app = mysqli_query($con, $sql_query);
                                while ($row = mysqli_fetch_assoc($sql_app)) {

                                    $id = $row['id'];
                                    $serialNumber = $row['serial_no'];
                                    $created_at = $row['created_at'];
                                    $created_by = $row['created_by'];
                                    $created_by = getUsername($created_by, false);

                                    $router_ip = $row["router_ip"];
                                    $network_ip = $row["network_ip"];
                                    $atm_ip = $row["atm_ip"];
                                    $subnet_ip = $row["subnet_ip"];
                                    $status = $row['status'];
                                    
                                    if($status==1){
                                       $activityStatus = 'Active' ;  
                                    }else{
                                       $activityStatus = 'In-Active' ;  
                                    }

                                    echo "<tr>
                                            <td>{$i}</td>
                                            <td class='strong'>{$serialNumber}</td>
                                            <td>{$network_ip}</td>
                                            <td>{$router_ip}</td>
                                            <td>{$atm_ip}</td>
                                            <td>{$subnet_ip}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            <td>{$activityStatus}</td>
                                            <td><a href='#' data-toggle='modal' data-target='#unbindModal' data-id='{$id}'>Unbind</a></td>

                                        </tr>";

                                    $i++;
                                }

                                echo "    </tbody>
                            </table>";



                            $serial_no = $_REQUEST['serial_no'];
                            echo '<div class="pagination"><ul>';
                            if ($start_window > 1) {

                                echo "<li><a href='?page=1&&serial_no=$serial_no'>First</a></li>";
                                echo '<li><a href="?page=' . ($start_window - 1) . '&&serial_no=' . $serial_no . '">Prev</a></li>';
                            }

                            for ($i = $start_window; $i <= $end_window; $i++) {
                            ?>
                                <li class="<? if ($i == $current_page) {
                                                echo 'active';
                                            } ?>">
                                    <a href="?page=<?= $i; ?>&&serial_no=<?= $serial_no; ?>">
                                        <?= $i;  ?>
                                    </a>
                                </li>

                            <? }

                            if ($end_window < $total_pages) {

                                echo '<li><a href="?page=' . ($end_window + 1) . '&&serial_no=' . $serial_no . '">Next</a></li>';
                                echo '<li><a href="?page=' . $total_pages . '&&serial_no=' . $serial_no . '">Last</a></li>';
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




<div class="modal fade" id="unbindModal" tabindex="-1" role="dialog" aria-labelledby="unbindModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="unbindModalLabel">Unbind Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to unbind this item?</p>
                <input type="hidden" id="unbindItemId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmUnbind()">Unbind</button>
            </div>
        </div>
    </div>
</div>


<script>
    function confirmUnbind() {
        // Retrieve the ID from the hidden input field in the modal
        var idToUnbind = document.getElementById("unbindItemId").value;
        
        alert(idToUnbind)
        // Make an AJAX request to unbindIP.php
        $.ajax({
            type: "POST",
            url: "unbindIP.php",
            data: { id: idToUnbind },
            success: function(response) {
                // Handle the response from unbindIP.php
                // You can update your UI or perform any further actions here
                console.log(response); // Log the response for debugging
            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error(xhr.responseText);
            }
        });

        // Close the modal
        $('#unbindModal').modal('hide');
    }

    // Event listener to set the ID in the modal when the "Unbind" link is clicked
    $(document).on("click", "a[data-target='#unbindModal']", function () {
        var id = $(this).data('id');
        document.getElementById("unbindItemId").value = id;
    });
</script>


<? include('footer.php'); ?>
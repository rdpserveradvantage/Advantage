<? include('header.php'); ?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">

                            <?
                            $vendorId = vendorUsersData($userid,'vendorId') ; 
                            $sql = mysqli_query($con, "select * from faultymaterialrequests where RequestedFor='" . $vendorId . "' and portal in ('Clarity','Clarify')");
                            if (mysqli_num_rows($sql) > 0) {
                                echo '
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs">
                                <thead>
                                <tr class="table-primary">
                                <th>Sr No</th>
                                <th>Material</th>
                                <th>Serial Number</th>
                                <th>ATMID</th>
                                <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                

                                ';
                                $i = 1;
                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                    $MaterialName = $sql_result['MaterialName'];
                                    $MaterialSerialNumber = $sql_result['MaterialSerialNumber'];
                                    $atmid = $sql_result['atmid'];

                                    echo "<tr>
                                    <td>$i &nbsp;&nbsp;<input type='checkbox' name='materialId[]'></td>
                                    <td>$MaterialName</td>
                                    <td>$MaterialSerialNumber</td>
                                    <td>$atmid</td>
                                    <td>
                                    <a href='#'>Send Replacement</a> | 
                                    <a href='#'>Send To Advantage</a>

                                    </td>
                                    </tr>";
                                    $i++;
                                }
                                echo '</tbody>
                                </table>';
                                echo '<a href="#" class="btn btn-primary">Dispatch Checked Item To Advantage</a> |';
                                echo '<a href="#" class="btn btn-warning">Send Replacement</a> ';

                            } else {
                                echo 'No Data Found ! ';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<? include('footer.php'); ?>
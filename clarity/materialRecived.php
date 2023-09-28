<?php include('header.php'); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow:auto;">
                            <?
                            $allSql = mysqli_query($con, "SELECT * FROM vendormaterialsend where contactPersonName='" . $userid . "' ");
                            while ($allSqlResult = mysqli_fetch_assoc($allSql)) {
                                $sendID[] = $allSqlResult['id'];
                            }
                            $sendID = "'" . implode("','", $sendID) . "'";
                            echo '<table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Sr NO</th>
                                            <th>Material</th>
                                            <th>Serial Number</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                            $counter = 1;
                            $allSql = "SELECT * FROM `vendormaterialsenddetails` where materialSendId in($sendID) and attribute<>''";
                            $allSqlQuery = mysqli_query($con, $allSql);
                            $grandTotal = 0;
                            while ($allSqlQueryResult = mysqli_fetch_assoc($allSqlQuery)) {
                                $material = $allSqlQueryResult['attribute'];
                                $serialNumber = $allSqlQueryResult['serialNumber'];
                                echo "<tr>
                                <td>$counter</td>
                                <td>$material</td>
                                <td>$serialNumber</td>

                                </tr>";
                                $counter++;
                            }
                            echo '</tbody>
                            </table>
                            ';

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
<script>
    $(document).ready(function() {
        $('.clickable-row').click(function() {
            $(this).toggleClass('active');
        });
    });
</script>
<?php include('footer.php'); ?>
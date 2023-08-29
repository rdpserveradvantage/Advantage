<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow:auto;">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Srno</th>
                                        <th>ATMID</th>
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
                                    $sql = mysqli_query($con, "SELECT * FROM material_send where vendorId='".$RailTailVendorID."'");
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                        $srno = $sql_result['id'];
                                        $atmid = $sql_result['atmid'];
                                        $address = $sql_result['address'];
                                        $contactPerson = $sql_result['contactPersonName'];
                                        $contactNumber = $sql_result['contactPersonNumber'];
                                        $pod = $sql_result['pod'];
                                        $courier = $sql_result['courier'];
                                        $remark = $sql_result['remark'];
                                        $date = $sql_result['created_at'];

                                        echo "<tr class='clickable-row' data-toggle='collapse' data-target='#details-$srno'>";
                                        echo "<td>$srno</td>";
                                        echo "<td>$atmid</td>";
                                        echo "<td>$address</td>";
                                        echo "<td>$contactPerson</td>";
                                        echo "<td>$contactNumber</td>";
                                        echo "<td>$pod</td>";
                                        echo "<td>$courier</td>";
                                        echo "<td>$remark</td>";
                                        echo "<td>$date</td>";
                                        echo "</tr>";
                                        echo "<tr id='details-$srno' class='collapse'>";
                                        echo "<td colspan='9'>";

                                        // Retrieve and display the material_send_details
                                        $detailsQuery = "SELECT * FROM material_send_details WHERE materialSendId = $srno";
                                        $detailsResult = mysqli_query($con, $detailsQuery);
                                        echo "<table class='table table-bordered'>";
                                        echo "<thead><tr><th>Product Name</th><th>Serial Number</th></tr></thead>";
                                        echo "<tbody>";
                                        while ($detailsRow = mysqli_fetch_assoc($detailsResult)) {
                                            $attribute = $detailsRow['attribute'];
                                            $serialNumber = $detailsRow['serialNumber'];
                                            echo "<tr><td>$attribute</td><td>$serialNumber</td></tr>";
                                        }
                                        echo "</tbody>";
                                        echo "</table>";

                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

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

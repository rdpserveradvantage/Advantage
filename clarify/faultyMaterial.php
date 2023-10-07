<? include('header.php'); ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <?
                              $statement = "SELECT * FROM generatefaultymaterialrequest WHERE requestBy='" . $SERVICE_email . "' AND requestByPortal IN ('Clarity','Clarify') and materialRequestLevel=3 and status=1";
                            $sql = mysqli_query($con, $statement);
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
                                    <tbody>';
                                $i = 1;
                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                    echo $id = $sql_result['id'];
                                    $atmid = $sql_result['atmid'];
                                    echo "<tr>
                                            <td>$i &nbsp;&nbsp;&nbsp;
                                            <input type='checkbox' name='materialRequestId[]' value='$id' /> 
                                            </td>
                                            <td class='strong' colspan='3'>$atmid</td>
                                            <td><a href='#'>Dispatch Item</a></td>
                                        </tr>";
                                    $detailsSql = mysqli_query($con, "SELECT * FROM generatefaultymaterialrequestdetails WHERE requestId='" . $id . "'");
                                    $counter2 = 1;
                                    while ($detailsSql_result = mysqli_fetch_assoc($detailsSql)) {
                                        $MaterialName = $detailsSql_result['MaterialName'];
                                        $MaterialSerialNumber = $detailsSql_result['MaterialSerialNumber'];
                                        echo "<tr>
                                                    <td></td>
                                                    <td>$MaterialName</td>
                                                    <td>$MaterialSerialNumber</td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>";
                                        $counter2++;
                                    }
                                    $i++;
                                }
                                echo '</tbody>
                                </table>';
                                echo '<a href="#" class="btn btn-primary" onclick="dispatchCheckedItems()">Dispatch Checked Item</a>';
                            } else {
                                echo 'No Data Found!';
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



<div class="modal fade" id="dispatchModal" tabindex="-1" role="dialog" aria-labelledby="dispatchModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="receiversForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="dispatchModalLabel">Enter OEM Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">
                            form fields
                            <input type="text" id="vendorName" value="1">

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitVendorDetails" class="btn btn-primary" id="submitOemDetails">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
    var selectedItems = []; // Variable to store selected item IDs

    function dispatchCheckedItems() {
        var materialRequestIds = document.getElementsByName('materialRequestId[]');

        for (var i = 0; i < materialRequestIds.length; i++) {
            if (materialRequestIds[i].checked) {
                selectedItems.push(materialRequestIds[i].value);
            }
        }


        if (selectedItems.length > 0) {
            $('#dispatchModal').modal('show');
        } else {
            alert('Please select at least one item to dispatch.');
        }
    }

    document.getElementById('submitVendorDetails').addEventListener('click', function() {
        var vendorName = document.getElementById('vendorName').value;

        if (selectedItems.length > 0) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        console.log(xhr.responseText);
                        $('#dispatchModal').modal('hide');
                    } else {
                        console.error('Error: ' + xhr.status);
                    }
                }
            };

            xhr.open('POST', 'process_selected_items.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('vendorName=' + encodeURIComponent(vendorName) + '&selectedItems=' + JSON.stringify(selectedItems));
        } else {
            alert('Please select at least one item to dispatch.');
        }
    });
</script>

<? include('footer.php'); ?>
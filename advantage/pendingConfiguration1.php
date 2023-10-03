<?php include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block">
                            <div class="two_end">
                                <h5>Router Configuration <span style="font-size:12px; color:red;">(add router serial number along with seal number)</span></h5>

                            </div>
                            <hr>


                            <form id="routerConfigForm" action="processPendingConfiguration.php" method="post">
                                <div class="form-group">
                                    <label>Atmid</label>
                                    <input type="text" id="atmid" class="form-control" list="atmidOptions" name="atmid">
                                    <datalist id="atmidOptions"></datalist>
                                </div>
                                <div class="form-group">
                                    <label for="serialNumber">Serial Number</label>
                                    <input type="text" class="form-control" id="serialNumber" name="serialNumber" required>
                                </div>
                                <div class="form-group">
                                    <label for="sealNumber">Seal Number</label>
                                    <input type="text" class="form-control" id="sealNumber" name="sealNumber" required>
                                </div>
                                <button type="submit" class="btn btn-primary" id="submitButton">Submit</button>
                            </form>





                            <div class="row" id="additionalInfo" style="display:none">
                                <div class="col-sm-4">
                                    <label for="networkIP">networkIP</label>
                                    <input type="text" id="networkIP" name="networkIP" class="form-control" value="<?= $networkIP; ?>" />
                                </div>

                                <div class="col-sm-4">
                                    <label for="routerIP">routerIP</label>
                                    <input type="text" id="routerIP" name="routerIP" class="form-control" value="<?= $routerIP; ?>" />
                                </div>
                                <div class="col-sm-4">
                                    <label for="atmIP">atmIP</label>
                                    <input type="text" id="atmIP" name="atmIP" class="form-control" value="<?= $atmIP; ?>" />
                                </div>


                                <div class="col-sm-4">
                                    <label class="label_label">Region</label>
                                    <input class="form-control" type="text" name="region" id="region" value="<? echo $region; ?>">
                                </div>

                                <div class="col-sm-4">
                                    <label class="label_label">City</label>
                                    <input class="form-control" type="text" name="city" id="city" value="<? echo $city; ?>" required>
                                </div>

                                <div class="col-sm-4">
                                    <label class="label_label">State</label>
                                    <select name="state" id="state" class="form-control" required>
                                        <option value="">Select State</option>
                                        <?
                                        $state_sql = mysqli_query($con, "select distinct(state) as state from sites where status=1");
                                        while ($state_sql_result = mysqli_fetch_assoc($state_sql)) { ?>
                                            <option value="<? echo $state_sql_result['state']; ?>" <? if ($state == $state_sql_result['state']) {
                                                                                                        echo 'selected';
                                                                                                    } ?>>
                                                <? echo $state_sql_result['state']; ?>
                                            </option>
                                        <? } ?>
                                    </select>

                                </div>

                                <div class="col-sm-12">
                                    <label class="label_label">Locations</label>
                                    <input class="form-control" type="text" name="location" id="location" value="<? echo $location; ?>">
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">

                            <?
                            $i = 1;
                            $sql = mysqli_query($con, "select * from routerConfiguration where status=1 order by id desc limit 40");
                            if (mysqli_num_rows($sql) > 0) {

                                echo '<table class="table table-hover table-styling table-xs" style="width:100%;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Atm id</th>
                                        <th>Serial Number</th>
                                        <th>Seal Number</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                while ($sql_result = mysqli_fetch_assoc($sql)) {

                                    $atmid = $sql_result['atmid'];
                                    $serialNumber = $sql_result['serialNumber'];
                                    $sealNumber = $sql_result['sealNumber'];
                                    $created_at = $sql_result['created_at'];

                                    $created_by = $sql_result['created_by'];
                                    $created_by = getUsername($created_by, false);


                                    echo "<tr>
                                            <td>{$i}</td>
                                            <td>{$atmid}</td>
                                            <td>{$serialNumber}</td>
                                            <td>{$sealNumber}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            
                                        </tr>";

                                    $i++;
                                }

                                echo "    </tbody>
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










<script>
    $(document).ready(function() {
        function populateATMData(atmid) {
            $.ajax({
                type: "POST",
                url: 'get_atm_data.php',
                data: 'atmid=' + atmid,
                success: function(msg) {
                    console.log(msg);

                    if (msg != 0) {
                        var obj = JSON.parse(msg);
                        var fields = ['customer', 'bank', 'engineer', 'location', 'region', 'state', 'city', 'branch', 'bm', 'lho', 'networkIP', 'routerIP', 'atmIP'];

                        fields.forEach(function(field) {
                            if (!obj[field]) {
                                $("#" + field).focus();
                            } else {
                                $("#" + field).val(obj[field]);
                                $('#' + field).attr('readonly', true);
                            }
                        });

                        if (obj.customer && obj.bank && obj.location && obj.region && obj.state && obj.city && obj.branch && obj.bm && obj.lho) {
                            $("#call_receive").focus();
                        }

                        $("#call_type").focus();
                        $("#additionalInfo").css('display', 'flex');
                    } else {
                        $("#additionalInfo").css('display', 'none');
                        Swal.fire({
                            icon: 'error',
                            title: 'No Info With This ATM',
                        }).then(function() {
                            // Reset the form
                            $("#form")[0].reset();
                        });

                    }
                }
            });

        }

        $("#atmid").on('input', function() {
            var input = $(this).val();

            $.ajax({
                type: "POST",
                url: 'get_suggestions.php',
                data: {
                    input: input
                },
                success: function(response) {
                    console.log(response)
                    var datalist = $("#atmidOptions");
                    datalist.empty();

                    var suggestions = JSON.parse(response);

                    suggestions.forEach(function(suggestion) {
                        datalist.append($("<option>").attr('value', suggestion).text(suggestion));
                    });
                }
            });
        });

        $("#atmid").on('change', function() {
            var atmid = $(this).val();
            populateATMData(atmid);
        });
    });
</script>

<?php include('footer.php'); ?>
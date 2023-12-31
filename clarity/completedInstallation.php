<? include('header.php'); ?>

<style>
    html {
        text-transform: inherit !important;
    }
</style>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <?

                    $statement = "SELECT a.*,b.LHO FROM projectInstallation a INNER JOIN sites b ON a.siteid = b.id WHERE a.isDone=1 AND a.status=1";

                    // $statement = "SELECT * FROM projectInstallation WHERE isDone=1 AND status=1 ";
                    $sqlappCount = "select COUNT(distinct atmid) AS totalCount from projectInstallation where isDone=1 and status=1 ";


                    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
                        $atmid = $_REQUEST['atmid'];
                        $statement .= " and a.atmid like '%" . trim($atmid) . "%'";
                        $sqlappCount .= " and atmid like '%" . trim($atmid) . "%'";
                    }

                    if (isset($_REQUEST['vendor']) && $_REQUEST['vendor'] != '') {
                        $vendorId = $_REQUEST['vendor'];
                        $statement .= " and a.vendor like '%" . trim($vendorId) . "%'";
                        $sqlappCount .= " and vendor like '%" . trim($vendorId) . "%'";
                    }


                    if (isset($_POST['submit'])) {
                        $_GET['page'] = 1;
                    }
                    $statement .= " group by a.atmid order by a.id desc";

                    $page_size = 10;
                    $result = mysqli_query($con, $sqlappCount);
                    $row = mysqli_fetch_assoc($result);
                    $total_records = $row['totalCount'];

                    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $offset = ($current_page - 1) * $page_size;
                    $total_pages = ceil($total_records / $page_size);
                    $window_size = 10;
                    $start_window = max(1, $current_page - floor($window_size / 2));
                    $end_window = min($start_window + $window_size - 1, $total_pages);
                    $sql_query = "$statement LIMIT $offset, $page_size";


                    // echo $sql_query;



                    ?>


                    <div class="card" id="filter">
                        <div class="card-block">
                            <form action="<? $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>ATMID</label>
                                        <input type="text" name="atmid" class="form-control" value="<?= $atmid; ?>" />
                                    </div>
                                    <div class="col-sm-4">
                                        <label>LHO</label>
                                        <select name="lho" class="form-control">
                                            <option>Select</option>
                                            <?
                                            $lhoSql = mysqli_query($con, "select distinct(LHO) as lho from sites");
                                            while ($lhoSqlResult = mysqli_fetch_assoc($lhoSql)) {
                                                $distinctLHO = $lhoSqlResult['lho'];
                                                ?>

                                                <option value="<?= $distinctLHO; ?>">
                                                    <?= $distinctLHO; ?>
                                                </option>
                                            <?

                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label> Contractor </label>
                                        <select name="vendor" class="form-control">
                                            <option>Select</option>
                                            <?
                                            $vendorSql = mysqli_query($con, "select * from vendor where status=1");
                                            while ($vendorSqlResult = mysqli_fetch_assoc($vendorSql)) {
                                                $vendor = $vendorSqlResult['vendorName'];
                                                $vendorID = $vendorSqlResult['id'];
                                                
                                                ?>

                                                <option value="<?= $vendorID; ?>">
                                                    <?= $vendor; ?>
                                                </option>
                                            <?

                                            }

                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-12">
                                        <br />
                                        <input type="submit" name="submit" class="btn btn-primary">
                                        <a class="btn btn-warning" id="hide_filter"
                                            style="color:white;margin:auto 10px;">Hide Filters</a>

                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show
                            Filters</a>
                        <div class="card-header">
                            <h5>Total Records: <strong class="record-count">
                                    <?= $total_records; ?>
                                </strong></h5>

                            <hr />
                            <form action="exportsites.php" method="POST">
                                <input type="hidden" name="exportSql" value="<?= $atm_sql; ?>">
                                <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                            </form>

                        </div>
                        <div class="card-block overflow_auto">

                            <table class="table table-hover table-styling table-xs">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>atmid</th>
                                        <th>LHO</th>
                                        <th>created_at</th>
                                        <th>created_by</th>
                                        <th>remark</th>
                                        <th>vendor</th>
                                        <th>scheduleAtmEngineerName</th>
                                        <th>scheduleAtmEngineerNumber</th>
                                        <th>bankPersonName</th>
                                        <th>bankPersonNumber</th>
                                        <th>backRoomKeyPersonName</th>
                                        <th>backRoomKeyPersonNumber</th>
                                        <th>scheduleDate</th>
                                        <th>scheduleTime</th>
                                        <th>sbiTicketId</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    <?
                                    $counter = ($current_page - 1) * $page_size + 1;
                                    $sql = mysqli_query($con, $sql_query);
                                    while ($sql_result = mysqli_fetch_assoc($sql)) {
                                        $siteid = $sql_result['siteid'];
                                        $atmid = $sql_result['atmid'];
                                        $status = $sql_result['status'];
                                        $created_at = $sql_result['created_at'];
                                        $created_by = $sql_result['created_by'];
                                        $isDone = $sql_result['isDone'];
                                        $remark = $sql_result['remark'];
                                        $vendor = $sql_result['vendor'];
                                        $portal = $sql_result['portal'];
                                        $isSentToEngineer = $sql_result['isSentToEngineer'];
                                        $scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
                                        $scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
                                        $bankPersonName = $sql_result['bankPersonName'];
                                        $bankPersonNumber = $sql_result['bankPersonNumber'];
                                        $backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
                                        $backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
                                        $scheduleDate = $sql_result['scheduleDate'];
                                        $scheduleTime = $sql_result['scheduleTime'];
                                        $sbiTicketId = $sql_result['sbiTicketId'];
                                        $lho = $sql_result['LHO'];



                                        ?>
                                        <tr>
                                            <td>
                                                <?= $counter; ?>
                                            </td>
                                            <td class="strong">
                                                <?= $atmid; ?>
                                            </td>
                                            <td>
                                                <?= $lho; ?>
                                            </td>
                                            <td>
                                                <?= $created_at; ?>
                                            </td>
                                            <td>
                                                <?= getUsername($created_by, true); ?>
                                            </td>
                                            <td>
                                                <?= $remark; ?>
                                            </td>
                                            <td>
                                                <?= getVendorName($vendor); ?>
                                            </td>
                                            <td>
                                                <?= $scheduleAtmEngineerName; ?>
                                            </td>
                                            <td>
                                                <?= $scheduleAtmEngineerNumber; ?>
                                            </td>
                                            <td>
                                                <?= $bankPersonName; ?>
                                            </td>
                                            <td>
                                                <?= $bankPersonNumber; ?>
                                            </td>
                                            <td>
                                                <?= $backRoomKeyPersonName; ?>
                                            </td>
                                            <td>
                                                <?= $backRoomKeyPersonNumber; ?>
                                            </td>
                                            <td>
                                                <?= $scheduleDate; ?>
                                            </td>
                                            <td>
                                                <?= $scheduleTime; ?>
                                            </td>
                                            <td>
                                                <?= $sbiTicketId; ?>
                                            </td>
                                            <td>
                                                <?= $address; ?>
                                            </td>



                                        </tr>

                                        <?
                                        $counter++;
                                    }

                                    ?>

                                </tbody>
                            </table>


                        </div>

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
                                    <?= $i; ?>
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


<script>
    $("#show_filter").css('display', 'none');
    $("#hide_filter").on('click', function () {
        $("#filter").css('display', 'none');
        $("#show_filter").css('display', 'block');
    });
    $("#show_filter").on('click', function () {
        $("#filter").css('display', 'block');
        $("#show_filter").css('display', 'none');
    });
</script>

<? include('footer.php'); ?>
<?php include('header.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

function get_mis_history($parameter, $type, $id)
{
    global $con;
    $sql = mysqli_query($con, "select $parameter from mis_history where type='" . $type . "' and mis_id='" . $id . "'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result[$parameter];
}

$username = $_SESSION['SERVICE_username'];

?>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<style>
    html {
        /* text-transform: inherit !important; */
    }

    td a {
        color: #01a9ac;
        text-decoration: none;
    }

    td a:focus,
    td a:hover {
        text-decoration: none;
        color: chartreuse;
    }

    a:not([href]) {
        padding: 5px;
    }

    .btn-group {
        border: 1px solid #cccccc;
    }

    ul.dropdown-menu {
        transform: translate3d(0px, 2%, 0px) !important;
        overflow: scroll !important;
        max-height: 250px;
    }

    label {
        font-weight: 900;
        font-size: 16px;
    }
</style>

<?php

$userid = $_SESSION['userid'];
$call_type = $_REQUEST['call_type'];
$call_receive = $_REQUEST['call_receive'];
$sql = mysqli_query($con, "select * from vendorUsers where id='" . $userid . "'");
$sql_result = mysqli_fetch_assoc($sql);








if (isset($_REQUEST['submit']) || isset($_GET['page'])) {

    $statement = "select a.remarks,a.id,a.bank,a.customer,a.location,a.zone,a.state,a.city,a.branch,a.created_by,a.bm,b.id,b.mis_id,b.atmid,
                b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date,b.call_type,b.case_type ,      
                (SELECT name from vendorUsers WHERE id= a.created_by) AS createdBy
                from mis a INNER JOIN mis_details b ON b.mis_id = a.id 
                where 1 and 
                b.mis_id = a.id 
                ";
    $sqlappCount = "select count(1) as total from mis a
                    INNER JOIN mis_details b ON b.mis_id = a.id 
                    where 1 and b.mis_id = a.id 
                ";


    if (isset($_REQUEST['atmid']) && $_REQUEST['atmid'] != '') {
        $statement .= " and b.atmid = '" . $_REQUEST['atmid'] . "'";
        $sqlappCount .= " and b.atmid = '" . $_REQUEST['atmid'] . "'";
    }

    if (isset($_REQUEST['call_receive_from']) && $_REQUEST['call_receive_from'] != '') {
        $statement .= " and a.call_receive_from = '" . $_REQUEST['call_receive_from'] . "'";
        $sqlappCount .= " and a.call_receive_from = '" . $_REQUEST['call_receive_from'] . "'";
    }


    if (isset($_REQUEST['fromdt']) && $_REQUEST['fromdt'] != '' && isset($_REQUEST['todt']) && $_REQUEST['todt'] != '') {

        $date1 = $_REQUEST['fromdt'];
        $date2 = $_REQUEST['todt'];

        if (isset($_REQUEST['status']) && is_array($_REQUEST['status']) && count($_REQUEST['status']) > 0) {
            if ($_REQUEST['status'][0] == 'close' && count($_REQUEST['status']) == 1) {
                $statement .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
                $sqlappCount .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
            } else {
                $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
                $sqlappCount .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
            }
        } else {
            $statement .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
            $sqlappCount .= " and CAST(b.created_at AS DATE) >= '" . $date1 . "' and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
        }
    }




    if (isset($_REQUEST['status']) && $_REQUEST['status'] != '') {

        $statusArray = $_REQUEST['status'];
        $statusValues = array_values($statusArray);
        // var_dump($statusValues);
        // Convert the values to a string in the format "('close', 'schedule', ...)"
        $statusString = "('" . implode("', '", $statusValues) . "')";

        $statement .= " and b.status in $statusString ";
        $sqlappCount .= " and b.status in $statusString ";
    } else {
        $statement .= " and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','close','MRS','fund_required','service_center')";
        $sqlappCount .= " and b.status in('open','permission_require','dispatch','material_requirement','material_in_process','schedule','material_available_i','material_dispatch','cancelled','not_available','available','close','MRS','fund_required','service_center')";
    }



    if (isset($_REQUEST['call_receive']) && $_REQUEST['call_receive'] != '') {
        $statement .= " and b.case_type = '" . $call_receive . "'";
        $sqlappCount .= " and b.case_type = '" . $call_receive . "'";
    }


    $statement .= " order by b.id desc";


    // if ($_REQUEST['atmid'] == '' && $_REQUEST['customer'] == '') {

    //     $date1 = $_REQUEST['fromdt'];
    //     $date2 = $_REQUEST['todt'];


    //     $statement = "select a.remarks,a.id AS misid,a.bank,a.customer,a.location,a.zone,a.state,a.city,a.branch,a.created_by,a.bm,b.id,b.mis_id,
    //         b.atmid,b.component,b.subcomponent,b.engineer,b.docket_no,b.status,b.created_at,b.ticket_id,b.close_date,b.call_type,b.case_type 
    //         from mis a
    //         INNER JOIN mis_details b ON b.mis_id = a.id 

    //         where 1 and

    //         b.mis_id = a.id and
    //         b.status in($status) ";












    //     $sqlappCount = "select count(1) as total from
    //                 mis a
    //                 INNER JOIN mis_details b ON b.mis_id = a.id 

    //                 where 1 and
    //                     b.mis_id = a.id and
    //                     b.status in($status) ";


    //     if ($_REQUEST['status'][0] == 'close' && count($_REQUEST['status']) == 1) {
    //         $statement .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
    //         $sqlappCount .= " and CAST(b.close_date AS DATE) >= '" . $date1 . "' and CAST(b.close_date AS DATE) <= '" . $date2 . "'";
    //     } else {
    //         $statement .= "and CAST(b.created_at AS DATE) >= '" . $date1 . "' 
    //                               and CAST(b.created_at AS DATE) <= '" . $date2 . "'";

    //         $sqlappCount .= "and CAST(b.created_at AS DATE) >= '" . $date1 . "' 
    //                       and CAST(b.created_at AS DATE) <= '" . $date2 . "'";
    //     }


    //     $statement .= " order by b.id desc";
    // }


    // echo $statement;

    $result = mysqli_query($con, $sqlappCount);
    $row = mysqli_fetch_assoc($result);
    $total_records = $row['total'];
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    $page_size = 10;

    $offset = ($current_page - 1) * $page_size;


    $total_pages = ceil($total_records / $page_size);

    $window_size = 10;

    $start_window = max(1, $current_page - floor($window_size / 2));
    $end_window = min($start_window + $window_size - 1, $total_pages);




    // Query to retrieve the records for the current page
    $sql_query = "$statement LIMIT $offset, $page_size";
}

// return ; 

?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">


                    <div class="card" id="filter">
                        <div class="card-block">
                            <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>ATMID</label>
                                        <input type="text" name="atmid" class="form-control"
                                            value="<? echo $_REQUEST['atmid']; ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>From Call Login Date</label>
                                        <input type="date" name="fromdt" class="form-control" value="<? if ($_REQUEST['fromdt']) {
                                            echo $_REQUEST['fromdt'];
                                        } else {
                                            echo '2023-01-01';
                                        } ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label>To Call Login Date</label>
                                        <input type="date" name="todt" class="form-control" value="<? if ($_REQUEST['todt']) {
                                            echo $_REQUEST['todt'];
                                        } else {
                                            echo date('Y-m-d');
                                        } ?>">
                                    </div>

                                    <div class="col-md-3">
                                        <label>Status</label>
                                        <select id="multiselect_status" class="form-control" name="status[]"
                                            multiple="multiple">
                                            <?
                                            $i = 0;
                                            $status_sql = mysqli_query($con, "select status_code,status_name from mis_status where status='1'");
                                            while ($status_sql_result = mysqli_fetch_assoc($status_sql)) {
                                                if ($status_sql_result['status_code'] == "material_pending") {
                                                    $status_sql_result['status_code'] = "MRS";
                                                }
                                                ?>
                                                <option value="<? echo $status_sql_result['status_code']; ?>" <? if (isset($_REQUEST['status'])) {

                                                       if (in_array($status_sql_result['status_code'], $_REQUEST['status'])) {
                                                           echo 'selected';
                                                       }
                                                   } else {
                                                       if ($status_sql_result['status_name'] != 'Closed') {
                                                           echo 'selected';
                                                       }
                                                   }
                                                   ?>>
                                                    <? echo $status_sql_result['status_name']; ?>
                                                </option>
                                                <?
                                                $i++;
                                            } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Call Receive From </label>
                                        <select name="call_receive_from" id="call_receive_from" class="form-control">
                                            <option value="">Select</option>
                                            <option value="Customer / Bank" <? if ($_REQUEST['call_receive_from'] == 'Customer / Bank') {
                                                echo 'selected';
                                            } ?>>Customer / Bank</option>
                                            <option value="Internal" <? if ($_REQUEST['call_receive_from'] == 'Internal') {
                                                echo 'selected';
                                            } ?>>Internal</option>
                                            <option value="Auto Email Call" <? if ($_REQUEST['call_receive_from'] == 'Auto Email Call') {
                                                echo 'selected';
                                            } ?>>Auto Email Call</option>
                                        </select>
                                    </div>




                                </div>
                                <br><br>
                                <div class="col" style="display:flex;justify-content:center;">
                                    <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                    <a class="btn btn-warning" id="hide_filter"
                                        style="color:white;margin:auto 10px;">Hide Filters</a>
                                </div>

                            </form>

                            <!--Filter End -->
                            <hr>

                        </div>
                    </div>
                    <!--Filter Start -->


                    <style>
                        .indication {
                            display: flex;
                            background: #404e67;
                        }

                        .indication span {
                            width: 15px;
                            height: 15px;
                            border: 1px solid white;
                            border-radius: 25px;
                            margin: 10px;
                        }

                        .open {
                            background: white;
                        }

                        .close {
                            background: #e29a9a;
                        }

                        .schedule {
                            background: #d09f45;
                        }

                        th.address,
                        td.address {
                            white-space: inherit;
                        }
                    </style>


                    <? if (isset($_REQUEST['submit']) || isset($_GET['page'])) { ?>

                        <div class="card">
                            <div class="card-block">

                                <h5 style="text-align:right;" id="row_count"></h5>
                                <div class="card-header">
                                    <h5>Total Records: <strong class="record-count">
                                            <?= $total_records; ?>
                                        </strong></h5>
                                    <hr>
                                    <form action="exportMis.php" method="POST">
                                        <input type="hidden" name="exportSql" value="<? echo $statement; ?>">
                                        <input type="submit" name="exportMis" class="btn btn-primary" value="Export">
                                    </form>

                                </div>


                                <div class="custom_table_content">
                                    <table class="table table-hover table-styling table-xs" style="width:100%;">
                                        <thead>
                                            <tr class="table-primary">
                                                <th>SR</th>
                                                <th>TicketId</th>
                                                <th>Customer</th>
                                                <th>Bank</th>
                                                <th>Atmid</th>
                                                <th>Atm Address</th>
                                                <th>City</th>
                                                <th>State</th>

                                                <th>Call Type</th>
                                                <th>Call Receive From</th>
                                                <th>Component</th>
                                                <th>Sub Component</th>
                                                <th>Current Status</th>


                                                <th>Call Log Date</th>
                                                <th>Call Log By</th>

                                                <th>Aging</th>
                                                <th>Remark</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $date = date('Y-m-d');
                                            $date1 = date_create($date);

                                            $i = 0;

                                            $counter = ($current_page - 1) * $page_size + 1;
                                            $sql_app = mysqli_query($con, $sql_query);

                                            while ($sql_result = mysqli_fetch_assoc($sql_app)) {
                                                $id = $sql_result['id'];
                                                $createdBy = $sql_result['createdBy'];
                                                $site_eng_contact = $sql_result['eng_name_contact'];
                                                if ($site_eng_contact == '') {
                                                    $site_engineer = "";
                                                    $site_engineer_contact = "";
                                                } else {
                                                    $site_engcontact = explode("_", $site_eng_contact);
                                                    $site_engineer = $site_engcontact[0];
                                                    $site_engineer_contact = $site_engcontact[1];
                                                }

                                                $mis_id = $sql_result['mis_id'];
                                                // echo $mis_id;
                                        
                                                $historydate = mysqli_query($con, "select created_at from mis_history where mis_id='" . $id . "' order by id desc limit 1");
                                                $created_date_result = mysqli_fetch_row($historydate);
                                                $created_date = $created_date_result[0];

                                                $customer = $sql_result['customer'];
                                                $closed_date = $sql_result['close_date'];

                                                if ($closed_date != '0000-00-00') {
                                                    $date1 = date_create($closed_date);
                                                }

                                                $date2 = $sql_result['created_at'];
                                                $cust_date2 = date('Y-m-d', strtotime($date2));

                                                $cust_date2 = date_create($cust_date2);
                                                $diff = date_diff($date1, $cust_date2);
                                                $atmid = $sql_result['atmid'];


                                                $status = $sql_result['status'];
                                                $created_by = $sql_result['created_by'];
                                                $aging_day = $diff->format("%a");

                                                $mis_his_key = 0;
                                                // echo "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM vendorUsers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc";
                                                $lastactionsql = mysqli_query($con, "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM vendorUsers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc");
                                                if ($lastactionsql_result = mysqli_fetch_assoc($lastactionsql)) {
                                                    // echo '<pre>';print_r($lastactionsql_result);echo '</pre>';die;
                                                    $his_type = $lastactionsql_result['type'];


                                                    $lastactionuserid = $lastactionsql_result['created_by'];
                                                    $status_remark = $lastactionsql_result['remark'];

                                                    if ($mis_his_key == 0) {
                                                        $last_action_by = $lastactionsql_result['last_action_by'];
                                                    }
                                                    $mis_his_key = $mis_his_key + 1;
                                                    $schedule_date = "";
                                                    if ($his_type == 'schedule') {
                                                        $schedule_date = $lastactionsql_result['schedule_date'];
                                                    }


                                                    $material = "";
                                                    $material_req_remark = "";
                                                    if ($his_type == 'material_requirement') {
                                                        $material = $lastactionsql_result['material'];
                                                        $material_req_remark = $lastactionsql_result['remark'];
                                                        $material_condition = $lastactionsql_result['material_condition'];
                                                    }
                                                    $courier_agency = "";
                                                    $pod = "";
                                                    $serial_number = "";
                                                    $dispatch_date = "";
                                                    $material_dispatch_remark = "";
                                                    // if($his_type=='material_dispatch'){
                                                    $courier_agency = $lastactionsql_result['courier_agency'];
                                                    $pod = $lastactionsql_result['pod'];
                                                    $serial_number = $lastactionsql_result['serial_number'];
                                                    $dispatch_date = $lastactionsql_result['dispatch_date'];
                                                    $material_dispatch_remark = $lastactionsql_result['remark'];
                                                    // }
                                                    $close_type = "";
                                                    $close_remark = "";
                                                    $close_created_at = "";
                                                    $attachment = "";
                                                    if ($his_type == 'close') {
                                                        $close_type = $lastactionsql_result['close_type'];
                                                        $close_remark = $lastactionsql_result['remark'];
                                                        $close_created_at = $lastactionsql_result['created_at'];
                                                        $attachment = $lastactionsql_result['attachment'];
                                                    }
                                                }
                                                ?>
                                                <tr <? if ($aging_day > 3 && $status != 'close') { ?>
                                                        style="background:#fe5d70c2;color:white;" <? }
                                                if ($status == 'close') { ?> style="background:#0ac282;color:white;" <? } elseif ($status == 'schedule') { ?> style="background:#6c757d;color:white;" <? } elseif ($status == 'open') { ?> style="background:white;color:black;" <? } ?>>
                                                    <!--<td><? echo ++$i; ?></td>-->
                                                    <!-- <th><a href="delete_mis.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white"  <? } ?>>Delete</a></th>-->

                                                    <td>
                                                        <? echo $counter; ?>
                                                    </td>
                                                    <td style=" background:white;    border: 1px solid black; ">
                                                        <a style=" text-decoration: none; font-weight: 700;" target="_blank"
                                                            href="mis_details.php?id=<? echo $id; ?>" <? if ($aging_day > 3 && $status != 'close') { ?> style="color:white" <? } ?>>
                                                            <? echo $sql_result['ticket_id']; ?>
                                                        </a>
                                                    </td>

                                                    <td>
                                                        <? echo $customer; ?>
                                                    </td>

                                                    <td>
                                                        <? echo $sql_result['bank']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $atmid; ?>
                                                    </td>

                                                    <td>
                                                        <? echo $sql_result['location']; ?>

                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['city']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['state']; ?>
                                                    </td>



                                                    <td>
                                                        <? echo $sql_result['call_type']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['case_type']; ?>
                                                    </td>


                                                    <td>
                                                        <? echo $sql_result['component']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['subcomponent']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $status; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['created_at']; ?>
                                                    </td>
                                                    <td>
                                                        <? echo $createdBy; ?>
                                                    </td>

                                                    <td>
                                                        <? echo $diff->format("%a days"); ?>
                                                    </td>
                                                    <td>
                                                        <? echo $sql_result['remarks']; ?>
                                                    </td>

                                                </tr>


                                                <? $counter++;
                                            } ?>

                                        </tbody>
                                    </table>






                                </div>




                                <?





                                $customer = $_REQUEST['customer'];
                                $customer = http_build_query(array('customer' => $customer));

                                // $status = $_REQUEST['status'];
                                // $status = http_build_query(array('status' => $status));
                            

                                // $status = $_REQUEST['status'];
                                // $statusQuery = '';
                                // foreach ($status as $key => $value) {
                                //     $statusQuery .= "status%5B{$key}%5D={$value}&";
                                // }
                                // $statusQuery = rtrim($statusQuery, '&');
                            
                                $status = $_REQUEST['status'];
                                $statusQuery = http_build_query(array('status' => $status), '', '&', PHP_QUERY_RFC3986);


                                $call_receive_from = $_REQUEST['call_receive_from'];
                                $atmid = $_REQUEST['atmid'];
                                $fromdt = $_REQUEST['fromdt'];
                                $todt = $_REQUEST['todt'];




                                echo '<div class="pagination"><ul>';
                                if ($start_window > 1) {

                                    echo "<li><a href='?page=1&&atmid=$atmid&&$customer&&fromdt=$fromdt&&todt=$todt&&call_type=$call_type&&$statusQuery&&call_receive_from=$call_receive_from'>First</a></li>";
                                    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&' . $statusQuery . '&&call_receive_from=' . $call_receive_from . '">Prev</a></li>';
                                }

                                for ($i = $start_window; $i <= $end_window; $i++) {
                                    ?>
                                    <li class="<? if ($i == $current_page) {
                                        echo 'active';
                                    } ?>">
                                        <a
                                            href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&<? echo $customer; ?>&&fromdt=<? echo $fromdt; ?>&&todt=<? echo $todt; ?>&&call_type=<? echo $call_type; ?>&&<? echo $statusQuery; ?>&&call_receive_from=<?= $call_receive_from; ?>">
                                            <? echo $i; ?>
                                        </a>
                                    </li>

                                <? }

                                if ($end_window < $total_pages) {

                                    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&&' . $statusQuery . '&&call_receive_from=' . $call_receive_from . '">Next</a></li>';
                                    echo '<li><a href="?page=' . $total_pages . '&&atmid=' . $atmid . '&&' . $customer . '&&fromdt=' . $fromdt . '&&todt=' . $todt . '&&call_type=' . $call_type . '&&' . $statusQuery . '&&call_receive_from=' . $call_receive_from . '">Last</a></li>';

                                }
                                echo '</ul></div>';


                                ?>





                                <style>
                                    .pagination {
                                        display: flex;
                                        margin: 10px 0;
                                        padding: 0;
                                        justify-content: center;
                                    }

                                    .pagination li {
                                        display: inline-block;
                                        margin: 0 5px;
                                        padding: 5px 10px;
                                        border: 1px solid #ccc;
                                        background-color: #fff;
                                        color: #555;
                                        text-decoration: none;
                                    }

                                    .pagination li.active {
                                        border: 1px solid #007bff;
                                        background-color: #007bff;
                                        color: #fff;
                                    }

                                    .pagination li:hover:not(.active) {
                                        background-color: #f5f5f5;
                                        border-color: #007bff;
                                        color: #007bff;
                                    }
                                </style>




                            </div>
                        </div>

                    <? } ?>

                    <script>
                        $('.update_remark').on('submit', function (e) {
                            e.preventDefault();
                            var remark = $(this).find("[name='update_remark']").val();
                            var misid = $(this).find("[name='misid']").val();
                            $.ajax({
                                type: 'post',
                                url: 'updatemisremark.php',
                                data: 'remark=' + remark + '&&misid=' + misid,
                                success: function (msg) {
                                    if (msg == 1) {
                                        swal('Updated !');
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 3000);


                                    } else if (msg == 0) {
                                        swal('Error in updated !');
                                    } else if (msg == 2) {
                                        swal('Remark should not be empty !');
                                    }
                                }
                            });


                        });
                    </script>








                </div>
            </div>


        </div>
    </div>
</div>


<? include('footer.php'); ?>

<script>
    $(document).ready(function () {

        $('#multiselect_status').multiselect({
            buttonWidth: '100%',
            includeSelectAllOption: true,
            nonSelectedText: 'Select an Option'
        });




    });


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js">
</script>
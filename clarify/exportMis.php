<? include('config.php');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);



if (!function_exists('endsWith')) {
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return $length === 0 ||
            (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('clean')) {
    function clean($string)
    {
        $string = str_replace('-', ' ', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
    }

}
if (!function_exists('remove_special')) {

    function remove_special($site_remark2)
    {
        $site_remark2_arr = explode(" ", $site_remark2);

        foreach ($site_remark2_arr as $k => $v) {
            $a[] = preg_split('/\n/', $v);
        }

        $site_remark = '';
        foreach ($a as $key => $value) {
            foreach ($value as $ke => $va) {
                $site_remark .= $va . " ";
            }

        }

        return clean($site_remark);

    }

}







$sql_query = $_REQUEST['exportSql'];
$sql_app = mysqli_query($con, $sql_query);
$date = date('Y-m-d');
$date1 = date_create($date);

$contents = "";
$contents .= "SR \t TicketId \t Customer \t Bank \t Atmid \t Atm Address \t City \t State \t Branch \t Call Type \t Call Receive From \t Component \t Sub Component \t Current Status \t Status Remarks \t Schedule Date \t Material Condition \t Material \t Material Remark \t Courier Agency (Material Dispatch) \t POD (Material Dispatch) \t Serial Number \t Material dispatch date  \t  Material Dispatch Remark \t  DOCKET NO \t  REQUEST FOOTAGE DATE \t  Time From \t  Time To \t Close Type \t Close Remark \t Last Action By \t Last Action Date \t Call Log Date \t Call Log By \t BM \t Aging \t Remark \t Engineer Name \t Engineer Contact Number \t Dependency \t Closure Time \t Downtime";

$counter = 1;
$start = microtime(true);
while ($sql_result = mysqli_fetch_assoc($sql_app)) {

    $iterationStart = microtime(true);

    $id = $sql_result['id'];




    $customer = $sql_result['customer'];
    $ticket_id = $sql_result['ticket_id'];
    $createdBy = $sql_result['createdBy'];
    $mis_id = $sql_result['mis_id'];
    $closed_date = $sql_result['close_date'];
    $date2 = $sql_result['created_at'];
    $bank = $sql_result['bank'];
    $atmid = $sql_result['atmid'];
    $bm_name = $sql_result['bm'];
    $status = $sql_result['status'];
    $created_by = $sql_result['created_by'];
    $site_eng_contact = $sql_result['eng_name_contact'];
    $city = $sql_result['city'];
    $state = $sql_result['state'];
    $branch = $sql_result['branch'];
    $call_type = $sql_result['call_type'];
    $case_type = $sql_result['case_type'];
    $component = $sql_result['component'];
    $subcomponent = $sql_result['subcomponent'];
    $material_condition = $sql_result['material_condition'];
    $material = $sql_result['material'];
    $material_req_remark = $sql_result['material_req_remark'];
    $dispatch_date = $sql_result['dispatch_date'];
    $material_dispatch_remark = $sql_result['material_dispatch_remark'];
    $docket_no = $sql_result['docket_no'];
    $footage_date = $sql_result['footage_date'];
    $fromtime = $sql_result['fromtime'];
    $totime = $sql_result['totime'];
    $close_type = "";
    $created_date = $sql_result['created_date'];
    $created_at = $sql_result['created_at'];
    $remarks = $sql_result['remarks'];
    $site_engineer = $sql_result['eng_name'];
    $site_engineer_contact = $sql_result['eng_contact'];
    $pod = $sql_result['pod'];
    $courier_agency = $sql_result['courier_agency'];
    $serial_number = $sql_result['serial_number'];


    if ($closed_date != '0000-00-00') {
        $date1 = date_create($closed_date);
    }


    $cust_date2 = date('Y-m-d', strtotime($date2));

    $cust_date2 = date_create($cust_date2);
    $diff = date_diff($date1, $cust_date2);

    $aging_day = $diff->format("%a");




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

    $bm_name = $sql_result['bm'];

    $status = $sql_result['status'];
    $created_by = $sql_result['created_by'];
    $aging_day = $diff->format("%a");

    $mis_his_key = 0;


    $lastactionsql = mysqli_query($con, "select type,created_by,remark,schedule_date,material,material_condition,courier_agency,pod,serial_number,dispatch_date,(SELECT name FROM mis_loginusers WHERE id=mis_history.created_by) AS last_action_by from mis_history where mis_id='" . $id . "' order by id desc");
    if ($lastactionsql_result = mysqli_fetch_assoc($lastactionsql)) {

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

    $dependency = ''; // Initialize the $dependency variable
    $type = array();
    $timeDifference = '';
    $dependencySql = mysqli_query($con, "SELECT * FROM mis_history WHERE mis_id='" . $id . "'");
    while ($dependencySqlResult = mysqli_fetch_assoc($dependencySql)) {

        $closeType = $dependencySqlResult['type'];
        if ($closeType == 'close') {
            $closureTime = $dependencySqlResult['created_at'];

            $closureTime = new DateTime($closureTime);

            $date2 = new DateTime($sql_result['created_at']);
            $difference = $closureTime->diff($date2);

            $timeDifference = "";
            $timeDifference .= $difference->d > 0 ? $difference->d . " days " : "";
            $timeDifference .= $difference->h > 0 ? $difference->h . " hours " : "";
            $timeDifference .= $difference->i > 0 ? $difference->i . " minutes " : "";
            $timeDifference .= $difference->s > 0 ? $difference->s . " seconds" : "";

        }

        $type[] = $dependencySqlResult['type'];
    }
    
      $dependencySql2 = mysqli_query($con, "SELECT * FROM mis_history WHERE mis_id='" . $id . "' order by id desc");
        if($dependencySqlResult2 = mysqli_fetch_assoc($dependencySql2)){
                $closureTime2 = $dependencySqlResult2['created_at'];  
                $closureTime2 = new DateTime($closureTime2);
    
                $date22 = new DateTime($sql_result['created_at']);
                $difference2 = $closureTime2->diff($date22);
                
                $timeDifference2 = "";
                $timeDifference2 .= $difference2->d > 0 ? $difference2->d . " days " : "";
                $timeDifference2 .= $difference2->h > 0 ? $difference2->h . " hours " : "";
                $timeDifference2 .= $difference2->i > 0 ? $difference2->i . " minutes " : "";
                $timeDifference2 .= $difference2->s > 0 ? $difference2->s . " seconds" : "";
                
        }
        

    if (count($type) > 0) {
        if (in_array('reassign', $type)) {
            $dependency = 'bank';
        } else {
            $dependency = 'advantage';
        }
    } else {
        $dependency = 'advantage';
    }


    $contents .= "\n" . $counter . "\t";
    $contents .= $ticket_id . "\t";
    $contents .= $customer . "\t";
    $contents .= $bank . "\t";
    $contents .= $atmid . "\t";
    $contents .= remove_special($sql_result['location']) . "\t";

    $contents .= $city . "\t";
    $contents .= $state . "\t";
    $contents .= $branch . "\t";

    $contents .= $call_type . "\t";
    $contents .= $case_type . "\t";

    $contents .= $component . "\t";
    $contents .= $subcomponent . "\t";


    $contents .= $status . "\t";
    $contents .= remove_special($status_remark) . "\t";
    $contents .= $schedule_date . "\t";
    $contents .= $material_condition . "\t";
    $contents .= $material . "\t";
    $contents .= remove_special($material_req_remark) . "\t";
    $contents .= remove_special(trim($courier_agency)) . "\t";
    $contents .= remove_special($pod) . "\t";
    $contents .= remove_special($serial_number) . "\t";
    $contents .= $dispatch_date . "\t";
    $contents .= remove_special($material_dispatch_remark) . "\t";


    $contents .= remove_special($docket_no) . "\t";
    $contents .= $footage_date . "\t";
    $contents .= $fromtime . "\t";
    $contents .= $totime . "\t";

    $contents .= $close_type . "\t";
    $contents .= remove_special($close_remark) . "\t";
    $contents .= $last_action_by . "\t";

    $contents .= $created_date . "\t";
    $contents .= $created_at . "\t";
    $contents .= $createdBy . "\t";
    $contents .= remove_special($bm_name) . "\t";
    $contents .= remove_special($diff->format("%a days")) . "\t";
    $contents .= (remove_special($remarks) ? remove_special($remarks) : 'NA') . "\t";
    $contents .= (trim($site_engineer) ? trim($site_engineer) : 'NA') . "\t";
    $contents .= (trim($site_engineer_contact) ? trim($site_engineer_contact) : 'NA') . "\t";
    $contents .= ($dependency ? trim($dependency) : 'NA') . "\t";
    $contents .= (trim($timeDifference) ? trim($timeDifference) : 'NA') . "\t";
    $contents .= (trim($timeDifference2) ? trim($timeDifference2) : 'NA') . "\t";
    
    $counter++;
}

$contents = strip_tags($contents);
header("Content-Disposition: attachment; filename=mis.xls");
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
print $contents;
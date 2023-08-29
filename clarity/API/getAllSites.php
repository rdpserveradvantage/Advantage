<? include('config.php');


$sqlappCount = "SELECT COUNT(1) AS total FROM sites WHERE 1";
$atm_sql = "SELECT id, activity, customer, bank, atmid, atmid2, atmid3, address, city, state, zone, LHO, LHO_Contact_Person, LHO_Contact_Person_No, LHO_Contact_Person_email, LHO_Adv_Person, LHO_Adv_Contact, LHO_Adv_email, Project_Coordinator_Name, Project_Coordinator_No, Project_Coordinator_email, Customer_SLA, Our_SLA, Vendor, Cash_Management, CRA_VENDOR, ID_on_Make, Model, SiteType, PopulationGroup, XPNET_RemoteAddress, CONNECTIVITY, Connectivity_Type, Site_data_Received_for_Feasiblity_date FROM sites WHERE 1";

if (isset($_POST['atmid']) && $_POST['atmid'] !== '') {
    $atmid = $_POST['atmid'];
    $atm_sql .= " AND atmid LIKE '%" . $atmid . "%'";
    $sqlappCount .= " AND atmid LIKE '%" . $atmid . "%'";
}

if (isset($_POST['cust']) && $_POST['cust'] !== '') {
    $atm_sql .= " AND customer LIKE '%" . $_POST['cust'] . "%'";
    $sqlappCount .= " AND customer LIKE '%" . $_POST['cust'] . "%'";
}

if (isset($_POST['zone']) && $_POST['zone'] !== '') {
    $atm_sql .= " AND zone = '" . $_POST['zone'] . "'";
    $sqlappCount .= " AND zone = '" . $_POST['zone'] . "'";
}

if (isset($_POST['state']) && $_POST['state'] !== '') {
    $atm_sql .= " AND state = '" . $_POST['state'] . "'";
    $sqlappCount .= " AND state = '" . $_POST['state'] . "'";
}

$atm_sql .= " AND status = 1";
$sqlappCount .= " AND status = 1";

$result = mysqli_query($con, $sqlappCount);
$row = mysqli_fetch_assoc($result);
$total_records = $row['total'];

$current_page = isset($_POST['page']) ? $_POST['page'] : 1;
$page_size = 10;
$offset = ($current_page - 1) * $page_size;
$total_pages = ceil($total_records / $page_size);
$window_size = 10;
$start_window = max(1, $current_page - floor($window_size / 2));
$end_window = min($start_window + $window_size - 1, $total_pages);
$limit = $page_size;

// Adjust the limit if there are fewer records than the requested page size
if ($total_records < $offset + $limit) {
    $limit = $total_records - $offset;
    if ($limit < 0) {
        $limit = 0;
    }
}

$offset = ($current_page - 1) * $page_size;
$limit = $page_size;

$sql_query = "$atm_sql LIMIT $offset, $limit";

$counter = ($current_page - 1) * $page_size + 1;
$atm_sql_res = mysqli_query($con, $sql_query);

$response = [];




        while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
            
            $id = $atm_sql_result['id'];
            $activity= $atm_sql_result['activity'];
            $customer= $atm_sql_result['customer'];
            $bank= $atm_sql_result['bank'];
            $atmid= $atm_sql_result['atmid'];
            $atmid2= $atm_sql_result['atmid2'];
            $atmid3= $atm_sql_result['atmid3'];
            $address= $atm_sql_result['address'];
            $city= $atm_sql_result['city'];
            $state= $atm_sql_result['state'];
            $zone= $atm_sql_result['zone'];
            $LHO= $atm_sql_result['LHO'];
            $LHO_Contact_Person= $atm_sql_result['LHO_Contact_Person'];
            $LHO_Contact_Person_No= $atm_sql_result['LHO_Contact_Person_No'];
            $LHO_Contact_Person_email= $atm_sql_result['LHO_Contact_Person_email'];
            $LHO_Adv_Person= $atm_sql_result['LHO_Adv_Person'];
            $LHO_Adv_Contact= $atm_sql_result['LHO_Adv_Contact'];
            $LHO_Adv_email= $atm_sql_result['LHO_Adv_email'];
            $Project_Coordinator_Name= $atm_sql_result['Project_Coordinator_Name'];
            $Project_Coordinator_No= $atm_sql_result['Project_Coordinator_No'];
            $Project_Coordinator_email= $atm_sql_result['Project_Coordinator_email'];
            $Customer_SLA= $atm_sql_result['Customer_SLA'];
            $Our_SLA= $atm_sql_result['Our_SLA'];
            $Vendor= $atm_sql_result['Vendor'];
            $Cash_Management= $atm_sql_result['Cash_Management'];
            $CRA_VENDOR= $atm_sql_result['CRA_VENDOR'];
            $ID_on_Make= $atm_sql_result['ID_on_Make'];
            $Model= $atm_sql_result['Model'];
            $SiteType= $atm_sql_result['SiteType'];
            $PopulationGroup= $atm_sql_result['PopulationGroup'];
            $XPNET_RemoteAddress= $atm_sql_result['XPNET_RemoteAddress'];
            $CONNECTIVITY= $atm_sql_result['CONNECTIVITY'];
            $Connectivity_Type= $atm_sql_result['Connectivity_Type'];
            $Site_data_Received_for_Feasiblity_date = $atm_sql_result['Site_data_Received_for_Feasiblity_date'];
            
            $response[] = ['srno'=>$counter,'id'=>$id,'activity'=>$activity,'customer'=>$customer,'bank'=>$bank,'atmid'=>$atmid,'atmid2'=>$atmid2,'atmid3'=>$atmid3,
            'address'=>$address,'city'=>$city,'state'=>$state,'zone'=>$zone,'LHO'=>$LHO,'LHO_Contact_Person'=>$LHO_Contact_Person,
            'LHO_Contact_Person_No'=>$LHO_Contact_Person_No,'LHO_Contact_Person_email'=>$LHO_Contact_Person_email,'LHO_Adv_Person'=>$LHO_Adv_Person,
            'LHO_Adv_Contact'=>$LHO_Adv_Contact,'LHO_Adv_email'=>$LHO_Adv_email,'Project_Coordinator_Name'=>$Project_Coordinator_Name,
            'Project_Coordinator_No'=>$Project_Coordinator_No,'Project_Coordinator_email'=>$Project_Coordinator_email,'Customer_SLA'=>$Customer_SLA,
            'Our_SLA'=>$Our_SLA,'Vendor'=>$Vendor,'Cash_Management'=>$Cash_Management,'CRA_VENDOR'=>$CRA_VENDOR,'ID_on_Make'=>$ID_on_Make,'Model'=>$Model,
            'SiteType'=>$SiteType,'PopulationGroup'=>$PopulationGroup,'XPNET_RemoteAddress'=>$XPNET_RemoteAddress,'CONNECTIVITY'=>$CONNECTIVITY,
            'Connectivity_Type'=>$Connectivity_Type,'Site_data_Received_for_Feasiblity_date'=>$Site_data_Received_for_Feasiblity_date];

            $counter++;
            
        }

$data = ['total_records'=>$total_records,'response'=>$response];

echo json_encode($data);














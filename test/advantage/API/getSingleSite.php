<? include('config.php');


$siteid = $_REQUEST['siteid'];
if(isset($siteid) && !empty($siteid)){
    
$atm_sql = "SELECT id, activity, customer, bank, atmid, atmid2, atmid3, address, city, state, zone, LHO, LHO_Contact_Person, LHO_Contact_Person_No, 
LHO_Contact_Person_email, LHO_Adv_Person, LHO_Adv_Contact, LHO_Adv_email, Project_Coordinator_Name, Project_Coordinator_No, Project_Coordinator_email,
Customer_SLA, Our_SLA, Vendor, Cash_Management, CRA_VENDOR, ID_on_Make, Model, SiteType, PopulationGroup, XPNET_RemoteAddress, CONNECTIVITY, Connectivity_Type,
Site_data_Received_for_Feasiblity_date FROM sites WHERE id='".$siteid."' and status=1";

    $response = [];
    $atm_sql_res = mysqli_query($con,$atm_sql); 
    if($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){            
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
            
            $response = ['id'=>$id,'activity'=>$activity,'customer'=>$customer,'bank'=>$bank,'ATMID1'=>$atmid,'ATMID2'=>$atmid2,'ATMID3'=>$atmid3,
            'address'=>$address,'city'=>$city,'state'=>$state,'zone'=>$zone,'LHO'=>$LHO,'LHO_Contact_Person'=>$LHO_Contact_Person,
            'LHO_Contact_Person_No'=>$LHO_Contact_Person_No,'LHO_Contact_Person_email'=>$LHO_Contact_Person_email,'LHO_Adv_Person'=>$LHO_Adv_Person,
            'LHO_Adv_Contact'=>$LHO_Adv_Contact,'LHO_Adv_email'=>$LHO_Adv_email,'Project_Coordinator_Name'=>$Project_Coordinator_Name,
            'Project_Coordinator_No'=>$Project_Coordinator_No,'Project_Coordinator_email'=>$Project_Coordinator_email,'Customer_SLA'=>$Customer_SLA,
            'Our_SLA'=>$Our_SLA,'Vendor'=>$Vendor,'Cash_Management'=>$Cash_Management,'CRA_VENDOR'=>$CRA_VENDOR,'ID_on_Make'=>$ID_on_Make,'Model'=>$Model,
            'SiteType'=>$SiteType,'PopulationGroup'=>$PopulationGroup,'XPNET_RemoteAddress'=>$XPNET_RemoteAddress,'CONNECTIVITY'=>$CONNECTIVITY,
            'Connectivity_Type'=>$Connectivity_Type,'Site_data_Received_for_Feasiblity_date'=>$Site_data_Received_for_Feasiblity_date];

            
        }

    $data = ['statusCode'=>200,'response'=>$response];
    echo json_encode($data);
}else{
    $data = ['statusCode'=>500,'response'=>'Not Found'];
    echo json_encode($data);
}













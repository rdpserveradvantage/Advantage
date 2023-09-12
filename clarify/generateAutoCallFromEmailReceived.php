<? include('config.php');


$atmid = $_REQUEST['atmID'];
$siteAddress = $_REQUEST['siteAddress'];
$city = $_REQUEST['city'];
$circle = $_REQUEST['circle'];
$linkVendor = $_REQUEST['linkVendor'];
$atmIP = $_REQUEST['atmIP'];




if($atmid){
        $sql = mysqli_query($con,"select * from sites where atmid='".trim($atmid)."'");
        
        if($sql_result = mysqli_fetch_assoc($sql)){

            $customer = strtoupper($sql_result['customer']);
            $bank = $sql_result['bank'];
            $location = $sql_result['address'];
            $state = $sql_result['state'];
            $region = $sql_result['zone'];    
            $bm = $sql_result['bm_name'];
            $branch = $sql_result['branch'];
            $city = $sql_result['city'];
            $eng_user_id = $sql_result['engineer_user_id'];
            $lho = $sql_result['LHO'];
            $engname =mysqli_query($con,"select name from mis_loginusers where id = '".$eng_user_id."' ");
            $engname_result = mysqli_fetch_assoc($engname);
            $_engname = $engname_result['name'];
            
        

            $comp = 'Offline';
            $subcomp = 'Router Offline';

        }
}





?>
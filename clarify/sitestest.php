<?php include('header.php');

function get_misstate($id){
    global $con;
    $sql = mysqli_query($con,"select * from sites where id='".$id."'");
    $sql_result = mysqli_fetch_assoc($sql);
    return $sql_result['state'];
}
?>

<link rel="stylesheet" type="text/css" href="datatable/dataTables.bootstrap.css">
 <style>
    .select2-container .select2-selection--single{height: auto !important; }
    .select2-selection__choice {background-color:cyan; }
}
 </style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">
                                                 
                                                <div class="col-md-3">
                                                    <label>ATMID</label>
                                                    <input type="text" class="form-control" name="atmid" value="<? echo $_POST['atmid']; ?>" />
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Customer</label>
                                                    <select name="cust" class="form-control mdb-select md-form" searchable="Search here..">

                                                        <option value="">-- Select Customer --</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $custlist= mysqli_query($con,"SELECT id,customer from sites where customer!='' group by customer ");
    											        while($fetch_data = mysqli_fetch_assoc($custlist)){
    											     ?>
											        <option value="<?php echo $fetch_data['customer'] ?>" <?php if($_POST['cust']== $fetch_data['customer']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['customer'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                
                                                <div class="col-md-3">
                                                    <label>State</label>
                                                    <select name="state" class="form-control" >
                                                        <option value="">-- Select State--</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $statelist= mysqli_query($con,"SELECT id,state from sites where state!='' group by state ");
    											        while($fetch_data = mysqli_fetch_assoc($statelist)){
    											     ?>
											        <option value="<?php echo $fetch_data['state'] ?>" <?php if($_POST['state'] == $fetch_data['state']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['state'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Zone</label>
                                                    <select name="zone" class="form-control mdb-select md-form" searchable="Search here..">
                                                        <option value=""  selected>-- Select Zone --</option>
                                                        <?php 
                                                        $i = 0;
                                                        $zonelist= mysqli_query($con,"SELECT id,zone from sites where zone!='' and zone!='select' group by zone ");
    											        while($fetch_data = mysqli_fetch_assoc($zonelist)){
    											     ?>
											        <option value="<?php echo $fetch_data['zone'] ?>" <?php if($_POST['zone'] == $fetch_data['zone']) { echo 'selected'; }  ?>>
											         <?php echo $fetch_data['zone'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                

                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>
                                    
                                    <!--Filter End -->
                                    <hr>
                                          
                                      </div>
                                    </div>


                        <?php
                            if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
                            $sqlappCount = "select count(1) as total from sites where 1 " ;
                            $atm_sql = "select id,activity,customer,bank,atmid,atmid2,atmid3,address,city,state,zone,LHO,LHO_Contact_Person,LHO_Contact_Person_No,
                                LHO_Contact_Person_email,LHO_Adv_Person,LHO_Adv_Contact,LHO_Adv_email,Project_Coordinator_Name,Project_Coordinator_No,
                                Project_Coordinator_email,Customer_SLA,Our_SLA,Vendor,Cash_Management,CRA_VENDOR,ID_on_Make,Model,SiteType,PopulationGroup,
                                XPNET_RemoteAddress,CONNECTIVITY,Connectivity_Type,Site_data_Received_for_Feasiblity_date,isDelegated,created_at,created_by from sites where 1 ";
                                
                            if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                                $atmid = $_POST['atmid'];
                                $atm_sql .= "and atmid like '%".$atmid."%'" ;
                                $sqlappCount .= "and atmid like '%".$atmid."%'" ;
                            }
                            
                            if(isset($_POST['cust']) && $_POST['cust']!=''){
                                $atm_sql .=  "and customer like '%".$_POST['cust']."%' ";
                                $sqlappCount .= "and customer like '%".$_POST['cust']."%' ";
                            }
                               
                            if(isset($_POST['zone']) && $_POST['zone']!=''){
                                $atm_sql .=  "and zone = '".$_POST['zone']."' ";
                                $sqlappCount .= "and zone = '".$_POST['zone']."' ";
                            }
                            
                            if(isset($_POST['state']) && $_POST['state']!=''){
                                $atm_sql .=  "and state= '".$_POST['state']."' ";
                                $sqlappCount .=  "and state= '".$_POST['state']."' ";
                            }
                            
                        function getBranchName($id){
                            global $con ;
                            $sql = mysqli_query($con,"select * from mis_city where id='".$id."'");
                            $sql_result = mysqli_fetch_assoc($sql);
                            return $sql_result['city'];
                        }
                        
                        
                
                        $atm_sql .=  "and status=1";
                        $sqlappCount .=  "and status=1";
                        
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
                        $sql_query = "$atm_sql LIMIT $offset, $page_size";
                            }
                            
                               
                               ?>
                                <div class="card">
                                    <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table table-hover table-styling" style="width:100%;">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <td>atmid </td>
                                                    <td>activity </td>
                                                    <td>customer </td>
                                                    <td>bank </td>
                                                    
                                                    <td>address </td>
                                                    <td>city </td>
                                                    <td>state </td>
                                                    <td>zone </td>
                                                    <td>LHO </td>
                                                    <td>LHO Contact Person </td>
                                                    <td>LHO Contact Person No. </td>
                                                    <td>LHO Contact Person email </td>
                                                    <td>LHO Adv Person </td>
                                                    <td>LHO Adv Contact </td>
                                                    <td>LHO Adv email </td>
                                                    <td>Project Coordinator Name </td>
                                                    <td>Project Coordinator No. </td>
                                                    <td>Project Coordinator email </td>
                                                    <td>Customer SLA </td>
                                                    <td>Our SLA </td>
                                                    <td>Vendor </td>
                                                    <td>Cash Management </td>
                                                    <td>CRA VENDOR </td>
                                                    <td>ID on Make </td>
                                                    <td>Model </td>
                                                    <td>SiteType </td>
                                                    <td>PopulationGroup </td>
                                                    <td>XPNET_RemoteAddress </td>
                                                    <td>CONNECTIVITY </td>
                                                    <td>Connectivity Type </td>
                                                    <td>Site data Received for Feasiblity date </td>
                                                    <th>Created At</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                
                                                $counter = ($current_page - 1) * $page_size + 1;
                                                $atm_sql_res = mysqli_query($con,$sql_query);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
                                                        
                                                        $id = $atm_sql_result['id'];
                                                        $activity= $atm_sql_result['activity'];
                                                        $customer= $atm_sql_result['customer'];
                                                        $bank= $atm_sql_result['bank'];
                                                        $atmid= $atm_sql_result['atmid'];
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
                                                        $isDelegated = $atm_sql_result['isDelegated'];
                                                        $created_at = $atm_sql_result['created_at'];
                                                        $created_by = $atm_sql_result['created_by'];
                                                        $created_by = getUsername($created_by,false);

                                                    ?>
                                                
                                                 <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td class="strong"> <? echo $atmid ; ?> </td>
                                                    <td> <? echo $activity ; ?> </td>
                                                    <td> <? echo $customer ; ?> </td>
                                                    <td> <? echo $bank ; ?> </td>
                                                    
                                                    <td> <? echo $address ; ?> </td>
                                                    <td> <? echo $city ; ?> </td>
                                                    <td> <? echo $state ; ?> </td>
                                                    <td> <? echo $zone ; ?> </td>
                                                    <td> <? echo $LHO ; ?> </td>
                                                    <td> <? echo $LHO_Contact_Person ; ?> </td>
                                                    <td> <? echo $LHO_Contact_Person_No ; ?> </td>
                                                    <td> <? echo $LHO_Contact_Person_email ; ?> </td>
                                                    <td> <? echo $LHO_Adv_Person ; ?> </td>
                                                    <td> <? echo $LHO_Adv_Contact ; ?> </td>
                                                    <td> <? echo $LHO_Adv_email ; ?> </td>
                                                    <td> <? echo $Project_Coordinator_Name ; ?> </td>
                                                    <td> <? echo $Project_Coordinator_No ; ?> </td>
                                                    <td> <? echo $Project_Coordinator_email ; ?> </td>
                                                    <td> <? echo $Customer_SLA ; ?> </td>
                                                    <td> <? echo $Our_SLA ; ?> </td>
                                                    <td> <? echo $Vendor ; ?> </td>
                                                    <td> <? echo $Cash_Management ; ?> </td>
                                                    <td> <? echo $CRA_VENDOR ; ?> </td>
                                                    <td> <? echo $ID_on_Make ; ?> </td>
                                                    <td> <? echo $Model ; ?> </td>
                                                    <td> <? echo $SiteType ; ?> </td>
                                                    <td> <? echo $PopulationGroup ; ?> </td>
                                                    <td> <? echo $XPNET_RemoteAddress ; ?> </td>
                                                    <td> <? echo $CONNECTIVITY ; ?> </td>
                                                    <td> <? echo $Connectivity_Type ; ?> </td>
                                                    <td> <? echo $Site_data_Received_for_Feasiblity_date ; ?> </td>
                                                     <td><?= ($created_at ? $created_at : 'NA' ); ?></td>
                                                    <td><?= ($created_by ? $created_by : 'NA' ); ?></td>
                                                 </tr>
                                            <?  $counter++ ;   } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    
                                    
                                    
                                      <? 




$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$local_branch = $_REQUEST['local_branch'];
$customer = $_REQUEST['customer'];
$atmid = $_REQUEST['atmid'];
										
										
echo '<div class="pagination"><ul>';
if ($start_window > 1) {

    echo "<li><a href='?page=1&&atmid=$atmid&&$customer'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid='.$atmid.'&&'.$customer.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&<? echo $customer; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid='.$atmid.'&&'.$customer.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&atmid='.$atmid.'&&'.$customer.'">Last</a></li>';
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
                        </div>


                    </div>
                </div>
            </div>
                    
                    
                    
                    
                    
                    <script>
                            $("#show_filter").css('display', 'none');

    $("#hide_filter").on('click', function() {
        $("#filter").css('display', 'none');
        $("#show_filter").css('display', 'block');
    });
    $("#show_filter").on('click', function() {
        $("#filter").css('display', 'block');
        $("#show_filter").css('display', 'none');
    });


                    </script>
                    
    <?php include('footer.php'); ?>
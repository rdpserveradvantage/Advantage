<?php include('header.php');


$page_size = min(isset($_POST['page_size']) ? $_POST['page_size'] : 10, 100); // shoul not be greater than 100
                        
                        
                        
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
                                        <div class="col-sm-3">
                                            <label>Page Size</label>
                                            <input class="form-control" type="number" name="page_size" value="<?=$page_size;?>" placeholder="max 100 records" min="10" max="100" required>  
                                                
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
                                XPNET_RemoteAddress,CONNECTIVITY,Connectivity_Type,Site_data_Received_for_Feasiblity_date,isDelegated,created_at,created_by,
                                isFeasibiltyDone
                                from sites where 1 ";
                                
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
                                        
                                        <br />
                                        <table class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <th>activity </th>
                                                    <th>customer </th>
                                                    <th>bank </th>
                                                    <th>atmid </th>
                                                    <th>atmid2 </th>
                                                    <th>atmid3 </th>
                                                    <th>address </th>
                                                    <th>city </th>
                                                    <th>state </th>
                                                    <th>zone </th>
                                                    <th>LHO </th>
                                                    <th>LHO Contact Person </th>
                                                    <th>LHO Contact Person No. </th>
                                                    <th>LHO Contact Person email </th>
                                                    <th>LHO Adv Person </th>
                                                    <th>LHO Adv Contact </th>
                                                    <th>LHO Adv email </th>
                                                    <th>Project Coordinator Name </th>
                                                    <th>Project Coordinator No. </th>
                                                    <th>Project Coordinator email </th>
                                                    <th>Customer SLA </th>
                                                    <th>Our SLA </th>
                                                    <th>Vendor </th>
                                                    <th>Cash Management </th>
                                                    <th>CRA VENDOR </th>
                                                    <th>ID on Make </th>
                                                    <th>Model </th>
                                                    <th>SiteType </th>
                                                    <th>PopulationGroup </th>
                                                    <th>XPNET_RemoteAddress </th>
                                                    <th>CONNECTIVITY </th>
                                                    <th>Connectivity Type </th>
                                                    <th>Site data Received for Feasiblity date </th>
                                                    <th>Created At</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                
                                                $counter = ($current_page - 1) * $page_size + 1;
                                                $atm_sql_res = mysqli_query($con,$sql_query);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
                                                        $isFeasibiltyDone = $atm_sql_result['isFeasibiltyDone'];
                                                        
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
                                                        $isDelegated = $atm_sql_result['isDelegated'];
                                                        $created_at = $atm_sql_result['created_at'];
                                                        $created_by = $atm_sql_result['created_by'];
                                                        $created_by = getUsername($created_by,0);
                                                    ?>
                                                
                                                 <tr>
                                                    <td><?php echo $counter; ?></td>
                                                    <td>
                                                        <?php
                                                        
                                                        if ($isFeasibiltyDone) {
                                                            echo 'Feasibility: Done | ';
                                                            echo '<a href="feasibilityReport.php?atmid=' . $atmid . '" target="_blank">Report</a>';
                                                        } else {
                                                            if ($isDelegated == 0) {
                                                                echo '<a href="delegate.php?id=' . $id . '&atmid=' . $atmid . '">Delegate</a>';
                                                            } else {
                                                                echo 'Delegated | <a href="delegate.php?id=' . $id . '&atmid=' . $atmid . '&action=redelegate">Re-Delegate</a>';
                                                            }
                                                        }
                                                        ?>
                                                    </td>

                                                    <td> <? echo $activity ; ?> </td>
                                                    <td> <? echo $customer ; ?> </td>
                                                    <td> <? echo $bank ; ?> </td>
                                                    <td> <? echo $atmid ; ?> </td>
                                                    <td> <? echo $atmid2 ; ?> </td>
                                                    <td> <? echo $atmid3 ; ?> </td>
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
                                                    <td> <? echo $created_at; ?></td>
                                                    <td> <? echo $created_by; ?></td>
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

    echo "<li><a href='?page=1&&atmid=$atmid&&$customer&&page_size=$page_size'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid='.$atmid.'&&customer='.$customer.'&&page_size='.$page_size.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&customer=<? echo $customer; ?>&&page_size=<? echo $page_size; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid='.$atmid.'&&customer='.$customer.'&&page_size='.$page_size.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&atmid='.$atmid.'&&customer'.$customer.'&&page_size='.$page_size.'">Last</a></li>';
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
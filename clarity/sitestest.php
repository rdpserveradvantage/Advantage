<?php include('header.php'); ?>


            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                

                        <?php
                            // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
                            $sqlappCount = "select count(1) as total from sites where 1 " ;
                            $atm_sql = "select po,po_date,id,activity,customer,bank,atmid,address,city,state,zone,LHO,LHO_Contact_Person,LHO_Contact_Person_No,
                                LHO_Contact_Person_email,LHO_Adv_Person,LHO_Adv_Contact,LHO_Adv_email,Project_Coordinator_Name,Project_Coordinator_No,
                                Project_Coordinator_email,Customer_SLA,Our_SLA,Vendor,Cash_Management,CRA_VENDOR,ID_on_Make,Model,SiteType,PopulationGroup,
                                XPNET_RemoteAddress,CONNECTIVITY,Connectivity_Type,Site_data_Received_for_Feasiblity_date,isDelegated,created_at,created_by,
                                isFeasibiltyDone,latitude,longitude,verificationStatus,delegatedtoVendorId,ESD,ASD
                                from sites where 1 ";
                                
                            if(isset($_REQUEST['atmid']) && $_REQUEST['atmid']!=''){
                                $atmid = $_REQUEST['atmid'];
                                $atm_sql .= "and atmid like '%".$atmid."%'" ;
                                $sqlappCount .= "and atmid like '%".$atmid."%'" ;
                            }
                            
                            if(isset($_REQUEST['isFeasibiltyDone']) && $_REQUEST['isFeasibiltyDone']!=''){
                                $isFeasibiltyDonefilter = $_REQUEST['isFeasibiltyDone'];
                                $atm_sql .= "and isFeasibiltyDone like '%".$isFeasibiltyDonefilter."%'" ;
                                $sqlappCount .= "and isFeasibiltyDone like '%".$isFeasibiltyDonefilter."%'" ;
                            }
                            if(isset($_REQUEST['isDelegated']) && $_REQUEST['isDelegated']!=''){
                                $isDelegatedFilter = $_REQUEST['isDelegated'];
                                $atm_sql .= "and isDelegated like '%".$isDelegatedFilter."%'" ;
                                $sqlappCount .= "and isDelegated like '%".$isDelegatedFilter."%'" ;
                            }
                            
                            if(isset($_REQUEST['cust']) && $_REQUEST['cust']!=''){
                                $atm_sql .=  "and customer like '%".$_REQUEST['cust']."%' ";
                                $sqlappCount .= "and customer like '%".$_REQUEST['cust']."%' ";
                            }
                               
                            if(isset($_REQUEST['zone']) && $_REQUEST['zone']!=''){
                                $atm_sql .=  "and zone = '".$_REQUEST['zone']."' ";
                                $sqlappCount .= "and zone = '".$_REQUEST['zone']."' ";
                            }
                            
                            if(isset($_REQUEST['state']) && $_REQUEST['state']!=''){
                                $atm_sql .=  "and state= '".$_REQUEST['state']."' ";
                                $sqlappCount .=  "and state= '".$_REQUEST['state']."' ";
                            }
                            
                        function getBranchName($id){
                            global $con ;
                            $sql = mysqli_query($con,"select * from mis_city where id='".$id."'");
                            $sql_result = mysqli_fetch_assoc($sql);
                            return $sql_result['city'];
                        }
                        
                        
                
                        $atm_sql .=  "and status=1 order by id desc";
                        $sqlappCount .=  "and status=1";
                        
                        $page_size = 10; 
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
                            // }
                            
                               
                               ?>
                               
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">    
                                                <div class="col-md-3">
                                                    <label>ATMID</label>
                                                    <input type="text" class="form-control" name="atmid" value="<? echo $_REQUEST['atmid']; ?>" />    
                                                </div>
                                                
                                                <div class="col-md-3">
                                                    <label>Feasibilty Done</label>
                                                    <select name="isFeasibiltyDone" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" <? if(isset($isFeasibiltyDonefilter) && $isFeasibiltyDonefilter==1 ){ echo 'selected'; } ?>>Yes</option>
                                                        <option value="0" <? if(isset($isFeasibiltyDonefilter) && $isFeasibiltyDonefilter==0 ){ echo 'selected'; } ?>>No</option>
                                                    </select>
                                                    
                                                </div>
                                                
                                                
                                                <div class="col-md-2">
                                                    <label>Customer</label>
                                                    <select name="cust" class="form-control mdb-select md-form" searchable="Search here..">

                                                        <option value="">-- Select Customer --</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $custlist= mysqli_query($con,"SELECT id,customer from sites where customer!='' group by customer ");
    											        while($fetch_data = mysqli_fetch_assoc($custlist)){
    											     ?>
											        <option value="<?php echo $fetch_data['customer'] ?>" <?php if($_REQUEST['cust']== $fetch_data['customer']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['customer'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                
                                                <div class="col-md-2">
                                                    <label>State</label>
                                                    <select name="state" class="form-control" >
                                                        <option value="">-- Select State--</option>
                                                        
                                                        <?php 
                                                        $i = 0;
                                                        $statelist= mysqli_query($con,"SELECT id,state from sites where state!='' group by state ");
    											        while($fetch_data = mysqli_fetch_assoc($statelist)){
    											     ?>
											        <option value="<?php echo $fetch_data['state'] ?>" <?php if($_REQUEST['state'] == $fetch_data['state']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['state'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-2">
                                                    <label>Delegated</label>
                                                    <select name="isDelegated" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" <? if(isset($isDelegatedFilter) && $isDelegatedFilter==1 ){ echo 'selected'; } ?>>Yes</option>
                                                        <option value="0" <? if(isset($isDelegatedFilter) && $isDelegatedFilter==0 ){ echo 'selected'; } ?>>No</option>
                                                    </select>
                                                    
                                                </div>
                                                

                                            </div>
                                            <br>
                                           <div class="col" style="display:flex;justify-content:center;">
                                                 <input type="submit" name="submit" value="Filter" class="btn btn-primary">
                                                <a class="btn btn-warning" id="hide_filter" style="color:white;margin:auto 10px;">Hide Filters</a>
                                             </div>
                                            
                                     </form>  
                                      </div>
                                    </div>
   
                               
                               
                               
                                <div class="card">
                                    <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    <div class="card-header">
                                        <h5>Total Records: <strong class="record-count"><? echo $total_records ; ?></strong></h5>

                                        <hr />
                                        <form action="exportsites.php" method="POST">
                                            <input type="hidden" name="exportSql" value="<? echo $atm_sql; ?>">
                                            <input type="submit" name="exportsites" class="btn btn-primary" value="Export">
                                        </form>

                                    </div>
                                    <div class="card-body" style="overflow:auto;">
                                        
                                        <? 
                                        // if (isset($_REQUEST['submit']) || isset($_GET['page'])) { 
                                        
                                        ?>
                                        
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs" style="width:100%;">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>atmid </th>

                                                    <th>PO Number</th>
                                                    <th>PO Date</th>
                                                    <th>activity </th>
                                                    <th>customer </th>
                                                    <th>bank </th>
                                                    <th>address </th>
                                                    <th>Latitude</th>
                                                    <th>Longitude</th>
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
                                                    <th>ESD</th>
                                                    <th>ASD</th>
                                                    <th>Created At</th>
                                                    <th>Created By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1 ;
                                                
                                                $counter = ($current_page - 1) * $page_size + 1;
                                                $atm_sql_res = mysqli_query($con,$sql_query);
                                                while($atm_sql_result = mysqli_fetch_assoc($atm_sql_res)){
                                                        $isFeasibiltyDoneRecord = $atm_sql_result['isFeasibiltyDone'];
                                                        
                                                        $id = $atm_sql_result['id'];
                                                        $po = $atm_sql_result['po'];
                                                        $po_date = $atm_sql_result['po_date'];
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
                                                        $created_by = getUsername($created_by,0);
                                                        $longitude = $atm_sql_result['longitude'] ? $atm_sql_result['longitude'] : 'NA';
                                                        $latitude = $atm_sql_result['latitude'];
                                                        $verificationStatus = $atm_sql_result['verificationStatus'];
                                                        $delegatedtoVendorId = $atm_sql_result['delegatedtoVendorId'];
                                                        $ESD = $atm_sql_result['ESD'];
                                                        $ASD = $atm_sql_result['ASD'];
                                                        
                                                        $projectInstallationsql = mysqli_query($con,"select * from projectInstallation where siteid = '".$id."' and status=1 ");
                                                        if($projectInstallationsql_result = mysqli_fetch_assoc($projectInstallationsql)){
                                                            $projectInstallation = true ; 
                                                            $projectInstallationVendor = $projectInstallationsql_result['vendor'];
                                                        }else{
                                                            $projectInstallation = false ; 
                                                        }
                                                        
                                                    ?>
                                                
                                                 <tr>
                                                    <th><?= $counter; ?></th>
                                                    <td class="strong"><? echo $atmid ; ?>  </td>
                                                    <td><?= ( $po ? $po : 'NA' ); ?></td>
                                                    <td><?= ( $po_date ? $po_date : 'NA' ); ?></td>
                                                    <td><?= ($activity ? $activity : 'NA' ) ; ?> </td>
                                                    <td><?= ($customer ? $customer : 'NA' ) ; ?> </td>
                                                    <td><?= ($bank ? $bank : 'NA' ) ; ?> </td>
                                                    
                                                    <td><?= ($address ? $address : 'NA' ) ; ?> </td>
                                                    
                                                    <td> <?= ($latitude? $latitude:'NA') ; ?> </td>
                                                    <td><?= ($longitude ? $longitude : 'NA' ) ; ?> </td>
                                                    
                                                    <td><?= ($city ? $city : 'NA' ) ; ?> </td>
                                                    <td><?= ($state ? $state : 'NA' ) ; ?> </td>
                                                    <td><?= ($zone ? $zone : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO ? $LHO : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Contact_Person ? $LHO_Contact_Person : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Contact_Person_No ? $LHO_Contact_Person_No : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Contact_Person_email ? $LHO_Contact_Person_email : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Adv_Person ? $LHO_Adv_Person : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Adv_Contact ? $LHO_Adv_Contact : 'NA' ) ; ?> </td>
                                                    <td><?= ($LHO_Adv_email ? $LHO_Adv_email : 'NA' ) ; ?> </td>
                                                    <td><?= ($Project_Coordinator_Name ? $Project_Coordinator_Name : 'NA' ) ; ?> </td>
                                                    <td><?= ($Project_Coordinator_No ? $Project_Coordinator_No : 'NA' ) ; ?> </td>
                                                    <td><?= ($Project_Coordinator_email ? $Project_Coordinator_email : 'NA' ) ; ?> </td>
                                                    <td><?= ($Customer_SLA ? $Customer_SLA : 'NA' ) ; ?> </td>
                                                    <td><?= ($Our_SLA ? $Our_SLA : 'NA' ) ; ?> </td>
                                                    <td><?= ($Vendor ? $Vendor : 'NA' ) ; ?> </td>
                                                    <td><?= ($Cash_Management ? $Cash_Management : 'NA' ) ; ?> </td>
                                                    <td><?= ($CRA_VENDOR ? $CRA_VENDOR : 'NA' ) ; ?> </td>
                                                    <td><?= ($ID_on_Make ? $ID_on_Make : 'NA' ) ; ?> </td>
                                                    <td><?= ($Model ? $Model : 'NA' ) ; ?> </td>
                                                    <td><?= ($SiteType ? $SiteType : 'NA' ) ; ?> </td>
                                                    <td><?= ($PopulationGroup ? $PopulationGroup : 'NA' ) ; ?> </td>
                                                    <td><?= ($XPNET_RemoteAddress ? $XPNET_RemoteAddress : 'NA' ) ; ?> </td>
                                                    <td><?= ($CONNECTIVITY ? $CONNECTIVITY : 'NA' ) ; ?> </td>
                                                    <td><?= ($Connectivity_Type ? $Connectivity_Type : 'NA' ) ; ?> </td>
                                                    <td><?= ($Site_data_Received_for_Feasiblity_date ? $Site_data_Received_for_Feasiblity_date : 'NA' ) ; ?> </td>
                                                    <td><?= ($ESD!='0000-00-00 00:00:00' ? $ESD : 'NA' ); ?></td>
                                                    <td><?= ($ASD!='0000-00-00 00:00:00' ? $ASD : 'NA' ); ?></td>
                                                    <td><?= ($created_at ? $created_at : 'NA' ); ?></td>
                                                    <td><?= ($created_by ? $created_by : 'NA' ); ?></td>
                                                 </tr>
                                            <?  $counter++ ;   } ?>
                                            </tbody>
                                        </table>
                                        
                                        <? 
                                        // }
                                        ?>
                                    </div>
                                    
                                    
                                    
                                    
                                      <? 




$fromdt = $_REQUEST['fromdt'];
$todt = $_REQUEST['todt'];
$local_branch = $_REQUEST['local_branch'];
$customer = $_REQUEST['customer'];
$atmid = $_REQUEST['atmid'];
$isDelegated = $_REQUEST['isDelegated'];
$isFeasibiltyDone = $_REQUEST['isFeasibiltyDone'];

echo '<div class="pagination"><ul>';
if ($start_window > 1) {

    echo "<li><a href='?page=1&&atmid=$atmid&&$customer&&page_size=$page_size&&isDelegated=$isDelegated&&isFeasibiltyDone=$isFeasibiltyDone'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&atmid='.$atmid.'&&customer='.$customer.'&&page_size='.$page_size.'&&isDelegated='.$isDelegated.'&&isFeasibiltyDone='.$isFeasibiltyDone.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&atmid=<? echo $atmid; ?>&&customer=<? echo $customer; ?>&&page_size=<? echo $page_size; ?>&&isDelegated=<? echo $isDelegated; ?>&&isFeasibiltyDone=<? echo $isFeasibiltyDone; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&atmid='.$atmid.'&&customer='.$customer.'&&page_size='.$page_size.'&&isDelegated='.$isDelegated.'&&isFeasibiltyDone='.$isFeasibiltyDone.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&atmid='.$atmid.'&&customer'.$customer.'&&page_size='.$page_size.'&&isDelegated='.$isDelegated.'&&isFeasibiltyDone='.$isFeasibiltyDone.'">Last</a></li>';
}
echo '</ul></div>';
										
										
										?>
									
                                    
                                </div>

                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>


<div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="esdModalLabel">History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="historyContent">
            
        </div>    
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {


  $(".history-link").click(function() {
    var siteId = $(this).data("siteid"); 
    var modal = document.getElementById("historyModal");    
    $.ajax({
      url: "getHistory.php",
      type: "POST",
      data: { siteId: siteId },
      success: function(response) {
        $("#historyContent").html(response);
        modal.style.display = "block";
      },
      error: function() {
        alert("Failed to fetch history data.");
      }
    });
  });
});
</script>                    
                    
    
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
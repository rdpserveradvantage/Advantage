<?  include('header.php'); ?>

     
     <style>
         html{
                 /*text-transform: inherit !important;*/
         }
     </style>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <?
                                    $statement = "select * from vendorSitesDelegation where vendorid='".$RailTailVendorID."' and status=1" ; 
                                    $sql = mysqli_query($con,$statement);
                                    while($sql_result = mysqli_fetch_assoc($sql)){    
                                        $siteids[] = $sql_result['siteid'];
                                    }
                                            
                                    $siteids=json_encode($siteids);
                                    $siteids=str_replace( array('[',']','"') , ''  , $siteids);
                                    $arr=explode(',',$siteids);
                                    $siteids = "'" . implode ( "', '", $arr )."'";
                                ?>
                                <div class="card" id="filter">
                                    <div class="card-block">
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">
                                                 
                                                <div class="col-md-3">
                                                    <label>ATMID</label>
                                                    <input type="text" class="form-control" name="atmid" value="<? echo $_POST['atmid']; ?>" />
                                                    
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Feasibilty Done</label>
                                                    <select name="isFeasibiltyDone" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" <? if(isset($_POST['isFeasibiltyDone']) && $_POST['isFeasibiltyDone']==1 ){ echo 'selected'; } ?>>Yes</option>
                                                        <option value="0" <? if(isset($_POST['isFeasibiltyDone']) && $_POST['isFeasibiltyDone']==0 ){ echo 'selected'; } ?>>No</option>
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
											        <option value="<?php echo $fetch_data['customer'] ?>" <?php if($_POST['cust']== $fetch_data['customer']){ echo 'selected'; }  ?>>
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
											        <option value="<?php echo $fetch_data['state'] ?>" <?php if($_POST['state'] == $fetch_data['state']){ echo 'selected'; }  ?>>
											         <?php echo $fetch_data['state'];?>
											         </option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-md-2">
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

                            $sqlappCount = "select count(1) as total from sites where 1 and id in($siteids) " ;
                            $atm_sql = "select id,activity,customer,bank,atmid,atmid2,atmid3,address,city,state,zone,LHO,LHO_Contact_Person,LHO_Contact_Person_No,
                                LHO_Contact_Person_email,LHO_Adv_Person,LHO_Adv_Contact,LHO_Adv_email,Project_Coordinator_Name,Project_Coordinator_No,
                                Project_Coordinator_email,Customer_SLA,Our_SLA,Vendor,Cash_Management,CRA_VENDOR,ID_on_Make,Model,SiteType,PopulationGroup,
                                XPNET_RemoteAddress,CONNECTIVITY,Connectivity_Type,Site_data_Received_for_Feasiblity_date,isDelegated,created_at,created_by,
                                isFeasibiltyDone,delegatedByVendor
                                from sites where 1
                                and id in($siteids)  ";
                                
                            if(isset($_POST['atmid']) && $_POST['atmid']!=''){
                                $atmid = $_POST['atmid'];
                                $atm_sql .= "and atmid like '%".$atmid."%'" ;
                                $sqlappCount .= "and atmid like '%".$atmid."%'" ;
                            }
                            if(isset($_POST['isFeasibiltyDone']) && $_POST['isFeasibiltyDone']!=''){
                                $isFeasibiltyDonefilter = $_POST['isFeasibiltyDone'];
                                $atm_sql .= "and isFeasibiltyDone like '%".$isFeasibiltyDonefilter."%'" ;
                                $sqlappCount .= "and isFeasibiltyDone like '%".$isFeasibiltyDonefilter."%'" ;
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

                            
                               
                               ?>
                                <div class="card">
                                    <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    <div class="card-body" style="overflow:auto;">
                                        <table class="table" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Actions</th>
                                                    <td>activity </td>
                                                    <td>customer </td>
                                                    <td>bank </td>
                                                    <td>atmid </td>
                                                    <td>atmid2 </td>
                                                    <td>atmid3 </td>
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
                                                       $isDelegated = $atm_sql_result['delegatedByVendor'];
                                                    
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
                                

                    
<!-- Modal for ASD -->
<div class="modal fade" id="asdModal" tabindex="-1" role="dialog" aria-labelledby="asdModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="asdModalLabel">ASD Working Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="asdDatetime" class="asd-datetime-label">ASD Date and Time:</label>
        <input type="datetime-local" class="form-control asd-datetime-input">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-asd-datetime">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal for ESD -->
<div class="modal fade" id="esdModal" tabindex="-1" role="dialog" aria-labelledby="esdModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="esdModalLabel">ESD Working Date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="esdDatetime" class="esd-datetime-label">ESD Date and Time:</label>
        <input type="datetime-local" class="form-control esd-datetime-input">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save-esd-datetime">Save</button>
      </div>
    </div>
  </div>
</div>



                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    


<script>
    $(document).ready(function() {
  // ASD link click event
  $('.asd-link').click(function(e) {
    e.preventDefault();
    var siteId = $(this).data('siteid');
    $('#asdModal').modal('show');
    $('.save-asd-datetime').data('siteid', siteId); // Set the siteId as data attribute
  });

  // ESD link click event
  $('.esd-link').click(function(e) {
    e.preventDefault();
    var siteId = $(this).data('siteid');
    $('#esdModal').modal('show');
    $('.save-esd-datetime').data('siteid', siteId); // Set the siteId as data attribute
  });

  // Save ASD datetime
  $('.save-asd-datetime').click(function() {
    var asdDatetime = $(this).closest('.modal-content').find('.asd-datetime-input').val();
    var siteId = $(this).data('siteid');

    // Make AJAX call to save ASD datetime
    $.ajax({
      url: 'API/saveEsdAsd.php',
      type: 'POST',
      data: {
        siteId: siteId,
        datetime: asdDatetime,
        type: 'ASD' // Specify the type as ASD
      },
      success: function(response) {
       if(response.statusCode===200){
            swal("Success", response.response , "success");
            setTimeout(function() {
                location.reload();
            }, 3000);
        }else if(response.statusCode===500){
            swal("Error", response.response , "error");
            // location.reload();
        }else{
            console.log(response);            
        }
          
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });

    $('#asdModal').modal('hide');
  });

  // Save ESD datetime
  $('.save-esd-datetime').click(function() {
    var esdDatetime = $(this).closest('.modal-content').find('.esd-datetime-input').val();
    var siteId = $(this).data('siteid');

    // Make AJAX call to save ESD datetime
    $.ajax({
      url: 'API/saveEsdAsd.php',
      type: 'POST',
      data: {
        siteId: siteId,
        datetime: esdDatetime,
        type: 'ESD' // Specify the type as ESD
      },
      success: function(response) {
        if(response.statusCode===200){
            swal("Success", response.response , "success");
            setTimeout(function() {
                location.reload();
            }, 3000);
            
        }else if(response.statusCode===500){
            swal("Error", response.response , "error");
            // location.reload();
        }else{
            console.log(response);            
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
      }
    });

    $('#esdModal').modal('hide');
  });
});

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


    <? include('footer.php'); ?>

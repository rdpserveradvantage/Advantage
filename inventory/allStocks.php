<?php include('header.php');


?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                         <div class="card" id="filter">
                                    <div class="card-block">
                                        
                                        <form id="sitesForm" action="<?php echo basename(__FILE__); ?>" method="POST">
                                            <div class="row">    
                                                
                                                <div class="col-md-6">
                                                    <label>Material</label>
                                                    <select name="material" class="form-control">
                                                        <option value="">-- Select Material --</option>
                                                        <?php 
                                                            $i = 0;
                                                            $materiallist= mysqli_query($con,"SELECT distinct(material) as material from Inventory where status=1 ");
        											        while($fetch_data = mysqli_fetch_assoc($materiallist)){
        											     ?>

<option value="<?php echo $fetch_data['material'] ?>" <?php if($fetch_data['material'] == $_REQUEST['material']){ echo 'selected'; }  ?>>
    <?php echo $fetch_data['material'];?>
</option>
											         <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                                
                                                <div class="col-sm-6">
                                                    <label>Serial Number</label>
                                                    <input type="text" name="serialNumber" class="form-control" value="<? echo $_REQUEST['serialNumber']; ?>" placeholder="Enter Serial Number ..." />
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


                        <?php
                            // if (isset($_REQUEST['submit']) || isset($_GET['page'])) {
                            $sqlappCount = "select count(1) as total from Inventory where 1 " ;
                            $atm_sql = "select id,material,material_make,model_no,serial_no,challan_no,amount,gst,amount_with_gst,courier_detail,tracking_details,
                            date_of_receiving,receiver_name,vendor_name,vendor_contact,po_date,po_number,created_at,created_by,updated_at
                                from Inventory where 1 ";
                                
                            
                            if(isset($_REQUEST['material']) && $_REQUEST['material']!=''){
                                $material = $_REQUEST['material'];
                                $atm_sql .= "and material like '%".$material."%'" ;
                                $sqlappCount .= "and material like '%".$material."%'" ;
                            }
                            if(isset($_REQUEST['serialNumber']) && $_REQUEST['serialNumber']!=''){
                                $serialNumber = $_REQUEST['serialNumber'];
                                $atm_sql .= "and serial_no like '%".$serialNumber."%'" ;
                                $sqlappCount .= "and serial_no like '%".$serialNumber."%'" ;
                            }
                
                        $atm_sql .=  " and status=1 order by id desc";
                        $sqlappCount .=  " and status=1";
                        
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
                        // echo $sql_query ; 
                               
                               
                               
                               

?>

                    <div class="card">
                        <div class="card-block" style="overflow:auto;">

                                 <div style="display:flex;justify-content:space-around;">
                                        <h5 style="text-align:center;">All Stocks - <p>Total Records- <? echo $total_records ;  ?></p></h5>

                                        <a class="btn btn-warning" id="show_filter" style="color:white;margin:auto 10px;">Show Filters</a>
                                    </div>
                                    
                            
                            
                                <table class="table table-hover table-styling table-xs">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Sr no</th>
                                            <th>material</th>
                                            <th>material_make</th>
                                            <th>model_no</th>
                                            <th>serial_no</th>
                                            <th>challan_no</th>
                                            <th>amount</th>
                                            <th>gst</th>
                                            <th>amount_with_gst</th>
                                            <th>courier_detail</th>
                                            <th>tracking_details</th>
                                            <th>date_of_receiving</th>
                                            <th>receiver_name</th>
                                            <th>vendor_name</th>
                                            <th>vendor_contact</th>
                                            <th>po_date</th>
                                            <th>po_number</th>
                            
                                            <!-- Add other column headers here -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i=1 ;
                                        $counter = ($current_page - 1) * $page_size + 1;
                                        $sql_app = mysqli_query($con, $sql_query);
                                        while ($row = mysqli_fetch_assoc($sql_app)) {
                                            
                                            $material = $row['material'] ;  
                                            $material_make = $row['material_make'] ;  
                                            $model_no = $row['model_no'] ;  
                                            $serial_no = $row['serial_no'] ;  
                                            $challan_no = $row['challan_no'] ;  
                                            $amount = $row['amount'] ;  
                                            $gst = $row['gst'] ;  
                                            $amount_witd_gst = $row['amount_witd_gst'] ;  
                                            $courier_detail = $row['courier_detail'] ;  
                                            $tracking_details = $row['tracking_details'] ;  
                                            $date_of_receiving = $row['date_of_receiving'] ;  
                                            $receiver_name = $row['receiver_name'] ;  
                                            $vendor_name = $row['vendor_name'] ;  
                                            $vendor_contact = $row['vendor_contact'] ;  
                                            $po_date = $row['po_date'] ;  
                                            $po_number = $row['po_number'] ;  
                                            
                            
                                            echo '<tr>';
                            ?>
                            
                            <td><? echo $counter; ?></td>
                            <td><? echo $material; ?></td>
                            <td><? echo $material_make; ?></td>
                            <td><? echo $model_no; ?></td>
                            <td><? echo $serial_no; ?></td>
                            <td><? echo $challan_no; ?></td>
                            <td><? echo $amount; ?></td>
                            <td><? echo $gst; ?></td>
                            <td><? echo $amount_witd_gst; ?></td>
                            <td><? echo $courier_detail; ?></td>
                            <td><? echo $tracking_details; ?></td>
                            <td><? echo $date_of_receiving; ?></td>
                            <td><? echo $receiver_name; ?></td>
                            <td><? echo $vendor_name; ?></td>
                            <td><? echo $vendor_contact; ?></td>
                            <td><? echo $po_date; ?></td>
                            <td><? echo $po_number; ?></td>
                            
                            
                            <? 
                            
                                            // Display other record fields as table cells
                                            echo '</tr>';
                                        $counter++; }
                                        ?>
                                    </tbody>
                                </table>
                            
                             
                             		<?					
									
									$material_name = $_REQUEST['material'];	
echo '<div class="pagination"><ul>';
if ($start_window > 1) {

    echo "<li><a href='?page=1&&material=$material_name'>First</a></li>";
    echo '<li><a href="?page=' . ($start_window - 1) . '&&material='.$material_name.'">Prev</a></li>';
}

for ($i = $start_window; $i <= $end_window; $i++) {
?>
    <li class="<? if ($i == $current_page) { echo 'active'; }?>" >
        <a href="?page=<? echo $i; ?>&&material=<? echo $material_name; ?>" >
            <? echo $i;  ?>
        </a>        
    </li>

 <? }

if ($end_window < $total_pages) {

    echo '<li><a href="?page=' . ($end_window + 1) . '&&material='.$material_name.'">Next</a></li>';
    echo '<li><a href="?page=' . $total_pages . '&&material='.$material_name.'">Last</a></li>';
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
<?php
include('footer.php');
?>

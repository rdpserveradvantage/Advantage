<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                        <div class="card-body">
                            
                            <?
                            $i=1 ; 
                            $sql = mysqli_query($con,"select * from routerConfiguration where status=1 order by id desc limit 40");
                          if (mysqli_num_rows($sql) > 0) {      
                            
                            echo '<table class="table table-hover table-styling table-xs" style="width:100%;">
                                <thead>
                                    <tr class="table-primary">
                                        <th>Sr No</th>
                                        <th>Atm id</th>
                                        <th>Serial Number</th>
                                        <th>Seal Number</th>
                                        <th>Created At</th>
                                        <th>Created By</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                    while($sql_result = mysqli_fetch_assoc($sql)){ 
                                    
                                    $atmid = $sql_result['atmid'];
                                    $serialNumber = $sql_result['serialNumber']; 
                                    $sealNumber = $sql_result['sealNumber'];
                                    $created_at = $sql_result['created_at'];
                                     
                                    $created_by = $sql_result['created_by'];
                                    $created_by = getUsername($created_by,false) ;

                                        
                                        echo "<tr>
                                            <td>{$i}</td>
                                            <td>{$atmid}</td>
                                            <td>{$serialNumber}</td>
                                            <td>{$sealNumber}</td>
                                            <td>{$created_at}</td>
                                            <td>{$created_by}</td>
                                            
                                        </tr>";

                                     $i++;  } 

                            echo "    </tbody>
                            </table>";
                            
                          } else{
                                 echo '
                                    <div class="noRecordsContainer">
                                        <img src="assets/noRecords.png">
                                    </div>';
                          }
                            
                    ?>        
                        </div>
                    </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
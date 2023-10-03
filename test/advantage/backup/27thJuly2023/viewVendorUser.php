<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                          <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Desgination</th>
                                                    <th>Username</th>
                                                    <th>Password</th>
                                                    <th>Contact No.</th>
                                                    <th>Status</th>
                                                    <th>action</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $RailTailVendorID = $_REQUEST['vendor'];
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from vendorUsers where vendorId='".$RailTailVendorID."'");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 
                                                    $serviceExecutiveStatus=0 ; 
                                                  if($sql_result['user_status']==0){
                                                      $user_status = 'Inactive';
                                                      $makeuser_status = 'Make Active';
                                                      
                                                  }else{
                                                      $user_status = 'Active';
                                                      $makeuser_status = 'Make Inactive';
                                                      $status_class = 'text-success';
                                                  }
                                                  $level = $sql_result['level'];
                                                  
                                                  if($level==1){
                                                       $designation = 'Admin';
                                                  }else if($level==2){
                                                       $designation = 'Project Executive';   
                                                  }else if($level==3){
                                                      $designation = 'Engineer';
                                                  }

                                                  $desgination = $sql_result['designation']; 
                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['id']; ?></td>
                                                        <td><? echo $sql_result['name']; ?></td>
                                                        <td><? echo $designation; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['uname']; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['password']; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['contact']; ?></td>
                                                        <td class="<? echo $status_class; ?>"><? echo $user_status;?></td>
                                                        <td>
                                                            <a class="btn btn-warning" href="vendorallotmenu_perm.php?id=<? echo $sql_result['id'];  ?>">Menu Permission</a>
                                                        </td>
                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
                                            </table>
                                    </div>
                                </div>
                                
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>


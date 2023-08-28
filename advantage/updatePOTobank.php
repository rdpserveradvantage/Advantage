<? include('header.php'); ?>

<style>
    .approval_form .col-sm-12 select, .approval_form .col-sm-12 input {
    width: 70%;
}
.approval_form .col-sm-12 label {
    width: 30%;
    font-weight: 700;
}
.approval_form .col-sm-12 {
    display: flex;
    justify-content: space-between;
    margin: 0.8%;
}
</style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">

                                        <?
                                        $id = $_REQUEST['id'];
                                        
                                        $sql = mysqli_query($con,"select * from feasibilityCheck where id = '".$id."'");
                                        $sql_result = mysqli_fetch_assoc($sql);
                                            $ATMID1 = $sql_result['ATMID1'];
                                            $ATMID2 = $sql_result['ATMID2'];
                                            $ATMID3 = $sql_result['ATMID3'];
                                            $address = $sql_result['address'];
                                            $city = $sql_result['city'];
                                            $location = $sql_result['location'];
                                            $LHO = $sql_result['LHO'];
                                            $state = $sql_result['state'];
                                            $bank = $sql_result['bank'];
                                            $ticketid = $sql_result['ticketid'];
                                            $feasibilityDone = $sql_result['feasibilityDone'];
                                        ?>

                                
                                
                                
                                
                                
                                
                            <div class="card">
                                    <div class="card-block">
                                        
                                        <h5>SITE INFORMATION</h5>
                                        <hr>
                                        
                                        <div class="view-info">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="general-info">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">Ticket ID </th>
                                                                                <td><? echo $ticketid; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">ATM ID</th>
                                                                                <td>
                                                                                    <span><? echo $ATMID1; ?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">City</th>
                                                                                <td><? echo $city; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Location</th>
                                                                                <td><? echo $location; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 col-xl-6">
                                                                <div class="table-responsive">
                                                                    <table class="table m-0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th scope="row">State </th>
                                                                                <td><? echo $state; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Address</th>
                                                                                <td>
                                                                                    <span><? echo $address; ?></span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">LHO</th>
                                                                                <td><? echo $LHO; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th scope="row">Is Feasibility Done</th>
                                                                                <td><? echo $feasibilityDone; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end of row -->
                                                    </div>
                                                    <!-- end of general info -->
                                                </div>
                                                <!-- end of col-lg-12 -->
                                            </div>
                                            
                                            <!-- end of row -->
                                        </div>
                                    </div>
                                </div>
                                
                                
                            <div class="card">
                                    <div class="card-block">
                                        <h5>Send PO To Bank</h5>
                                        <div class="view-info">
                                            <hr>
                              <form id="form" action="#" enctype="multipart/form-data" method="POST">
                                
                                <div class="row approval_form">
                                    <div class="col-sm-12">
                                        <label>Select Bank</label>
                                        <select name="bank" class="form-control" required="" style="background:gray;color:white;">
                                            <option value="">Select</option>
                                            <?
                                            $banksql = mysqli_query($con,"select * from bank where status=1");
                                            while($banksql_result = mysqli_fetch_assoc($banksql)){
                                                $bank = $banksql_result['bank'];
                                                echo '<option>'.$bank.'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Remarks</label>
                                        <input type="text" name="remarks" value="" class="form-control" required="">
                                    </div>
                                    <div class="col-sm-12">
                                        <label>Attach email</label>	
                                        <input type="file" class="form-control" name="email_cpy" id="email_cpy">
                                    </div>
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-sm-12" >
                                        <input type="submit" value="submit" name="submit" class="btn btn-success" style="margin-right:10px;">
                                    </div>

                                </div>
                                <br>
                                <br>
                                </form>
                                
                                
                                        </div>
                                    </div>
                                </div>
                                        
                                
                                
                                
                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
<? include('header.php'); ?>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <h4>Project Co-ordinator</h4>
                                        <hr>
                                        
                                        <form action="process_projectCoordinator.php" method="POST">
                                            <div class="row">
                                                    <div class="col-sm-4">
                                                    <label>Contact Person</label>
                                                    <input type="text" name="contactPersonName" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Contact Person No</label>
                                                    <input type="text" name="contactPersonNo" class="form-control">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Contact Person Email</label>
                                                    <input type="text" name="contactPersonEmail" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Designation</label>
                                                    <input type="text" name="designation" class="form-control" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Exclamation Matrix</label>
                                                    <input type="text" name="esc_matrix" class="form-control" placeholder="Level 1 or Level 2 ..." />
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-primary">
                                                </div>                                                
                                            </div>

                                        </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-body" style="overflow:auto;">
                                        <table id="example" class="table table-hover table-styling" style="width:100%">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>Contact Person</th>
                                                    <th>Contact Person No</th>
                                                    <th>Contact Person Email</th>
                                                    <th>Designation</th>
                                                    <th>Escalation Matrix</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from projectCoordinator where status=1");
                                                while($sql_result = mysqli_fetch_assoc($sql)){ 

                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['contactPersonName']; ?></td>
                                                        <td><? echo $sql_result['contactPersonNo']; ?></td>
                                                        <td><? echo $sql_result['contactPersonEmail']; ?></td>
                                                        <td><? echo $sql_result['designation']; ?></td>
                                                        <td><? echo $sql_result['esc_matrix']; ?></td>
                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
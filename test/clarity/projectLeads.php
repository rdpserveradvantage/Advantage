<?  include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow: auto;">
                            <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                        <th>Srno</th>
                                        <th>Atmid</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?
                                    $i=1 ; 
                                    $sql = mysqli_query($con,"select * from assignedInstallation where assignedToId='".$userid."' and status=1") ; 
                                    while($sql_result = mysqli_fetch_assoc($sql)){ 
                                    
                                    $atmid = $sql_result['atmid'];
                                    $siteid = $sql_result['siteid'];
                                    $isDone=$sql_result['isDone'];
                                    
                                    $sitessql = mysqli_query($con,"select * from sites where id='".$siteid."'");
                                    $sitessql_result = mysqli_fetch_assoc($sitessql);
                                    $address = $sitessql_result['address'];
                                    
                                    ?>
                                    
                                        <tr>
                                            <td><? echo $i; ?></td>
                                            <td><? echo $atmid; ?></td>
                                            <td><? echo $address ; ?></td>
                                            <td>
                                                <?

                                                if($isDone==1){
                                                    echo 'Installation Done !';
                                                }else{
                                                echo '<a href="proceedInstallation.php?siteid=' . $siteid . '&&atmid=' . $atmid . '" target="_blank">Proceed With Installation</a>';
    
                                                }
                                                
                                                ?>
                                                
                                            </td>
                                        </tr>
                                        
                                    <? $i++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script></script>

<? include('footer.php'); ?>
<script src="./datatable/jquery.dataTables.js"></script>
<script src="./datatable/dataTables.bootstrap.js"></script>
<script src="./datatable/dataTables.buttons.min.js"></script>
<script src="./datatable/buttons.flash.min.js"></script>
<script src="./datatable/jszip.min.js"></script>

<script src="./datatable/pdfmake.min.js"></script>
<script src="./datatable/vfs_fonts.js"></script>
<script src="./datatable/buttons.html5.min.js"></script>
<script src="./datatable/buttons.print.min.js"></script>
<script src="./datatable/jquery-datatable.js"></script>
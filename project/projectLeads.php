<?  include('header.php'); ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow: auto;">
                            <table class="table table-hover table-styling table-xs">
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

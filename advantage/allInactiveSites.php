<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                      
                                    <?
                                                $counter=1;
                                                $sql = mysqli_query($con,"select * from inactiveSites where status=1");
                                                if (mysqli_num_rows($sql) > 0) { ?>


                                        <table class="table table-hover table-styling table-xs">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Sr no</th>
                                                    <th>ATMID</th>
                                                    <th>Remarks</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                      <?
                                                while($sql_result = mysqli_fetch_assoc($sql)){
                                                    
                                                    $siteid = $sql_result['siteid'];
                                                    $atmid = $sql_result['atmid'];
                                                    $remarks = $sql_result['reason'];
                                                    $created_at = $sql_result['created_at'];
                                                ?>
                                                
                                                
                                                <tr>
                                                    <td><?= $counter ; ?></td>
                                                    <td class="strong"><?= $atmid; ?></td>
                                                    <td><?= $remarks; ?></td>
                                                    <td><?= $created_at; ?></td>
                                                    <td>
                                                        <a id="recoverSite" data-siteid="<?= $siteid; ?>" style="cursor:pointer;">
                                                             Recover 
                                                        </a>
                                                    </td>
                                                </tr>    
                                                    
                                                <? $counter++; } 

                                                 } else{

echo '
                                            
<div class="noRecordsContainer">
    <img src="assets/no_records.jpg">
</div>';

} ?>



                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    

<script>

    $(document).on('click', '#recoverSite', function () {
    let siteid = $(this).data('siteid');

    $.ajax({
        url: 'recoverSites.php',
        type: 'POST',
        data: {
            siteid: siteid
        },
        success: function (data) {
            console.log(data);
            if(data==200){
                swal('Success','Site Recover Successfully !','success') ; 
                setTimeout(function(){ 
                    window.location.href="allInactiveSites.php";
                }, 2000);
            }else{
                swal('Error','Site Not Inactive !','error') ;
            }
            
        }
    });

});
    
</script>

    <? include('footer.php'); ?>
<?  include('header.php'); ?>
<style>
    .btn-primary.disabled, .btn-primary:disabled {
    color: #fff;
    background-color: gray;
    border-color: gray;
}
</style>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block" style="overflow: auto;">
                                        
                                        <?
                                        $statement = "select distinct(siteid) as siteid from delegation where engineerId='".$userid."' and status=1 order by id desc" ; 
                                        $sql = mysqli_query($con,$statement);
                                        while($sql_result = mysqli_fetch_assoc($sql)){    
                                            $atm[] = $sql_result['siteid'];
                                        }
                                        
                                        ?>
                                        
                                <table class="table table-hover table-styling table-xs">
                                    <thead>
                                        <tr class="table-primary">
                                          <th>Srno</th>
                                          <th>Atmid</th>
                                          <th>Action</th>
                                          <th>Working Date</th>
                                          <th>Address</th>
                                        </tr>
                                      </thead>
                                      <tbody>

                                            <?php
                                                $i = 1;
                                                foreach ($atm as $atmkey => $atmvalue) {
                                                    $siteid = $atmvalue;
                                                    $getAtmInfoSql = mysqli_query($con, "select * from sites where status=1 and id='" . $siteid . "'");
                                                    if ($getAtmInfoSqlResult = mysqli_fetch_assoc($getAtmInfoSql)) {
                                                        $atmid = $getAtmInfoSqlResult['atmid'];
                                                        $address = $getAtmInfoSqlResult['address'];
                                                        $esd = $getAtmInfoSqlResult['ESD'];
                                                        $asd = $getAtmInfoSqlResult['ASD'];
                                                        $isFeasibiltyDone = $getAtmInfoSqlResult['isFeasibiltyDone'];
                                                        ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td class="strong"><?= $atmid; ?></td>
                                                            <td class="strong">
                                                                 <?php
                                                                    if ($isFeasibiltyDone == 1) {
                                                                        echo 'Feasibility Done!';
                                                                    } elseif ($isFeasibiltyDone == 0 && $esd=='0000-00-00 00:00:00') {
                                                                        echo 'Put ESD';
                                                                    } elseif ($isFeasibiltyDone == 0 && $asd=='0000-00-00 00:00:00' && $esd!='0000-00-00 00:00:00') {
                                                                        echo 'PUT ASD';
                                                                    } elseif ($esd !='0000-00-00 00:00:00' && $isFeasibiltyDone == 0) {
                                                                        echo '<a href="feasibilitycheck.php?siteid=' . $siteid . '" target="_blank">Check Feasibility</a>';
                                                                    }else {
                                                                        echo 'here' ; 
                                                                    }
                                                                ?>
                                                                
                                                            </td>
                                                            <td>

                                                                <button type="button" class="esd-link btn btn-primary" data-siteid="<?php echo $siteid; ?>" data-atmid="<?php echo $atmid; ?>" <? if ($isFeasibiltyDone == 1) { echo 'disabled'; } ?> >
                                                                    <i class="icofont icofont-info-square"></i> ESD
                                                                </button>
                                                                <? 
                                                                if($esd!='0000-00-00 00:00:00'){
                                                                        echo $esd ;                                                                    
                                                                }

                                                                if($esd!='0000-00-00 00:00:00'){
                                                                    ?>
                                                                |   
                                                                <button type="button" class="asd-link btn btn-primary" data-siteid="<?php echo $siteid; ?>" data-atmid="<?php echo $atmid; ?>" <? if ($isFeasibiltyDone == 1) { echo 'disabled'; } ?>>
                                                                    <i class="icofont icofont-info-square"></i> ASD
                                                                </button>
                                                                   <? echo $asd ;  } ?>

                                                            </td>
                                                            <td><?= $address; ?></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    $i++;
                                                }
                                                ?>

                                        
                                      </tbody>
                                    </table>
                    
                    
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

      $('.asd-link').click(function(e) {
        e.preventDefault();
        var siteId = $(this).data('siteid');
        var atmid = $(this).data('atmid');
        $('#asdModal').modal('show');
        $('.save-asd-datetime').data('siteid', siteId); // Set the siteId as data attribute
        $('.save-asd-datetime').data('atmid', atmid); // Set the atmid as data attribute
      });

  // ESD link click event
  $('.esd-link').click(function(e) {
    e.preventDefault();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');
    
    $('#esdModal').modal('show');
    $('.save-esd-datetime').data('siteid', siteId);
    $('.save-esd-datetime').data('atmid', atmid);
    // Set the siteId as data attribute
  });

  // Save ASD datetime
  $('.save-asd-datetime').click(function() {
    var asdDatetime = $(this).closest('.modal-content').find('.asd-datetime-input').val();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');

    // Make AJAX call to save ASD datetime
    $.ajax({
      url: 'API/saveEsdAsd.php',
      type: 'POST',
      data: {
        siteId: siteId,
        datetime: asdDatetime,
        atmid:atmid,
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
    var atmid = $(this).data('atmid');

    // Make AJAX call to save ESD datetime
    $.ajax({
      url: 'API/saveEsdAsd.php',
      type: 'POST',
      data: {
        siteId: siteId,
        datetime: esdDatetime,
        atmid : atmid,
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
</script>

    <? include('footer.php'); ?>

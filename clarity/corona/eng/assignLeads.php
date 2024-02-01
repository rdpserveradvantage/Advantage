<? include('../header.php'); ?>

<div class="row">

<style>
    .btn-primary.disabled, .btn-primary:disabled {
    color: #fff;
    background-color: gray;
    border-color: gray;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="page-body">
                                <div class="card">
                                    <div class="card-body" style="overflow: auto;">
                                        
                                        <?
                                        $statement = "select distinct(siteid) as siteid from delegation where engineerId='".$userid."' and status=1 order by id desc" ; 
                                        $sql = mysqli_query($con,$statement);
                                        while($sql_result = mysqli_fetch_assoc($sql)){    
                                            $atm[] = $sql_result['siteid'];
                                        }
                                        ?>
                                <table id="example" class="table  dataTable js-exportable no-footer" style="width:100%">
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
                                                            <td><? echo $i; ?></td>
                                                            <td class="strong"><?= $atmid; ?></td>
                                                            <td class="strong">
                                                                 <?php

                                                                    if ($isFeasibiltyDone == 1) {
                                                                        echo 'Feasibility Done!';
                                                                    } elseif ($isFeasibiltyDone == 0 && $esd=='0000-00-00 00:00:00' || $esd=='' ) {
                                                                        echo 'Put ESD';
                                                                    } elseif ($isFeasibiltyDone == 0 && $asd=='0000-00-00 00:00:00' && $esd!='0000-00-00 00:00:00' || $asd=='') {
                                                                        echo 'PUT ASD';
                                                                    } elseif ($esd !='0000-00-00 00:00:00' && $isFeasibiltyDone == 0) {
                                                                        echo '<a href="feasibilitycheck.php?siteid=' . $siteid . '" target="_blank">Check Feasibility</a>';
                                                                    }else {
                                                                        echo 'here' ; 
                                                                    }
                                                                ?>
                                                                
                                                            </td>
                                                            <td>

                                                            <button type="button" class="esd-link btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#esd-link-modal" data-act="add"
                                                                data-value="<?= $id; ?>"
                                                                data-siteid="<?php echo $siteid; ?>" data-atmid="<?php echo $atmid; ?>" <? if ($isFeasibiltyDone == 1 || $esd!='0000-00-00 00:00:00' && $esd!='') { echo 'disabled'; } ?>>
                                                                &nbsp; ETA

                                                            </button>
                                                                <? 
                                                                if($esd!='0000-00-00 00:00:00' || $esd==''){
                                                                        echo $esd ;                                                                    
                                                                }

                                                                if($esd!='0000-00-00 00:00:00' || $asd==''){
                                                                    ?>
                                                                |   
                                                                
                                                            <button type="button" class="asd-link btn btn-primary" data-bs-toggle="modal"
                                                                data-bs-target="#asd-link-modal" data-act="add"
                                                                data-value="<?= $id; ?>"
                                                                data-siteid="<?php echo $siteid; ?>" data-atmid="<?php echo $atmid; ?>" <? if ($isFeasibiltyDone == 1 || $asd!='0000-00-00 00:00:00' &&  $asd!='') { echo 'disabled'; } ?>>
                                                                &nbsp; ATT
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
                    



                                        
                                    </div>
                                </div>
    </div>

</div>




<div class="modal fade" id="esd-link-modal" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                
        <label for="esdDatetime" class="esd-datetime-label">ESD Date and Time:</label>
        <input type="datetime-local" class="form-control esd-datetime-input">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary save-esd-datetime">Save</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="asd-link-modal" tabindex="-1" aria-labelledby="ModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">New message</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                
        <label for="esdDatetime" class="asd-datetime-label">ASD Date and Time:</label>
        <input type="datetime-local" class="form-control asd-datetime-input">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-primary save-asd-datetime">Save</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>

    
// Save ASD datetime
$(document).ready(function () {
  
    $('.esd-link').click(function(e) {
    e.preventDefault();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');
    
    $('.save-esd-datetime').data('siteid', siteId);
    $('.save-esd-datetime').data('atmid', atmid);
    
  });

  
  $('.asd-link').click(function(e) {
    e.preventDefault();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');
    
    $('.save-asd-datetime').data('siteid', siteId);
    $('.save-asd-datetime').data('atmid', atmid);
    
  });



    $('.save-esd-datetime').click(function() {
    var esdDatetime = $(this).closest('.modal-content').find('.esd-datetime-input').val();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');

    $.ajax({
  url: 'saveEsdAsd.php',
  type: 'POST',
  data: {
    'siteId': siteId,
    'datetime': esdDatetime,
    'atmid': atmid,
    'type': 'ESD' // Specify the type as ASD
  },
  success: function(response) {
    console.log(response)

    var jsonResponse = JSON.parse(response);

    if (jsonResponse.statusCode == 200) {
      Swal.fire("Success", jsonResponse.response, "success");
      setTimeout(function() {
        location.reload();
      }, 3000);
    } else if (jsonResponse.statusCode == 500) {
      Swal.fire("Error", jsonResponse.response, "error");
      // location.reload();
    } else {
      console.log(jsonResponse);
    }

  },
  error: function(xhr, status, error) {
    console.error(error);
  }
});
  });





  $('.save-asd-datetime').click(function() {
    var asdDatetime = $(this).closest('.modal-content').find('.asd-datetime-input').val();
    var siteId = $(this).data('siteid');
    var atmid = $(this).data('atmid');

    $.ajax({
  url: 'saveEsdAsd.php',
  type: 'POST',
  data: {
    'siteId': siteId,
    'datetime': asdDatetime,
    'atmid': atmid,
    'type': 'ASD' // Specify the type as ASD
  },
  success: function(response) {

    var jsonResponse = JSON.parse(response);

    if (jsonResponse.statusCode == 200) {
      Swal.fire("Success", jsonResponse.response, "success");
      setTimeout(function() {
        location.reload();
      }, 3000);
    } else if (jsonResponse.statusCode == 500) {
      Swal.fire("Error", jsonResponse.response, "error");
      // location.reload();
    } else {
      console.log(jsonResponse);
    }

  },
  error: function(xhr, status, error) {
    console.error(error);
  }
});
  });




});
</script>


<script src="../../assets/vendors/js/vendor.bundle.base.js"></script>

<? include('../footer.php'); ?>


                        
                        
                        
                        
                    
                    



<script src="../datatable/jquery.dataTables.js"></script>
<script src="../datatable/dataTables.bootstrap.js"></script>
<script src="../datatable/dataTables.buttons.min.js"></script>
<script src="../datatable/buttons.flash.min.js"></script>
<script src="../datatable/jszip.min.js"></script>

<script src="../datatable/pdfmake.min.js"></script>
<script src="../datatable/vfs_fonts.js"></script>
<script src="../datatable/buttons.html5.min.js"></script>
<script src="../datatable/buttons.print.min.js"></script>
<script src="../datatable/jquery-datatable.js"></script>
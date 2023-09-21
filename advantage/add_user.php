<? include('header.php'); ?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function disable(id){

        Swal.fire({
              title: 'Are you sure?',
              text: "Think twice to revert this!",
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, Proceed it!'
            }).then((result) => {
              if (result.isConfirmed) {
                
                   jQuery.ajax({
                            type: "POST",
                            url: 'disable_user.php',
                           data: 'id='+id,
                                success:function(msg) {
                                    
                                    if(msg==1){
                                            Swal.fire(
                                              'Updated!',
                                              'Status has been changed.',
                                              'success'
                                            );
                                            
                                            setTimeout(function(){ 
                                        window.location.reload();
                                    }, 2000);
                                    
                                    }else if(msg==0 || msg==2){
                                        
                                        Swal.fire(
                                         'Cancelled',
                                          'Your imaginary file is safe :)',
                                          'error'
                                            );
                                            
                                            
            
                                    }
                                    
                                }
                   });
            
            
              }
            })

    }
</script>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_add_user.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Name</label>
                                                    <input type="text" name="name" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Email / userid</label>
                                                    <input type="email" name="uname" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Password</label>
                                                    <input type="password" name="pwd" class="form-control">
                                                </div>
                                                
                                                <div class="col-sm-3">
                                                    <label>Contact</label>
                                                    <input type="number" id="contact" name="contact" class="form-control" onkeypress="return validInput(event);" >
                                                </div>
    
                                                <div class="col-sm-12">
                                                    <label>Role</label>
                                                    <select class="form-control" name="role" required>
                                                        <option value="">Select</option>
                                                        <option value="1">Admin</option>
                                                        <option value="2">Project Executive</option>
                                                        <option value="5">Bank Executive</option>
                                                        <option value="6">LHO</option>
                                                        
                                                    </select>
                                                </div>

                                            </div>
                                            
                                            
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <br>
                                                    <input type="submit" name="submit" class="btn btn-danger">
                                                </div>                                                
                                            </div>

                                        </form>
                                        
                                        
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Users</h5>
                                    </div>
                                    <div class="card-body" style="overflow:auto;">
                                        <table id="example" class="table table-hover table-styling" style="width:100%">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>User ID</th>

                                                    <th>Name</th>
                                                    <th>Desgination</th>
                                                    <th>Username</th>
                                                    <th>Contact No.</th>
                                                    <th>Status</th>
                                                    <th>action</th>
                                                    <th>Active / Inactive </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from mis_loginusers");
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

                                                        <td style="text-transform: initial;"><? echo $sql_result['contact']; ?></td>
                                                        <td class="<? echo $status_class; ?>"><? echo $user_status;?></td>
                                                        <td>
                                                            <!--<a class="btn btn-danger" href="allot_perm.php?id=<? echo $sql_result['id']; ?>">Permission</a>-->
                                                            <a class="btn btn-warning" href="allotmenu_perm.php?id=<? echo $sql_result['id'];  ?>">Menu Permission</a>
                                                        </td>
                                                        <td><a href="#" class="btn btn-danger" onclick="disable(<? echo $sql_result['id']; ?>)"><? echo $makeuser_status;?></a></td>
                                                        <!--<td>-->
                                                        <!--    <a href="edit_designation.php?id=<? echo $sql_result['id']; ?>"><input type="submit" name="edit" id="edit" class="btn btn-warning" value="Edit"></a>-->
                                                        <!--</td>-->

                                                    </tr>    
                                                <? $i++; }?>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                
                                                                
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Bank Executives</h5>
                                    </div>
                                    <div class="card-body" style="overflow:auto;">
                                        <table id="example" class="table table-hover table-styling" style="width:100%">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>#</th>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Desgination</th>
                                                    <th>Username</th>
                                                    <th>Contact No.</th>
                                                    <th>Status</th>
                                                    <th>action</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                $i= 1; 
                                                $sql = mysqli_query($con,"select * from vendorUsers where level=5");
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
                                                  
                                                  $designation = 'Bank Executive';
                                                  

                                                  $desgination = $sql_result['designation']; 
                                                ?>
                                                    <tr>
                                                        <td><? echo $i; ?></td>
                                                        <td><? echo $sql_result['id']; ?></td>
                                                        <td><? echo $sql_result['name']; ?></td>
                                                        <td><? echo $designation; ?></td>
                                                        <td style="text-transform: initial;"><? echo $sql_result['uname']; ?></td>

                                                        <td style="text-transform: initial;"><? echo $sql_result['contact']; ?></td>
                                                        <td class="<? echo $status_class; ?>"><? echo $user_status;?></td>
                                                        <td>
                                                            <a class="btn btn-warning" href="allotmenu_perm_bank.php?id=<? echo $sql_result['id'];?>&level=<?= $level; ?>">Menu Permission</a>
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
                    
                    
    <? include('footer.php'); ?>
<script>
function validInput(e) {
  e = (e) ? e : window.event;
  a = document.getElementById('contact');
  cPress = (e.which) ? e.which : e.keyCode;

  if (cPress > 31 && (cPress < 48 || cPress > 57)) {
    return false;
  } else if (a.value.length >= 10) {
    return false;
  }

  return true;
}

$(document).ready(function(){
  // Attach the event handler to the checkbox
  $('.serviceExecutive').change(function(){
    if($(this).is(':checked')){
      // Checkbox is checked
      console.log('Checkbox checked');
    } else {
      // Checkbox is unchecked
      console.log('Checkbox unchecked');
    }
  });
});



  $('.serviceExecutive').change(function(){
      
      let id = $(this).val();
  
    if($(this).is(':checked')){
        
        $.ajax({
              url: 'serviceExecutive.php',
              type : 'POST',
              data : "userid="+id+"&type=1",
              success: function(data) {
                console.log(data);
              }
        });
  
  
    } else {
      $.ajax({
              url: 'serviceExecutive.php',
              type: 'POST',
              data : "userid="+id+"&type=0",
              success: function(data) {
                console.log(data);
              }
        });
    }
  });
  


</script>

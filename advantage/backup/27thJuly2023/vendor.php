<? include('header.php'); ?>
<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<link rel="stylesheet" type="text/css" href="../datatable/dataTables.bootstrap.css">
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        <form action="process_vendor.php" method="POST">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>vendor Name</label>
                                                    <input type="text" name="vendorName" class="form-control">
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
                                    <div class="card-body" style="overflow:auto;">

                                        <table id="example" class="table table-bordered table-striped table-hover dataTable js-exportable no-footer" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Vendor Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i = 1;
                                                $sql = mysqli_query($con, "select * from vendor where status=1 order by id asc");
                                                while ($sql_result = mysqli_fetch_assoc($sql)) {
                                                    $id = $sql_result['id'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $sql_result['vendorName']; ?></td>
                                                        <td>
                                                            <a href="#" class="btn btn-success createVendorUserLink" data-vendorid="<?php echo $id; ?>">Create Vendor User</a>
                                                            | 
                                                            <a class="btn btn-primary" href="viewVendorUser.php?vendor=<? echo $id; ?>">View Users</a>
                                                            </td>
                                                        
                                                    </tr>
                                                <?php $i++;
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
                    

<!-- Modal for Create Vendor User -->
<div class="modal fade" id="createVendorUserModal" tabindex="-1" role="dialog" aria-labelledby="createVendorUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createVendorUserModalLabel">Create Vendor User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="createVendorUserForm">
          <div class="row">
            <div class="col-sm-3">
              <label>Name</label>
              <input type="text" name="name" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Email / Username</label>
              <input type="email" name="uname" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Password</label>
              <input type="password" name="pwd" class="form-control">
            </div>
            <div class="col-sm-3">
              <label>Contact</label>
              <input type="number" id="contact" name="contact" class="form-control" onkeypress="return validInput(event);">
            </div>
            <div class="col-sm-12">
              <label>Role</label>
              <select class="form-control" name="role" required="">
                <option value="">Select</option>
                <option value="1">Admin</option>
                <option value="2">Project Executive</option>
                <option value="3">Engineer</option>
              </select>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveVendorUser" data-vendorid="">Save</button>
      </div>
    </div>
  </div>
</div>

                
                    
<script>

function validInput(event) {
  // Add your validation logic here
  // For example, if you want to allow only numeric input:
  var charCode = (event.which) ? event.which : event.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode > 57)) {
    return false;
  }
  return true;
}

    
$(document).ready(function() {


  // Create Vendor User link click event
  $('.createVendorUserLink').click(function(e) {
    e.preventDefault();
    var vendorId = $(this).data('vendorid');
    $('#createVendorUserModal').modal('show');
    $('#saveVendorUser').data('vendorid', vendorId);
  });

  // Save Vendor User click event
// Save Vendor User click event
$('#saveVendorUser').click(function() {
  var vendorId = $(this).data('vendorid');
  var formData = $('#createVendorUserForm').serialize();

  // Make AJAX call to save vendor user data
  $.ajax({
    url: 'API/saveVendorUsers.php',
    type: 'POST',
    data: formData + '&vendorId=' + vendorId,
    success: function(response) {
      console.log(response);

      if (response.statusCode === 200) {
        Swal.fire({
          title: 'Success',
          text: response.response,
          icon: 'success',
        });
        $('#createVendorUserModal').modal('hide');
      } else {
        Swal.fire({
          title: 'Error',
          text: response.response,
          icon: 'error',
        });
      }
    },
    error: function(xhr, status, error) {
      // Handle the error case
      console.error(error);
      Swal.fire({
        title: 'Error',
        text: 'An error occurred. Please try again.',
        icon: 'error',
      });
      // TODO: Handle the error case
    }
  });
});

});



</script>
                    
<? include('footer.php'); ?>
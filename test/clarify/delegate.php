<? session_start();
include('config.php');

if($_SESSION['username']){ 

include('header.php');
?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        <?
                                        $atmid = $_REQUEST['atmid'];
                                        $id = $_REQUEST['id'];
                                        $action = $_REQUEST['action'];
                                        ?>
                                        <h4>Delegate : <? echo $atmid ; ?></h4>
                                        <hr>
                                        <form id="myForm" enctype="multipart/form-data">
                                        <!--<form action="process_delegate.php" method="POST">-->
                                            <input type="hidden" name="atmid" value="<? echo $atmid ; ?>" />
                                            <input type="hidden" name="siteid" value="<? echo $id ; ?>" />
                                            <input type="hidden" name="action" value="<? echo $action ; ?>" />
                                            
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label>Engineer</label>

                                                    <select name="engineer" class="form-control" required>
                                                        <option value="">Select</option>
                                                        <?
                                                        $sql = mysqli_query($con,"select * from vendorUsers where user_status=1 and vendorId='".$RailTailVendorID."' and level=3");
                                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                                        $engineerid = $sql_result['id'];
                                                        $name = $sql_result['name'];
                                                        ?>
                                                        <option value="<? echo $engineerid; ?>">
                                                            <? echo $name; ?>
                                                        </option>
                                                            
                                                            
                                                        <? } ?>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <br>
                                                    <button type="submit" class="btn btn-success" onclick="saveForm()">Save</button>
                                                    <!--<input type="submit" name="submit" class="btn btn-primary"  /> -->
                                                </div>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
              
              
              <script>
                  function saveForm() {
    event.preventDefault();
    var formData = new FormData($('#myForm')[0]);
    var requiredFields = $('#myForm :required');
    var emptyFields = [];

    // Check for empty required fields
    requiredFields.each(function() {
        if ($(this).val() === '') {
            emptyFields.push($(this).attr('name'));
        }
    });

    if (emptyFields.length > 0) {
        swal("Error", "Please fill in all the required fields!", "error");
        $('input, select').removeClass('highlight');
        $.each(emptyFields, function(index, fieldName) {
            $('[name="' + fieldName + '"]').addClass('highlight');
        });
        return; // Exit the function if empty fields exist
    }

        $.ajax({
            url: 'process_delegate.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
                if (response == 200) {
                    swal("Success", "Delegated Successfully!", "success");
                    setTimeout(function() {
                        // window.location.href = "allLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else if (response == 202) {
                    // swal("Success", "Re-Delegated Successfully!", "success");
                    setTimeout(function() {
                        window.location.href = "allLeads.php";
                    }, 3000); // Redirect after 3 seconds
                } else {
                    alert('Added Error!');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Added Error!');
            }
        });

}

              </script>      
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>

</body>

</html>
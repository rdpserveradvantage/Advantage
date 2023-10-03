<? include('header.php'); ?>


<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-block" style="overflow: auto;">
                            <div id="tableWrapper">
                                <div id="lockedData"></div>    
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>






<script>
function refreshTable() {
    $.ajax({
        type: 'GET',
        url: 'getLockedIPs.php', // Replace with the URL of your data source
        success: function (data) {
            // Replace the table body with the new data
            $('#lockedData').html(data);

            // Destroy the previous DataTable instance (if exists)
            if ($.fn.DataTable.isDataTable('#example')) {
                $('#example').DataTable().destroy();
            }

            // Initialize DataTable with exportable buttons
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

setInterval(refreshTable, 5000);

    function confirmUnbind() {
        // Retrieve the ID from the hidden input field in the modal
        var ipID = document.getElementById("unbindItemId").value;

        $.ajax({
            type: "POST",
            url: "manualUnlockIP.php",
            data: 'ipID=' + ipID,
            success: function (response) {
                console.log(response)
                if (response == 1) {
                    // Success: Display a success SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Unlock Successful',
                        text: 'The IP has been successfully unlocked.',
                    });
                } else {
                    // Not successful: Display an error SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Unlock Failed',
                        text: 'Sorry, there was an error unlocking the IP.',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        $('#unbindModal').modal('hide');
    }


</script>




<script>
    $(document).ready(function () {
        // Function to update countdown timers
        function updateCountdownTimers() {
            $('.countdown').each(function () {
                var timerText = $(this).text();
                var parts = timerText.split(' ');
                var minutes = parseInt(parts[0]);
                var seconds = parseInt(parts[2]);
                if (seconds === 0 && minutes === 0) {
                    // Timer has reached 0, you can handle this case if needed
                } else if (seconds === 0) {
                    // Decrease minutes and reset seconds
                    minutes--;
                    seconds = 59;
                } else {
                    // Decrease seconds
                    seconds--;
                }
                // Update the timer display
                $(this).text(minutes + ' minute ' + seconds + ' second');
            });
        }

        // Call the updateCountdownTimers function every second
        setInterval(updateCountdownTimers, 1000); // 1000 milliseconds = 1 second
    });
</script>

<? include('footer.php'); ?>


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
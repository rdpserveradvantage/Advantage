<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                        
                                <!-- admin_task_assignment.html -->
<form id="taskAssignmentForm" action="assign_task.php" method="post">
    <label for="taskName">Task Name:</label>
    <input type="text" id="taskName" name="taskName" required>

    <!-- Other task details inputs -->

    <label for="vendorId">Assign To Vendor:</label>
    <select id="vendorId" name="vendorId" required>
        <option value="1">Vendor 1</option>
        <option value="2">Vendor 2</option>
        <!-- Add more vendors as needed -->
    </select>

    <button type="submit">Assign Task</button>
</form>




<script>
    document.getElementById('taskAssignmentForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const taskNameInput = document.getElementById('taskName');
        const vendorIdInput = document.getElementById('vendorId');

        // Perform simple form validation
        if (taskNameInput.value.trim() === '') {
            alert('Task Name is required.');
            return;
        }

        if (vendorIdInput.value === '') {
            alert('Please select a vendor.');
            return;
        }

        // If form validation passes, submit the form
        this.submit();
    });
</script>

        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
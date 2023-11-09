<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dynamic Column Visibility</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Table with Dynamic Column Visibility</h1>
        
                <!-- Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Column 1</th>
                    <th>Column 2</th>
                    <th>Sr no</th>
                    <th>Column 4</th>
                    <th>Column 5</th>
                    <th>Column 6</th>
                </tr>
            </thead>
            <tbody>
                <!-- Your table data goes here -->
            </tbody>
        </table>
    </div>

    <!-- Add Bootstrap Modal -->
    <div class="modal fade" id="columnModal" tabindex="-1" role="dialog" aria-labelledby="columnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!--<h5 class="modal-title" id="columnModalLabel">Customize Column Visibility</h5>-->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="columnForm">
                        <div class="form-group">
                            <!-- Column checkboxes will be generated here -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveColumnVisibility">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap and jQuery scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
         $(document).ready(function() {
            // Initialize Bootstrap modal
            $('#columnModal').modal({ backdrop: 'static', keyboard: false, show: false });
            const table = $('table');
            function createColumnModal() {
                const customizeButton = $('<button type="button" class="btn btn-primary" id="customizeColumnsButton">Customize Column Visibility</button>');
                customizeButton.click(function() {
                    const form = $('#columnForm');
                    form.empty();
                    table.find('thead th').each(function(index) {
                        const columnTitle = $(this).text();
                        const columnCheckbox = $(`<div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck${index + 1}" data-column="${index + 1}" checked>
                            <label class="custom-control-label" for="customCheck${index + 1}">${columnTitle}</label>
                        </div>`);
                        form.append(columnCheckbox);
                    });
                    $('#columnModal').modal('show');
                });
                $('.container').prepend(customizeButton);
            }

            // Function to load user preferences from the database
            function loadUserPreferences() {
                $.ajax({
                    url: 'demo3.php', // Replace with the actual URL to fetch user preferences
                    method: 'GET',
                    data: { tableId: 'view_site' }, // Pass the table ID to retrieve user preferences
                    success: function(response) {
                        const selectedColumns = response.split(',');

                        // Update the checkboxes based on the retrieved preferences
                        $('input[type=checkbox]', '#columnForm').each(function() {
                            const column = $(this).data('column');
                            const isVisible = selectedColumns.includes(column.toString());
                            $(this).prop('checked', isVisible);

                            if (isVisible) {
                                // Show the column
                                $('th, td', `table tr td:nth-child(${column})`).show();
                            } else {
                                // Hide the column
                                $('th, td', `table tr td:nth-child(${column})`).hide();
                            }
                        });
                    },
                    error: function() {
                        console.log('Error loading user preferences.');
                    }
                });
            }

            // Call the function to create the column customization modal
            createColumnModal();

            // Load and apply user preferences
            loadUserPreferences();

            // Event handler for showing the modal
            $('#columnModal').on('show.bs.modal', function() {
                // Reset the form to the previous state
                $('input[type=checkbox]', '#columnForm').each(function() {
                    const column = $(this).data('column');
                    const isVisible = $(`th, td`, `table tr td:nth-child(${column})`).is(':visible');
                    $(this).prop('checked', isVisible);
                });
            });

            $('#saveColumnVisibility').click(function() {
                const selectedColumns = [];
                $('input[type=checkbox]:checked', '#columnForm').each(function() {
                    selectedColumns.push($(this).data('column'));
                });

                // Save the user's column preferences using AJAX
                $.ajax({
                    url: 'demo2.php', // Replace with the actual URL to save preferences
                    method: 'POST',
                    data: {
                        tableId: 'view_site', // Pass the table ID for the user's preferences
                        selectedColumns: selectedColumns.join(',')
                    },
                    success: function(response) {
                        console.log(response);
                    },
                    error: function() {
                        console.log('Error saving user preferences.');
                    }
                });
                $('#columnModal').modal('hide');
            });
        });
    </script>
</body>
</html>



<? return; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Column Selection</title>
</head>

<body>
    <button id="openModalBtn">Select Columns</button>

    <table id="data-table">
        <thead>
            <tr>
                <th>ATMID</th>
                <th>DELEGATION</th>
                <th>DELEGATED TO</th>
                <th>HISTORY</th>
                <th>CURRENT STATUS</th>
                <!-- Add more column headers here -->
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Delegation 1</td>
                <td>Delegated To 1</td>
                <td>History 1</td>
                <td>Status 1</td>
                <!-- Add more data rows here -->
            </tr>
            <tr>
                <td>2</td>
                <td>Delegation 2</td>
                <td>Delegated To 2</td>
                <td>History 2</td>
                <td>Status 2</td>
                <!-- Add more data rows here -->
            </tr>
            <!-- Add more data rows here -->
        </tbody>
    </table>


    <div id="columnSelectionModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModalBtn">&times;</span>
            <h2>Select Columns to Display</h2>
            <form id="columnSelectionForm">
                <!-- Populate this form dynamically with checkboxes -->
            </form>
            <button id="applyColumnsBtn">Apply</button>
        </div>
    </div>
    <script>
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modal = document.getElementById('columnSelectionModal');
        const columnSelectionForm = document.getElementById('columnSelectionForm');
        const applyColumnsBtn = document.getElementById('applyColumnsBtn');

        // Sample column names
        const columnNames = [
            "ATMID", "DELEGATION", "DELEGATED TO", "HISTORY", "CURRENT STATUS",
            // Add more column names here
        ];

        // Map column names to their corresponding table indexes
        const columnIndexes = {};

        // Function to initialize column indexes
        function initColumnIndexes() {
            const headers = document.querySelectorAll('#data-table th');
            headers.forEach((header, index) => {
                columnIndexes[header.textContent.trim()] = index;
            });
        }

        // Function to toggle column visibility
        function toggleColumnVisibility(columnName, isVisible) {
            const columnIndex = columnIndexes[columnName];
            if (columnIndex !== undefined) {
                const header = document.querySelectorAll('#data-table th')[columnIndex];
                const cells = document.querySelectorAll('#data-table td:nth-child(' + (columnIndex + 1) + ')');

                header.style.display = isVisible ? 'table-cell' : 'none';
                cells.forEach((cell) => {
                    cell.style.display = isVisible ? 'table-cell' : 'none';
                });
            }
        }

        // Function to update checkbox states based on column visibility
        function updateCheckboxStates() {
            const checkboxes = columnSelectionForm.querySelectorAll('input[name="columns[]"]');
            checkboxes.forEach((checkbox) => {
                const columnName = checkbox.value;
                const columnIndex = columnIndexes[columnName];
                const header = document.querySelectorAll('#data-table th')[columnIndex];
                checkbox.checked = header.style.display !== 'none';
            });
        }

        // Function to dynamically create checkboxes
        function createCheckboxes() {
            // Clear existing checkboxes
            columnSelectionForm.innerHTML = '';

            columnNames.forEach((columnName) => {
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'columns[]';
                checkbox.value = columnName;
                checkbox.checked = true; // By default, all columns are checked
                const label = document.createElement('label');
                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(columnName));
                columnSelectionForm.appendChild(label);
            });
        }

        // Open or close the modal
        openModalBtn.addEventListener('click', () => {
            createCheckboxes();
            updateCheckboxStates(); // Update checkbox states based on column visibility
            modal.style.display = 'block';
        });

        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Apply selected columns
        applyColumnsBtn.addEventListener('click', () => {
            const selectedColumns = Array.from(columnSelectionForm.querySelectorAll('input[name="columns[]"]:checked'))
                .map((checkbox) => checkbox.value);

            // Update table columns visibility
            columnNames.forEach((columnName) => {
                const isVisible = selectedColumns.includes(columnName);
                toggleColumnVisibility(columnName, isVisible);
            });

            modal.style.display = 'none';
        });

        // When the user clicks outside the modal, close it
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Initialize column indexes when the page loads
        window.addEventListener('load', initColumnIndexes);


        function updateTableColumns(selectedColumns) {
            const tableHeaders = document.querySelectorAll('#data-table th');
            const tableCells = document.querySelectorAll('#data-table td');


            tableHeaders.forEach((header) => {
                if (selectedColumns.includes(header.textContent.trim())) {
                    header.style.display = 'table-cell';
                } else {
                    header.style.display = 'none';
                }
            });

            tableCells.forEach((cell) => {
                if (selectedColumns.includes(cell.parentElement.querySelector('th').textContent.trim())) {
                    cell.style.display = 'table-cell';
                } else {
                    cell.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
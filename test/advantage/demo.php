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
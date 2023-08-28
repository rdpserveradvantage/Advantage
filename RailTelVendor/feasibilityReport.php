<?php include('header.php'); 

        $atmid = $_REQUEST['atmid'];
                                
?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text">Feasibility Report for ATMID : <span style="color:red;display: inline-block;"><? echo $atmid ; ?></span></h5>
                                </div>
                                <div class="card-block accordion-block">
                                    <div id="accordion" role="tablist" aria-multiselectable="true">
                                        <?php
                                
                                        $query = "SELECT * FROM feasibilityCheck where ATMID1='".$atmid."'";

                                        $result = $con->query($query);

                                        if ($result->num_rows > 0) {
                                            $i=1 ; 
                                            while ($row = $result->fetch_assoc()) {
                                                $isVendor = $row['isVendor'];

                                                    $baseurl = 'https://sarmicrosystems.in/project/API/';
                                                
                                                echo '<div class="accordion-panel">';
                                                echo '<div class="accordion-heading" role="tab" id="heading' . $i . '">';
                                                echo '<h3 class="card-title accordion-title">';
                                                echo '<a class="accordion-msg" data-toggle="collapse" data-parent="#accordion" href="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">';
                                                echo 'Feasibility Check ' . $i;
                                                echo '</a>';
                                                echo '</h3>';
                                                echo '</div>';
                                                echo '<div id="collapse' . $i . '" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading' . $i . '">';
                                                echo '<div class="accordion-content accordion-desc">';
                                                
                                                echo '<table class="table">';
                                                foreach ($row as $column => $value) {
                                                    echo '<tr>';
                                                    echo '<th>' . formatColumnName($column) . '</th>';
                                                    
                                                    // Check if the column name ends with "Snap" and contains an image URL-like value
                                                    if (substr($column, -4) === 'Snap' || substr($column, -5) === 'Snap2') {
                                                        echo '<td><a href="' . $baseurl.$value . '" target="_blank">View Image</a></td>';
                                                    } else {
                                                        echo '<td>' . $value . '</td>';
                                                    }
                                                    
                                                    echo '</tr>';
                                                }
                                                echo '</table>';
                                                
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';

                                                $i++ ; 
                                            }
                                        } else {
                                            echo "No records found.";
                                        }

                                        $con->close();
                                        ?>
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

<script type="text/javascript" src="files/assets/pages/accordion/accordion.js"></script>

<?php include('footer.php'); ?>

<?php
// Function to break down column name
function formatColumnName($columnName) {
    return implode(' ', preg_split('/(?=[A-Z])/', $columnName));
}
// Function to check if a URL-like value represents a valid image URL
function isValidImageUrl($url) {
    $url1 = 'https://sarmicrosystems.in/RailTailVendor/feasibiltyData/API/';
    $url2 = 'https://sarmicrosystems.in/advantages/feasibiltyData/API/';
    
    return (strpos($url, $url1) === 0 || strpos($url, $url2) === 0);
}

// Function to check if a URL-like value represents a valid image URL
// function isValidImageUrl($url) {
//     // Add your custom validation logic here
//     return filter_var($url, FILTER_VALIDATE_URL) !== false;
// }

?>

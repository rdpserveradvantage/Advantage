<? include('config.php');
    


echo '<div class="card">
    <div class="card-header">
            <h5>LHO Wise Open Calls</h5>
            <hr />
        </div>
    
        <div class="card-block">';

        // LHO wise open calls
$lhowiseSrno=1 ; 
$lhosql = mysqli_query($con,"select lho,count(1) as count from mis where status='open' group by lho order by lho asc");
if (mysqli_num_rows($lhosql) > 0) {


echo '
<table class="table table-hover table-styling table-xs">
    <thead>
        <tr class="table-primary">
            <th>Sr No</th>
            <th>ATMID</th>
            <th>Aging</th>
        <tr>
    <thead>
    <tbody>
    ';


while($lhosql_result = mysqli_fetch_assoc($lhosql)){
    echo "<tr>
            <td>{$lhowiseSrno}</td>
            <td>{$lhosql_result['lho']}</td>
            <td>{$lhosql_result['count']}</td>
        <tr>";
    $lhowiseSrno++;    
}




echo '
</tbody>
</table>';

} else{

    echo '
                                                
    <div class="noRecordsContainer">
        <img src="assets/no_records.jpg">
    </div>';

}


echo '
        </div>
    </div>
    ';
    



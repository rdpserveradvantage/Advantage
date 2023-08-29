<? include('config.php');



$query1 = "select count(1) as count from mis where status='open'";
$query2 = "select count(1) as count from mis where status='close'";
$query3 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1";
$queries = [$query1,$query2,$query3];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Open Calls","Total Close Calls",'Total Sites'
];

$links = [
    "#","#","#"
];

$icon = [
    "uil-list-ul",
    "uil-check-circle",
    "uil-users-alt",
    "uil-clock-eight",
];



 for ($i = 0; $i < count($titles); $i++) { ?>
 
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-primary-subtle text-primary rounded-circle font-size-18">
                                                        <i class="uil <?= $icon[$i]; ?> "></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-truncate text-muted">
                                                    <a href="<?= $links[$i]; ?>"><?= $titles[$i]; ?></a>
                                                </p>
                                                <h5 class="font-size-16 mb-0"><?= $results[$i]; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
<? } 
    



// todays ESD


// todays ASD


// high aging calls


echo '<div class="card">
        <div class="card-header">
            <h5>Calls with Max Aging</h5>
        </div>
    
        <div class="card-block" style="overflow:auto;">
        
    
        ';


echo '
<table class="table table-hover table-styling table-xs">
    <thead>
        <tr class="table-primary">
            <th>Sr No</th>
            <th>ATMID</th>
            <th>Ticket ID</th>
            <th>Created At</th>
            <th>Aging</th>
            <th>LHO</th>
            <th>City</th>
            <th>State</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
';
$agingCount=1 ; 
$highagingsql = mysqli_query($con,"select a.created_at,a.atmid,a.lho,a.state,a.city,a.location,b.ticket_id,b.id from mis a
INNER JOIN mis_details b on a.id=b.mis_id
where a.status='open' order by a.created_at asc limit 10 ");
while($highagingsql_result = mysqli_fetch_assoc($highagingsql)){


    $createdAtTimestamp = strtotime($highagingsql_result['created_at']);
    $currentTime = time();
    $agingInSeconds = $currentTime - $createdAtTimestamp;
    
    $days = floor($agingInSeconds / (60 * 60 * 24));
    $hours = floor(($agingInSeconds % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($agingInSeconds % (60 * 60)) / 60);
    $seconds = $agingInSeconds % 60;
    
    $agingFormatted = sprintf("%dd %02dh %02dm %02ds", $days, $hours, $minutes, $seconds);

    

    $ticket_id = $highagingsql_result['ticket_id'];
    $detail_id = $highagingsql_result['id'];


    echo "<tr>
        <td>{$agingCount}</td>
        <td>{$highagingsql_result['atmid']}</td>
        <td><a href=\"mis_details.php?id={$detail_id}\">{$ticket_id}</a></td>
        <td>{$highagingsql_result['created_at']}</td>
        <td>{$agingFormatted}</td>
        <td>{$highagingsql_result['lho']}</td>
        <td>{$highagingsql_result['city']}</td>
        <td>{$highagingsql_result['state']}</td>
        <td>{$highagingsql_result['location']}</td>
    </tr>";


    $agingCount++ ; 
}
echo '</tbody>
    </table>';

echo '
        </div>
    </div>
    ';
    


echo '<div class="card">
    <div class="card-header">
            <h5>LHO Wise Open Calls</h5>
            <hr />
        </div>
    
        <div class="card-block">';

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

// LHO wise open calls
$lhowiseSrno=1 ; 
$lhosql = mysqli_query($con,"select lho,count(1) as count from mis where status='open' group by lho order by lho asc");
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
</table>
        </div>
    </div>
    ';
    



    

    echo '<div class="card">
        <div class="card-header">
            <h5>Recent Open Calls</h5>
            <hr />
        </div>
    
        <div class="card-block" style="overflow:auto;">
        
    
        ';


echo '
<table class="table table-hover table-styling table-xs">
    <thead>
        <tr class="table-primary">
            <th>Sr No</th>
            <th>ATMID</th>
            <th>Ticket ID</th>
            <th>Created At</th>
            <th>Aging</th>
            <th>LHO</th>
            <th>City</th>
            <th>State</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
';
$agingCount=1 ; 
$highagingsql = mysqli_query($con,"select a.created_at,a.atmid,a.lho,a.state,a.city,a.location,b.ticket_id,b.id from mis a
INNER JOIN mis_details b on a.id=b.mis_id
where a.status='open' order by a.created_at desc limit 10 ");
while($highagingsql_result = mysqli_fetch_assoc($highagingsql)){
    
    $createdAtTimestamp = strtotime($highagingsql_result['created_at']);
    $currentTime = time();
    $agingInSeconds = $currentTime - $createdAtTimestamp;
    
    $days = floor($agingInSeconds / (60 * 60 * 24));
    $hours = floor(($agingInSeconds % (60 * 60 * 24)) / (60 * 60));
    $minutes = floor(($agingInSeconds % (60 * 60)) / 60);
    $seconds = $agingInSeconds % 60;
    
    $agingFormatted = sprintf("%dd %02dh %02dm %02ds", $days, $hours, $minutes, $seconds);



    $ticket_id = $highagingsql_result['ticket_id'];
    $detail_id = $highagingsql_result['id'];


    echo "<tr>
        <td>{$agingCount}</td>
        <td>{$highagingsql_result['atmid']}</td>
        <td><a href=\"mis_details.php?id={$detail_id}\">{$ticket_id}</a></td>
        <td>{$highagingsql_result['created_at']}</td>
        <td>{$agingFormatted}</td>

        <td>{$highagingsql_result['lho']}</td>
        <td>{$highagingsql_result['city']}</td>
        <td>{$highagingsql_result['state']}</td>
        <td>{$highagingsql_result['location']}</td>
    </tr>";


    $agingCount++ ; 
}
echo '</tbody>
    </table>';

echo '
        </div>
    </div>
    ';








?>
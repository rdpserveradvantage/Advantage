<?php include('config.php');

                                
if($assignedLho){
    $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and LHO like '".$assignedLho."'";
    $query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1 and LHO like '".$assignedLho."'";
    $query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1 and LHO like '".$assignedLho."'";
    $query5 = "SELECT COUNT(1) AS count FROM projectInstallation a inner join sites b on a.atmid = b.atmid where isDone=1 and LHO like '".$assignedLho."'";
    

}else{
    $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
    $query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1";
    $query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1";
    $query5 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1";    
}


// $queries = [$query1, $query2, $query3, $query4, $query5];
$queries = [$query1, $query2, $query3,  $query5];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Active Sites",
    "Total Sites Delegated",
    "Total Feasibility Done",
    // "Material Request Pending",
    "Total Installation Done"
];

$links = [
    "sitestest.php",
    "sitestest.php?isDelegated=1",
    "sitestest.php?isFeasibiltyDone=1",
    // "materialRequest.php",
    "completedInstallation.php"
];

$icon = [
    "uil-list-ul",
    "uil-check-circle",
    "uil-users-alt",
    "uil-clock-eight",
    // "bg-c-yellow"
];






 for ($i = 0; $i < count($titles); $i++) { ?>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar">
                                                    <div class="avatar-title rounded-circle font-size-18" style="background-color: #01a9ac !important;">
                                                        <i class="uil <?= $icon[$i]; ?> "></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-truncate text-muted">
                                                    <a href="<?= $links[$i]; ?>" style="font-size: 15px;color: #01a9ac !important;">
                                                        <?= $titles[$i]; ?>
                                                    </a>
                                                </p>
                                                        <h5 class="font-size-16 mb-0"><span class="count"><?= $results[$i] ; ?></span></h5>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<? } ?>
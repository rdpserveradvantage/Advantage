<? include('config.php');





$query1 = "select count(1) as count from mis where status='open'";
$query2 = "select count(1) as count from mis where status='close'";
$query3 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1";  
$query4 = "SELECT COUNT(1) AS count FROM mis where call_receive_from='Customer / Bank'";
$queries = [$query1, $query2, $query3, $query4];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Open Calls", "Total Close Calls", 'Total Sites', 'Total Calls from Bank'
];

$links = [
    "view_mis.php?status%5B0%5D=open&submit=1",
    "view_mis.php?status%5B0%5D=close&submit=1",
    "#", '#'
];

$icon = [
    "fas fa-list-ul",
    "fas fa-check",
    "fas fa-hand-holding-usd",
    "fas fa-piggy-bank",
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
                                                <p class="mb-1 text-truncate text-muted" style="color: #01a9ac !important;">
                                                    <a href="<?= $links[$i]; ?>" style="font-size: 15px;color: #01a9ac !important;"><?= $titles[$i]; ?></a>
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



?>
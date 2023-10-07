<?php include('config.php');

                                

    $query1 = "SELECT COUNT(1) AS count FROM inventory WHERE status in(0,1)";
    $query2 = "SELECT COUNT(1) AS count FROM inventory WHERE status = 0";
    $query3 = "SELECT COUNT(1) AS count FROM inventory WHERE status = 1 ";
    $query4 = "SELECT COUNT(1) AS count FROM material_send WHERE isDelivered = 0 ";


// $queries = [$query1, $query2, $query3, $query4, $query5];
$queries = [$query1, $query2, $query3,$query4];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Inventories",
    "Material Out",
    "On Hand",
    "In-Transit",
    // "Total Installation Done"
];

$links = [
    "#",
    "#?isDelegated=1",
    "#?isFeasibiltyDone=1",
    "#"
];

$icon = [
    "fas fa-warehouse",
    "uil-navigator",
    "fas fa-hand-holding-usd",
    "fas fa-shipping-fast",
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
                            
                            
<? } ?>

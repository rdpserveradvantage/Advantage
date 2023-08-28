<?php
include('config.php');

$query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
$query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1";
$query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1";
$query4 = "SELECT COUNT(DISTINCT siteid) AS count FROM material_requests WHERE status='pending' AND isProject=1";
$query5 = "SELECT COUNT(1) AS count FROM material_send";

$queries = [$query1, $query2, $query3, $query4, $query5];
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
    "Material Request Pending",
    "Total Material Sent"
];

$links = [
    "sitestest.php",
    "sitestest.php?isDelegated=1",
    "sitestest.php?isFeasibiltyDone=1",
    "materialRequest.php",
    "materialSent.php"
];

$colors = [
    "bg-c-yellow",
    "bg-c-green",
    "bg-c-pink",
    "bg-c-blue",
    "bg-c-yellow"
];
?>

<style>
    .align-items-center p {
        font-size: 12px;
    }
</style>

<?php for ($i = 0; $i < count($titles); $i++) { ?>
    <div class="col">
        <div class="card">
            <div class="card-block">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="text-<?php echo $colors[$i]; ?> f-w-600"><?php echo $results[$i]; ?></h4>
                        <p class="text-muted m-b-0"><?php echo $titles[$i]; ?></p>
                    </div>
                </div>
            </div>
            <div class="card-footer <?php echo $colors[$i]; ?>">
                <div class="row align-items-center">
                    <div class="col-9">
                        <a href="<?php echo $links[$i]; ?>"><p class="text-white m-b-0">View</p></a>
                    </div>
                    <div class="col-3 text-right">
                        <i class="feather icon-trending-up text-white f-16"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<? include('config.php');
$query1 = "select count(1) as count from mis where status='open'";
$query2 = "select count(1) as count from mis where status='close'";
$query3 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1";
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
    "#", "#", "#", '#'
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
                                                
                                                <h5 class="font-size-16 mb-0"><span class="clarifyCount">0</span></h5>
                                                <? $clarifyCount[] = $results[$i] ; ?>
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
<script>
    // Assuming you have received the updated count values in your AJAX response
    const updatedClarifyCounts = <?= json_encode($clarifyCount); ?>; // Replace with your actual updated counts

    // Select all elements with class "count"
    const countClarifyElements = document.querySelectorAll('.clarifyCount');

    // Update and animate the count values dynamically on page load and focus
    console.log('Event listener registered');

    window.addEventListener('load', function () {
        countClarifyElements.forEach((element, index) => {
            const startCount = parseFloat(element.textContent);
            const endCount = updatedClarifyCounts[index];
            const animationDuration = 4; // Animation duration in seconds (adjust as needed)
        console.log(`Updating element ${index}: startCount=${startCount}, endCount=${endCount}`);

            animateCount(endCount, animationDuration, element);
        });
    });

    window.addEventListener('focus', function () {
        countClarifyElements.forEach((element, index) => {
            const startCount = parseFloat(element.textContent);
            const endCount = updatedClarifyCounts[index];
            const animationDuration = 4; // Animation duration in seconds (adjust as needed)
        // console.log(`Updating element ${index}: startCount=${startCount}, endCount=${endCount}`);

            animateCount(endCount, animationDuration, element);
        });
    });
</script>


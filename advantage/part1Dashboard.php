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
                                                        <h5 class="font-size-16 mb-0"><span class="count">0</span></h5>

                                                <? $counts[] = $results[$i] ; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<? } ?>





<script>
    function animateCount(target, duration, countElement) {
        const start = 0;
        const increment = Math.floor(target / (duration * 1000 / 60)); // Calculate increment per frame

        let current = start;

        function updateCount() {
            current += increment;
            countElement.textContent = current;

            if (current < target) {
                requestAnimationFrame(updateCount);
            } else {
                countElement.textContent = target;
            }
        }

        updateCount();
    }

    // Assuming you have received the updated count values in your AJAX response
    const updatedCounts = <?= json_encode($counts); ?>; // Replace with your actual updated counts

    // Select all elements with class "count"
    const countElements = document.querySelectorAll('.count');

    // Update and animate the count values dynamically on page load and focus
    window.addEventListener('load', function () {
        countElements.forEach((element, index) => {
            const startCount = parseFloat(element.textContent);
            const endCount = updatedCounts[index];
            const animationDuration = 4; // Animation duration in seconds (adjust as needed)

            animateCount(endCount, animationDuration, element);
        });
    });

    window.addEventListener('focus', function () {
        countElements.forEach((element, index) => {
            const startCount = parseFloat(element.textContent);
            const endCount = updatedCounts[index];
            const animationDuration = 4; // Animation duration in seconds (adjust as needed)

            animateCount(endCount, animationDuration, element);
        });
    });
</script>

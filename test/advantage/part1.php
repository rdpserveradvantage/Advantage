<? include('header.php'); ?>

<link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css" type="text/css"></link>
<link rel="stylesheet" href="https://preview.pichforest.com/dashonic/layouts/assets/css/app.min.css" type="text/css"></link>
<!--<link rel="stylesheet" href="https://preview.pichforest.com/dashonic/layouts/assets/css/bootstrap.min.css" type="text/css"></link>     -->

     
     
<style>
.card-body{
    padding:.5rem;
}
.rounded-circle i{
    color:blue;
}
.font-size-16 {
    font-size: 16px!important;
}

.mb-0 {
    margin-bottom: 0!important;
}
.h5, h5 {
    font-size: 1.125rem;
}
.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-family: Roboto,sans-serif;
    font-weight: 500;
    line-height: 1.2;
    color: var(--bs-heading-color);
}
:root, [data-bs-theme=light]{
    --bs-primary-bg-subtle: #cde8f8;
}
         .avatar-sm {
    height: 2rem;
    width: 2rem;
}
.me-3 {
    margin-right: 1rem!important;
}

.flex-shrink-0 {
    -ms-flex-negative: 0!important;
    flex-shrink: 0!important;
}
.font-size-18 {
    font-size: 18px!important;
}

.avatar-title {
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    background-color: #038edc;
    color: #fff;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    font-weight: 500;
    height: 100%;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    width: 100%;
}
.rounded-circle {
    border-radius: 50%!important;
}
.bg-primary-subtle {
    background-color: var(--bs-primary-bg-subtle)!important;
}
.text-primary {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-primary-rgb),var(--bs-text-opacity))!important;
}
     </style>
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                
                                
                                                                <div class="row">
                                
<?                                
$query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
$query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1";
$query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1";
$query5 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1";

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
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                            
                            
<? } ?>
                        </div>                                    
                                      
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
    
    
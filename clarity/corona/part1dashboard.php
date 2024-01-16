

<?

if($assignedLho){
    $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and LHO like '".$assignedLho."'";
    $query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1 and LHO like '".$assignedLho."'";
    $query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1 and LHO like '".$assignedLho."'";
    $query5 = "SELECT COUNT(distinct a.atmid) AS count FROM projectInstallation a inner join sites b on a.atmid = b.atmid where isDone=1 and LHO like '".$assignedLho."' and a.status=1";
    

}else{
    $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
    $query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1";
    $query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1";
    $query5 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1";    
}



$queries = [$query1, $query2, $query3,  $query5];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}


var_dump($results);

?>
<div class="row">

<div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">

                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0"><?= $results[3] .' / '. $results[0]; ?></h3>
                          <p class="text-success ms-2 mb-0 font-weight-medium"></p>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Active / All </h6>
                  </div>
                </div>
              </div>
              
              
            </div>

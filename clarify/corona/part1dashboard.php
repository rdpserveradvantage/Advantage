<?php
if ($assignedLho) {
  $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and LHO like '" . $assignedLho . "'";
  $query2 = "SELECT COUNT(distinct a.atmid) AS count FROM projectInstallation a inner join sites b on a.atmid = b.atmid where isDone=1 and LHO like '" . $assignedLho . "' and a.status=1";

} else {
  $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1";
  $query2 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1";
}

$queries = [$query1, $query2];
$results = [];
foreach ($queries as $query) {
  $result = mysqli_query($con, $query);
  $count = mysqli_fetch_assoc($result)['count'];
  $results[] = $count;
}


?>
<div class="row">

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">
                <?= $results[1] . ' / ' . $results[0]; ?>
              </h3>
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
        <h2 class="mb-0">Sites</h3>
      </div>
    </div>


  </div>


  <?

  if ($assignedLho) {
    $query3 = "SELECT 
        COUNT(CASE WHEN ESD = CURDATE() THEN 1 END) AS ESD_Count,
        COUNT(CASE WHEN ASD = CURDATE() THEN 1 END) AS ASD_Count FROM
        sites WHERE (ESD = CURDATE() OR ASD = CURDATE()) AND LHO like '" . $assignedLho . "'";
  } else {
    $query3 = "SELECT COUNT(CASE WHEN ESD = CURDATE() THEN 1 END) AS ESD_Count,
  COUNT(CASE WHEN ASD = CURDATE() THEN 1 END) AS ASD_Count FROM
  sites WHERE (ESD = CURDATE() OR ASD = CURDATE()) AND status=1";
  }

  $sql = mysqli_query($con, $query3);
  $sql_result = mysqli_fetch_assoc($sql);
  ?>

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">
                <?= $sql_result['ESD_Count'] . ' / ' . $sql_result['ASD_Count']; ?>
              </h3>
              <p class="text-success ms-2 mb-0 font-weight-medium"></p>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success ">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">ESD / ASD </h6>
        <h3 class="mb-0">Todays Installation</h3>
      </div>
    </div>


  </div>




  <?
  $inv_sql = mysqli_query($con, "SELECT isDelivered,count(1) as total FROM `material_send` group by isDelivered");
  while ($inv_sql_result = mysqli_fetch_assoc($inv_sql)) {
    $isDelivered = $inv_sql_result['isDelivered'];

    $statusCount[] = $inv_sql_result['total'];
  }


  ?>

  <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-9">
            <div class="d-flex align-items-center align-self-start">
              <h3 class="mb-0">
                <?= $statusCount[0] . ' / ' . $statusCount[1]; ?>
              </h3>
              <p class="text-success ms-2 mb-0 font-weight-medium"></p>
            </div>
          </div>
          <div class="col-3">
            <div class="icon icon-box-success ">
              <span class="mdi mdi-arrow-top-right icon-item"></span>
            </div>
          </div>
        </div>
        <h6 class="text-muted font-weight-normal">In-transit / Delivered </h6>
        <h3 class="mb-0">Material</h3>
      </div>
    </div>


  </div>



</div>
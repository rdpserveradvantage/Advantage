<? include('../header.php'); ?>
<div class="row">
    <a href="sitestest.php">View Sites</a>
    <?
    $checkedIds = $_REQUEST['checkedIds'];
    $acceptance_type = $_REQUEST['acceptance_type'];

    foreach ($checkedIds as $key => $id) {

        if ($acceptance_type == 'lho') {
            $sql = mysqli_query($con, "select * from lhositesdelegation where id='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);
            $siteid = $sql_result['siteid'];
            $atmid = $sql_result['atmid'];
            $updateSql = "update lhositesdelegation set isPending=0, updated_at='" . $datetime . "', 
            updated_by='" . $userid . "' where id='" . $id . "'";

            if (mysqli_query($con, $updateSql)) {
                echo $atmid . ' Accepted Successfully ! <br />';
            } else {
                echo $atmid . ' Acceptance Error !<br />';
            }
        } else {
            $sql = mysqli_query($con, "select * from vendorsitesdelegation where id='" . $id . "'");
            $sql_result = mysqli_fetch_assoc($sql);
            $siteid = $sql_result['siteid'];
            $atmid = $sql_result['amtid'];
            $updateSql = "update vendorsitesdelegation set isPending=0, upated_at='" . $datetime . "', 
        updated_by='" . $userid . "' where id='" . $id . "'";

            if (mysqli_query($con, $updateSql)) {
                echo $atmid . ' Accepted Successfully ! <br />';
            } else {
                echo $atmid . ' Acceptance Error !<br />';
            }
        }

    }
    ?>
</div>
<? include('../footer.php'); ?>
<?php include('config.php');

$id = $_REQUEST['id'];

$sql = mysqli_query($con, "select * from trackingDetailsUpdate where materialSendId='" . $id . "' order by id desc");
if ($sqlResult = mysqli_fetch_assoc($sql)) {


?>


    <div class="card-block task-details">
        <table class="table table-border">
            <tbody>
                <tr>
                    <td>


                        ATMID:</td>
                    <td class="text-right">
                        <span class="f-right">
                            <a href="#"><?= $sqlResult['atmid']; ?> </a>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>


                        Challan Number:</td>
                    <td class="text-right"><?= $sqlResult['challanNumber']; ?></td>
                </tr>
                <tr>
                    <td>

                        Receivers Name
                    </td>
                    <td class="text-right"><?= $sqlResult['receiversName']; ?></td>
                </tr>
                <tr>
                    <td>


                        Receivers Number:</td>
                    <td class="text-right">
                        <?= $sqlResult['receiversNumber']; ?>
                    </td>
                </tr>
                <tr>
                    <td>


                        LR COPY:</td>
                    <td class="text-right">
                        <?
                        if ($sqlResult['lrCopyPath']) {
                        ?>
                            <a href="http://inventory.advantagesb.com/<?= $sqlResult['lrCopyPath']; ?>" target="_blank">
                                View
                            </a>
                        <?
                        } else {
                            echo 'No Data';
                        } ?>



                    </td>
                </tr>
                <tr>
                    <td>


                        Delivery Challan:</td>
                    <td class="text-right">
                    <?
                        if ($sqlResult['deliveryChallanPath']) {
                        ?>
                            <a href="http://inventory.advantagesb.com/<?= $sqlResult['deliveryChallanPath']; ?>" target="_blank">
                                View
                            </a>
                        <?
                        } else {
                            echo 'No Data';
                        } ?>

                    </td>
                </tr>
                <tr>
                    <td>


                        Updated At:</td>
                    <td class="text-right"><?= $sqlResult['created_at']; ?></td>
                </tr>
            </tbody>
        </table>
    </div>

<?



}


?>
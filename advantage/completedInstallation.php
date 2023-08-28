<? include('header.php'); ?>

     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block overflow_auto">
                                        
                                        <table class="table table-hover table-styling table-xs">
                                            <thead>
                                                <tr class="table-primary">
                                                    <th>Sr No</th>
                                                    <th>atmid</th>
                                                    <th>created_at</th>
                                                    <th>created_by</th>
                                                    <th>remark</th>
                                                    <th>vendor</th>
                                                    <th>scheduleAtmEngineerName</th>
                                                    <th>scheduleAtmEngineerNumber</th>
                                                    <th>bankPersonName</th>
                                                    <th>bankPersonNumber</th>
                                                    <th>backRoomKeyPersonName</th>
                                                    <th>backRoomKeyPersonNumber</th>
                                                    <th>scheduleDate</th>
                                                    <th>scheduleTime</th>
                                                    <th>sbiTicketId</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                

                                        <?
                                        $counter=1 ; 
                                        $sql = mysqli_query($con,"select * from projectInstallation where isDone=1 and status=1 order by id desc");
                                        while($sql_result = mysqli_fetch_assoc($sql)){
                                            $siteid = $sql_result['siteid'];
                                            $atmid = $sql_result['atmid'];
                                            $status = $sql_result['status'];
                                            $created_at = $sql_result['created_at'];
                                            $created_by = $sql_result['created_by'];
                                            $isDone = $sql_result['isDone'];
                                            $remark = $sql_result['remark'];
                                            $vendor = $sql_result['vendor'];
                                            $portal = $sql_result['portal'];
                                            $isSentToEngineer = $sql_result['isSentToEngineer'];
                                            $scheduleAtmEngineerName = $sql_result['scheduleAtmEngineerName'];
                                            $scheduleAtmEngineerNumber = $sql_result['scheduleAtmEngineerNumber'];
                                            $bankPersonName = $sql_result['bankPersonName'];
                                            $bankPersonNumber = $sql_result['bankPersonNumber'];
                                            $backRoomKeyPersonName = $sql_result['backRoomKeyPersonName'];
                                            $backRoomKeyPersonNumber = $sql_result['backRoomKeyPersonNumber'];
                                            $scheduleDate = $sql_result['scheduleDate'];
                                            $scheduleTime = $sql_result['scheduleTime'];
                                            $sbiTicketId = $sql_result['sbiTicketId'];



                                            
                                         ?>
                                         
                                                <tr>
                                                    <td><?= $counter ;?></td>
                                                    
                                                    <td class="strong">
                                                        <a href="installationInfo.php?siteid=<?= $siteid; ?>&atmid=<?= $atmid; ?>">
                                                            <?= $atmid; ?>
                                                        </a>
                                                    </td>
                                                    <td><?= $created_at; ?></td>
                                                    <td><?= getUsername($created_by,true); ?></td>
                                                    <td><?= $remark; ?></td>
                                                    <td><?= getVendorName($vendor); ?></td>
                                                    <td><?= $scheduleAtmEngineerName; ?></td>
                                                    <td><?= $scheduleAtmEngineerNumber; ?></td>
                                                    <td><?= $bankPersonName; ?></td>
                                                    <td><?= $bankPersonNumber; ?></td>
                                                    <td><?= $backRoomKeyPersonName; ?></td>
                                                    <td><?= $backRoomKeyPersonNumber; ?></td>
                                                    <td><?= $scheduleDate; ?></td>
                                                    <td><?= $scheduleTime; ?></td>
                                                    <td><?= $sbiTicketId; ?></td>


                                                </tr>
                                         
                                         <?
                                         $counter++ ;   
                                        }
                                        
                                        ?>
                                        
                                            </tbody>
                                        </table>
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
                    
                    
    <? include('footer.php'); ?>
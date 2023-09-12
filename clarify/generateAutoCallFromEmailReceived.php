<? include('config.php');


$atmid = $_REQUEST['atmid'];
$siteAddress = $_REQUEST['siteAddress'];
$city = $_REQUEST['city'];
$circle = $_REQUEST['circle'];
$linkVendor = $_REQUEST['linkVendor'];
$atmIP = $_REQUEST['atmIP'];

// $atmid = 'S10A000393004';


if ($atmid) {
    $sql = mysqli_query($con, "select * from sites where atmid='" . trim($atmid) . "'");

    if ($sql_result = mysqli_fetch_assoc($sql)) {

        $customer = strtoupper($sql_result['customer']);
        $bank = $sql_result['bank'];
        $location = $sql_result['address'];
        $state = $sql_result['state'];
        $region = $sql_result['zone'];
        $bm = $sql_result['bm_name'];
        $branch = $sql_result['branch'];
        $city = $sql_result['city'];
        $eng_user_id = $sql_result['engineer_user_id'];
        $lho = $sql_result['LHO'];
        $engname = mysqli_query($con, "select name from mis_loginusers where id = '" . $eng_user_id . "' ");
        $engname_result = mysqli_fetch_assoc($engname);
        $_engname = $engname_result['name'];

        $comp = 'Offline';
        $subcomp = 'Router Offline';
        $call_receive = 'Auto Email Call';
        $status = 'open';
        $remarks = 'Call Log';
        $created_by = '45'; // userid for system 

        $created_at = $datetime;


        $statement = "INSERT INTO mis(atmid, bank, customer, zone, city, state, location, call_receive_from, remarks, status, created_by, created_at, branch, bm, call_type, serviceExecutive,lho) 
            VALUES ('" . $atmid . "','" . $bank . "','" . $customer . "','" . $zone . "','" . $city . "','" . $state . "','" . $location . "','" . $call_receive . "','" . $remarks . "','open','" . $created_by . "','" . $created_at . "','" . $branch . "','" . $bm . "','Service','System','" . $lho . "')";

        if (mysqli_query($con, $statement)) {
            $mis_id = $con->insert_id;

            $last_sql = mysqli_query($con, "select id from mis_details order by id desc");
            $last_sql_result = mysqli_fetch_assoc($last_sql);
            $last = $last_sql_result['id'];
            if (!$last) {
                $last = 0;
            }
            $ticket_id =  mb_substr(date('M'), 0, 1) . date('Y') . date('m')  . date('d') . sprintf('%04u', $last);

            $detai_statement = "insert into mis_details(mis_id,atmid,component,subcomponent,status,created_at,ticket_id,
                         mis_city,zone,call_type,case_type,branch) 
                         values('" . $mis_id . "','" . $atmid . "','" . $comp . "','" . $subcomp . "','" . $status . "','" . $created_at . "','" . $ticket_id . "',
                         '" . $city . "','" . $zone . "','Service','" . $call_receive . "','" . $branch . "')";
            if (mysqli_query($con, $detai_statement)) {




                $from = 'noc@advantagesb.com';
                $fromname = 'NOC Advantaesb Team' ; 
                
                $subject = 'Auto Response ' . $atmid . ': Ticket ID : ' . $ticket_id;
                $message = '
                            <!DOCTYPE html>
                                <html>
                                <head>
                                    <title>Auto Response Template</title>
                                </head>
                                <body>
                                    <table border="1">
                                        <tr>
                                            <td>
                                                <strong>Subject:</strong> Auto Response - ATM Issue Report
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Dear ,<br><br>
                                                Thank you for reporting the ATM issue. Your request has been received, and we are actively working on a resolution. Expect updates soon.<br><br>
                                                Best regards,<br>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </body>
                                </html>

                            ';

                require_once 'phpmail/src/PHPMailer.php';
                require_once 'phpmail/src/SMTP.php';
                require_once 'phpmail/src/Exception.php';



                $mail = new PHPMailer\PHPMailer\PHPMailer();

                // $mail->SMTPDebug = 1;                                // Enable verbose debug output
                $mail->isSMTP();                                        // Set mailer to use SMTP
                $mail->Host = 'webmail-b21.web-hosting.com';                                    // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                                 // Enable SMTP authentication
                $mail->Username = 'noc@advantagesb.com';                        // SMTP username
                $mail->Password = '4mPZJcl^X@XB';                        // SMTP password
                $mail->SMTPSecure = 'tls';                              // Enable TLS encryption, `ssl` also accepted
                $mail->Port = $port;                                    // TCP port to connect to
                $mail->addReplyTo('noc@advantagesb.com');

                //Recipients
                $mail->setFrom($from, $fromname);
                $mail->From = trim($hostusername);
                $mail->FromName = $fromname;

                foreach ($to as $key => $val) {
                    $mail->addAddress($val);
                }

                foreach ($cc as $keycc => $valcc) {
                    $mail->addCC($valcc);
                }

                foreach ($bcc as $keybcc => $valbcc) {
                    $mail->addBCC($valbcc);
                }
                $mailheader = "From: ".$from."\r\n"; 
                $mailheader .= "Reply-To: ".$from."\r\n"; 
                
                // $mail->mailheader = $mailheader; // Add a recipient
                $mail->SMTPDebug = 2;
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject . "\r\n";
                $mail->Body    = $message;

                if ($mail->send()) {
                    echo 1;
                } else {
                    echo 0;
                }




            }

        }
    
    }
}

<?php

// set_time_limit(0); // Reset the execution time limit to its original value (unlimited)

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// $to = "vishwaaniruddh@gmail.com";
// $subject = "Subject";
// $message = "Hello, this is a test email.";
// $headers = "From: noc@advantagesb.com\r\n";

// $smtpConfig = [
//     'host' => '199.188.205.42',
//     'port' => 465,
//     'username' => 'noc@advantagesb.com',
//     'password' => '4mPZJcl^X@XB',
// ];

// $smtp = stream_socket_client('tcp://' . $smtpConfig['host'] . ':' . $smtpConfig['port']);
// fwrite($smtp, "EHLO " . $smtpConfig['host'] . "\r\n");
// // More SMTP commands for authentication, sending email, etc.


// if (mail($to, $subject, $message, $headers)) {
//     echo "Mail sent successfully!";
// } else {
//     echo "Mail sending failed!";
// }

// // Close the SMTP connection when done.
// fclose($smtp);




// return ; 
$atmid = 'S1NG000527005';
$ticket_id = 'S2023202923';


$from = 'noc@advantagesb.com';
$fromname = 'NOC Advantagesb Team';

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

require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
require_once 'PHPMailer/src/Exception.php';

$hostusername = 'noc@advantagesb.com';
$hostPassword = '4mPZJcl^X@XB';

$mail = new PHPMailer\PHPMailer\PHPMailer();

$mail->SMTPDebug = 1;                                // Enable verbose debug output
$mail->isSMTP();                                        // Set mailer to use SMTP
$mail->Host = 'webmail-b21.web-hosting.com';           // Specify main and backup SMTP servers
// $mail->Host = '199.188.205.42';           // Specify main and backup SMTP servers

$mail->SMTPAuth = true;   
                              // Enable SMTP authentication
$mail->Username = $hostusername;                        // SMTP username
$mail->Password = $hostPassword;                        // SMTP password
$mail->SMTPSecure = 'ssl';                              // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                     // Use port 587 for TLS

$mail->addReplyTo('noc@advantagesb.com');

// Recipients
$mail->setFrom($from, $fromname);
$mail->From = trim($hostusername);
$mail->FromName = $fromname;
$to = ['vishwaaniruddh@gmail.com'];
foreach ($to as $val) {
    $mail->addAddress($val);
}

// You can uncomment and modify the following sections for CC and BCC recipients if needed.
// $cc = ['cc1@example.com', 'cc2@example.com'];
// foreach ($cc as $valcc) {
//     $mail->addCC($valcc);
// }

// $bcc = ['bcc1@example.com', 'bcc2@example.com'];
// foreach ($bcc as $valbcc) {
//     $mail->addBCC($valbcc);
// }

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $subject . "\r\n";
$mail->Body = $message;

if ($mail->send()) {
    echo 1;
} else {
    echo 0;
}
?>

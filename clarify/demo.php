<?php include('config.php');


return ; 

$sql = mysqli_query($con,"select * from mis_history where mis_id=0 order by id desc") ; 
while($sqlResult = mysqli_fetch_assoc($sql)){

$id = $sqlResult['id'];
$created_at = $sqlResult['created_at'];

$misSql = mysqli_query($con,"select * from mis where created_at='".$created_at."'");
$misSqlResult = mysqli_fetch_assoc($misSql) ; 
$misId = $misSqlResult['id'];


mysqli_query($con,"update mis_history set mis_id='".$misId."' where id='".$id."'")
; 

echo '<br />';

}





















return ; 






date_default_timezone_set("Asia/Calcutta"); // India time (GMT+5:30)
error_reporting(E_ALL); // Enable error reporting for debugging

$username = 'noc@advantagesb.com';
$password = '4mPZJcl^X@XB';
$emailServer = 'webmail-b21.web-hosting.com';
$nodes = 'http://clarify.advantagesb.com/generateAutoCallFromEmailReceived.php';
$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {

    $unseenMessages = imap_search($inbox, 'UNSEEN');



    if ($unseenMessages) {

        foreach ($unseenMessages as $messageNumber) {



            // Fetch the email body
            $emailBody = imap_fetchbody($inbox, $messageNumber, 1); // Assuming the body is in MIME type 1 (text/plain)

            // Extract ATM ID and other details from email body
            $atmID = extractValue($emailBody, 'ATM ID');

            if (isset($atmID) && !empty($atmID)) {
                
                echo $atmID ;
                echo '<br>';
                $siteAddress = extractValue($emailBody, 'SITE ADDRESS');
                $city = extractValue($emailBody, 'CITY');
                $circle = extractValue($emailBody, 'CIRCLE');
                $linkVendor = extractValue($emailBody, 'LINK VENDOR');
                $atmIP = extractValue($emailBody, 'ATM IP');



                $header = imap_headerinfo($inbox, $messageNumber);
                $subject = $header->subject;
                $overview = imap_fetch_overview($inbox, $messageNumber);
                $emailHeaders = imap_fetchheader($inbox, $messageNumber);


                // Parse the headers into an associative array
                $headerInfo = imap_rfc822_parse_headers($emailHeaders);


                // Get the "To" recipients
                $toRecipients = isset($headerInfo->to) ? $headerInfo->to : [];
                $toEmails = getRecipientsEmails($toRecipients);

                $fromaddress = isset($headerInfo->fromaddress) ? $headerInfo->fromaddress : [];
                $ccRecipients = isset($headerInfo->cc) ? $headerInfo->cc : [];

                if (is_array($ccRecipients) || is_object($ccRecipients)) {
                    foreach ($ccRecipients as $ccValue) {
                        if (is_array($ccValue) || is_object($ccValue)) {
                            $ccEmails[] = $ccValue->mailbox . '@' . $ccValue->host;
                        }
                    }
                }


                $sender = $overview[0]->from;
                echo $senderEmail = getSenderEmail($sender);

                $toEmails[] = $senderEmail;


$emailToRemove = "noc@advantagesb.com";

foreach ($toEmails as $key => $email) {
    if ($email === $emailToRemove) {
        unset($toEmails[$key]);
    }
}


                echo '<br>';
                echo '<br>';
                var_dump($toEmails);

                echo '<br>';
                echo '<br>';


                $to = $senderEmail;
                $data = array(
                    'atmid' => $atmID,
                    'to' => $toEmails,
                    'cc' => $ccEmails,
                );

                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'POST',
                        'content' => http_build_query($data)
                    )
                );

                $context = stream_context_create($options);
                $result = file_get_contents($nodes, false, $context);

                var_dump($result);

            }


        }
    } else {
        // echo "No unread messages in the mailbox.";
    }
} else {
}

imap_close($inbox);

// Function to extract a value based on a label from email body
function extractValue($emailBody, $label)
{
    if (preg_match("/$label\s+(.+)/i", $emailBody, $matches)) {
        return trim($matches[1]);
    } else {
        return '';
    }
}


function getSenderEmail($sender)
{
    $matches = array();
    preg_match('/([^<]*)<([^>]*)>/', $sender, $matches);
    return isset($matches[2]) ? trim($matches[2]) : '';
}

function getRecipientsEmails($recipients)
{
    $emails = array();
    if (is_array($recipients) || is_object($recipients)) {
        foreach ($recipients as $recipient) {
            if (is_array($recipient) || is_object($recipient)) {
                $emails[] = $recipient->mailbox . '@' . $recipient->host;
            }
        }
    }
    return $emails;
}

// Function to extract CC recipients from email headers
function getCCRecipientsFromHeaders($emailHeaders)
{
    preg_match('/^Cc:\s*(.*)$/mi', $emailHeaders, $matches);
    return isset($matches[1]) ? trim($matches[1]) : '';
}
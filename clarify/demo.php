<?
date_default_timezone_set("Asia/Calcutta");   // India time (GMT+5:30)

$username = 'noc@advantagesb.com';
$password = '4mPZJcl^X@XB';
$nodes = 'http://clarify.advantagesb.com/generateAutoCallFromEmailReceived.php';

$emailServer = 'webmail-b21.web-hosting.com'; // Correct hostname for Gmail IMAP
$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {

    $unseenMessages = imap_search($inbox, 'UNSEEN');

    if ($unseenMessages) {
        echo "Number of unread messages: " . count($unseenMessages);
        echo '<br>';

        foreach ($unseenMessages as $messageNumber) {
            $header = imap_headerinfo($inbox, $messageNumber);
            $subject = $header->subject;
            $overview = imap_fetch_overview($inbox, $messageNumber);


            $sender = $overview[0]->from;
            echo $senderEmail = getSenderEmail($sender);

            $cc = $overview[0]->cc;
            $ccEmails = getRecipientsEmails($cc);

            $bcc = $overview[0]->bcc;
            $bccEmails = getRecipientsEmails($bcc);



            echo "Message Number: $messageNumber<br>";
            echo "Subject: $subject<br>";

            // Fetch the email body
            $emailBody = imap_fetchbody($inbox, $messageNumber, 1); // Assuming the body is in MIME type 1 (text/plain)

            // Extract ATM ID and other details from email body
            $atmID = extractValue($emailBody, 'ATM ID');
            $siteAddress = extractValue($emailBody, 'SITE ADDRESS');
            $city = extractValue($emailBody, 'CITY');
            $circle = extractValue($emailBody, 'CIRCLE');
            $linkVendor = extractValue($emailBody, 'LINK VENDOR');
            $atmIP = extractValue($emailBody, 'ATM IP');

            // Display the extracted information
            echo "ATM ID: $atmID<br>";
            echo "SITE ADDRESS: $siteAddress<br>";
            echo "CITY: $city<br>";
            echo "CIRCLE: $circle<br>";
            echo "LINK VENDOR: $linkVendor<br>";
            echo "ATM IP: $atmIP<br>";

            echo "<hr>";



            
            $to = $senderEmail;
            $cc = $ccEmails;
            $bcc = $bccEmails;
                $data = array(
                'atmid'=>$atmID,
                'to'=>$to,
                'cc'=>$cc,
                'bcc'=>$bcc,
                );
            
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            
            $context  = stream_context_create($options);
            $result =  file_get_contents($nodes, false, $context);

            var_dump($result);
        }
    } else {
        echo "No unread messages in the mailbox.";
    }
} else {
    echo "Failed to connect to the IMAP server: " . imap_last_error();
}

imap_close($inbox);

// Function to extract a value based on a label from email body
function extractValue($emailBody, $label) {
    if (preg_match("/$label\s+(.+)/i", $emailBody, $matches)) {
        return trim($matches[1]);
    } else {
        return '';
    }
}


function getSenderEmail($sender) {
    $matches = array();
    preg_match('/([^<]*)<([^>]*)>/', $sender, $matches);
    return isset($matches[2]) ? trim($matches[2]) : '';
}

// Function to extract email addresses from a comma-separated list of recipients
function getRecipientsEmails($recipients) {
    $emails = array();
    $recipients = explode(",", $recipients);
    foreach ($recipients as $recipient) {
        $email = getSenderEmail($recipient);
        if (!empty($email)) {
            $emails[] = $email;
        }
    }
    return $emails;
}



?>
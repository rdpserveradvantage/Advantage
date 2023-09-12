<?
date_default_timezone_set("Asia/Calcutta");   // India time (GMT+5:30)

$username = 'noc@advantagesb.com';
$password = '4mPZJcl^X@XB';
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

?>
<? 
date_default_timezone_set("Asia/Calcutta");   // India time (GMT+5:30)

$username = 'noc@advantagesb.com';
$password = '4mPZJcl^X@XB';
$emailServer = 'webmail-b21.web-hosting.com'; // Correct hostname for Gmail IMAP

$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {
    // Search for unread messages
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

            // Remove signature
            $emailBody = removeSignature($emailBody);

            
            $emailBody = "ATM ID    SITE ADDRESS    CITY    CIRCLE  Link Vendor ATM IP
            S1NG020049018  ZILLA PARISHAD OFFICE   NANDED  MAHARASHTRA Railtel Capex  10.130.0.218";
            
            // Split the email body into lines
            $lines = explode("\n", $emailBody);
            
            // Initialize a variable to store the ATM ID
            $atmID = '';
            
            // Iterate through each line to find the line containing ATM ID
            foreach ($lines as $line) {
                if (stripos($line, 'ATM ID') !== false) {
                    // Use regular expression to extract ATM ID value
                    if (preg_match('/ATM ID\s+(.+)/', $line, $matches)) {
                        $atmID = trim($matches[1]);
                        break; // Exit the loop once ATM ID is found
                    }
                }
            }
            
            if (!empty($atmID)) {
                echo "ATM ID: $atmID";
            } else {
                echo "ATM ID not found in the email.";
            }



            // Your email processing code here...
            echo "Email Body:<br>";
            echo $emailBody;

            echo "<hr>";
        }
    } else {
        echo "No unread messages in the mailbox.";
    }
} else {
    echo "Failed to connect to the IMAP server: " . imap_last_error();
}

imap_close($inbox);

// Function to remove the signature
function removeSignature($emailBody) {
    // You can use a regular expression to detect and remove the signature.
    $pattern = '/("regards,".[\s]*)/'; // Pattern to detect "--" or "-- " (double dash followed by a space)
    $emailBody = preg_replace($pattern, '', $emailBody);

    return $emailBody;
}


return ; 
$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {
    $unseenMessages = imap_search($inbox, 'UNSEEN');

    $numMessages = imap_num_msg($inbox);
    echo "Number of messages: $numMessages";
} else {
    echo "Failed to connect to the IMAP server: " . imap_last_error();
}





echo '<br>';

for ($i = 1; $i <= $numMessages; $i++) {
    $header = imap_headerinfo($inbox, $i);
    $subject = $header->subject;

echo $i . ' ) '.$subject ; 
echo '<br>';

    if ($subject == 'email- auto call log format' || $subject == 'Fwd: email- auto call log format' || $subject == 'auto - call') {

        $fromAddress = $header->fromaddress;
        $date = date("Y-m-d H:i:s", $header->udate);

        $body = imap_fetchbody($inbox, $i, "1");
        $atmIdLine = findATMIDLine($body);
        $atmIdValue = extractATMIDValue($atmIdLine);

if($atmIdValue){
    
    $invoiceNoLine = extractInvoiceNoLine($body);
        $invoiceNoValue = extractInvoiceNoValue($invoiceNoLine);
        
        $problemLine = findProblemLine($body);
        $problemValue = extractProblemValue($problemLine);
        
        $contactPersonValue = extractContactPersonValue($body);
        $contactNumberValue = extractContactNumberValue($body);
        
        if (!empty($atmIdValue)) {
            echo "ATM ID: $atmIdValue<br>";
        } else {
            echo "ATM ID not found in the email.<br>";
        }

        if (!empty($invoiceNoValue)) {
            echo "Invoice No: $invoiceNoValue<br>";
        } else {
            echo "Invoice No not found in the email.<br>";
        }
        
        if (!empty($problemValue)) {
            echo "Problem: $problemValue<br>";
        } else {
            echo "Problem not found in the email.<br>";
        }
        
        if (!empty($contactPersonValue)) {
            echo "Contact Person: $contactPersonValue<br>";
        } else {
            echo "Contact Person not found in the email.<br>";
        }
        
        if (!empty($contactNumberValue)) {
            echo "Contact Number: $contactNumberValue<br>";
        } else {
            echo "Contact Number not found in the email.<br>";
        }

}
        
        echo "<hr>";
    }
}
imap_close($inbox);

function findATMIDLine($body) {
    $lines = explode("\n", $body);
    foreach ($lines as $line) {
        if (stripos($line, 'Site / Sol / ATM Id') !== false) {
            return $line;
        }
    }
    return '';
}

function extractATMIDValue($line) {
    $line = str_ireplace('Site / Sol / ATM Id', '', $line);
    return trim($line);
}

function extractInvoiceNoLine($body) {
    $lines = explode("\n", $body);
    foreach ($lines as $index => $line) {
        if (stripos($line, 'Invoice No') !== false && preg_match('/\d+/', $line)) {
            return $line;
        }
    }
    return '';
}

function extractInvoiceNoValue($line) {
    preg_match('/\d+/', $line, $matches);
    $invoiceNoValue = isset($matches[0]) ? trim($matches[0]) : '';
    return $invoiceNoValue;
}


function findProblemLine($body) {
    $lines = explode("\n", $body);
    foreach ($lines as $line) {
        if (stripos($line, 'Problem') !== false) {
            return $line;
        }
    }
    return '';
}

function extractProblemValue($line) {
    $line = str_ireplace('Problem', '', $line);
    return trim($line);
}

function extractContactPersonValue($body) {
    preg_match('/Contact Person\s*([^\n\r]+)/i', $body, $matches);
    return isset($matches[1]) ? trim($matches[1]) : '';
}

function extractContactNumberValue($body) {
    preg_match('/Contact Number\s*([^\n\r]+)/i', $body, $matches);
    return isset($matches[1]) ? trim($matches[1]) : '';
}

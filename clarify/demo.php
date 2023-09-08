<?php

date_default_timezone_set("Asia/Calcutta");   // India time (GMT+5:30)

// $username = 'aniruddh@sarmicrosystems.in';
// $password = 'AVav@@2023';
// $emailServer = 'mail.sarmicrosystems.in';

$username = 'calllog@avoups.com';
$password = 'avo@12345';
$emailServer = 'imap.gmail.com'; // Correct hostname for Gmail IMAP

$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {
    $numMessages = imap_num_msg($inbox);
    echo "Number of messages: $numMessages";
} else {
    echo "Failed to connect to the IMAP server: " . imap_last_error();
}





return ; 
date_default_timezone_set("Asia/Calcutta");   // India time (GMT+5:30)

$username = 'aniruddh@sarmicrosystems.in';
$password = 'AVav@@2023';
$emailServer = 'mail.sarmicrosystems.in';

// $username = 'noc@advantagesb.com';
// $password = '4mPZJcl^X@XB';
// $emailServer = 'webmail-b21.web-hosting.com'; // Correct hostname for Gmail IMAP

// Please find below credentials for NOC.

// username: noc@advantagesb.com
// password: 4mPZJcl^X@XB

// Mail Server: webmail-b21.web-hosting.com

$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {
    $numMessages = imap_num_msg($inbox);
    echo "Number of messages: $numMessages";
} else {
    echo "Failed to connect to the IMAP server: " . imap_last_error();
}





return ;



for ($i = 1; $i <= $numMessages; $i++) {
    $header = imap_headerinfo($inbox, $i);
    $subject = $header->subject;

echo $subject ; 

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

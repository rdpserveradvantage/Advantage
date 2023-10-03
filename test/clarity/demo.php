<?php
$username = 'aniruddh@sarmicrosystems.in';
$password = 'AVav@@2023';
$emailServer = 'mail.sarmicrosystems.in';

$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

$numMessages = imap_num_msg($inbox);

// Include the Simple HTML DOM Parser library
require 'data/simple_html_dom.php';


$numMessages = imap_num_msg($inbox);

for ($i = 1; $i <= $numMessages; $i++) {
    $header = imap_headerinfo($inbox, $i);
    $subject = $header->subject;
    $fromAddress = $header->fromaddress;
    $date = date("Y-m-d H:i:s", $header->udate);

    // Fetch the body of the email (use "1.1" for plain text or "1.2" for HTML)
    $body = imap_fetchbody($inbox, $i, "1.1");

    // If the body is not in plain text, try fetching the HTML part
    if (empty($body)) {
        $body = imap_fetchbody($inbox, $i, "1.2");
    }


    $html = str_get_html($body);

    if ($html !== false) {
        $tables = $html->find('table');

        $atmIdValue = '';

        foreach ($tables as $table) {
            $tableContent = $table->plaintext;

            // Check if the table contains "ATM ID" and "=". If found, extract the ATM ID value
            if (strpos($tableContent, 'ATM ID') !== false && strpos($tableContent, '=') !== false) {
                // Extract the ATM ID from the table content
                preg_match('/ATM ID\s*=\s*(\S+)/', $tableContent, $matches);
                $atmIdValue = isset($matches[1]) ? trim($matches[1]) : '';

                break; // Break out of the loop once we find the ATM ID
            }
        }

        // Display the details for each email
        echo "Subject: $subject<br>";
        echo "From: $fromAddress<br>";
        echo "Date: $date<br>";

        if (!empty($atmIdValue)) {
            echo "ATM ID: $atmIdValue<br>";
        } else {
            echo "ATM ID not found in the email.<br>";
        }

        echo "<hr>";
    } else {
        echo "Error parsing the email body.<br>";
    }
}

// Close the IMAP connection
imap_close($inbox);

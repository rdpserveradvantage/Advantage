<?php
date_default_timezone_set("Asia/Calcutta"); // India time (GMT+5:30)
error_reporting(E_ALL); // Enable error reporting for debugging

$username = 'alarms@advantagesb.com';
$password = 'Adv@1234#';
$emailServer = 'webmail-b21.web-hosting.com';
$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if ($inbox) {
    $emails = imap_search($inbox, 'UNSEEN');

    if ($emails) {
        rsort($emails);

        foreach ($emails as $email_number) {
            $message = imap_fetchbody($inbox, $email_number, 1);

            $overview = imap_fetch_overview($inbox, $email_number, 0);
            $subject = $overview[0]->subject;

            // Modify the regular expression to match both cases
            preg_match('/(\d+) devices on the platform are offline|The VPN of (\d+) devices in the platform is offline/', $message, $matches);

            if (!empty($matches)) {
                // Check if the first capture group is set (for the first pattern)
                if (!empty($matches[1])) {
                    $numberOfDevices = $matches[1];
                } else {
                    // If the first capture group is empty, use the second capture group (for the second pattern)
                    $numberOfDevices = $matches[2];
                }

                // Remove "= td>" from the message
                $message = str_replace("= td>", "", $message);

                $dom = new DOMDocument;
                libxml_use_internal_errors(true);

                $dom->loadHTML(mb_convert_encoding($message, 'HTML-ENTITIES', 'UTF-8'));

                libxml_use_internal_errors(false);

                // Search for tables with specific content in cells
                $tables = $dom->getElementsByTagName('table');
                $firstTable = null;
                $thirdTable = null;

                foreach ($tables as $table) {
                    $cellContent = $table->textContent;
echo '<br>';echo '<br>';
echo '$cellContent = ' . $cellContent ; 
echo '<br>';echo '<br>';echo '<br>';
                    if (strpos($cellContent, 'devices on the platform are offline') !== false) {
                        $firstTable = $table;
                    } elseif (strpos($cellContent, 'devices in the platform have been offline for more than 15 minutes') !== false) {
                        $thirdTable = $table;
                    }
                    // echo '<br>';
                    // echo '$table = ' . $table ; 
                }

                if ($firstTable) {
                    echo "Subject: $subject<br>";
                    echo "Number of Devices Offline: $numberOfDevices<br>";
                    echo "SN\tDevice ID\tDescription\tOffline Time<br>";

                    foreach ($firstTable->getElementsByTagName('tr') as $row) {
                        $cells = $row->getElementsByTagName('td');

                        if ($cells->length >= 4) {
                            $sn = trim(html_entity_decode(strip_tags($cells->item(0)->nodeValue)));
                            $deviceID = trim(html_entity_decode(strip_tags($cells->item(1)->nodeValue)));
                            $description = trim(html_entity_decode(strip_tags($cells->item(2)->nodeValue)));

                            echo "$sn\t$deviceID\t$description<br>";
                        }
                    }

                    var_dump($snValues, $deviceIDValues, $descriptionValues, $offlineTimeValues);

                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                }

                if ($thirdTable) {
                    echo "Subject: $subject<br>";
                    echo "Number of Devices Offline: $numberOfDevices<br>";
                    echo "SN\tDevice ID\tDescription\tOffline Time<br>";

                    foreach ($thirdTable->getElementsByTagName('tr') as $row) {
                        $cells = $row->getElementsByTagName('td');

                        if ($cells->length >= 4) {
                            $sn = trim(html_entity_decode(strip_tags($cells->item(0)->nodeValue)));
                            $deviceID = trim(html_entity_decode(strip_tags($cells->item(1)->nodeValue)));
                            $description = trim(html_entity_decode(strip_tags($cells->item(2)->nodeValue)));
                            $offlineTime = trim(html_entity_decode(strip_tags($cells->item(3)->nodeValue)));

                            echo "$sn\t$deviceID\t$description\t$offlineTime<br>";
                        }
                    }

                    var_dump($snValues, $deviceIDValues, $descriptionValues, $offlineTimeValues);

                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                } else {
                    echo "No 15-minute offline table found in the email<br>";
                }
            } else {
                echo "No relevant information found in the email<br>";
            }
        }
    } else {
        echo "No unread emails found";
    }
} else {
    echo 'No Inbox';
}

imap_close($inbox);
?>

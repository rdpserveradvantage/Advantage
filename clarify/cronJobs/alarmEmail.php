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

            // Check if the body contains the target phrase
            preg_match('/(\d+) devices on the platform are offline/', $message, $matches);

            if (!empty($matches)) {
                $numberOfDevices = $matches[1];

                $dom = new DOMDocument;
                libxml_use_internal_errors(true);

                $dom->loadHTML(mb_convert_encoding($message, 'HTML-ENTITIES', 'UTF-8'));

                libxml_use_internal_errors(false);

                $tables = $dom->getElementsByTagName('table');
                $table = $tables->item(0);

                if ($table) {
                    $snValues = [];
                    $deviceIDValues = [];
                    $descriptionValues = [];

                    echo "Subject: $subject<br>";
                    echo "Number of Devices Offline: $numberOfDevices<br>";
                    echo "SN\tDevice ID\tDescription<br>";

                    foreach ($table->getElementsByTagName('tr') as $row) {
                        $cells = $row->getElementsByTagName('td');

                        if ($cells->length >= 3) {
                            $sn = trim(html_entity_decode(strip_tags($cells->item(0)->nodeValue)));
                            $deviceID = trim(html_entity_decode(strip_tags($cells->item(1)->nodeValue)));
                            $description = trim(html_entity_decode(strip_tags($cells->item(2)->nodeValue)));

                            echo "$sn\t$deviceID\t$description<br>";

                            $snValues[] = $sn;
                            $deviceIDValues[] = $deviceID;
                            $descriptionValues[] = $description;
                        }
                    }

                    var_dump($snValues, $deviceIDValues, $descriptionValues);

                    echo '<br />';
                    
                    echo '<br />';
                    echo '<br />';
                } else {
                    echo "No table found in the email body<br>";
                }
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

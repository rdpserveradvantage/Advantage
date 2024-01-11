<?php
include('config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$username = 'noc@advantagesb.com';
$password = '4mPZJcl^X@XB';
$emailServer = 'webmail-b21.web-hosting.com';

mysqli_query($con, "SET SESSION wait_timeout = 300");

$inbox = imap_open("{{$emailServer}:993/imap/ssl}INBOX", $username, $password);

if (!$inbox) {
    die('Cannot connect to the mailbox: ' . imap_last_error());
}

$emails = imap_search($inbox, 'UNSEEN');

if ($emails) {
    foreach ($emails as $email_number) {
        $header = imap_headerinfo($inbox, $email_number);
        $structure = imap_fetchstructure($inbox, $email_number);
        $email_body = imap_body($inbox, $email_number);

        $isReply = isNewEmail($header);

        // $emailQuery = "INSERT INTO emails (subject, content_body, from_email, is_reply) 
        //    VALUES ('" . addslashes($header->subject) . "', '" . addslashes($email_body) . "', '" . addslashes($header->fromaddress) . "', $isReply)";

        $messageId = isset($header->message_id) ? $header->message_id : '';
        $isReply = isNewEmail($header);

        $emailQuery = $con->prepare("INSERT INTO emails (subject, content_body, from_email, is_reply,message_id) 
                             VALUES (?, ?, ?, ?, ?)");

        $emailQuery->bind_param("sssis", $header->subject, $email_body, $header->fromaddress, $isReply, $messageId);

        if ($emailQuery->execute()) {
            $emailId = $con->insert_id;
            $attachmentFolder = createDirectoryStructure($emailId);

            echo "Email stored in tables successfully.\n";

            foreach ($header->to as $recipient) {
                $recipientQuery = "INSERT INTO recipients (email_id, recipient_type, recipient_email) 
                                   VALUES ('$emailId', 'To', '" . addslashes($recipient->mailbox . "@" . $recipient->host) . "')";
                mysqli_query($con, $recipientQuery);
            }

            if (!empty($header->cc)) {
                foreach ($header->cc as $ccRecipient) {
                    $ccRecipientQuery = "INSERT INTO recipients (email_id, recipient_type, recipient_email) 
                                         VALUES ('$emailId', 'Cc', '" . addslashes($ccRecipient->mailbox . "@" . $ccRecipient->host) . "')";
                    mysqli_query($con, $ccRecipientQuery);
                }
            }

            // Process attachments
            if ($structure->parts) {
                echo 'if';
                echo '<pre>';
                // print_r($structure->parts) ; 
                echo '</pre>';

                foreach ($structure->parts as $partNumber => $part) {
                    processAttachment($inbox, $email_number, $part, $emailId, $partNumber);
                }
            } else {
                echo 'else ';
            }
        } else {
            echo "Error: " . mysqli_error($con) . "\n";
        }
    }
} else {
    echo "No unread emails in the INBOX.\n";
}


imap_close($inbox);

function isNewEmail($header)
{
    $subject = strtolower($header->subject);
    return (strpos($subject, 're:') === 0 || strpos($subject, 'fwd:') === 0);
}

function createDirectoryStructure($emailId)
{
    $currentDate = date('Y/m/d');
    $directoryStructure = './emailAttachments/' . $currentDate . '/' . $emailId . '/';
    if (!file_exists($directoryStructure)) {
        mkdir($directoryStructure, 0777, true);
    }
    return $directoryStructure;
}

function processAttachment($inbox, $email_number, $part, $emailId, $partNumber)
{
    global $attachmentFolder;
    $attachmentFileName = null;

    if ($part->ifdisposition && strtolower($part->disposition) == "attachment") {
        if ($part->ifdparameters && $part->dparameters[0]->attribute == 'filename') {
            $attachmentFileName = $part->dparameters[0]->value;
        } elseif ($part->ifparameters && $part->parameters[0]->attribute == 'name') {
            $attachmentFileName = $part->parameters[0]->value;
        }

        if ($attachmentFileName) {
            $attachmentContent = imap_fetchbody($inbox, $email_number, $partNumber + 1);
            $encoding = $part->encoding;

            if ($encoding == 3) { // Base64 encoding
                $attachmentContent = base64_decode($attachmentContent);
            } elseif ($encoding == 4) { // Quoted-printable encoding
                $attachmentContent = quoted_printable_decode($attachmentContent);
            }


            $attachmentFileName = $attachmentFolder . $attachmentFileName;

            if (file_put_contents($attachmentFileName, $attachmentContent) !== false) {
                global $con;
                $attachmentQuery = "INSERT INTO attachments (email_id, file_name, file_path) 
                                       VALUES ('$emailId', '" . addslashes($part->dparameters[0]->value) . "', '" . addslashes($attachmentFileName) . "')";
                if (mysqli_query($con, $attachmentQuery)) {
                    echo 'Debug: Attachment saved to database' . "\n";
                } else {
                    echo 'Debug: Error inserting attachment information into the database: ' . mysqli_error($con) . "\n";
                }
            } else {
                echo 'Debug: Error saving attachment to file: ' . $attachmentFileName . "\n";
                echo 'Debug: ' . error_get_last()['message'] . "\n";
            }

            // if (file_put_contents($attachmentFileName, $attachmentContent) !== false) {
            //     global $con; 
            //     $attachmentQuery = "INSERT INTO attachments (email_id, file_name, file_path) 
            //                            VALUES ('$emailId', '" . addslashes($part->dparameters[0]->value) . "', '" . addslashes($attachmentFileName) . "')";
            //     if (mysqli_query($con, $attachmentQuery)) {
            //         echo 'Debug: Attachment saved to database' . "\n";
            //     } else {
            //         echo 'Debug: Error inserting attachment information into the database: ' . mysqli_error($con) . "\n";
            //     }
            // } else {
            //     echo 'Debug: Error saving attachment to file: ' . $attachmentFileName . "\n";
            // }
        } else {
            echo 'Debug: Attachment filename is empty' . "\n";
        }
    }
}

?>
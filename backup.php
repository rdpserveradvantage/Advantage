<?php

$host = '10.63.21.6';
$username = 'advantage';
$password = 'qwerty121';
$database = 'sarmicrosystems_advantage';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
// Backup the database
$backupFileName = 'backup_' . date('YmdHis') . '.sql';
$backupFilePath = './' . $backupFileName;

// Execute mysqldump command to create the backup
exec("mysqldump --user=$username --password=$password --host=$host $database > $backupFilePath");

// Close the database connection
$mysqli->close();


// Provide a link to download the backup file
if (file_exists($backupFilePath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($backupFilePath) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backupFilePath));
    readfile($backupFilePath);
    exit;
} else {
    echo 'Backup file not found.';
}
?>

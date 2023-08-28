<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $targetDirectory = 'uploads/';

  foreach ($_FILES as $fieldName => $file) {
    $targetFile = $targetDirectory . basename($file['name']);

    if (file_put_contents($targetFile, base64_decode(file_get_contents($file['tmp_name'])))) {
      echo 'Image uploaded successfully: ' . $file['name'] . '<br>';
    } else {
      echo 'Error uploading image: ' . $file['name'] . '<br>';
    }
  }
}
?>

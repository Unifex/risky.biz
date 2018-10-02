<?php

use Symfony\Component\Yaml\Yaml;

// Preload the $update_sponsors with existing values.
$update_sponsors = $vars['sponsors'];

// Update sponsor with new values.
$update_sponsors[$_POST['edit_key']]['name'] = $_POST['edit_name'];
$update_sponsors[$_POST['edit_key']]['url'] = $_POST['edit_url'];

// Handle the file.
if (!empty($_FILES['edit_file']['tmp_name'])) {
  $uploaddir = realpath(dirname(__FILE__) . '/../jekyll_src/static/img/sponsors/');
  $uploadfile = $uploaddir . '/' . basename($_FILES['edit_file']['name']);
  if (!is_writable($uploaddir)) {
    $err[] = "Nope, can't write to $uploaddir";
  } elseif (move_uploaded_file($_FILES['edit_file']['tmp_name'], $uploadfile)) {
    $update_sponsors[$_POST['edit_key']]['banner_url'] = '/static/img/sponsors/' . basename($_FILES['edit_file']['name']);
  }
  else {
    switch($_FILES['edit_file']['error']) {
      case UPLOAD_ERR_INI_SIZE: 
        $message = "The uploaded file exceeds the upload_max_filesize directive in php.ini"; 
        break; 
      case UPLOAD_ERR_FORM_SIZE: 
        $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form"; 
        break; 
      case UPLOAD_ERR_PARTIAL: 
        $message = "The uploaded file was only partially uploaded"; 
        break; 
      case UPLOAD_ERR_NO_FILE: 
        $message = "No file was uploaded. Keeping the previous one"; 
        break; 
      case UPLOAD_ERR_NO_TMP_DIR: 
        $message = "Missing a temporary folder"; 
        break; 
      case UPLOAD_ERR_CANT_WRITE: 
        $message = "Failed to write file to disk"; 
        break; 
      case UPLOAD_ERR_EXTENSION: 
        $message = "File upload stopped by extension"; 
        break; 

      default: 
        $message = "Unknown upload error: " . $_FILES['edit_file']['error']; 
        break; 
    }
    $err[] = $message;
  }
}

// This *should* never happen.
if ($_POST['src_sponsor'] != $_POST['edit_key']) {
  unset($update_sponsors[$_POST['src_sponsor']]);
}

// Can we write the YAML file?
$destDataFile = $dataDir . 'sponsors.yml';
if (!is_writable($destDataFile)) {
  $err[] = "Nope, can't write to $destDataFile.";
}

if (!empty($err)) {
  $vars['write_status'] = 'danger';
  $vars['write_message'] = implode(" \n", $err);
} else {
  // Things look good.
  // Move the file.
  move_uploaded_file($_FILES['edit_file']['tmp_name'], $uploadfile);
  if (!empty($_FILES['edit_file']['name'])) {
    $update_sponsors[$_POST['edit_key']]['banner_url'] = '/static/img/sponsors/' . basename($_FILES['edit_file']['name']);
  }
  // Write the data file.
  $yaml = Yaml::dump($update_sponsors);

  if ($bytes = file_put_contents($destDataFile, $yaml)) {
    //print_r($destDataFile);
    header('Location: sponsors.php?woot=' . $_POST['edit_key'] . '&b=' . $bytes . '#jump_' . $_POST['edit_key']);
    die();
  }
  else {
    $err[] = "Huh? Can't write to $destDataFile.";
  }
}

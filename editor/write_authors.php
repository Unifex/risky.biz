<?php

use Symfony\Component\Yaml\Yaml;

// Preload the $update_authors with existing values.
$update_authors = $vars['authors'];

// Update author with new values.
$update_authors[$_POST['edit_key']]['name'] = $_POST['edit_name'];

// This *should* never happen.
if ($_POST['src_author'] != $_POST['edit_key']) {
  unset($update_authors[$_POST['src_author']]);
}

// Can we write the YAML file?
$destDataFile = $dataDir . 'authors.yml';
if (!is_writable($destDataFile)) {
  $err[] = "Nope, can't write to $destDataFile.";
}

if (!empty($err)) {
  $vars['write_status'] = 'danger';
  $vars['write_message'] = implode(" \n", $err);
} else {
  // Things look good.
  // Write the data file.
  $yaml = Yaml::dump($update_authors);

  if ($bytes = file_put_contents($destDataFile, $yaml)) {
    header('Location: authors.php?woot=' . $_POST['edit_key'] . '&b=' . $bytes . '#jump_' . $_POST['edit_key']);
    die();
  }
  else {
    $err[] = "Huh? Can't write to $destDataFile.";
  }
}

<?php

// use Symfony\Component\Yaml\Yaml;

// Preload the $update_authors with existing values.
$update_authors = $vars['authors'];

// Can we write to the Authors dir?
if (!is_writeable($authorDir)) {
  $err[] = "Nope, can't write to $authorDir";
}

if (!empty($err)) {
  $vars['write_status'] = 'danger';
  $vars['write_message'] = implode(" \n", $err);
} else {
  // Things look good, remove current author files.
  $author_files = glob($authorDir . '*.md');
  foreach($author_files as $author_filename){
    if(is_file($author_filename)) {
      unlink($author_filename);
    }
  }
  // Write the author templates.
  $author_template = file_get_contents($authorDir . 'author.template');

  foreach ($update_authors as $stub => $author) {
    if (empty(trim($stub))) {
      continue;
    }
    $author_file = str_replace('[author_stub]', $stub, $author_template);
    $author_file = str_replace('[author_name]', $author['name'], $author_file);
    file_put_contents($authorDir . $stub . '.md', $author_file);
  }
  
}

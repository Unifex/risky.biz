<?php

//require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;
# Build the filename.

$build_filename = implode('-', array(
  $_POST['post']['date_yyyy'],
  $_POST['post']['date_mm'],
  $_POST['post']['date_dd'],
  $_POST['post']['file_stub'],
)) . '.' . $_POST['post']['extension'];

$frontmatter = array(
  'layout' => 'podcast',
  'excerpt_separator' => '<!--excerpt-above-->',
);
$frontmatter['title'] = $_POST['title'];
$frontmatter['tagline'] = $_POST['tagline'];
$frontmatter['author'] = $_POST['author'];
$frontmatter['explicit'] = $_POST['explicit'];
$frontmatter['layout'] = $_POST['layout'];
$frontmatter['permalink'] = $_POST['permalink'];
$frontmatter['sponsor'] = $_POST['sponsor'];
$frontmatter['categories'] = $_POST['categories'];
$frontmatter['media_url'] = $_POST['media_url'];
$frontmatter['media_length'] = $_POST['media_length'];
$frontmatter['media_type'] = $_POST['media_type'];
if (!empty(trim($_POST['bulk_show_notes']))) {
  $show_notes = explode("\n", trim($_POST['bulk_show_notes']));
  while (count($show_notes) >= 2) {
    $note_title = array_shift($show_notes);
    $note_link = array_shift($show_notes);
    if (count($show_notes)) {
      $note_description = array_shift($show_notes);
    } else {
      $note_description = '';
    }
    // Add this shownote.
    $frontmatter['show_notes'][] = array(
      'title' => $note_title,
      'link' => $note_link,
      'description' => $note_description,
    );
  }
} else {
  for ($i = 0; $i < count($_POST['note_title']); $i++) {
    if (!empty($_POST['note_title'][$i]) && !empty($_POST['note_link'][$i])) {
      // Add this shownote.
      $frontmatter['show_notes'][] = array(
        'title' => $_POST['note_title'][$i],
        'link' => $_POST['note_link'][$i],
        'description' => $_POST['note_description'][$i],
      );
    }
  }
}
// Build the Frontmatter string.
$yaml = Yaml::dump($frontmatter);
// Tweak the YAML for Frontmatter and Jekyll.
$yaml = str_replace(array('{', '}'), '', $yaml);
$yaml = str_replace(', link', "\n       link", $yaml);
$yaml = str_replace(', description', "\n       description", $yaml);
// Build the final string to write out.
$post_string = "---\n";
$post_string .= $yaml;
$post_string .= "\n---\n";
$post_string .= $_POST['body'];

// Write the new file.
if (!is_writable($postsDir)) {
  // Jekyll _posts dir is unwritable.
  $vars['write_status'] = 'danger';
  $vars['write_message'] = "The _posts directory is unwriteable. " .
    "Dir: " . $postsDir;
} else {
  $write_bytes = file_put_contents($postsDir . $build_filename, $post_string);
  if ($write_bytes) {
    // New post written.
    $vars['write_status'] = 'success';
    $vars['write_message'] = sprintf(
      "Wrote %d bytes to %s.",
      $write_bytes,
      $build_filename
    );
    if (
      $_POST['src_file'] != $postsDir . $build_filename &&
      strpos($_POST['src_file'], $postsDir) === 0
      ) {
      // The post is being saved to a different filename and the src_file is
      // pointing to the correct directory... Delete the original.
      unlink($_POST['src_file']);
    }
    header('Location: ' . '/post.php?p=' . $build_filename);
    die();
  } else {
    // Failed to write to the file.
    $vars['write_status'] = 'danger';
    $vars['write_message'] = sprintf("Cannot write to %s.", array(
      $build_filename,
    ));
  }
}

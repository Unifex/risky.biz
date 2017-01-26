<?php

require __DIR__ . '/vendor/autoload.php';

use perchten\rmrdir;

Twig_Autoloader::register();

$vars['states'] = array();
$states = array();

$build_sites = array('staging', 'production');
foreach ($build_sites as $site_state) {
  if (file_exists('/tmp/build_' . $site_state)) {
    chmod('/tmp/build_' . $site_state, '0777');
    $states[] = '+++ ' . ucfirst($site_state) . ' +++';
    $states = array_merge(
      $states,
      explode("\n", file_get_contents('/tmp/build_' . $site_state))
    );
  }
}

if (file_exists('/tmp/last_build')) {
  $states = array_merge(
    $states,
    explode("\n", file_get_contents('/tmp/last_build'))
  );
}

if (!empty($states)) {
  $vars['states'] = array_filter($states);
}

// Prep template.
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$template_dir = dirname(__FILE__) . '/templates';
if (!empty($_GET['cc'])) {
  rmrdir($tmp_cache_dir);
}
if (!is_dir($tmp_cache_dir)) {
  mkdir($tmp_cache_dir, 0700);
}

$loader = new Twig_Loader_Filesystem($template_dir);
$twig = new Twig_Environment($loader, array(
  'cache' => $tmp_cache_dir,
));

try {
  $template = $twig->loadTemplate('site_status.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

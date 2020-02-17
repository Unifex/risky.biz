<?php
$tmp_dir = dirname(__FILE__) . '/tmp';

require __DIR__ . '/vendor/autoload.php';

use perchten\rmrdir;

Twig_Autoloader::register();

$vars['states'] = array();
$states = array();

$build_sites = array('staging', 'master');
foreach ($build_sites as $site_state) {
  if (file_exists($tmp_dir . '/build_' . $site_state)) {
    chmod($tmp_dir, 0777);
    if (!chmod($tmp_dir . '/build_' . $site_state, 0777)) {
      print "error on chmod";
    }
    $states[] = '+++ ' . ucfirst($site_state) . ' +++';
    $states = array_merge(
      $states,
      explode("\n", file_get_contents($tmp_dir . '/build_' . $site_state))
    );
  } else {
    $states[] = "File does not exist (looking for {$tmp_dir}/build_" . $site_state . ")";
    $states[] = ">> " . ucfirst($site_state) . " build has not been requested.";
  }
}

if (file_exists($tmp_dir . '/last_build')) {
  $states[] = '+++ Build Log +++';
  $states = array_merge(
    $states,
    explode("\n", file_get_contents($tmp_dir . '/last_build'))
  );
} else {
  $states[] = "File does not exist (looking for {$tmp_dir}/last_build)";
  $states[] = ">> Build is not in progress.";
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
  mkdir($tmp_cache_dir, 0770);
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

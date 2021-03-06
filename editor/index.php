<?php

require __DIR__ . '/vendor/autoload.php';

Twig_Autoloader::register();

use jc21\FileList;
use perchten\rmrdir;

$tmp_dir = dirname(__FILE__) . '/tmp';
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$template_dir = dirname(__FILE__) . '/templates';
if (!empty($_GET['cc'])) {
  if (file_exists($tmp_cache_dir)) {
    rmrdir($tmp_cache_dir);
  }
  if (file_exists($tmp_dir)) {
    rmrdir($tmp_dir);
  }
}
if (!is_dir($tmp_cache_dir)) {
  mkdir($tmp_cache_dir, 0770);
}
if (!file_exists($tmp_dir)) {
  mkdir($tmp_dir);
  chmod ($tmp_dir, 0777);
}

$siteSrc = '../jekyll_src/';
$postsDir = $siteSrc . '_posts/';
$vars = array();

# Posts
$fileList = new FileList;
$items = $fileList->get($postsDir, FileList::TYPE_FILE, FileList::KEY_NAME, FileList::DESC);
$vars['item_count'] = count($items);
foreach ($items as $item) {
  $bits = explode('-', $item['name']);
  if (empty($vars['items'][$bits[0]][$bits[1]])) {
    $vars['items'][$bits[0]][$bits[1]] = 1;
  } else {
    $vars['items'][$bits[0]][$bits[1]]++;
  }
}

foreach ($vars['items'] as $year => $months) {
  ksort($vars['items'][$year]);
}

$loader = new Twig_Loader_Filesystem($template_dir);
$twig = new Twig_Environment($loader, array(
  'cache' => $tmp_cache_dir,
));

// Check build states.
$build_sites = array('staging', 'production');
foreach ($build_sites as $site_state) {
  if (file_exists($tmp_dir . '/build_' . $site_state)) {
    $states[] = '+++ ' . ucfirst($site_state) . ' +++';
    $states = array_merge(
      $states,
      explode("\n", file_get_contents($tmp_dir . '/build_' . $site_state))
    );
  }
}
if (!empty($states)) {
  $vars['states'] = array_filter($states);
}

try {
  $template = $twig->loadTemplate('index.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

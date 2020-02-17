<?php

require __DIR__ . '/vendor/autoload.php';

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;
use perchten\rmrdir;

$parser = new Mni\FrontYAML\Parser();

$siteSrc = '../jekyll_src/';
$dataDir = realpath($siteSrc . '_data') . '/';
$sponsorList = array();
$currentPost = array();
$vars = array(
  'sponsor_active' => '',
  'write_message' => '',
  'write_status' => '',
  'debug_show' => FALSE,
  'debug_message' => '',
);

# Data dir. (adds sponsors.)
$fileList = new FileList;
$items = $fileList->get($dataDir, FileList::TYPE_FILE);
foreach ($items as $item) {
  $filename = $dataDir . $item['name'];
  $str = file_get_contents($filename);
  $bits = explode('.', $item['name']);
  $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
}

if (!empty($_GET['woot'])) {
  if (!empty($vars['sponsors'][$_GET['woot']])) {
    $vars['write_status'] = 'success';
    $vars['write_message'] = $vars['sponsors'][$_GET['woot']]['name'] . ' updated.';
  }
}

if (!empty($_POST)) {
  require_once('write_sponsors.php');
}

if (!empty($_GET['e'])) {
  // Do we have an existing sponsor to edit or delete?
  if (!empty($vars['sponsors'][$_GET['e']])) {
    $vars['edit'] = $vars['sponsors'][$_GET['e']];
    $vars['edit']['key'] = $_GET['e'];
  }
}

// Prep template.
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$cache_dir = dirname(__FILE__) . '/templates';
if (!empty($_GET['cc'])) {
  rmrdir($tmp_cache_dir);
}
if (!is_dir($tmp_cache_dir)) {
  mkdir($tmp_cache_dir, 0770);
}
$loader = new Twig_Loader_Filesystem($cache_dir);
$twig = new Twig_Environment($loader, array(
  'cache' => $tmp_cache_dir,
));

try {
  $template = $twig->loadTemplate('sponsor_editor.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

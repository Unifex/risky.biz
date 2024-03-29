<?php

require __DIR__ . '/vendor/autoload.php';

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;
use perchten\rmrdir;

$parser = new Mni\FrontYAML\Parser();

$siteSrc = '../jekyll_src/';
$dataDir = realpath($siteSrc . '_data') . '/';
$authorDir = realpath($siteSrc . 'author') . '/';
$authorList = array();
$currentPost = array();
$vars = array(
  'author_active' => '',
  'write_message' => '',
  'write_status' => '',
  'debug_show' => FALSE,
  'debug_message' => '',
);

# Data dir. (adds authors.)
$fileList = new FileList;
$items = $fileList->get($dataDir, FileList::TYPE_FILE);
foreach ($items as $item) {
  if ($item['ext'] == 'yml') {
    $vars['debug_message'] .= '$item = ' . print_r($item, a) . "<br />\n";
    $filename = $dataDir . $item['name'];
    $str = file_get_contents($filename);
    $bits = explode('.', $item['name']);
    $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
  }
}

if (!empty($_GET['woot'])) {
  if (!empty($vars['authors'][$_GET['woot']])) {
    $vars['write_status'] = 'success';
    $vars['write_message'] = $vars['authors'][$_GET['woot']]['name'] . ' updated.';
  }
}
if (isset($_GET['woot'])) {
  require_once('write_author_templates.php');
}

if (!empty($_POST)) {
  require_once('write_authors.php');
}

if (!empty($_GET['e'])) {
  // Do we have an existing author to edit or delete?
  if (!empty($vars['authors'][$_GET['e']])) {
    $vars['edit'] = $vars['authors'][$_GET['e']];
    $vars['edit']['key'] = $_GET['e'];
  }
}

// Prep template.
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$cache_dir = dirname(__FILE__) . '/templates';
$vars['debug_message'] .= '$tmp_cache_dir = ' . $tmp_cache_dir . "<br />\n";
$vars['debug_message'] .= '$cache_dir = ' . $cache_dir . "\n";
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
  $template = $twig->loadTemplate('author_editor.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>===";
}

<?php

require __DIR__ . '/vendor/autoload.php';

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;
use perchten\rmrdir;

$parser = new Mni\FrontYAML\Parser();

$siteSrc = '../jekyll_src/';
$postsDir = $siteSrc . '_posts/';
$dataDir = $siteSrc . '_data/';
$postList = array();
$currentPost = array();
$vars = array(
  'index_active' => '',
  'post_active' => '',
  'file_types' => array(
    'md' => 'Markdown',
    'html' => 'HTML',
  ),
  'src_file' => '',
  'write_message' => '',
  'write_status' => '',
  'post_types' => array(
    'podcast' => 'Podcast',
    'blog' => 'Blog',
  ),
);

if (!empty($_POST)) {
  require_once('write_post.php');
}

# Data dir.
$fileList = new FileList;
$items = $fileList->get($dataDir, FileList::TYPE_FILE);
foreach ($items as $item) {
  $filename = $dataDir . $item['name'];
  $str = file_get_contents($filename);
  $bits = explode('.', $item['name']);
  $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
}

$file_date_dd = date('d');
$file_date_mm = date('m');
$file_date_yyyy = date('Y');
$file_stub = '';
$file_extension = 'md';

if (!empty($_GET['p'])) {
  $filename = $postsDir . $_GET['p'];
  $vars['src_file'] = $filename;
  $str = file_get_contents($filename);
  $document = $parser->parse($str, false);

  $file_bits = explode("-", $_GET['p']);
  $last_bit = count($file_bits) - 1;
  $file_bits[$last_bit] = explode(".", $file_bits[$last_bit]);
  $file_extension = $file_bits[$last_bit][1];
  $file_bits[$last_bit] = $file_bits[$last_bit][0];

  $file_date_dd = $file_bits[2];
  $file_date_mm = $file_bits[1];
  $file_date_yyyy = $file_bits[0];
  $file_stub = implode('-', array_slice($file_bits, 3));

  $yaml = $document->getYAML();
  $body= $document->getContent();

  $currentPost = $yaml;
  $currentPost['body'] = $body;
}
$vars['post'] = $currentPost;
$vars['post']['file_date_dd'] = $file_date_dd;
$vars['post']['file_date_mm'] = $file_date_mm;
$vars['post']['file_date_yyyy'] = $file_date_yyyy;
$vars['post']['file_stub'] = $file_stub;
$vars['post']['file_extension'] = $file_extension;

// Prep template.
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$cache_dir = dirname(__FILE__) . '/templates';
if (!empty($_GET['cc'])) {
  rmrdir($tmp_cache_dir);
}
if (!is_dir($tmp_cache_dir)) {
  mkdir($tmp_cache_dir, 0700);
}
$loader = new Twig_Loader_Filesystem($cache_dir);
$twig = new Twig_Environment($loader, array(
  'cache' => $tmp_cache_dir,
));

try {
  $template = $twig->loadTemplate('post_editor.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

<?php

require __DIR__ . '/vendor/autoload.php';

Twig_Autoloader::register();

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;
use perchten\rmrdir;

$parser = new Mni\FrontYAML\Parser();

//$validation_url = 'http://risky.biz/export/blogs/urls';
# @TODO: Only fetch if this isn't a 404.
//$file = file_get_contents($validation_url);
//$spans = htmlqp($validation_url, '.view-blog-urls span.field-content')->toArray();
//$src_blog_paths = array();
//foreach ($spans as $span) {
//  $src_blog_paths[] = trim($span->nodeValue) . '/';
//}

$blog_paths = array();

$siteSrc = '../jekyll_src/';
$postsDir = $siteSrc . '_posts/';
$dataDir = $siteSrc . '_data/';
$postList = array();
$currentPost = array();
$vars = array(
  'index_active' => '',
  'post_active' => '',
  'subtitle' => '',
);

# Data dir.
$fileList = new FileList;
$items = $fileList->get($dataDir, FileList::TYPE_FILE);
foreach ($items as $item) {
  $filename = $dataDir . $item['name'];
  $str = file_get_contents($filename);
  $bits = explode('.', $item['name']);
  switch (end($bits)) {
    case 'yaml':
    case 'yml':
      $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
      break;

    case 'csv':
      $csv = array_map('str_getcsv', file($filename));
      $csv_header = array_shift($csv);
      $csv_data = array();
      foreach ($csv as $row) {
        $csv_data[] = array_combine($csv_header, $row);
      }
      $vars[$bits[0]] = $csv_data;
  }
}

# Posts
$fileList = new FileList;
$items = $fileList->get($postsDir, FileList::TYPE_FILE, FileList::KEY_NAME, FileList::DESC);
if (!empty($_GET['y']) && is_numeric($_GET['y'])) {
  $stub = $_GET['y'];
  if (!empty($_GET['m']) && is_numeric($_GET['m'])) {
    $stub .= '-' . $_GET['m'];
    $vars['subtitle'] = date('F, Y', mktime(0, 0, 0, $_GET['m'], 1, $_GET['y']));
  }
}

foreach ($items as $item) {
  if (!empty($stub) && strpos($item['name'], $stub) !== 0) {
    continue;
  }

  $filename = $postsDir . $item['name'];
  $str = file_get_contents($filename);
  $document = $parser->parse($str, false);
  $yaml = $document->getYAML();
  if ($yaml['layout'] == 'blog') {
    $postList[] = array(
      'href' => "/post.php?p=" . $item['name'],
      'text' => $yaml['title'],
    );
    $src_blog_paths = array_diff($src_blog_paths, array($yaml['permalink']));
  }
}

$posts = array();
$posts[] = array(
  'category' => 'blog',
  'heading' => 'Blogs',
  'posts' => $postList,
);

//$postList = array();
//foreach ($src_blog_paths as $src_path) {
//  $postList[] = array(
//    'href' => "/post.php?i=" . $src_path,
//    'text' => $src_path,
//  );
//}
//$posts[] = array(
//  'category' => 'unimported-blogs',
//  'heading' => 'Unimported Blogs',
//  'posts' => $postList,
//);
$vars['posts'] = $posts;

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
  'debug' => true,
));
$twig->addExtension(new Twig_Extension_Debug());

try {
  $template = $twig->loadTemplate('blog_list.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

<?php

require __DIR__ . '/vendor/autoload.php';

Twig_Autoloader::register();

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;

$parser = new Mni\FrontYAML\Parser();

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
  $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
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
  }
  $posts = array();
  $posts[] = array(
    'category' => blog,
    'heading' => 'Blog',
    'posts' => $postList,
  );

  $vars['posts'] = $posts;
  /*
  if (!empty($_GET['p']) && $_GET['p'] == $item['name']) {
    $currentPost = $yaml;
    $currentPost['body'] = $body;
    $currentPost['file'] = $item;
    $vars['post_active'] = 'active';
  }
  $vars['post'] = $currentPost;
  */
}
/*
if (empty($vars['post_active'])) {
  $vars['index_active'] = 'active';
}
*/
// Prep template.
$tmp_cache_dir = dirname(__FILE__) . '/template_cache';
$template_dir = dirname(__FILE__) . '/templates';
if (!is_dir($tmp_cache_dir)) {
  mkdir($tmp_cache_dir, 0700);
}
$loader = new Twig_Loader_Filesystem($template_dir);
$twig = new Twig_Environment($loader, array(
  'cache' => $tmp_cache_dir,
));

try {
  $template = $twig->loadTemplate('blog_list.html');
  echo $template->render($vars);
} catch (Twig_Error_Syntax $e) {
  // $template contains one or more syntax errors
  echo "+++<pre>";
  print_r($e);
  echo "</pre>+++";
}

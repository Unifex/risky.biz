<?php

require __DIR__ . '/vendor/autoload.php';

use jc21\FileList;
use Symfony\Component\Yaml\Yaml;
use perchten\rmrdir;

$parser = new Mni\FrontYAML\Parser();

$siteSrc = '../jekyll_src/';
$dataDir = $siteSrc . '_data/';

# Data dir. (adds sponsors.)
$fileList = new FileList;
$items = $fileList->get($dataDir, FileList::TYPE_FILE);
foreach ($items as $item) {
  if ($item['ext'] != 'yml') {
    continue;
  }
  $filename = $dataDir . $item['name'];
  $str = file_get_contents($filename);
  $bits = explode('.', $item['name']);
  $vars[$bits[0]] = Yaml::parse(file_get_contents($filename));
}
$sponsor = $vars['sponsors'][$_GET['i']];
$banner = $siteSrc . $sponsor['banner_url'];
if (true) {
  $fake_it = false;
  $type = mime_content_type($banner);
  if ($type == 'image/svg') {
    $type += '+xml';
    $fake_it = true;
  }
  if ($type == 0) {
    // Select type based on extension.
    $bits = explode('.', $banner);
    $ext = array_pop($bits);
    switch ($ext) {
        case 'svg':
          $type = 'image/svg+xml';
    }
  }
  // Fake the type.
  header('Content-Type: ' . $type);
  header('Content-Length: ' . filesize($banner));
  if ($fake_it) {
    echo '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
  }
  readfile($banner);
} else {
  echo "<pre>";
  echo 'Content-Type: ' . mime_content_type($banner) . "\n";
  echo 'Content-Length: ' . filesize($banner) . "\n";
}
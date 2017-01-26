<?php
$tmp_dir = dirname(__FILE__) . '/tmp';

if (empty($_GET['site'])) {
  header('Location: /');
}
if (!preg_match('/[^a-z]/', $_GET['site'])) {
  echo "matched " . $_GET['site'];
  switch ($_GET['site']) {
    case 'staging':
    case 'master':
      if (!file_exists($tmp_dir . '/build_' . $_GET['site'])) {
        file_put_contents($tmp_dir . '/build_' . $_GET['site'], "build requested\n");
      }
      chmod($tmp_dir . '/build_' . $_GET['site'], octdec(0777));
  }
}
header('Location: /');

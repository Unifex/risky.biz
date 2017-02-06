<?php
$tmp_dir = dirname(__FILE__) . '/tmp';

if (empty($_GET['site'])) {
  header('Location: /');
}
if (!preg_match('/[^a-z]/', $_GET['site'])) {
  switch ($_GET['site']) {
    case 'staging':
    case 'master':
      $this_request_exists = file_exists($tmp_dir . '/build_' . $_GET['site']);
      $staging_request_exists = file_exists($tmp_dir . '/build_staging');
      if (!$this_request_exists && !$staging_request_exists) {
        if (!file_exists($tmp_dir)) {
          mkdir($tmp_dir, 0777);
        }
        file_put_contents($tmp_dir . '/build_' . $_GET['site'], "build requested\n");
        chmod($tmp_dir . '/build_' . $_GET['site'], 0777);
      }
  }
}
header('Location: /');

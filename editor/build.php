<?php

if (empty($_GET['site'])) {
  header('Location: /');
}
if (!preg_match('/[^a-z]/', $_GET['site'])) {
  echo "matched " . $_GET['site'];
  switch ($_GET['site']) {
    case 'staging':
    case 'master':
      if (!file_exists('/tmp/build_' . $_GET['site'])) {
        file_put_contents('/tmp/build_' . $_GET['site'], "build requested\n");
      }
      chmod('/tmp/build_' . $_GET['site'], 'ug_rw');
  }
}
header('Location: /');

<?php

require_once __DIR__ . '/../vendor/autoload.php';

use jc21\FileList;

$fileList = new FileList;
$items    = $fileList->get('../');

foreach ($items as $item) {
    if ($item[FileList::KEY_TYPE] == FileList::TYPE_DIR) {
        print 'd' . "\t" . $item[FileList::KEY_NAME] . PHP_EOL;
    } else {
        print 'f' . "\t" . $item[FileList::KEY_NAME] . "\t" . $item[FileList::KEY_SIZE] . "\t" . date('Y-m-d', $item[FileList::KEY_DATE]) . PHP_EOL;
    }
}

File Listing helper class for PHP
================================================

- List files from a directory
- Filter for only directories, files or file types
- Sort and limit the listing items

### Installing via Composer

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version:

```bash
composer.phar require jc21/filelist
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Using

```php
use jc21\FileList;

$fileList = new FileList;

$items = $fileList->get('/path/to/files');

// Use the items array
print '<pre>';
foreach ($items as $item) {
    if ($item[FileList::KEY_TYPE] == FileList::TYPE_DIR) {
        print 'd' . "\t" . $item[FileList::KEY_NAME] . PHP_EOL;
    } else {
        print 'f' . "\t" . $item[FileList::KEY_NAME] . "\t" . $item[FileList::KEY_SIZE] . "\t" . date('Y-m-d', $item[FileList::KEY_DATE]) . PHP_EOL;
    }
}
print '</pre>';
```

Or to get only directories:

```php
$items = $fileList->get('/path/to/files', FileList::TYPE_DIR);
```

Or only files:

```php
$items = $fileList->get('/path/to/files', FileList::TYPE_FILE);
```

Or only files of a certain extension:

```php
$extensions = array('jpg', 'png', 'jpeg', 'gif');
$items      = $fileList->get('/path/to/files', FileList::TYPE_DIR, FileList::KEY_NAME, FileList::ASC, null, $extensions);
```

Order by the Size descending:
```php
$items = $fileList->get('/path/to/files', FileList::TYPE_DIR, FileList::KEY_SIZE, FileList::DESC);
```


<?php
// +---------------------------------------------------------------+
// | File List helper class                                        |
// +---------------------------------------------------------------+
// | List files and folders with filtering                         |
// +---------------------------------------------------------------+
// | Licence: MIT                                                  |
// +---------------------------------------------------------------+
// | Copyright: Jamie Curnow  <jc@jc21.com>                        |
// +---------------------------------------------------------------+
//

namespace jc21;

class FileList {

    const KEY_TYPE = 'type';
    const KEY_NAME = 'name';
    const KEY_DATE = 'date';
    const KEY_SIZE = 'size';
    const KEY_EXT  = 'ext';

    const ASC  = 'asc';
    const DESC = 'desc';

    const TYPE_BOTH = 'both';
    const TYPE_DIR  = 'dir';
    const TYPE_FILE = 'file';

    /**
     * Callback for File Type and Name Filters
     *
     * @var callable
     *
     **/
    protected $filterCallback = false;

    /**
     * Stores the last directory listing total size in bytes
     *
     * @var int
     *
     **/
    protected $lastSize = 0;

    /**
     * Stores the last directory listing total number of files
     *
     * @var int
     *
     **/
    protected $lastItemCount = 0;


    /**
     * Sets the Filter Callback
     *
     * @param  string|array  $object
     * @return void
     */
    public function setFilterCallback($object)
    {
        $this->filterCallback = $object;
    }


    /**
     * Order the results of a directory listing
     *
     * @param  array   $items
     * @param  string  $type
     * @param  string  $by
     * @param  string  $direction
     * @return array
     */
    protected function sort($items, $type = self::TYPE_BOTH, $by = self::KEY_NAME, $direction = self::ASC)
    {
        $returnArray = array();
        if (count($items) > 0) {
            $tmpArray = array();
            foreach($items as $key => $value) {
                $tmpArray[$key] = $value[$by];
            }

            natcasesort($tmpArray);

            if ($direction == self::DESC) {
                $tmpArray = array_reverse($tmpArray, true);
            }

            foreach($tmpArray as $key => $value) {
                $returnArray[] = $items[$key];
            }

            // If sorting by name, lets seperate the files from the dirs.
            if ($by == self::KEY_NAME && $type == self::TYPE_BOTH) {
                $files = array();
                $dirs  = array();

                foreach ($returnArray as $value) {
                    if ($value[self::KEY_TYPE] == self::TYPE_FILE) {
                        $files[] = $value;
                    } elseif ($value[self::KEY_TYPE] == self::TYPE_DIR) {
                        $dirs[] = $value;
                    }
                }

                if ($direction == self::DESC) {
                    $returnArray = array_merge($files, $dirs);
                } else {
                    $returnArray = array_merge($dirs, $files);
                }
            }
        }
        return $returnArray;
    }


    /**
     * Return the listing of a directory
     *
     * @param  string $directory
     * @param  string $type
     * @param  string $order
     * @param  string $direction
     * @param  int    $limit
     * @param  array  $fileExtensions
     * @return array
     * @throws \Exception
     */
    public function get($directory, $type = self::TYPE_BOTH, $order = self::KEY_NAME, $direction = self::ASC, $limit = null, $fileExtensions = array()) {
        // Get the contents of the dir
        $items     = array();
        $directory = rtrim($directory,'/');

        // Check Dir
        if (!is_dir($directory)) {
            throw new \Exception('Directory does not exist: ' . $directory);
        }

        // Get Raw Listing
        $directoryHandle = opendir($directory);
        while (false !== ($file = readdir($directoryHandle))) {
            // skip anything that starts with a '.' i.e.:('.', '..', or any hidden file)
            if (substr($file, 0, 1) != '.') {
                // Directories
                if (is_dir($directory . '/' . $file) && ($type == self::TYPE_BOTH || $type == self::TYPE_DIR)) {
                    $items[] = array(
                        self::KEY_TYPE => self::TYPE_DIR,
                        self::KEY_NAME => $file,
                        self::KEY_DATE => filemtime($directory.'/'.$file),
                        self::KEY_SIZE => filesize($directory.'/'.$file),
                        self::KEY_EXT  => ''
                    );

                // Files
                } else if (is_file($directory.'/'.$file) && ($type == self::TYPE_BOTH || $type == self::TYPE_FILE)) {
                    if (!count($fileExtensions) || in_array(self::getExtension($file), $fileExtensions)) {
                        $items[] = array(
                            self::KEY_TYPE => self::TYPE_FILE,
                            self::KEY_NAME => $file,
                            self::KEY_DATE => filemtime($directory.'/'.$file),
                            self::KEY_SIZE => filesize($directory.'/'.$file),
                            self::KEY_EXT  => self::getExtension($file)
                        );
                    }
                }
            }

            // Impose Limit, if specified
            if ($limit && count($items) >= $limit) {
                break;
            }
        }

        closedir($directoryHandle);

        // Sorting
        $items = $this->sort($items, $type, $order, $direction);

        // Callbacks
        if ($this->filterCallback) {
            $items = call_user_func($this->filterCallback, $items);
        }

        // Total Size
        $totalSize = 0;
        foreach ($items as $item) {
            $totalSize += $item[self::KEY_SIZE];
        }

        $this->lastSize = $totalSize;
        $this->lastItemCount = count($items);

        return $items;
    }


    /**
     * Returns the extension of a file, lowercase
     *
     * @param  string  $file
     * @return string
     */
    protected function getExtension($file)
    {
        if (strpos($file, '.') !== false) {
            $tempExt = strtolower(substr($file, strrpos($file, '.') + 1, strlen($file) - strrpos($file, '.')));
            return strtolower(trim($tempExt,'/'));
        }
        return '';
    }


    /**
     * Return the last listing size in bytes
     *
     * @return int
     */
    public function getLastSize() {
        return $this->lastSize;
    }


    /**
     * Return the last listing count of items
     *
     * @return int
     */
    public function getLastItemCount() {
        return $this->lastItemCount;
    }
}

<?php

namespace Ludmila\LSNewClasses\Model;

use \Magento\Framework\Filesystem\DirectoryList;

class ShowFiles
{
    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * ShowFiles constructor.
     * @param \Magento\Framework\Filesystem\DirectoryList $directoryList
     */
    public function __construct(
       DirectoryList $directoryList
    )
    {
        $this->directoryList = $directoryList;
    }

    /**
     * @return \RecursiveIteratorIterator
     */
    public function getFileList()
    {
        $path = realpath($this->directoryList->getRoot() . join(DIRECTORY_SEPARATOR, array('/app', 'code', 'Ludmila', 'LSNewClasses')));
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

        return $objects;
    }
}
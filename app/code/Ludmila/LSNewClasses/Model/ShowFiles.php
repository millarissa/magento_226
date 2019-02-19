<?php

namespace Ludmila\LSNewClasses\Model;

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
        \Magento\Framework\Filesystem\DirectoryList $directoryList
    )
    {
        $this->directoryList = $directoryList;
    }

    public function getFileList()
    {
        $path = $this->directoryList->getPath(join(DIRECTORY_SEPARATOR, array('app', 'code', 'Ludmila', 'LSNewClasses')));
        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);

        return $objects;
    }
}
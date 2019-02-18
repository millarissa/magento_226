<?php

namespace Ludmila\LSNewClasses\Model;

class ShowFiles
{

    /**
     * @var \Magento\Framework\Filesystem\DirectoryList
     */
    protected $_dir;

    /**
     * ShowFiles constructor.
     * @param \Magento\Framework\Filesystem\DirectoryList $dir
     */
    public function __construct(
        \Magento\Framework\Filesystem\DirectoryList $dir
    )
    {
        $this->_dir = $dir;
    }

    /**
     *
     */
    public function show()
    {
//        $path = realpath('/misc/apps/magento-226/app/code/Ludmila/LSNewClasses');

        $path = $this->_dir->getRoot();

        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path), \RecursiveIteratorIterator::SELF_FIRST);
        foreach($objects as $name => $object){
            echo "$name"." was modified on ".date('F d Y H:i:s',filemtime($name))."\n";
        }
    }
}

$foo1 = new ShowFiles();
$foo1->show();

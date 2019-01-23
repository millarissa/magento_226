<?php
namespace Ludmila\LSNewClasses\Block\Homework11;
use Ludmila\LSNewClasses\Model\ShowFiles;
use Ludmila\LSNewClasses\Model\ShowConstants;
use Ludmila\LSNewClasses\Model\ShowTypes;

/**
 * Class HomeworkOOP
 * @package Ludmila\LSNewClasses\Block\Homework11
 */
class HomeworkOOP extends \Magento\Framework\View\Element\Template {
    /**
     * @var ShowFiles
     */
    public $showFilesGet;
    /**
     * @var ShowConstants
     */
    public $showConstantsGet;
    /**
     * @var ShowTypes
     */
    public $showTypesGet;

    /**
     * HomeworkOOP constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param ShowConstants $showConstants
     * @param ShowFiles $showFiles
     * @param ShowTypes $showTypes
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        ShowConstants $showConstants,
        ShowFiles $showFiles,
        ShowTypes $showTypes
    ) {
        parent::__construct($context);
        $this->showFilesGet = $showFiles;
        $this->showConstantsGet = $showConstants;
        $this->showTypesGet = $showTypes;
    }
    /**
     * @return \RecursiveIteratorIterator
     */
    public function giveFileList(): \RecursiveIteratorIterator
    {
        return $this->showFilesGet->giveFileList();
    }
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods(): array
    {
        return $this->showConstantsGet->getMethods();
    }
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants(): array
    {
        return $this->showConstantsGet->getConstants();
    }
    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->showTypesGet->getParameters();
    }
}
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
    public $filesProvider;
    /**
     * @var ShowConstants
     */
    public $constantsProvider;
    /**
     * @var ShowTypes
     */
    public $typesProvider;

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
        $this->filesProvider = $showFiles;
        $this->constantsProvider = $showConstants;
        $this->typesProvider = $showTypes;
    }
    /**
     * @return \RecursiveIteratorIterator
     */
    public function getFileList(): \RecursiveIteratorIterator
    {
        return $this->filesProvider->getFileList();
    }
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getMethods(): array
    {
        return $this->constantsProvider->getMethods();
    }
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getConstants(): array
    {
        return $this->constantsProvider->getConstants();
    }
    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->typesProvider->getArgs();
    }
}
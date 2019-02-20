<?php
namespace Ludmila\LSNewClasses\Block\Homework11;
use Ludmila\LSNewClasses\Model\ShowFiles;
use Ludmila\LSNewClasses\Model\ShowConstants;
use Ludmila\LSNewClasses\Model\ShowTypes;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class HomeworkOOP
 * @package Ludmila\LSNewClasses\Block\Homework11
 */
class HomeworkOOP extends Template {
    /**
     * @var ShowFiles
     */
    private $filesProvider;
    /**
     * @var ShowConstants
     */
    private $constantsProvider;
    /**
     * @var ShowTypes
     */
    private $typesProvider;

    /**
     * HomeworkOOP constructor.
     * @param Context $context
     * @param ShowConstants $showConstants
     * @param ShowFiles $showFiles
     * @param ShowTypes $showTypes
     */
    public function __construct(
        Context $context,
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
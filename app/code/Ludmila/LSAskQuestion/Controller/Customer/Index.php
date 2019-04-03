<?php
namespace Ludmila\LSAskQuestion\Controller\Customer;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Class Index
 * @package Ludmila\LSAskQuestion\Controller\Customer
 */
class Index extends Action
{
    /**
     * Question constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('My Questions'));
        $this->_view->renderLayout();
    }
}
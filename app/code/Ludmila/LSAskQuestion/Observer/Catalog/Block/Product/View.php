<?php
namespace Ludmila\LSAskQuestion\Observer\Catalog\Block\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Registry;
use Magento\Customer\Model\Session;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class View
 * @package Ludmila\LSAskQuestion\Observer\Catalog\Block\Product
 */
class View implements \Magento\Framework\Event\ObserverInterface
{
    const LAYOUT_HANDLE_NAME = 'catalog_product_view_questionslist';
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * View constructor.
     * @param Registry $registry
     * @param Session $customerSession
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession)
    {
        $this->_registry = $registry;
        $this->customerSession = $customerSession;
    }
    /**
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $event = $observer->getEvent();
        $actionName = $event->getData('full_action_name');
        $product = $this->_registry->registry('current_product');

        if ($product && $actionName === 'catalog_product_view' && !$this->customerSession->getCustomer()->getDisallowAskQuestion()) {
            $layout = $event->getData('layout');
            $layoutUpdate = $layout->getUpdate();
            $layoutUpdate->addHandle(static::LAYOUT_HANDLE_NAME);
        }

        return $this;
    }
}
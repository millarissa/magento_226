<?php
namespace Ludmila\LSAskQuestion\Observer\Catalog\Block\Product;
use Magento\Framework\Event\Observer;
class View implements \Magento\Framework\Event\ObserverInterface
{

    const LAYOUT_HANDLE_NAME = 'catalog_product_view_questionslist';
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;
    /**
     * View constructor.
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(\Magento\Framework\Registry $registry)
    {
        $this->_registry = $registry;
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
        if ($product && $actionName === 'catalog_product_view' && $product->getAllowToAskQuestions()) {
            $layout = $event->getData('layout');
            $layoutUpdate = $layout->getUpdate();
            $layoutUpdate->addHandle(static::LAYOUT_HANDLE_NAME);
        }
        return $this;
    }
}
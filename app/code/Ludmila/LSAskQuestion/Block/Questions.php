<?php
namespace Ludmila\LSAskQuestion\Block;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\Collection;
class Questions extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_registry;

    /**
     * Questions constructor.
     * @param \Magento\Framework\Registry $registry
     * @param \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_registry = $registry;
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }
    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuestions()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection
            ->addFieldToFilter('sku', ['eq' => $this->getCurrentProduct()->getSku()])
            ->addStoreFilter()
            ->getSelect()
            ->orderRand();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }
        return $collection;
    }
    /**
     * @return mixed
     */
    public function getCurrentProduct()
    {
        return $this->_registry->registry('current_product');
    }
}
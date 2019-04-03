<?php
namespace Ludmila\LSAskQuestion\Block;

use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\Collection;
use Magento\Framework\Exception\LocalizedException;

class Requests extends \Magento\Framework\View\Element\Template
{
    const CUSTOMERS_LIMIT = 10;
    /**
     * @var \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory
     */
    private $collectionFactory;
    private $customerSession;

    /**
     * Requests constructor.
     * @param \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
    }
    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getQuestions(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();
        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }
        return $collection;
    }

    /**
     * @param \Magento\Customer\Model\Customer $customer
     * @return Collection
     * @throws LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getQuestionsByCustomer(\Magento\Customer\Model\Customer $customer): Collection
    {
        if (!$customer->getId()) {
            throw new LocalizedException(__('No customer has been found!'));
        }
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();
        $collection->addFieldToFilter('customer_id', ['eq' => $customer->getId()]);
        $limit = $this->getData('limit') ?: self::CUSTOMERS_LIMIT;
        $collection->setPageSize($limit);
        return $collection;
    }

    /**
     * @return Collection
     * @throws LocalizedException
     */
    public function getMyQuestions()
    {
        $currentCustomer = $this->customerSession->getCustomer();
        return $this->getQuestionsByCustomer($currentCustomer);
    }
}
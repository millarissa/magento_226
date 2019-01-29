<?php
namespace Ludmila\LSAskQuestion\Controller\Adminhtml\Question;
use Magento\Backend\App\Action\Context;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\Collection;

/**
 * Class AllQuestStatus
 * @package Ludmila\LSAskQuestion\Controller\Adminhtml\Question
 */
class AllQuestStatus extends AbstractMassAction
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * AllQuestStatus constructor.
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * @param Collection $collection
     * @return mixed
     */
    protected function massAction(Collection $collection)
    {
        $questionChangeStatus = 0;
        foreach ($collection as $rate) {
            $rate->setStatus('answered')->save();
            $questionChangeStatus++;
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath($this->getComponentRefererUrl());
        return $resultRedirect;
    }
}
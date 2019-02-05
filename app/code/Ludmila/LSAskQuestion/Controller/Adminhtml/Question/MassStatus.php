<?php
namespace Ludmila\LSAskQuestion\Controller\Adminhtml\Question;

use Magento\Backend\App\Action\Context;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Controller\ResultFactory;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\Collection;


/**
 * Class MassStatus
 * @package Ludmila\LSAskQuestion\Controller\Adminhtml\Question
 */

class MassStatus extends \Magento\Backend\App\Action

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
     * MassStatus constructor.
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
//    protected function massAction(Collection $collection)
//    {
//        $questionChangeStatus = 0;
//        foreach ($collection as $rate) {
//            $rate->setStatus('answered')->save();
//            $questionChangeStatus++;
//        }
//        if ($questionChangeStatus) {
//            $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $questionChangeStatus));
//        }
//        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
//        $resultRedirect->setPath($this->getComponentRefererUrl());
//        return $resultRedirect;
//    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|\Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */

    public function execute()
    {
//        $statusValue = $this->getRequest()->getParam('status');
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $questionChangeStatus = 0;
        foreach ($collection as $rate) {
//            $rate->setStatus($statusValue)->save();
            $rate->setStatus('processed')->save();
            $questionChangeStatus++;
        }

//        $this->messageManager->addSuccess(__('A total of %1 record(s) have been modified.', $collection->getSize()));

//        if ($questionChangeStatus) {
            $this->messageManager->addSuccess(__('A total of %1 record(s) were updated.', $questionChangeStatus));
//        }


        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
//        $resultRedirect->setPath($this->getComponentRefererUrl());
//        return $resultRedirect;
    }


}
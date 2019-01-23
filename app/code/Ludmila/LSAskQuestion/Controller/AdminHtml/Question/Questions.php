<?php
namespace Ludmila\LSAskQuestion\Controller\Adminhtml\Question;
use Magento\Framework\Controller\ResultFactory;
class Questions extends \Magento\Backend\App\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('All Questions'));

        return $resultPage;
    }
}
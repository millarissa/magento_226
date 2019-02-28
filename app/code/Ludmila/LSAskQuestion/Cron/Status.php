<?php
namespace Ludmila\LSAskQuestion\Cron;

use Ludmila\LSAskQuestion\Model\AskQuestion;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory;

/**
 * Class Status
 * @package Ludmila\LSAskQuestion\Cron
 */
class Status
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * Status constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $collectionFactory
    ) {
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
    }

    public function execute()
    {
        $date = date("Y-m-d h:i:s");
        $numberDays = strtotime('-' . $this->getNumberOfDays() . ' day', strtotime($date));
        $newDate = date('Y-m-d h:i:s', $numberDays);

        $collection = $this->collectionFactory->create();
        $collection
            ->addFieldToFilter('status', AskQuestion::STATUS_PENDING)
            ->addFieldToFilter('created_at', array('lt' => $newDate));

        foreach ($collection as $item) {
            $item->setStatus( AskQuestion::STATUS_PROCESSED)->save();
        }

        $this->logger->info('Cron Job Statuses changed ');
    }

    /**
     * @return int
     */
    protected function getNumberOfDays(){
        return 3;
    }
}
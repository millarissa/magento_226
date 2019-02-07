<?php
namespace Ludmila\LSAskQuestion\Cron;
class Status
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Status constructor.
     * @param \Psr\Log\LoggerInterface $logger
     * @param Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $askQuestionsFactory
     */
    public function __construct(\Psr\Log\LoggerInterface $logger,  Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory $askQuestionsFactory)
    {
        $this->logger = $logger;
        $this->questionsFactory = $askQuestionsFactory;
    }

    public function execute()
    {
        $date = date("Y-m-d h:i:s");
        $numberDays = strtotime('-' . $this->getNumberOfDays() . ' minutes', strtotime($date));
        $newDate = date('Y-m-d h:i:s', $numberDays);

        $questions = $this->questionsFactory->create();

//        $orders = Mage::getModel('sales/order')->getCollection()
//            ->addFieldToFilter('status', 'pending')
//            ->addFieldToFilter('cod_fee', array('null' => true))
//        ;

        $collection = $questions->getCollection()
            ->addFieldToFilter('status', 'pending')
            ->addFieldToFilter('created_at', array('lt' => $newDate))
        ;


//        foreach ($orders as $order) {
//            if (strtotime($order->getCreatedAt()) < $old_time)  {
//                try{
//                    $id = $order->getIncrementId();
//
//                    Mage::getModel('sales/order')
//                        ->loadByIncrementId($id)
//                        ->setState('pending_payment', true)
//                        ->save();
//
//                    $out .= $id."\n";
//                } catch (Exception $e)  {
//                    $out .= "Caught exception : ".$e->getMessage()."\n";
//                }
//            }
//        }


        foreach ($collection as $item) {
            $item->setStatus('processed')->save();
        }
//                $this->logger->info('Cron Job Statuses changed');

    }

    public function getNumberOfDays(){
        return 3;
    }

//


}
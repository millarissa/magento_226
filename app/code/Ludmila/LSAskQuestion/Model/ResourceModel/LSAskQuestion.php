<?php
namespace Ludmila\LSAskQuestion\Model\ResourceModel;
class LSAskQuestion extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('ludmila_ask_question', 'question_id');
    }
}
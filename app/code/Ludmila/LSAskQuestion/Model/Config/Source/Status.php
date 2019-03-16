<?php
namespace Ludmila\LSAskQuestion\Model\Config\Source;
use Magento\Framework\Data\OptionSourceInterface;
use Ludmila\LSAskQuestion\Model\AskQuestion;
class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Answered'),
                'value' => AskQuestion::STATUS_PROCESSED,
            ],
            [
                'label' => __('Pending'),
                'value' => AskQuestion::STATUS_PENDING,
            ],
        ];
    }
}
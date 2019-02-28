<?php
namespace Ludmila\LSAskQuestion\Model\Config\Source;
use Magento\Framework\Option\ArrayInterface;

/**
 * Class Multiselect
 * @package Ludmila\LSAskQuestion\Model\Config\Source
 */
class Multiselect implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray() :array
    {
        return [
            ['value' => 0, 'label' => __('First')],
            ['value' => 1, 'label' => __('Second')],
            ['value' => 2, 'label' => __('Third')],
            ['value' => 3, 'label' => __('Fourth')]
        ];
    }
}
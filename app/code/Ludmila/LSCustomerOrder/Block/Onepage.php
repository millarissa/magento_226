<?php
namespace Ludmila\LSCustomerOrder\Block;

class Onepage extends \Magento\Framework\View\Element\Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('customer/customer/getList');
        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}
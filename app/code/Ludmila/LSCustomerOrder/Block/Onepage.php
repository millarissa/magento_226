<?php
namespace Ludmila\LSCustomerOrder\Block;

class Onepage extends \Magento\Framework\View\Element\Template
{
    public function getJsLayout()
    {
        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['customer-step']['config']['customersListUrl'] = $this->getUrl('customer/customer/getList');

        $this->jsLayout['components']['onepageScope']['children']['steps']['children']['product-step']['config']['productsListUrl'] = $this->getUrl('customer/product/getList');

        return json_encode($this->jsLayout, JSON_HEX_TAG);
    }
}
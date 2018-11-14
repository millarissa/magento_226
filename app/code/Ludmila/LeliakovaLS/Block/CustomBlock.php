<?php

namespace Ludmila\LeliakovaLS\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{

    public function getGeneratedUrlToController()
    {
        return $this->getUrl('ludmila-homework/index/jsonresponse');
    }
}
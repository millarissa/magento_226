<?php

namespace Ludmila\LeliakovaLS\Controller\Index;

class ShowPerson extends \Magento\Framework\App\Action\Action{

    public function execute(){
        $this->_view->loadLayout();
        $this->_view->getLayout()->getBlock('show_person')->setName('Ludmila');
        $this->_view->getLayout()->getBlock('show_person')->setLastname('Leliakova');
        $this->_view->renderLayout();
    }
}
<?php

namespace Ludmila\LeliakovaLS\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class JsonResponse extends \Magento\Framework\App\Action\Action
{

    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $result->setData(["default_router_is" => "It`s located in lib/internal/Magento/Framework/App/Router/DefaultRouter.php and it`s last in the routers loop. It`s used when every other router doesn`t match. In Magento 2 we can create custom handle for 'Not found' page to display custom content."]);

    }
}
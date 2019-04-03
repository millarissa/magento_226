<?php
namespace Ludmila\LSCustomerOrder\Controller\Product;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

/**
 * Class GetList
 * @package Ludmila\LSCustomerOrder\Controller\Product
 */
class GetList extends \Magento\Framework\App\Action\Action
{
    protected $filterBuilder;
    protected $productRepository;
    protected $searchCriteriaBuilder;
    public function __construct(
        Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\Framework\Api\Search\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\Api\FilterBuilder $filterBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        parent::__construct($context);
    }
    public function execute()
    {
        if ($q = $this->getRequest()->getParam('q')) {
            $this->searchCriteriaBuilder->addFilter(
                $this->filterBuilder
                    ->setField('name')
                    ->setValue('%'.$q.'%')
                    ->setConditionType('like')
                    ->create()
            );
        }
        $this->searchCriteriaBuilder->addSortOrder('name', 'ASC');
        $this->searchCriteriaBuilder->setPageSize(10);
        $this->searchCriteriaBuilder->setCurrentPage(1);
        $products = $this->productRepository->getList($this->searchCriteriaBuilder->create())->getItems();
        $data = [];
        foreach ($products as $product) {
            if ($productitems = $product->getOptions()) {

                /** @var \Magento\Catalog\Model\Product $productitems */
                foreach ($productitems as $productitem) {
                }
            }
            $data[] = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'name' => $product->getName(),
                'price' => $product->getPrice()
            ];
        }
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_JSON);
        return $result->setData([
            'products' => $data,
            'error' => false
        ]);
    }
}
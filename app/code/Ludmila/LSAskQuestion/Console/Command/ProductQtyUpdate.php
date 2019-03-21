<?php
namespace Ludmila\LSAskQuestion\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\App\Area;

/**
 * Class ProductQtyUpdate
 * @package Ludmila\LSAskQuestion\Console\Command
 */
class ProductQtyUpdate extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var \Magento\CatalogInventory\Api\StockStateInterface
     */
    private $stockStateInterface;

    /**
     * @var \Magento\CatalogInventory\Api\StockRegistryInterface
     */
    private $stockRegistry;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * ProductQtyUpdate constructor.
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface
     * @param \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Magento\CatalogInventory\Api\StockStateInterface $stockStateInterface,
        \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry,
        \Magento\Framework\App\State $state
    ) {
        $this->productRepository = $productRepository;
        $this->stockStateInterface = $stockStateInterface;
        $this->stockRegistry = $stockRegistry;
        $this->state = $state;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('product-updater:update-qty')
            ->setDescription('Update Product Qty')
            ->setDefinition([
                new InputArgument(
                    'product_id',
                    InputArgument::OPTIONAL,
                    'Product Id'
                ),
                new InputArgument(
                    'qty',
                    InputArgument::OPTIONAL,
                    'Product Qty'
                )
            ]);
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->state->setAreaCode(Area::AREA_ADMINHTML);
        if ($input->getArgument('product_id')) {
            $productId = $input->getArgument('product_id');
        } else {
            $output->writeln("<info>Please input product Id for update!<info>");
            return;
        }
        if ($input->getArgument('qty') && is_numeric($input->getArgument('qty')) && ($input->getArgument('qty') >= 0)) {
            $qty = $input->getArgument('qty');
        } else {
            $output->writeln("<info>Please input product qty for update!<info>");
            return;
        }
        $output->writeln("<info>Product id: $productId. Qty: $qty. <info>");
        $this->updateProductStock($productId, $qty);
        $output->writeln("<info>Product has been updated. <info>");
    }

    /**
     * @param $productId
     * @param $stockData
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function updateProductStock($productId, $stockData) {
        $product = $this->productRepository->getById($productId);
        $stockItem = $this->stockRegistry->getStockItem($product->getId());
        $stockItem->setData('is_in_stock',1);
        $stockItem->setData('qty',$stockData);
        $stockItem->setData('manage_stock',1);
        $stockItem->setData('use_config_notify_stock_qty',1);
        $stockItem->save();
        $this->stockRegistry->updateStockItemBySku($product->getSku(), $stockItem);
    }
}
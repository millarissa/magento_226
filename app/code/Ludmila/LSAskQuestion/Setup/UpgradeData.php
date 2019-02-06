<?php
namespace Ludmila\LSAskQuestion\Setup;
use Magento\Framework\DB\Transaction;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Store\Model\Store;
use Ludmila\LSAskQuestion\Model\AskQuestion;

use \Magento\Framework\File\Csv;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Ludmila\LSAskQuestion\Model\AskQuestionFactory
     */
    private $askQuestionFactory;
    /**
     * @var \Magento\Framework\File\Csv $csv
     */
    private $csv;
    /**
     * @var \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     */
    private $componentRegistrar;
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * UpgradeData constructor.
     * @param \Ludmila\LSAskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     * @param \Magento\Framework\File\Csv $csv
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     */
    public function __construct(
        \Ludmila\LSAskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\Component\ComponentRegistrar $componentRegistrar,
        \Magento\Framework\File\Csv $csv,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->askQuestionFactory = $askQuestionFactory;
        $this->componentRegistrar = $componentRegistrar;
        $this->csv = $csv;
        $this->transactionFactory = $transactionFactory;
        $this->eavSetupFactory = $eavSetupFactory;
    }
    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            $statuses = [AskQuestion::STATUS_PENDING, AskQuestion::STATUS_PROCESSED];
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();
            for ($i = 1; $i <= 5; $i++) {
                /** @var AskQuestion $askQuestion */
                $askQuestion = $this->askQuestionFactory->create();
                $askQuestion->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName("Product #$i")
                    ->setSku("product_sku_$i")
                    ->setQuestion('Test Question')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($askQuestion);
            }
            $transaction->save();
        }
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
            $this->updateDataForAskQuestion($setup, 'import_data.csv');
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            /** @var EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            /**
             * Add attribute to the eav/attribute
             */
            $eavSetup->removeAttribute(\Magento\Catalog\Model\Product::ENTITY, 'allow_ask_questions');
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'allow_to_ask_questions',
                [
                    'group' => 'General',
                    'type' => 'int',
                    'backend' => '',
                    'frontend' => '',
                    'label' => 'Allow to ask questions',
                    'input' => 'boolean',
                    'class' => '',
                    'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                    'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'required' => false,
                    'user_defined' => false,
                    'default' => 0,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'visible_on_front' => false,
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => 'simple,configurable,virtual,bundle,downloadable'
                ]
            );
        }
        $setup->endSetup();
    }
    /**
     * @param ModuleDataSetupInterface $setup
     * @param $fileName
     * @throws \Exception
     */
    public function updateDataForAskQuestion(ModuleDataSetupInterface $setup, $fileName)
    {
        $tableName = $setup->getTable('ludmila_ask_question');
        $filePath = $this->getPathToCsvMagentoAtdec($fileName);
        $csvData = $this->csv->getData($filePath);
        if ($setup->getConnection()->isTableExists($tableName)) {
            foreach ($csvData as $row => $data) {
                if (count($data) === 9) {
                    $res = $this->getCsvData($data);
                    $setup->getConnection()->insertOnDuplicate(
                        $tableName,
                        $res,
                        [
                            'name',
                            'email',
                            'phone',
                            'product_name',
                            'sku',
                            'question',
                            'created_at',
                            'status',
                            'store_id',
                        ]
                    );
                }
            }
        }
    }
    /**
     * @param $fileName
     * @return string
     */
    private function getPathToCsvMagentoAtdec($fileName)
    {
        return $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Ludmila_LSAskQuestion') .
            DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName;
    }
    /**
     * @param $data
     * @return array
     */
    private function getCsvData($data)
    {
        return [
            'name' => $data[0],
            'email' => $data[1],
            'phone' => $data[2],
            'product_name' => $data[3],
            'sku' => $data[4],
            'question' => $data[5],
            'created_at' => $data[6],
            'status' => $data[7],
            'store_id' => $data[8],
        ];
    }
}
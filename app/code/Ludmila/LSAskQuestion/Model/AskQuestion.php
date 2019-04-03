<?php
namespace Ludmila\LSAskQuestion\Model;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion as AskQuestionResource;
use Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface;

/**
 * Class AskQuestion
 * @package Ludmila\LSAskQuestion\Model
 */
class AskQuestion extends \Magento\Framework\Model\AbstractModel implements AskQuestionInterface
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSED = 'processed';
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    protected $_eventPrefix = 'ludmila_ask_question';

    /**
     * LSAskQuestion constructor.
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param array $data
     */

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->storeManager = $storeManager;
    }
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(AskQuestionResource::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData('question_id');
    }
    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData('question_id', $id);
    }
    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->getData('created_at');
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData('name');
    }
    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        return $this->setData('name', $name);
    }
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getData('email');
    }
    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        return $this->setData('email', $email);
    }
    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->getData('phone');
    }
    /**
     * {@inheritdoc}
     */
    public function setPhone($phone)
    {
        return $this->setData('phone', $phone);
    }
    /**
     * {@inheritdoc}
     */
    public function getProductName()
    {
        return $this->getData('product_name');
    }
    /**
     * {@inheritdoc}
     */
    public function setProductName($productName)
    {
        return $this->setData('product_name', $productName);
    }
    /**
     * {@inheritdoc}
     */
    public function getSku()
    {
        return $this->getData('sku');
    }
    /**
     * {@inheritdoc}
     */
    public function setSku($sku)
    {
        return $this->setData('sku', $sku);
    }
    /**
     * {@inheritdoc}
     */
    public function getQuestion()
    {
        return $this->getData('question');
    }
    /**
     * {@inheritdoc}
     */
    public function setQuestion($question)
    {
        return $this->setData('question', $question);
    }
    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->getData('status');
    }
    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }
    /**
     * {@inheritdoc}
     */
    public function getStoreId()
    {
        return $this->getData('store_id');
    }
    /**
     * {@inheritdoc}
     */
    public function setStoreId($storeId)
    {
        return $this->setData('store_id', $storeId);
    }
    /**
     * @return int
     */
    public function getCustomerId():int
    {
        return (int) $this->getData('customer_id');
    }
    /**
     * @param int $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->setData('customer_id', $customerId);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSave()
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }
        if (!$this->getStoreId()) {
            $this->setStoreId($this->storeManager->getStore()->getId());
        }
        return parent::beforeSave();
    }
}
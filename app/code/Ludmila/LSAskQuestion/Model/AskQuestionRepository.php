<?php
namespace Ludmila\LSAskQuestion\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface;
use Ludmila\LSAskQuestion\Api\Data\AskQuestionInterfaceFactory;
use Ludmila\LSAskQuestion\Api\Data\AskQuestionSearchResultsInterfaceFactory;
use Ludmila\LSAskQuestion\Api\AskQuestionRepositoryInterface;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion as ResourceAskQuestion;
use Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\CollectionFactory as AskQuestionCollectionFactory;

/**
 * Class AskQuestionRepository
 * @package Ludmila\LSAskQuestion\Model
 */
class AskQuestionRepository implements AskQuestionRepositoryInterface
{
    /**
     * @var ResourceAskQuestion
     */
    protected $resource;
    /**
     * @var AskQuestionFactory
     */
    protected $askQuestionFactory;
    /**
     * @var AskQuestionCollectionFactory
     */
    protected $askQuestionCollectionFactory;
    /**
     * @var AskQuestionInterfaceFactory
     */
    protected $dataAskQuestionFactory;
    /**
     * @var AskQuestionSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;
    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * AskQuestionRepository constructor.
     * @param ResourceAskQuestion $resource
     * @param AskQuestionFactory $askQuestionFactory
     * @param AskQuestionCollectionFactory $askQuestionCollectionFactory
     * @param AskQuestionInterfaceFactory $dataAskQuestionFactory
     * @param AskQuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceAskQuestion $resource,
        AskQuestionFactory $askQuestionFactory,
        AskQuestionCollectionFactory $askQuestionCollectionFactory,
        AskQuestionInterfaceFactory $dataAskQuestionFactory,
        AskQuestionSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->askQuestionCollectionFactory = $askQuestionCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataAskQuestionFactory = $dataAskQuestionFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }
    /**
     * Save AskQuestion data
     *
     * @param AskQuestionInterface $askQuestion
     * @return AskQuestionInterface
     * @throws CouldNotSaveException
     */
    public function save(AskQuestionInterface $askQuestion)
    {
        try {
            $this->resource->save($askQuestion);
        } catch (\Exception $exception) {
//            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $askQuestion;
    }
    /**
     * Load AskQuestion data by given AskQuestion Identity
     *
     * @param string $askQuestionId
     * @return AskQuestionInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($askQuestionId)
    {
        $askQuestion = $this->AskQuestionFactory->create();
        $this->resource->load($askQuestion, $askQuestionId);
        if (!$askQuestion->getId()) {
//            throw new NoSuchEntityException(__('AskQuestion with id "%1" does not exist.', $askQuestionId));
        }
        return $askQuestion;
    }
    /**
     * Load AskQuestion data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Ludmila\LSAskQuestion\Model\ResourceModel\AskQuestion\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $collection = $this->askQuestionCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $askQuestions = [];
        /** @var AskQuestion $askQuestionModel */
        foreach ($collection as $askQuestionModel) {
            $askQuestionData = $this->dataAskQuestionFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $askQuestionData,
                $askQuestionModel->getData(),
                'Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface'
            );
            $askQuestions[] = $this->dataObjectProcessor->buildOutputDataArray(
                $askQuestionData,
                'Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface'
            );
        }
        $searchResults->setItems($askQuestions);
        return $searchResults;
    }
    /**
     * Delete AskQuestion
     *
     * @param AskQuestionInterface $askQuestion
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(AskQuestionInterface $askQuestion)
    {
        try {
            $this->resource->delete($askQuestion);
        } catch (\Exception $exception) {
//            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    /**
     * Delete AskQuestion by given AskQuestion Identity
     *
     * @param string $askQuestionId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($askQuestionId)
    {
        return $this->delete($this->getById($askQuestionId));
    }
}
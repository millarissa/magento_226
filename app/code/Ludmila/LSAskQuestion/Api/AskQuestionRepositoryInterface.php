<?php
namespace Ludmila\LSAskQuestion\Api;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface AskQuestionRepositoryInterface
 * @package Ludmila\LSAskQuestion\Api
 */
interface AskQuestionRepositoryInterface
{
    /**
     * Save request sample.
     *
     * @param \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface $askQuestion);
    
    /**
     * Retrieve request sample.
     *
     * @param int $askQuestionId
     * @return \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($askQuestionId);
    
    /**
     * Retrieve request samples matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Ludmila\LSAskQuestion\Api\Data\AskQuestionSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
   
    /**
     * Delete request sample.
     *
     * @param \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface $askQuestion
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface $askQuestion);
    
    /**
     * Delete request sample by ID.
     *
     * @param int $askQuestionId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($askQuestionId);
}
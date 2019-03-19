<?php
namespace Ludmila\LSAskQuestion\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface AskQuestionSearchResultsInterface
 * @package Ludmila\LSAskQuestion\Api\Data
 * @api
 */
interface AskQuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get questions list.
     *
     * @return \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface[]
     */
    public function getItems();

    /**
     * Set questions list.
     *
     * @param \Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
<?php
namespace Ludmila\LSAskQuestion\Api\Data;
/**
 * Interface AskQuestionInterface
 * @package Ludmila\LSAskQuestion\Api\Data
 * @api
 */
interface AskQuestionInterface
{
    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId();
    /**
     * Set ID
     *
     * @param int $id
     * @return AskQuestionInterface
     */
    public function setId($id);
    /**
     * Gets the created-at timestamp for the request sample.
     *
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt();
    /**
     * Get name
     *
     * @return string
     */
    public function getName();
    /**
     * Set name
     *
     * @param string $name
     * @return AskQuestionInterface
     */
    public function setName($name);
    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();
    /**
     * Set email
     *
     * @param string $email
     * @return AskQuestionInterface
     */
    public function setEmail($email);
    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();
    /**
     * Set phone
     *
     * @param string $phone
     * @return AskQuestionInterface
     */
    public function setPhone($phone);
    /**
     * Get Product Name
     *
     * @return string
     */
    public function getProductName();
    /**
     * Set Product Name
     *
     * @param string $productName
     * @return AskQuestionInterface
     */
    public function setProductName($productName);
    /**
     * Get sku
     *
     * @return string
     */
    public function getSku();
    /**
     * Set sku
     *
     * @param string $sku
     * @return AskQuestionInterface
     */
    public function setSku($sku);
    /**
     * Get request
     *
     * @return string
     */
    public function getQuestion();
    /**
     * Set request
     *
     * @param string $question
     * @return AskQuestionInterface
     */
    public function setQuestion($question);
    /**
     * Get status
     *
     * @return string
     */
    public function getStatus();
    /**
     * Set status
     *
     * @param string $status
     * @return AskQuestionInterface
     */
    public function setStatus($status);
    /**
     * Get store ID
     *
     * @return string
     */
    public function getStoreId();
    /**
     * Set store ID
     *
     * @param int $storeId
     * @return AskQuestionInterface
     */
    public function setStoreId($storeId);
}
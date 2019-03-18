<?php
namespace Ludmila\LSAskQuestion\Controller\Submit;

use Ludmila\LSAskQuestion\Model\AskQuestion;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Ludmila\LSAskQuestion\Helper\Mail;
use Ludmila\LSAskQuestion\Api\Data\AskQuestionInterface;
use Ludmila\LSAskQuestion\Api\AskQuestionRepositoryInterface;

/**
 * Class Index
 * @package Ludmila\LSAskQuestion\Controller\Submit
 */
class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESS = 'Success';
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Ludmila\LSAskQuestion\Model\AskQuestionFactory
     */
    private $askQuestionFactory;

    /**
     * @var Mail
     */
    private $mailHelper;

    /**
     * @var AskQuestionRepositoryInterface
     */
    private $askQuestionRepository;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Ludmila\LSAskQuestion\Model\AskQuestionFactory $askQuestionFactory
     * @param \Magento\Framework\App\Action\Context $context
     * @param Mail $mailHelper
     * @param AskQuestionRepositoryInterface $askQuestionRepository
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Ludmila\LSAskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\App\Action\Context $context,
        Mail $mailHelper,
        AskQuestionRepositoryInterface $askQuestionRepository
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
        $this->mailHelper = $mailHelper;
        $this->askQuestionRepository = $askQuestionRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();
        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }
            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            /** @var AskQuestion $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();
            $askQuestion->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setQuestion($request->getParam('question'));
//            $askQuestion->save();

            $this->askQuestionRepository->save($askQuestion);

            /**
             * Email Send
             */
            if ($request->getParam('email')) {
                $product = $request->getParam('product_name');
                $sku = $request->getParam('sku');
                $email = $request->getParam('email');
                $customerName = $request->getParam('name');
                $message = $request->getParam('question');
                $this->mailHelper->sendMail($product, $sku, $email, $customerName, $message);
            }

            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Your question was sent. We\'ll answer you as soon as possible.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }
        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        return $controllerResult->setData($data);
    }
}
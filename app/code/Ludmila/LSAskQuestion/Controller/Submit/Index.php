<?php
namespace Ludmila\LSAskQuestion\Controller\Submit;
use Ludmila\LSAskQuestion\Model\AskQuestion;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';
    const STATUS_SUCCESS = 'Success';
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;
    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Framework\App\Action\Context $context
     */

    /**
     * @var \Ludmila\LSAskQuestion\Model\AskQuestionFactory
     */
    private $askQuestionFactory;

    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Ludmila\LSAskQuestion\Model\AskQuestionFactory $askQuestionFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->askQuestionFactory = $askQuestionFactory;
    }
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
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
                throw new LocalizedException(__('This question is not valid and can not be processed.'));
            }

            /** @var AskQuestion $askQuestion */
            $askQuestion = $this->askQuestionFactory->create();
            $askQuestion->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setQuestion($request->getParam('question'));
            $askQuestion->save();

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
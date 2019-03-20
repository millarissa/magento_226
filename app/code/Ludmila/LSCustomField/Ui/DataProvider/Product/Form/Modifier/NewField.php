<?php
namespace Ludmila\LSCustomField\Ui\DataProvider\Product\Form\Modifier;
use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Element\Select;
use Magento\Ui\Component\Form\Element\DataType\Text;
class NewField extends AbstractModifier
{
    /**
     * @var LocatorInterface
     */
    private $locator;

    /**
     * NewField constructor.
     * @param LocatorInterface $locator
     */

    public function __construct(
        LocatorInterface $locator
    ) {
        $this->locator = $locator;
    }
    public function modifyData(array $data)
    {
        return $data;
    }
    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                'custom_fieldset' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Custom Fieldset'),
                                'componentType' => Fieldset::NAME,
                                'dataScope' => 'data.product.custom_fieldset',
                                'collapsible' => true,
                                'sortOrder' => 5,
                            ],
                        ],
                    ],
                    'children' => [
                        'custom_field' => $this->getCustomField(),
                        'custom_field_2' => $this->getCustomFieldTwo(),
                        'custom_field_3' => $this->getCustomFieldThree()
                    ],
                ]
            ]
        );
        return $meta;
    }

    public function getCustomField()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('First Custom Field'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 10,
                        'options' => [
                            ['value' => '0', 'label' => __('No')],
                            ['value' => '1', 'label' => __('Yes')]
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getCustomFieldTwo()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Second Custom Field'),
                        'componentType' => Field::NAME,
                        'formElement' => Select::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 20,
                        'options' => [
                            ['value' => '0', 'label' => __('Default')],
                            ['value' => '1', 'label' => __('Changed')]
                        ],
                    ],
                ],
            ],
        ];
    }

    public function getCustomFieldThree()
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'label' => __('Third Custom Field'),
                        'componentType' => Field::NAME,
                        'formElement' => \Magento\Ui\Component\Form\Element\Input::NAME,
                        'dataScope' => 'enabled',
                        'dataType' => Text::NAME,
                        'sortOrder' => 30,
                    ],
                ],
            ],
        ];
    }
}
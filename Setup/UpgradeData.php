<?php

namespace Magenest\Rules\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\DataConverter\SerializedToJson;

class UpgradeData implements UpgradeDataInterface
{
    protected $_rulesCollection;
    protected $_productMetadata;
    protected $_fieldDataConverterFactory;
    protected $_rules;

    const VERSION = '2.2';

    public function __construct(\Magenest\Rules\Model\ResourceModel\Rules\Collection $rulesCollection,
                                \Magenest\Rules\Model\Rules $rules,
                                \Magento\Framework\App\ProductMetadataInterface $productMetadata,
                                \Magento\Framework\DB\FieldDataConverterFactory $fieldDataConverterFactory)
    {
        $this->_rules = $rules;
        $this->_fieldDataConverterFactory = $fieldDataConverterFactory;
        $this->_productMetadata = $productMetadata;
        $this->_rulesCollection = $rulesCollection;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $currentVersion = $this->_productMetadata->getVersion();
        if (version_compare($context->getVersion(), '2.0.3') < 0) {
            if (version_compare($currentVersion, self::VERSION, '<')) {
                $rules = $this->_rulesCollection->getData();
                foreach ($rules as $rule) {
                    $convertToArr = json_decode($rule['conditions_serialized'],true);
                    $str = serialize($convertToArr);
                    $rule['conditions_serialized'] = $str;
                    $this->_rules->load($rule['id'])->save();
                }
            } else {
                $this->convertSerializedDataToJson($setup);
            }
        }

    }

    protected function convertSerializedDataToJson(ModuleDataSetupInterface $setup)
    {
        $tableName = 'magenest_rules';
        $identifierFieldName = 'id';
        $serializedFieldName = 'conditions_serialized';
        /** @var \Magento\Framework\DB\FieldDataConverter $fieldDataConverter */
        $fieldDataConverter = $this->_fieldDataConverterFactory->create(SerializedToJson::class);
        $fieldDataConverter->convert(
            $setup->getConnection(),
            $setup->getTable($tableName),
            $identifierFieldName,
            $serializedFieldName
        );
    }
}
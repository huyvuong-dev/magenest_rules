<?php

namespace Magenest\Rules\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('magenest_rules')) {
            $table = $installer->getConnection()->newTable($installer->getTable('magenest_rules'))
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    10,
                    [
                        'identity' => true,
                        'nullable' => false,
                        'primary' => true,
                        'unsigned' => true,
                    ],
                    'ID'
                )
                ->addColumn(
                    'title',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    50,
                    [],
                    'Title'
                )
                ->addColumn(
                    'status',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    10,
                    [],
                    'Status'
                )
                ->addColumn(
                    'rule_type',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    '11',
                    [],
                    'Rule Type'
                )
                ->addColumn(
                    'conditions_serialized',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Conditions Serialized'
                )
                ->setComment('Rules Table');
            $installer->getConnection()->createTable($table);
        }
        $installer->endSetup();
    }
}
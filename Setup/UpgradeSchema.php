<?php
namespace Magenest\Rules\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup,
                            ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.4') < 0) {
            $installer = $setup;
            $installer->startSetup();
            $connection = $installer->getConnection();
            //Install new database table
            $table = $installer->getConnection()->newTable(
                $installer->getTable('magenest_timeline')
            )->addColumn(
                'id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true
            ],
                'Id'
            )->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                ['nullable' => false],
                'Status'
            )->addColumn(
                'timeline',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null, [
                'nullable' => false,
                'default' =>
                    \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT
            ],
                'Timeline'
            );
            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }
}
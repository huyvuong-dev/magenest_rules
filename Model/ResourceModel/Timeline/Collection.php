<?php
namespace Magenest\Rules\Model\ResourceModel\Timeline;
/**
 * Subscription Collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct() {
        $this->_init('Magenest\Rules\Model\Timeline',
            'Magenest\Rules\Model\ResourceModel\Timeline');
    }
}
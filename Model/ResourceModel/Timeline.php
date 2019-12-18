<?php
namespace Magenest\Rules\Model\ResourceModel;
class Timeline extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
    public function _construct() {
        $this->_init('magenest_timeline',
            'id');
    }
}
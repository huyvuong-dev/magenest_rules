<?php
namespace Magenest\Rules\Block;

use Magenest\Rules\Model\ResourceModel\Rules\Collection;

class Test extends \Magento\Framework\View\Element\Template
{
    private $_rules;
    private $_resource;
    private $_collection;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magenest\Rules\Model\Rules $rules,
        \Magenest\Rules\Model\ResourceModel\Rules\Collection $collection,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $data
        );
        $this->_collection = $collection;
        $this->_resource = $resource;
        $this->_rules = $rules;
    }

    public function getTimeline(){
        return $this->_rules->load(1)->setData('rule_type',2)->save();
    }

    public function changeGetItems(){
        return $this->_collection->getItems();
    }
}
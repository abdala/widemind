<?php
class Default_Model_Group extends Zend_Db_Table_Abstract {
    protected $_name   = 'group';
    protected $_primary = 'id';

    public function fetchPairs($key = 'id', $value = 'name', $where = null, $order = null, $count = null, $offset = null)
    {
        // check input
        if (is_null($value)) {
            $value = $key;
        }
        if (is_null($order)) {
            $order = $value;
        }

        $data = array();
        $rowset = $this->fetchAll($where, $order, $count, $offset);
        foreach ($rowset as $row) {
            $data[$row->{$key}] = $row->{$value};
        }
        return $data;
    }
}
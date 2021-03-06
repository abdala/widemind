<?php
class Default_Model_GroupReport extends Zend_Db_Table {
    protected $_name    = 'group_report';
    protected $_primary = array('group_id', 'report_id');

    public function fetchByReport($report_id) {
        $select = $this->select()->where('report_id = ?', $report_id);

        $data = $this->fetchAll($select);

        foreach($data as $dt) {
            $response[] = $dt['group_id'];
        }

        return $response;
    }
}
<?php
class ReportController extends Zend_Controller_Action {
    protected $_model = 'Default_Model_Report';

    public function indexAction() {
        $report = new Default_Model_Report();
        $this->view->data = $report->fetchAll(null, 'created DESC');
    }

    public function formAction() {
        $id = Zend_Filter::filterStatic($this->_getParam('id'), "int");
        $report      = new Default_Model_Report();
        $group       = new Default_Model_Group();
        $groupReport = new Default_Model_GroupReport();

        $this->view->groups = $group->fetchPairs();
        $this->view->selectedGroups = array();

        if ($id) {
            $this->view->selectedGroups = $groupReport->fetchByReport($id);
            $this->view->data = $report->find($id)->current();
        } else {
            $this->view->data = $report->createRow();
        }
    }

    public function saveAction() {
        $id     = Zend_Filter::filterStatic($this->_getParam('id'), "int");
        $groups = $this->_getParam('group_id');
        
        $report      = new Default_Model_Report();
        $groupReport = new Default_Model_GroupReport();
        $session     = new Zend_Session_Namespace('report');

        $row = $report->fetchRow(array('id = ?' => $id));
        if (!$row) {
            unset($_POST['id']);
            $row = $report->createRow($_POST);
            $row->data = serialize($_SESSION['report']);
        } else {
            $row->setFromArray($_POST);
        }

        $report_id = $row->save();
        
        $groupReport->delete(array('report_id' => $report_id));

        foreach ($groups as $group) {
            $row = $groupReport->createRow();
            $row->group_id  = $group;
            $row->report_id = $report_id;
            $row->save();
        }
        
        $this->_helper->_flashMessenger->addMessage('Registrado com sucesso');
        $this->_redirect('/report');
    }

    public function loadAction() {
        $id   = Zend_Filter::filterStatic($this->_getParam('id'), "int");
        $page = Zend_Filter::filterStatic($this->_getParam( "page" ), "int");

        if (!$id) {
            throw new Exception('Acesso inválido');
        }

        $report = new Default_Model_Report();
        $data = $report->find($id)->current();

        $builder = new Default_Model_Builder($data->data);

        $this->view->rs		    = $builder->fetchAll($page);
        $this->view->colunms    = $builder->getSelectedColunms();
        $this->view->orders	    = $builder->getOrders();
        $this->view->filters    = $builder->getFilters();
        $this->view->aggregates = $builder->getAggregates();

        $this->_helper->layout->setLayout('clear');
    }

    public function deleteAction() {
        $id = Zend_Filter::filterStatic($this->_getParam('id'), "int");
        $report      = new Default_Model_Report();
        $groupReport = new Default_Model_GroupReport();
        $widget      = new Default_Model_Widget();

        $where = array('report_id = ?' => $id);

        $groupReport->delete($where);
        $widget->delete($where);

        $report->delete(array('id = ?' => $id));

        $this->_helper->_flashMessenger->addMessage('Excluido com sucesso');
        $this->_redirect('/report');
    }
}
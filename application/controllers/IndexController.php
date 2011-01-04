<?php
class IndexController extends Zend_Controller_Action {
    protected $_report;

    public function init() {
        $this->_report = new Default_Model_Builder();
    }

    public function indexAction() {
        $this->_report->clear();
        $this->view->tables = $this->_report->listTables();
    }

    public function fieldAction() {
        $this->_report->clear();


        $schema = $this->_getParam('schema');
        $table = $this->_getParam('table');

        $this->view->fields = $this->_report->getColunms($schema, $table);
        $this->view->tables = $this->_report->getRelationTables($schema, $table);

        $this->_helper->layout->disableLayout();
    }

    public function moreAction() {
        $info   = Zend_Json::decode($this->_getParam('info'));
        $schema = $info['schema'];
        $table  = $info['table'];

        $this->_report->addJoin($info);

        $this->view->fields = $this->_report->getColunms($schema, $table);
        $this->view->tables = $this->_report->getRelationTables($schema, $table);

        $this->_helper->layout->disableLayout();
    }

    public function listAction() {
        $info = Zend_Json::decode($this->_getParam('info'));

        if ($info) {
            $this->_report->add($info);
        }

        $this->_setViewFields();
        $this->_helper->layout->disableLayout();
    }

    public function orderAction() {
        $colunm    = $this->_getParam('colunm');
        $direction = $this->_getParam('direction');
        $add       = $this->_getParam('add');

        $this->_report->addOrder($colunm, $direction, $add);

        $this->_setViewFields();

        $this->_helper->layout->disableLayout();
        $this->render('list');
    }

    public function filterAction() {
        $colunm   = $this->_getParam('colunm');
        $value    = $this->_getParam('value');
        $operator = $this->_getParam('operator');
        $logic    = $this->_getParam('logic');

        $this->_report->addFilter($colunm, $value, $operator, $logic);
        $this->_setViewFields();

        $this->_helper->layout->disableLayout();
        $this->render('list');
    }

    public function aggregateAction() {
        $this->_report->addAggregate($this->_getParam('colunm'));
        $this->_setViewFields();

        $this->_helper->layout->disableLayout();
        $this->render('list');
    }

    public function columnAction() {
        $this->_report->addColumn($this->_getParam('colunm'));
        $this->_setViewFields();

        $this->_helper->layout->disableLayout();
        $this->render('list');
    }

    protected function _setViewFields() {
        $page = Zend_Filter::filterStatic($this->_getParam('page'), 'int');

        $this->view->rs         = $this->_report->fetchAll($page);
        $this->view->allColunms = $this->_report->getAllColunms();
        $this->view->colunms    = $this->_report->getSelectedColunms();
        $this->view->orders     = $this->_report->getOrders();
        $this->view->filters    = $this->_report->getFilters();
        $this->view->aggregates = $this->_report->getAggregates();
    }
}
<?php
class WidgetController extends Zend_Controller_Action
{
    protected $_model = 'Default_Model_Role';
    
    public function indexAction()
    {
        $name = $this->_getParam('name', null);

        if (!$name) {
            throw new Exception('Acesso inválido');
        }

        $report = new Default_Model_Report();
        $widget = new Default_Model_Widget();
        
        $select = $report->select(true)
                         ->join('group_report', 'report.id = group_report.report_id', array())
                         ->join('group', 'group.id = group_report.group_id', array())
                         ->where('group.name = ?', $name)
                         ->order('created');
        $this->view->itens = $report->fetchAll($select);
        
        $select = $widget->select()
                         ->join('group', 'group.id = widget.group_id', array())
                         ->where('group.name = ?', $name)
                         ->order('position');
        $this->view->data = $widget->fetchAll($select);

        $this->_helper->layout->setLayout('clear');
    }

    public function viewAction()
    {
        $id = Zend_Filter::filterStatic($this->_getParam('id'), "int");
        $widget_id = Zend_Filter::filterStatic($this->_getParam('widget'), "int");

        if (!$id) {
            throw new Exception('Acesso inválido');
        }
        
        $report = new Default_Model_Report();
        $data   = $report->find($id)->current();

        $widget     = new Default_Model_Widget();
        $widgetData = $widget->find($widget_id)->current();

        $builder = new Default_Model_Builder($data->data);

        $this->view->rs		    = $builder->fetchAll();
        $this->view->data		= $data;
        $this->view->widget		= $widgetData;
        $this->view->colunms    = $builder->getSelectedColunms();
        $this->view->orders	    = $builder->getOrders();
        $this->view->filters    = $builder->getFilters();
        $this->view->aggregates = $builder->getAggregates();

        $this->_helper->layout->disableLayout();
    }

    public function saveAction()
    {
        $model  = new Default_Model_Widget();
        $result = $model->save($_POST['data']);

        $this->_helper->_flashMessenger->addMessage($result->message);
        $this->_redirect('/widget');
    }

    public function deleteAction()
    {
        $id    = Zend_Filter::filterStatic($this->_getParam( "id" ), "int");
        $model = new Default_Model_Widget();

        $result = $model->delete($id);

        $this->_helper->_flashMessenger->addMessage($result->message);
        $this->_redirect('/widget');
    }
}
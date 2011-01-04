<?php
class GroupController extends Zend_Controller_Action
{
    protected $_model = 'Default_Model_Group';
    
    public function indexAction()
    {
        $group = new Default_Model_Group();
        $this->view->data = $group->fetchAll(null,'name');
    }

    public function formAction()
    {
        $id    = Zend_Filter::filterStatic($this->_getParam( "id" ), "int");
        $group = new Default_Model_Group();

        if ($id) {
            $this->view->data = $group->find($id)->current();
        } else {
            $this->view->data = $group->createRow();
        }
    }

    public function saveAction()
    {
        $group = new Default_Model_Group();
        $result = $group->save($_POST['data']);

        $this->_helper->_flashMessenger->addMessage($result->message);
        $this->_redirect('/group');
    }

    public function deleteAction()
    {
        $id   = Zend_Filter::filterStatic($this->_getParam( "id" ), "int");
        $group = new Default_Model_Group();
        $groupReport = new Default_Model_GroupReport();

        $groupReport->delete(array('group_id' => $id));
        $result = $group->delete($id);

        $this->_helper->_flashMessenger->addMessage($result->message);
        $this->_redirect('/group');
    }
}
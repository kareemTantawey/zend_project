<?php

class RepliesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        // action body
        $threadId = $this->getRequest()->getParam("id");
        $form = new Application_Form_Reply();

        $reply_model = new Application_Model_Replies();

        
        if ($this->getRequest()->isPost() && $threadId) {

            if ($form->isValid($this->getRequest()->getParams())) {
            	$reply_info = $form->getValues();
//                unset($reply_info["image"]);
                $reply_info["thread_id"] = $threadId;
                $reply_info["user_id"] = 9;

                if($reply_model->addReply($reply_info)){
                    
                    $form = new Application_Form_Reply();                
                    
                    $db = $reply_model->getAdapter();
                    $reply_id = $db->lastInsertId();
                    
                    $this->view->reply = $reply_model->getReplyById($reply_id);
                
           		}
       		}


	        if ($this->getRequest()->isXmlHttpRequest()) {
	            $this->_helper->layout->disableLayout();
	        }

	        $this->view->form = $form;

        }

    }

    public function deleteAction()
    {
        // action body
        $id = $this->getRequest()->getParam("id");
        $reply_model = new Application_Model_Replies();
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }

        if($reply_model->deleteReply($id)){
            $this->view->data = array("success" => 1, "message" => "Deleted Successfully");
        }  else {            
            $this->view->data = array("success" => 0, "message" => "unable to Delete");
        }
    }

    public function editAction()
    {
        // action body
        $id = $this->getRequest()->getParam("id");
        $form = new Application_Form_Reply();
        $form->getElement("submit")->setLabel("Edit Reply");
        $reply_model = new Application_Model_Replies();
        $reply = $reply_model->getReplyById($id);
        
        if ($this->getRequest()->isPost() && $id) {
            
            if ($form->isValid($this->getRequest()->getParams())) {
                
                $reply_info = $form->getValues();
                $reply[0]['body'] = $reply_info['body'];
                
                if($reply_model->editReply($reply[0])){
                    $this->view->data = array("success" => 1, "message"=> "updated successfully");
                }  else {
                    $this->view->data = array("success" => 0, "message"=> "unable to edit reply");
                }
            }
        }  else {
            $form->populate($reply[0]);
            
        }


        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        
        $this->view->reply = $reply;
        $this->view->form = $form;

    }


}








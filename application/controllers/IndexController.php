<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $authorization =Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) 
        {           
            $this->redirect("users/login");
        }
          
       
    }
    

    public function indexAction()
    {
        // action body
         $category_model = new Application_Model_Categories();
        $this->view->categories = $category_model->listCategory();
        // call forums
        $forum_model = new Application_Model_Forums();
        $this->view->forums = $forum_model->listForum();
    }


}


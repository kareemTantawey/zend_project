<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
          
       
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


<?php

require_once 'Zend/Mail.php';
require_once 'Zend/Mail/Transport/Smtp.php';
?>

<?php



class UsersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
        // action body
        $login_form = new Application_Form_Login();
        
        $this->view->login = $login_form;

        $login_model = new Application_Model_Users();
        if ($login_form->isValid($_POST)) {
            $email = $this->_request->getParam('email');
            $password = $this->_request->getParam('password');
            $db = Zend_Db_Table::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'email', 'password');

            $authAdapter->setIdentity($email);
            $authAdapter->setCredential(md5($password));
            $result = $authAdapter->authenticate();
            if ($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $storage = $auth->getStorage();
                $storage->write($authAdapter->getResultRowObject(array('email', 'password')));
                $this->_redirect('users/list');
                echo "welcome";
            }
        }
    }

    public function registerAction()
    {
        // action body
        $register_model = new Application_Model_Users();
        $form = new Application_Form_Registration();
        $this->view->register =$form;
        
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                           
               $data = $form->getValues();
                echo "hello";
                
               $data=$this->preparedata($data);

                if ($register_model->checkUnique($data['email'])) {
                    $this->view->errorMessage = "Name already taken. Please choose another one.";
                    return;
                }

                $register_model->insert($data);
                //$accept=$this->sendConfirmationEmail($data);
               
                 $this->redirect('users/login');        
            
            
        }
    }

    }

    public function addAction()
    {
        // action body
        $form = new Application_Form_Users();

        if ($this->_request->isPost()) {
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();
                $user_model = new Application_Model_Users();
                $user_model->addUser($user_info);
            }
        }

        $this->view->form = $form;
    }

    public function listAction()
    {
        // action body
        $user_model = new Application_Model_Users();
        $this->view->users = $user_model->listUsers();
    }

    public function homeAction()
    {
        // action body
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if (!$data) {
            $this->_redirect('users/login');
        }
        //$this->view->users = $data['name'];
    }

    public function deleteAction()
    {
        // action body
         $id = $this->_request->getParam("id");
        if (!empty($id)) {
            $user_model = new Application_Model_Users();
            $user_model->deleteUser($id);
        }
        $this->redirect("users/list");
    }

    public function editAction()
    {
        // action body
        $form = new Application_Form_Registration();
        
        $id = $this->_request->getParam("id");
       
        $form->getElement("password")->setRequired(false);
        $form->getElement("image")->setRequired(false);
        $form->removeElement("gender");
        $form->removeElement("email");
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            
            if ($form->isValid($this->_request->getParams())) {
                $user_info = $form->getValues();
                $user_model = new Application_Model_Users();
                
                if($user_info["image"] !="")
               {
                    $user_model = new Application_Model_Users();
                    $users = $user_model->getUserById($id);
                  
                    $imgName= $users[0]['image'];
                    unlink("/var/www/html/zend/zend_project/public/profile_images/$imgName");
                    $ext = pathinfo($user_info["image"], PATHINFO_EXTENSION);
                    $upload = new Zend_File_Transfer_Adapter_Http();  
                    $upload->setDestination("/var/www/html/zend/zend_project/public/profile_images");
                    $upload->addFilter(new Zend_Filter_File_Rename(array('target' => $user_info["name"].$users[0]["id"].'.'.$ext)));                  
                    $upload->receive();
                    $user_info["image"]=$user_info["name"].$users[0]["id"].'.'.$ext;
               }
               

             
                $user_model->editUser($user_info);
                $this->redirect("users/list");
            }
        }
            if (!empty($id)) {
                $user_model = new Application_Model_Users();
                $user = $user_model->getUserById($id);
               
                $form->populate($user[0]);
            } else
            {
                $this->redirect("users/list");
            }
        
        $this->render('add');
    }

    public function preparedata($data) {
        $data['password'] = md5($data['password']);
        return $data;
    }

    public function logoutAction() {
        $this->_redirect('users/login');
    }


}


















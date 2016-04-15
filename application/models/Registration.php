<?php

class Application_Model_Registration
{
	protected $_name = "users";
	function viewregister()
    {
      return $this->fetchAll()->toArray();  
    }

}

